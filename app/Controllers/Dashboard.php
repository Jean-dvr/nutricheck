<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $userModel = new \App\Models\UserModel();
        $usuario = $userModel->find(session()->get('loggedUser'));

        // EL VIGILANTE DE SUSCRIPCIONES
        if ($usuario && $usuario['rol'] === 'premium' && !empty($usuario['premium_expires_at'])) {
            if (date('Y-m-d H:i:s') > $usuario['premium_expires_at']) {
                $userModel->update($usuario['id'], [
                    'rol' => 'free',
                    'premium_expires_at' => null
                ]);
                session()->set('rol', 'free');
                session()->setFlashdata('fail', 'Tu suscripción Premium ha caducado. ¡Renueva para seguir disfrutando sin anuncios!');
            }
        }

        // Carga de comidas reales del usuario activo desde la tabla meal_logs
        $db = \Config\Database::connect();
        $builder = $db->table('meal_logs');
        $comidas = $builder->where('user_id', session()->get('loggedUser'))->get()->getResultArray();

        $data['comidas'] = $comidas;
        
        // ----------------------------------------------------------------------
        // NUEVO: Pasa el avatar guardado en BD a la vista (si existe)
        // ----------------------------------------------------------------------
        $data['avatar_usuario'] = !empty($usuario['avatar']) ? $usuario['avatar'] : null;

        return view('Dashboard/index', $data);
    }

    public function actualizarAnuncio()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->back()->with('fail', 'No tienes permisos.');
        }

        $archivo = $this->request->getFile('nuevo_anuncio');
        
        if ($archivo && $archivo->isValid() && !$archivo->hasMoved()) {
            $nombreFoto = $archivo->getRandomName(); 
            
            $rutaDestino = FCPATH . 'assets/ads';
            if (!is_dir($rutaDestino)) { mkdir($rutaDestino, 0777, true); }

            $archivo->move($rutaDestino, $nombreFoto);
            
            $bannersModel = new \App\Models\BannersModel();
            $bannersModel->insert(['image_url' => $nombreFoto]);
            
            return redirect()->back()->with('success', '¡Nuevo banner añadido a la rotación exitosamente!');
        }

        return redirect()->back()->with('fail', 'Error al subir la imagen.');
    }
    
    public function eliminarAnuncio($id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->back()->with('fail', 'No tienes permisos para realizar esta acción.');
        }

        $bannersModel = new \App\Models\BannersModel();
        $banner = $bannersModel->find($id);

        if ($banner) {
            $rutaArchivo = FCPATH . 'assets/ads/' . $banner['image_url'];
            
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
            
            $bannersModel->delete($id);
            
            return redirect()->back()->with('success', '¡Banner publicitario eliminado exitosamente!');
        }

        return redirect()->back()->with('fail', 'El banner no existe o ya fue eliminado.');
    }
}