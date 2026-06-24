<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $userModel = new \App\Models\UserModel();
        $usuario = $userModel->find(session()->get('loggedUser'));

        // EL VIGILANTE DE SUSCRIPCIONES
        // Si es Premium y la fecha actual es mayor a su fecha de expiración...
        if ($usuario['rol'] === 'premium' && !empty($usuario['premium_expires_at'])) {
            if (date('Y-m-d H:i:s') > $usuario['premium_expires_at']) {
                
                // 1. Le quitamos el rol en la base de datos y vaciamos la fecha
                $userModel->update($usuario['id'], [
                    'rol' => 'free',
                    'premium_expires_at' => null
                ]);

                // 2. Le quitamos el rol en la sesión actual
                session()->set('rol', 'free');

                // 3. Le avisamos que su suscripción terminó
                session()->setFlashdata('fail', 'Tu suscripción Premium ha caducado. ¡Renueva para seguir disfrutando sin anuncios!');
            }
        }

        // ... (El resto de tu código del Dashboard para cargar estadísticas sigue abajo) ...
        return view('dashboard/index');
    }

    public function actualizarAnuncio()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->back()->with('fail', 'No tienes permisos.');
        }

        $archivo = $this->request->getFile('nuevo_anuncio');
        
        if ($archivo && $archivo->isValid() && !$archivo->hasMoved()) {
            // Generamos un nombre aleatorio para evitar colisiones
            $nombreFoto = $archivo->getRandomName(); 
            
            $rutaDestino = FCPATH . 'assets/ads';
            if (!is_dir($rutaDestino)) { mkdir($rutaDestino, 0777, true); }

            // Movemos el archivo
            $archivo->move($rutaDestino, $nombreFoto);
            
            // Insertamos el registro en la base de datos
            $bannersModel = new \App\Models\BannersModel();
            $bannersModel->insert(['image_url' => $nombreFoto]);
            
            return redirect()->back()->with('success', '¡Nuevo banner añadido a la rotación exitosamente!');
        }

        return redirect()->back()->with('fail', 'Error al subir la imagen.');
    }
    
    public function eliminarAnuncio($id)
    {
        // Seguridad: Solo el administrador puede ejecutar esta acción
        if (session()->get('rol') !== 'admin') {
            return redirect()->back()->with('fail', 'No tienes permisos para realizar esta acción.');
        }

        $bannersModel = new \App\Models\BannersModel();
        $banner = $bannersModel->find($id);

        if ($banner) {
            // Ruta exacta del archivo en el servidor
            $rutaArchivo = FCPATH . 'assets/ads/' . $banner['image_url'];
            
            // 1. Borramos la imagen física de la carpeta
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
            
            // 2. Borramos el registro de la base de datos
            $bannersModel->delete($id);
            
            return redirect()->back()->with('success', '¡Banner publicitario eliminado exitosamente!');
        }

        return redirect()->back()->with('fail', 'El banner no existe o ya fue eliminado.');
    }
}