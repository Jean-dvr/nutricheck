<?php

namespace App\Controllers;

use App\Models\MealLogsModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Controlador de Racha de Comidas (CRUD del historial del usuario).
 */
class MealLogs extends BaseController
{
    private array $tiposComidaValidos = ['breakfast', 'lunch', 'dinner', 'snack'];
    private array $extensionesPermitidas = ['png', 'jpg', 'jpeg'];
    private string $directorioImagenes = 'assets/meallogsimg';

    /**
     * Lista el historial de comidas del usuario ordenadas por fecha y hora.
     */
    public function index(): string
    {
        $userId    = session()->get('loggedUser');
        $mealModel = new MealLogsModel();

        $comidas = $mealModel->where('user_id', $userId)
                             ->orderBy('meal_date', 'DESC')
                             ->orderBy('meal_time', 'DESC')
                             ->findAll();

        return view('meallogs/index', [
            'historial_comidas' => $comidas,
        ]);
    }

    /**
     * Valida y guarda una nueva comida (y su foto opcional).
     */
    public function guardar(): RedirectResponse
    {
        $userId    = session()->get('loggedUser');
        $mealModel = new MealLogsModel();

        // Valida campos y descripción (letras, números y espacios)
        if (!$this->validate(config('Validation')->registroComida)) {
            $errores = $this->validator->getErrors();
            return redirect()->to(base_url('comidas'))->withInput()->with('fail', reset($errores));
        }

        $resultadoImagen = $this->procesarImagenComida();
        if (is_array($resultadoImagen) && isset($resultadoImagen['error'])) {
            return redirect()->to(base_url('comidas'))->withInput()->with('fail', $resultadoImagen['error']);
        }

        $mealTypeInput = (string) $this->request->getPost('meal_type');
        $mealType      = in_array($mealTypeInput, $this->tiposComidaValidos, true) ? $mealTypeInput : 'snack';

        $datosComida = [
            'user_id'     => $userId,
            'meal_type'   => $mealType,
            'meal_date'   => $this->request->getPost('meal_date'),
            'meal_time'   => $this->request->getPost('meal_time'),
            'description' => trim((string) $this->request->getPost('description')),
            'image_path'  => $resultadoImagen,
        ];

        if ($mealModel->insert($datosComida)) {
            return redirect()->to(base_url('comidas'))->with('success', '¡Comida registrada exitosamente en tu diario!');
        }

        // Evita dejar archivos subidos si falla el insert
        $this->eliminarArchivoFoto($resultadoImagen);
        return redirect()->to(base_url('comidas'))->withInput()->with('fail', 'Error al registrar la comida. Intenta de nuevo.');
    }

    /**
     * Actualiza una comida existente verificando que pertenezca al usuario.
     */
    public function editar($id = null): RedirectResponse
    {
        $idComida  = (int) ($id ?? $this->request->getPost('id'));
        $userId    = session()->get('loggedUser');
        $mealModel = new MealLogsModel();

        // Verifica propiedad del registro para evitar edición ajena
        $comidaActual = $mealModel->where('id', $idComida)->where('user_id', $userId)->first();
        if (!$comidaActual) {
            return redirect()->to(base_url('comidas'))->with('fail', 'El registro de comida no existe o no tienes permiso para editarlo.');
        }

        if (!$this->validate(config('Validation')->registroComida)) {
            $errores = $this->validator->getErrors();
            return redirect()->to(base_url('comidas'))->withInput()->with('fail', reset($errores));
        }

        $nombreFoto      = $comidaActual['image_path'];
        $resultadoImagen = $this->procesarImagenComida();
        if (is_array($resultadoImagen) && isset($resultadoImagen['error'])) {
            return redirect()->to(base_url('comidas'))->withInput()->with('fail', $resultadoImagen['error']);
        }

        // Reemplaza foto anterior solo si se sube una nueva
        if (!empty($resultadoImagen)) {
            $this->eliminarArchivoFoto($comidaActual['image_path']);
            $nombreFoto = $resultadoImagen;
        }

        $mealTypeInput = (string) $this->request->getPost('meal_type');
        $mealType      = in_array($mealTypeInput, $this->tiposComidaValidos, true)
            ? $mealTypeInput
            : ($comidaActual['meal_type'] ?? 'snack');

        $datosActualizados = [
            'meal_type'   => $mealType,
            'meal_date'   => $this->request->getPost('meal_date'),
            'meal_time'   => $this->request->getPost('meal_time'),
            'description' => trim((string) $this->request->getPost('description')),
            'image_path'  => $nombreFoto,
        ];

        if ($mealModel->update($idComida, $datosActualizados)) {
            return redirect()->to(base_url('comidas'))->with('success', '¡Registro de comida actualizado correctamente!');
        }

        return redirect()->to(base_url('comidas'))->with('fail', 'No se pudo actualizar el registro de comida.');
    }

    /**
     * Elimina un registro de comida del usuario y borra su imagen si existe.
     */
    public function eliminar($id = null): RedirectResponse
    {
        $idComida  = (int) ($id ?? $this->request->getPost('id'));
        $userId    = session()->get('loggedUser');
        $mealModel = new MealLogsModel();

        $comidaActual = $mealModel->where('id', $idComida)->where('user_id', $userId)->first();
        if (!$comidaActual) {
            return redirect()->to(base_url('comidas'))->with('fail', 'El registro de comida no existe o no tienes permiso para eliminarlo.');
        }

        if ($mealModel->delete($idComida)) {
            $this->eliminarArchivoFoto($comidaActual['image_path']);
            return redirect()->to(base_url('comidas'))->with('success', 'Registro de comida eliminado correctamente.');
        }

        return redirect()->to(base_url('comidas'))->with('fail', 'No se pudo eliminar el registro de comida.');
    }

    /**
     * Valida y guarda la foto opcional en public/assets/meallogsimg.
     * Retorna nombre de archivo, ['error' => '...'] o null si no se envió imagen.
     */
    private function procesarImagenComida(): string|array|null
    {
        $archivoFoto = $this->request->getFile('foto_comida');
        if (!$archivoFoto || $archivoFoto->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (!$archivoFoto->isValid()) {
            return ['error' => 'La imagen es muy pesada o está dañada. Máximo 2MB.'];
        }

        $extension = strtolower((string) $archivoFoto->guessExtension());
        if (!in_array($extension, $this->extensionesPermitidas, true)) {
            return ['error' => 'Formato no permitido. Solo se aceptan imágenes JPG o PNG.'];
        }

        $nombreFoto  = $archivoFoto->getRandomName();
        $rutaDestino = FCPATH . $this->directorioImagenes;

        if (!is_dir($rutaDestino)) {
            mkdir($rutaDestino, 0775, true);
        }

        if (!$archivoFoto->move($rutaDestino, $nombreFoto)) {
            return ['error' => 'No se pudo guardar la imagen de la comida en el servidor.'];
        }

        return $nombreFoto;
    }

    /**
     * Borra la imagen física del disco usando basename por seguridad.
     */
    private function eliminarArchivoFoto(?string $nombreArchivo): void
    {
        if (empty($nombreArchivo)) {
            return;
        }

        $rutaCompleta = FCPATH . $this->directorioImagenes . '/' . basename($nombreArchivo);
        if (is_file($rutaCompleta)) {
            @unlink($rutaCompleta);
        }
    }
}