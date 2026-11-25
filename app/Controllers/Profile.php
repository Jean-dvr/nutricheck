<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\HealthProfilesModel;
use App\Models\HealthConditionsModel;
use App\Models\UserConditionsModel;
use App\Models\NotificationsModel;
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

        $usuario = $userModel->find($userId);
        $perfilSalud = $healthModel->where('user_id', $userId)->first();

        $listaPatologias = $conditionsModel->where('type', 'pathology')->findAll();
        $listaAlergias = $conditionsModel->whereIn('type', ['allergy', 'intolerance'])->findAll();

        $condicionesActuales = $userConditionsModel->where('user_id', $userId)->findAll();
        $idsCondiciones = array_column($condicionesActuales, 'condition_id');

        $data = [
            'usuario'        => $usuario,
            'perfil'         => $perfilSalud,
            'patologias'     => $listaPatologias,
            'alergias'       => $listaAlergias,
            'misCondiciones' => $idsCondiciones,
        ];

        return view('perfil/index', $data);
    }

    // --------------------------------------------------------------------
    // 1. APARTADO: DATOS PERSONALES (y contraseña opcional)
    // --------------------------------------------------------------------
    public function actualizarDatosPersonales()
    {
        $userId = session()->get('loggedUser');
        $userModel = new UserModel();
        $usuarioActual = $userModel->find($userId);

        if (!$usuarioActual) {
            return redirect()->to(base_url('perfil'))->with('fail', 'Usuario no encontrado.');
        }

        $reglas = [
            'name'       => 'required|min_length[5]|max_length[50]',
            'sex'        => 'permit_empty|in_list[M,F,Masculino,Femenino,Otro]',
            'birth_date' => 'permit_empty|valid_date[Y-m-d]',
            'password'   => 'permit_empty|min_length[6]|max_length[255]',
        ];

        $mensajes = [
            'name' => [
                'required'   => 'El nombre y apellido es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 5 caracteres.',
                'max_length' => 'El nombre no puede superar los 50 caracteres.',
            ],
            'birth_date' => [
                'valid_date' => 'La fecha de nacimiento no tiene un formato válido.',
            ],
            'password' => [
                'min_length' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            ],
        ];

        $rolActual = session()->get('rol');
        if (in_array($rolActual, ['free', 'premium'])) {
            $reglas['name'] = 'required|alpha_space|min_length[5]|max_length[50]';
            $mensajes['name']['alpha_space'] = 'Tu nombre solo debe contener letras y espacios. El uso de puntos y títulos (Dr., Dra.) es exclusivo para los Nutricionistas de la plataforma.';
        }

        $passwordPost = (string) $this->request->getPost('password');
        $esMismaPassword = ($passwordPost !== '' && !empty($usuarioActual['password']) && password_verify($passwordPost, $usuarioActual['password']));

        if ($passwordPost === '' || $esMismaPassword) {
            unset($reglas['password']);
        }

        if (!$this->validate($reglas, $mensajes)) {
            $errores = $this->validator->getErrors();
            return redirect()->to(base_url('perfil'))->withInput()->with('fail', reset($errores));
        }

        $nombreLimpio = trim((string) $this->request->getPost('name'));
        $sexoPost = $this->request->getPost('sex');
        $fechaNacPost = $this->request->getPost('birth_date');

        $datosUsuario = [
            'name'       => $nombreLimpio,
            'sex'        => ($sexoPost !== null && $sexoPost !== '') ? $sexoPost : $usuarioActual['sex'],
            'birth_date' => !empty($fechaNacPost) ? $fechaNacPost : $usuarioActual['birth_date'],
        ];

        if ($passwordPost !== '' && !$esMismaPassword) {
            $datosUsuario['password'] = Hash::make($passwordPost);
        }

        if (!$userModel->update($userId, $datosUsuario)) {
            return redirect()->to(base_url('perfil'))->withInput()->with('fail', 'No se pudieron guardar tus datos personales.');
        }

        session()->set('name', $datosUsuario['name']);

        return redirect()->to(base_url('perfil'))->with('success', '¡Datos personales actualizados correctamente!');
    }

    // --------------------------------------------------------------------
    // 2. APARTADO: FOTO DE PERFIL (AVATAR)
    // --------------------------------------------------------------------
    public function actualizarFoto()
    {
        $userId = session()->get('loggedUser');
        $userModel = new UserModel();
        $usuarioActual = $userModel->find($userId);

        if (!$usuarioActual) {
            return redirect()->to(base_url('perfil'))->with('fail', 'Usuario no encontrado.');
        }

        $archivoFoto = $this->request->getFile('foto_perfil');

        if (!$archivoFoto || $archivoFoto->getError() === UPLOAD_ERR_NO_FILE) {
            return redirect()->to(base_url('perfil'))->with('fail', 'Selecciona una imagen JPG o PNG antes de guardar.');
        }

        if (!$archivoFoto->isValid()) {
            return redirect()->to(base_url('perfil'))->with('fail', 'Error al subir: la imagen es muy pesada o está dañada (máx. 2MB).');
        }

        $extension = strtolower((string) $archivoFoto->guessExtension());
        if (!in_array($extension, ['png', 'jpg', 'jpeg'], true)) {
            return redirect()->to(base_url('perfil'))->with('fail', 'Formato de imagen no permitido. Solo JPG o PNG.');
        }

        $nombreFoto = $archivoFoto->getRandomName();
        $rutaDestino = FCPATH . 'assets/avatars';

        if (!is_dir($rutaDestino)) {
            mkdir($rutaDestino, 0775, true);
        }

        if (!$archivoFoto->move($rutaDestino, $nombreFoto)) {
            return redirect()->to(base_url('perfil'))->with('fail', 'No se pudo mover la imagen al directorio de avatares.');
        }

        if (!$userModel->update($userId, ['avatar' => $nombreFoto])) {
            return redirect()->to(base_url('perfil'))->with('fail', 'No se pudo actualizar tu foto en la base de datos.');
        }

        session()->set('avatar', $nombreFoto);

        return redirect()->to(base_url('perfil'))->with('success', '¡Foto de perfil actualizada correctamente!');
    }

    // --------------------------------------------------------------------
    // 3. APARTADO: MÉTRICAS Y OBJETIVOS (health_profiles)
    // --------------------------------------------------------------------
    public function actualizarMetricas()
    {
        $userId = session()->get('loggedUser');
        $healthModel = new HealthProfilesModel();
        $perfilActual = $healthModel->where('user_id', $userId)->first();

        $reglas = [
            'weight_kg' => 'permit_empty|decimal|greater_than[0]|less_than[500]',
            'height_cm' => 'permit_empty|numeric|greater_than[30]|less_than[300]',
            'goal'      => $perfilActual ? 'permit_empty|max_length[100]' : 'required|max_length[100]',
        ];

        $mensajes = [
            'weight_kg' => [
                'decimal'      => 'El peso debe ser un número válido.',
                'greater_than' => 'El peso debe ser mayor a 0 kg.',
                'less_than'    => 'Verifica el peso ingresado.',
            ],
            'height_cm' => [
                'numeric'      => 'La altura debe ser un valor numérico en cm.',
                'greater_than' => 'La altura debe ser mayor a 30 cm.',
                'less_than'    => 'Verifica la altura ingresada.',
            ],
            'goal' => [
                'required'   => 'Selecciona tu objetivo antes de crear tu perfil físico.',
                'max_length' => 'El objetivo es demasiado largo.',
            ],
        ];

        if (!$this->validate($reglas, $mensajes)) {
            $errores = $this->validator->getErrors();
            return redirect()->to(base_url('perfil'))->withInput()->with('fail', reset($errores));
        }

        $pesoPost = $this->request->getPost('weight_kg');
        $alturaPost = $this->request->getPost('height_cm');
        $objetivoPost = $this->request->getPost('goal');

        $peso = ($pesoPost !== null && $pesoPost !== '') ? (float) $pesoPost : ($perfilActual['weight_kg'] ?? null);
        $alturaCm = ($alturaPost !== null && $alturaPost !== '') ? (float) $alturaPost : ($perfilActual['height_cm'] ?? null);
        $objetivo = ($objetivoPost !== null && $objetivoPost !== '') ? trim((string) $objetivoPost) : ($perfilActual['goal'] ?? null);

        if ($objetivo === null || $objetivo === '') {
            return redirect()->to(base_url('perfil'))->withInput()->with('fail', 'Debes seleccionar un objetivo para guardar tus métricas.');
        }

        $imc = null;
        if (!empty($peso) && !empty($alturaCm) && $alturaCm > 0) {
            $alturaMetros = $alturaCm / 100;
            $imc = round($peso / ($alturaMetros * $alturaMetros), 2);
        }

        $datosFisicos = [
            'weight_kg'   => $peso,
            'height_cm'   => $alturaCm,
            'current_bmi' => $imc,
            'goal'        => $objetivo,
        ];

        if ($perfilActual) {
            $ok = $healthModel->update($perfilActual['id'], $datosFisicos);
        } else {
            $datosFisicos['user_id'] = $userId;
            $ok = (bool) $healthModel->insert($datosFisicos);
        }

        if (!$ok) {
            return redirect()->to(base_url('perfil'))->withInput()->with('fail', 'Ocurrió un error al guardar tus métricas y objetivos.');
        }

        return redirect()->to(base_url('perfil'))->with('success', '¡Métricas y objetivos actualizados correctamente!');
    }

    // --------------------------------------------------------------------
    // 4. APARTADO: CONDICIONES MÉDICAS / ALERGIAS (user_conditions)
    // --------------------------------------------------------------------
    public function actualizarCondiciones()
    {
        $userId = session()->get('loggedUser');
        $userConditionsModel = new UserConditionsModel();

        $condicionesSeleccionadas = $this->request->getPost('conditions');
        if (!is_array($condicionesSeleccionadas)) {
            $condicionesSeleccionadas = [];
        }

        // Filtramos únicamente IDs enteros positivos válidos
        $idsLimpios = array_values(array_unique(array_filter(array_map('intval', $condicionesSeleccionadas), fn ($id) => $id > 0)));

        $db = \Config\Database::connect();
        $db->transStart();

        $userConditionsModel->where('user_id', $userId)->delete();

        if (!empty($idsLimpios)) {
            $condicionesInsert = [];
            foreach ($idsLimpios as $condicionId) {
                $condicionesInsert[] = [
                    'user_id'      => $userId,
                    'condition_id' => $condicionId,
                ];
            }
            $userConditionsModel->insertBatch($condicionesInsert);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to(base_url('perfil'))->with('fail', 'Ocurrió un error al actualizar tus condiciones médicas.');
        }

        return redirect()->to(base_url('perfil'))->with('success', '¡Condiciones médicas actualizadas correctamente!');
    }

    // --------------------------------------------------------------------
    // GUARDADO COMPLETO (OPCIONAL / RETROCOMPATIBILIDAD)
    // --------------------------------------------------------------------
    public function actualizar()
    {
        $userId = session()->get('loggedUser');
        $userModel = new UserModel();
        $usuarioActual = $userModel->find($userId);

        $reglas = config('Validation')->actualizarPerfil;
        $mensajes = config('Validation')->actualizarPerfil_errors;

        $rolActual = session()->get('rol');
        if (in_array($rolActual, ['free', 'premium'])) {
            $reglas['name'] = 'required|alpha_space|min_length[5]|max_length[50]';
            $mensajes['name']['alpha_space'] = 'Tu nombre solo debe contener letras y espacios. El uso de puntos y títulos (Dr., Dra.) es exclusivo para los Nutricionistas de la plataforma.';
        }

        // Si la contraseña viene vacía o es idéntica a la actual (ej. autocompletada por el navegador), omitimos su validación
        $password = (string) $this->request->getPost('password');
        $esMismaPassword = ($password !== '' && !empty($usuarioActual['password']) && password_verify($password, $usuarioActual['password']));

        if ($password === '' || $esMismaPassword) {
            unset($reglas['password']);
        }

        if (!$this->validate($reglas, $mensajes)) {
            $errores = $this->validator->getErrors();
            return redirect()->to(base_url('perfil'))->withInput()->with('fail', reset($errores));
        }

        $healthModel = new HealthProfilesModel();
        $userConditionsModel = new UserConditionsModel();

        $perfilActual = $healthModel->where('user_id', $userId)->first();

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Foto de perfil
        $archivoFoto = $this->request->getFile('foto_perfil');
        $nombreFoto = $this->request->getPost('foto_actual') ?: ($usuarioActual['avatar'] ?? null);

        if ($archivoFoto && $archivoFoto->getError() !== UPLOAD_ERR_NO_FILE) {
            if (!$archivoFoto->isValid()) {
                $db->transRollback();
                return redirect()->to(base_url('perfil'))->with('fail', 'Error al subir: La imagen es muy pesada. Intenta con una que pese menos de 2MB.');
            }

            $extension = strtolower((string) $archivoFoto->guessExtension());
            if (!in_array($extension, ['png', 'jpg', 'jpeg'], true)) {
                $db->transRollback();
                return redirect()->to(base_url('perfil'))->with('fail', 'Formato de imagen no permitido. Solo JPG o PNG.');
            }

            $nombreFoto = $archivoFoto->getRandomName();
            $rutaDestino = FCPATH . 'assets/avatars';
            if (!is_dir($rutaDestino)) {
                mkdir($rutaDestino, 0775, true);
            }
            $archivoFoto->move($rutaDestino, $nombreFoto);
        }

        // 2. Datos de usuario
        $sexoPost = $this->request->getPost('sex');
        $fechaNacPost = $this->request->getPost('birth_date');

        $datosUsuario = [
            'name'       => trim((string) $this->request->getPost('name')),
            'sex'        => ($sexoPost !== null && $sexoPost !== '') ? $sexoPost : ($usuarioActual['sex'] ?? null),
            'birth_date' => !empty($fechaNacPost) ? $fechaNacPost : ($usuarioActual['birth_date'] ?? null),
            'avatar'     => $nombreFoto,
        ];

        if ($password !== '' && !$esMismaPassword) {
            $datosUsuario['password'] = Hash::make($password);
        }

        $userModel->update($userId, $datosUsuario);

        // 3. Métricas y objetivos
        $pesoPost = $this->request->getPost('weight_kg');
        $alturaPost = $this->request->getPost('height_cm');
        $objetivoPost = $this->request->getPost('goal');

        $peso = ($pesoPost !== null && $pesoPost !== '') ? (float) $pesoPost : ($perfilActual['weight_kg'] ?? null);
        $alturaCm = ($alturaPost !== null && $alturaPost !== '') ? (float) $alturaPost : ($perfilActual['height_cm'] ?? null);
        $objetivo = ($objetivoPost !== null && $objetivoPost !== '') ? trim((string) $objetivoPost) : ($perfilActual['goal'] ?? null);

        $imc = null;
        if (!empty($peso) && !empty($alturaCm) && $alturaCm > 0) {
            $alturaMetros = $alturaCm / 100;
            $imc = round($peso / ($alturaMetros * $alturaMetros), 2);
        }

        if ($perfilActual || $objetivo !== null || $peso !== null || $alturaCm !== null) {
            if ($objetivo === null || $objetivo === '') {
                $db->transRollback();
                return redirect()->to(base_url('perfil'))->withInput()->with('fail', 'Debes seleccionar un objetivo para guardar tus métricas de salud.');
            }

            $datosFisicos = [
                'weight_kg'   => $peso,
                'height_cm'   => $alturaCm,
                'current_bmi' => $imc,
                'goal'        => $objetivo,
            ];

            if ($perfilActual) {
                $healthModel->update($perfilActual['id'], $datosFisicos);
            } else {
                $datosFisicos['user_id'] = $userId;
                $healthModel->insert($datosFisicos);
            }
        }

        // 4. Condiciones (solo si el campo fue enviado en el POST)
        if ($this->request->getPost('conditions') !== null) {
            $userConditionsModel->where('user_id', $userId)->delete();
            $condicionesSeleccionadas = (array) $this->request->getPost('conditions');
            $idsLimpios = array_values(array_unique(array_filter(array_map('intval', $condicionesSeleccionadas), fn ($id) => $id > 0)));

            if (!empty($idsLimpios)) {
                $condicionesInsert = [];
                foreach ($idsLimpios as $condicionId) {
                    $condicionesInsert[] = [
                        'user_id'      => $userId,
                        'condition_id' => $condicionId,
                    ];
                }
                $userConditionsModel->insertBatch($condicionesInsert);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to(base_url('perfil'))->with('fail', 'Ocurrió un error al guardar tu perfil. Intenta nuevamente.');
        }

        session()->set('name', $datosUsuario['name']);
        if ($nombreFoto !== null) {
            session()->set('avatar', $nombreFoto);
        }

        return redirect()->to(base_url('perfil'))->with('success', '¡Perfil y cuadro clínico actualizados correctamente!');
    }

    // --------------------------------------------------------------------
    // MÓDULO DE CUADRO CLÍNICO (SOLO ADMIN)
    // --------------------------------------------------------------------
    public function agregarCondicion()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->back()->with('fail', 'No tienes permisos para alterar el catálogo médico.');
        }

        $reglas = config('Validation')->catalogoMedico;
        $mensajes = config('Validation')->catalogoMedico_errors;

        if (!$this->validate($reglas, $mensajes)) {
            $errores = $this->validator->getErrors();
            return redirect()->back()->with('fail', reset($errores));
        }

        $nombreCondicion = trim((string) $this->request->getPost('name'));

        $conditionsModel = new HealthConditionsModel();
        $conditionsModel->insert([
            'name' => $nombreCondicion,
            'type' => $this->request->getPost('type'),
        ]);

        // Notificar cambio en el catálogo médico al personal
        $notifModel = new NotificationsModel();
        $notifModel->notificarPorRoles(
            ['nutricionista', 'admin'],
            'Cambio en el catálogo médico',
            "Se añadió la condición \"{$nombreCondicion}\" al cuadro clínico del sistema.",
            'perfil',
            'sistema',
            (int) session()->get('loggedUser')
        );

        return redirect()->back()->with('success', '✅ Nueva condición médica añadida al catálogo exitosamente.');
    }

    public function eliminarCondicion(int $id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->back()->with('fail', 'No tienes permisos para alterar el catálogo médico.');
        }

        $conditionsModel = new HealthConditionsModel();
        $userConditionsModel = new UserConditionsModel();
        $condicion = $conditionsModel->find($id);

        if ($condicion) {
            $userConditionsModel->where('condition_id', $id)->delete();
            $conditionsModel->delete($id);

            // Notificar cambio en el catálogo médico al personal
            $notifModel = new NotificationsModel();
            $notifModel->notificarPorRoles(
                ['nutricionista', 'admin'],
                'Cambio en el catálogo médico',
                "Se eliminó la condición \"{$condicion['name']}\" del cuadro clínico del sistema.",
                'perfil',
                'sistema',
                (int) session()->get('loggedUser')
            );

            return redirect()->back()->with('success', '🗑️ Condición médica eliminada permanentemente del sistema.');
        }

        return redirect()->back()->with('fail', 'La condición no existe.');
    }
}