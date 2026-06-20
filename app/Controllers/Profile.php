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
        $listaAlergias = $conditionsModel->where('type', 'allergy')->findAll();

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
        $userId = session()->get('loggedUser');
        
        $userModel = new UserModel();
        $healthModel = new HealthProfilesModel();
        $userConditionsModel = new UserConditionsModel();

        // INICIAR TRANSACCIÓN SEGURA
        $db = \Config\Database::connect();
        $db->transStart();

        // -----------------------------------------------------------
        // 1. MANEJO DE LA FOTO DE PERFIL (AVATAR) - COMENTADO
        // -----------------------------------------------------------
        /*
        $archivoFoto = $this->request->getFile('foto_perfil');
        $nombreFoto = $this->request->getPost('foto_actual'); 
        
        if ($archivoFoto && $archivoFoto->isValid() && !$archivoFoto->hasMoved()) {
            $nombreFoto = $archivoFoto->getRandomName(); // Nombre único seguro
            // Guardamos físicamente la imagen en la carpeta public/assets/imagenes/avatars
            $archivoFoto->move(FCPATH . 'assets/imagenes/avatars', $nombreFoto);
        }
        */

        // -----------------------------------------------------------
        // 2. ACTUALIZACIÓN DE USUARIO (Tabla: users)
        // -----------------------------------------------------------
        $datosUsuario = [
            'name'       => trim($this->request->getPost('name')),
            'sex'        => $this->request->getPost('sex'),
            'birth_date' => $this->request->getPost('birth_date')
            // 'avatar'     => $nombreFoto  <--- COMENTADO HASTA ACTUALIZAR LA BD
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
}