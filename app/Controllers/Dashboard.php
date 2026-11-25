<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BannersModel;
use App\Models\NotificationsModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $notifModel = new NotificationsModel();
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

                // Notificación persistente en la campanita
                $notifModel->notificarUsuario(
                    (int) $usuario['id'],
                    'Tu suscripción Premium caducó',
                    'Tu plan NutriCheckPro ha vencido. Renueva ahora para recuperar tus beneficios sin anuncios.',
                    'premium/checkout',
                    'pago'
                );
            } else {
                // Aviso preventivo cuando falten 5 días o menos para vencer (máximo 1 aviso cada 24h)
                $diasRestantes = (int) ceil((strtotime($usuario['premium_expires_at']) - time()) / 86400);
                if ($diasRestantes > 0 && $diasRestantes <= 5) {
                    $tituloAviso = 'Tu plan NutriCheckPro vence pronto';
                    if (!$notifModel->existeReciente((int) $usuario['id'], 'pago', $tituloAviso, 24)) {
                        $etiquetaDias = ($diasRestantes === 1) ? '1 día' : "{$diasRestantes} días";
                        $notifModel->notificarUsuario(
                            (int) $usuario['id'],
                            $tituloAviso,
                            "Te quedan {$etiquetaDias} de suscripción. Prolonga tu plan para no perder acceso a Noticias.",
                            'premium/checkout',
                            'pago'
                        );
                    }
                }
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
            
            $bannersModel = new BannersModel();
            $bannersModel->insert(['image_url' => $nombreFoto]);

            // Notificar cambio en el sistema al personal
            $notifModel = new NotificationsModel();
            $notifModel->notificarPorRoles(
                ['nutricionista', 'admin'],
                'Cambio en el sistema',
                'Se ha añadido un nuevo banner publicitario a la rotación de NutriCheck.',
                'dashboard',
                'sistema',
                (int) session()->get('loggedUser')
            );
            
            return redirect()->back()->with('success', '¡Nuevo banner añadido a la rotación exitosamente!');
        }

        return redirect()->back()->with('fail', 'Error al subir la imagen.');
    }
    
    public function eliminarAnuncio(int $id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->back()->with('fail', 'No tienes permisos para realizar esta acción.');
        }

        $bannersModel = new BannersModel();
        $banner = $bannersModel->find($id);

        if ($banner) {
            $rutaArchivo = FCPATH . 'assets/ads/' . $banner['image_url'];
            
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
            
            $bannersModel->delete($id);

            // Notificar cambio en el sistema al personal
            $notifModel = new NotificationsModel();
            $notifModel->notificarPorRoles(
                ['nutricionista', 'admin'],
                'Cambio en el sistema',
                'Se ha eliminado un banner publicitario de la rotación.',
                'dashboard',
                'sistema',
                (int) session()->get('loggedUser')
            );
            
            return redirect()->back()->with('success', '¡Banner publicitario eliminado exitosamente!');
        }

        return redirect()->back()->with('fail', 'El banner no existe o ya fue eliminado.');
    }
}