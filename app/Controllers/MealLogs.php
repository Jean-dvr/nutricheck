<?php

namespace App\Controllers;

use App\Models\MealLogsModel;

class MealLogs extends BaseController
{
    public function index()
    {
        $userId = session()->get('loggedUser');
        $mealModel = new MealLogsModel();

        // Extraemos las comidas ordenadas por fecha y hora
        $comidas = $mealModel->where('user_id', $userId)
                             ->orderBy('meal_date', 'DESC')
                             ->orderBy('meal_time', 'DESC')
                             ->findAll();

        $data = [
            'historial_comidas' => $comidas
        ];

        // Apunta a tu carpeta meallogs
        return view('meallogs/index', $data);
    }

    public function guardar()
    {
        $userId = session()->get('loggedUser');
        $mealModel = new MealLogsModel();

        // 1. MANEJO DE LA IMAGEN DE LA COMIDA
        $archivoFoto = $this->request->getFile('foto_comida');
        $nombreFoto = null; 
        
        if ($archivoFoto && $archivoFoto->getError() !== UPLOAD_ERR_NO_FILE) {
            if (!$archivoFoto->isValid()) {
                return redirect()->to(base_url('comidas'))->with('fail', 'La imagen es muy pesada. Máximo 2MB.');
            }

            $extension = $archivoFoto->guessExtension();
            if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                $nombreFoto = $archivoFoto->getRandomName();
                // Guardamos en tu carpeta específica
                $archivoFoto->move(FCPATH . 'assets/meallogsimg', $nombreFoto);
            } else {
                return redirect()->to(base_url('comidas'))->with('fail', 'Formato no permitido. Solo JPG o PNG.');
            }
        }

        // 2. EMPAQUETAR DATOS
        $datosComida = [
            'user_id'     => $userId,
            'meal_type'   => $this->request->getPost('meal_type'),
            'meal_date'   => $this->request->getPost('meal_date'),
            'meal_time'   => $this->request->getPost('meal_time'),
            'description' => trim($this->request->getPost('description')),
            'image_path'  => $nombreFoto
        ];

        // 3. GUARDAR EN BD
        if ($mealModel->insert($datosComida)) {
            return redirect()->to(base_url('comidas'))->with('success', '¡Comida registrada exitosamente en tu diario!');
        } else {
            return redirect()->to(base_url('comidas'))->with('fail', 'Error al registrar la comida. Intenta de nuevo.');
        }
    }
}