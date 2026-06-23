<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Redirige al login si intentan entrar sin iniciar sesión
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        return view('Dashboard/index');
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