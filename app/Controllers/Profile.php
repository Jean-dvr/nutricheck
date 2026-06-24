<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\HealthProfilesModel;
use App\Models\HealthConditionsModel;
use App\Models\UserConditionsModel;
use App\Libraries\Hash; 

class Profile extends BaseController
{
    public function index()
    {
        $userId = session()->get('loggedUser');
        
        $userModel = new UserModel();
        $healthModel = new HealthProfilesModel();
        $conditionsModel = new HealthConditionsModel();
        $userConditionsModel = new UserConditionsModel();

        // Extraer todos los datos del usuario
        $usuario = $userModel->find($userId);
        $perfilSalud = $healthModel->where('user_id', $userId)->first();
        
        $listaPatologias = $conditionsModel->where('type', 'pathology')->findAll();
        $listaAlergias = $conditionsModel->whereIn('type', ['allergy', 'intolerance'])->findAll();
        
        // Extraer las condiciones que ya tiene marcadas el usuario (para el checkbox)
        $condicionesActuales = $userConditionsModel->where('user_id', $userId)->findAll();
        $idsCondiciones = array_column($condicionesActuales, 'condition_id');

        $data = [
            'usuario' => $usuario,
            'perfil' => $perfilSalud,
            'patologias' => $listaPatologias,
            'alergias' => $listaAlergias,
            'misCondiciones' => $idsCondiciones 
        ];

        return view('perfil/index', $data);
    }

    public function actualizar()
    {
        $reglas = config('Validation')->actualizarPerfil;
        $mensajes = config('Validation')->actualizarPerfil_errors;

        // 2. LÓGICA DE ROLES: Prevenir usurpación de títulos médicos
        $rolActual = session()->get('rol');
        
        // Si el usuario es un paciente (free o premium), le endurecemos la regla
        if (in_array($rolActual, ['free', 'premium'])) {
            $reglas['name'] = 'required|alpha_space|min_length[5]|max_length[50]';
            $mensajes['name']['alpha_space'] = 'Tu nombre solo debe contener letras y espacios. El uso de puntos y títulos (Dr., Dra.) es exclusivo para los Nutricionistas de la plataforma.';
        }

        // 3. Ejecutamos la validación con las reglas ya personalizadas
        if (!$this->validate($reglas, $mensajes)) {
            $errores = $this->validator->getErrors();
            $primerError = reset($errores);
            
            return redirect()->to(base_url('perfil'))->withInput()->with('fail', $primerError);
        }
        $userId = session()->get('loggedUser');
        
        $userModel = new UserModel();
        $healthModel = new HealthProfilesModel();
        $userConditionsModel = new UserConditionsModel();

        // INICIAR TRANSACCIÓN SEGURA
        $db = \Config\Database::connect();
        $db->transStart();

// -----------------------------------------------------------
        // 1. MANEJO DE LA FOTO DE PERFIL (AVATAR)
        // -----------------------------------------------------------
        $archivoFoto = $this->request->getFile('foto_perfil');
        $nombreFoto = $this->request->getPost('foto_actual'); 
        
        // NUEVO: Evaluamos si el usuario intentó subir un archivo
        if ($archivoFoto && $archivoFoto->getError() !== UPLOAD_ERR_NO_FILE) {
            
            // NUEVO: Verificamos si la imagen excede el límite de peso de PHP (usualmente 2MB)
            // Si es así, lanzamos una alerta roja en la vista en lugar de fallar en silencio.
            if (!$archivoFoto->isValid()) {
                return redirect()->to(base_url('perfil'))->with('fail', 'Error al subir: La imagen es muy pesada. Intenta con una que pese menos de 2MB.');
            }

            // NUEVO: Usamos guessExtension() en lugar de getMimeType(). Es mucho más preciso en CodeIgniter 4.
            $extension = $archivoFoto->guessExtension();
            if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                
                $nombreFoto = $archivoFoto->getRandomName(); // Nombre único seguro
                
                // Movemos la imagen a la carpeta física
                $archivoFoto->move(FCPATH . 'assets/avatars', $nombreFoto);
                
            } else {
                // Si suben un PDF o un archivo que no es imagen, bloqueamos el proceso
                return redirect()->to(base_url('perfil'))->with('fail', 'Formato de imagen no permitido. Solo JPG o PNG.');
            }
        }
        

        // -----------------------------------------------------------
        // 2. ACTUALIZACIÓN DE USUARIO (Tabla: users)
        // -----------------------------------------------------------
        $datosUsuario = [
            'name'       => trim($this->request->getPost('name')),
            'sex'        => $this->request->getPost('sex'),
            'birth_date' => $this->request->getPost('birth_date'), 
            'avatar'     => $nombreFoto
        ];

        // Verificar si el usuario escribió una contraseña nueva
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $datosUsuario['password'] = Hash::make($password);
        }
        
        $userModel->update($userId, $datosUsuario);

        // -----------------------------------------------------------
        // 3. ACTUALIZACIÓN FÍSICA Y OBJETIVOS (Tabla: health_profiles)
        // -----------------------------------------------------------
        $peso = $this->request->getPost('weight_kg');
        $alturaCm = $this->request->getPost('height_cm');
        $imc = null;

        // Recalcular el IMC internamente antes de guardar
        if (!empty($peso) && !empty($alturaCm)) {
            $alturaMetros = $alturaCm / 100;
            $imc = round($peso / ($alturaMetros * $alturaMetros), 2);
        }

        $datosFisicos = [
            'weight_kg'   => $peso,
            'height_cm'   => $alturaCm,
            'current_bmi' => $imc,
            'goal'        => $this->request->getPost('goal')
        ];

        $perfilActual = $healthModel->where('user_id', $userId)->first();
        if ($perfilActual) {
            $healthModel->update($perfilActual['id'], $datosFisicos);
        } else {
            $datosFisicos['user_id'] = $userId;
            $healthModel->insert($datosFisicos);
        }

        // -----------------------------------------------------------
        // 4. ACTUALIZACIÓN DE CONDICIONES (Tabla: user_conditions)
        // -----------------------------------------------------------
        // Paso A: Borrar el historial clínico anterior
        $userConditionsModel->where('user_id', $userId)->delete();
        
        // Paso B: Insertar las nuevas condiciones marcadas
        $condicionesSeleccionadas = $this->request->getPost('conditions');

        if (!empty($condicionesSeleccionadas)) {
            $condicionesInsert = [];
            foreach ($condicionesSeleccionadas as $condicionId) {
                $condicionesInsert[] = [
                    'user_id'      => $userId,
                    'condition_id' => $condicionId
                ];
            }
            $userConditionsModel->insertBatch($condicionesInsert);
        }

        // CERRAR TRANSACCIÓN Y EVALUAR
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to(base_url('perfil'))->with('fail', 'Ocurrió un error al guardar tu perfil. Intenta nuevamente.');
        }

        // Actualizamos el nombre en la sesión en caso de que lo haya cambiado
        session()->set('name', $datosUsuario['name']);

        return redirect()->to(base_url('perfil'))->with('success', '¡Perfil y cuadro clínico actualizados correctamente!');
    }

   
    // MÓDULO DE Cuadro Clinico (Solo Admin)
 
    
    public function agregarCondicion()
    {
        // Seguridad: Bloquear si no es admin
        if (session()->get('rol') !== 'admin') {
            return redirect()->back()->with('fail', 'No tienes permisos para alterar el catálogo médico.');
        }

        // Extraemos las reglas y mensajes de nuestro archivo central Validation.php
        $reglas = config('Validation')->catalogoMedico;
        $mensajes = config('Validation')->catalogoMedico_errors;

        // Ejecutamos la validación
        if (!$this->validate($reglas, $mensajes)) {
            // Si falla, tomamos el primer mensaje de error y lo enviamos a la vista
            $errores = $this->validator->getErrors();
            $primerError = reset($errores);
            
            return redirect()->back()->with('fail', $primerError);
        }

        // Si pasa la validación, procedemos a guardar en la base de datos
        $conditionsModel = new HealthConditionsModel();
        
        $conditionsModel->insert([
            'name' => trim($this->request->getPost('name')),
            'type' => $this->request->getPost('type')
        ]);

        return redirect()->back()->with('success', '✅ Nueva condición médica añadida al catálogo exitosamente.');
    }

    public function eliminarCondicion($id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->back()->with('fail', 'No tienes permisos para alterar el catálogo médico.');
        }

        $conditionsModel = new HealthConditionsModel();
        $userConditionsModel = new UserConditionsModel();

        if ($conditionsModel->find($id)) {
            // 1. Eliminamos primero las referencias en los cuadros clínicos de los pacientes (Evita errores de llave foránea)
            $userConditionsModel->where('condition_id', $id)->delete();
            
            // 2. Eliminamos la condición global del sistema
            $conditionsModel->delete($id);
            
            return redirect()->back()->with('success', '🗑️ Condición médica eliminada permanentemente del sistema.');
        }

        return redirect()->back()->with('fail', 'La condición no existe.');
    }
}