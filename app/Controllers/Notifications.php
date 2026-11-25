<?php

namespace App\Controllers;

use App\Models\NotificationsModel;

class Notifications extends BaseController
{
    /**
     * Marca una notificación como leída y redirige al destino correspondiente.
     */
    public function leer(int $id)
    {
        $userId = (int) session()->get('loggedUser');
        $notifModel = new NotificationsModel();

        $notificacion = $notifModel->where('id', $id)
                                   ->where('user_id', $userId)
                                   ->first();

        if (!$notificacion) {
            return redirect()->to(base_url('dashboard'));
        }

        if ((int) $notificacion['is_read'] === 0) {
            $notifModel->update($id, ['is_read' => 1]);
        }

        $destino = trim((string) ($notificacion['link'] ?? 'dashboard'));
        if ($destino === '') {
            $destino = 'dashboard';
        }

        return redirect()->to(base_url(ltrim($destino, '/')));
    }

    /**
     * Marca todas las notificaciones del usuario autenticado como leídas.
     */
    public function marcarTodas()
    {
        $userId = (int) session()->get('loggedUser');
        $notifModel = new NotificationsModel();

        $notifModel->where('user_id', $userId)
                   ->where('is_read', 0)
                   ->set(['is_read' => 1])
                   ->update();

        return redirect()->back();
    }
}