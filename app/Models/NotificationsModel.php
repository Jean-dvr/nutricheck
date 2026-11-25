<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo de Notificaciones para NutriCheck.
 * Gestiona el envío, consulta y lectura de alertas persistentes en la campanita.
 */
class NotificationsModel extends Model
{
    protected $table            = 'notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id',
        'title',
        'message',
        'link',
        'type',
        'is_read',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Envía una notificación individual a un usuario específico.
     */
    public function notificarUsuario(
        int $userId,
        string $title,
        string $message,
        string $link = 'dashboard',
        string $type = 'sistema'
    ): bool {
        if ($userId <= 0 || !$this->db->tableExists($this->table)) {
            return false;
        }

        return (bool) $this->insert([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'link'    => ltrim($link, '/'),
            'type'    => $type,
            'is_read' => 0,
        ]);
    }

    /**
     * Envía la misma notificación a todos los usuarios activos que pertenezcan a uno o más roles.
     *
     * @param list<string> $roles
     */
    public function notificarPorRoles(
        array $roles,
        string $title,
        string $message,
        string $link = 'dashboard',
        string $type = 'sistema',
        ?int $excluirUserId = null
    ): void {
        if (empty($roles) || !$this->db->tableExists($this->table)) {
            return;
        }

        $userModel = new UserModel();
        $usuarios  = $userModel->select('id')->whereIn('rol', $roles)->findAll();

        if (empty($usuarios)) {
            return;
        }

        $ahora = date('Y-m-d H:i:s');
        $lote  = [];

        foreach ($usuarios as $usuario) {
            $idDestino = (int) $usuario['id'];
            if ($excluirUserId !== null && $idDestino === $excluirUserId) {
                continue;
            }

            $lote[] = [
                'user_id'    => $idDestino,
                'title'      => $title,
                'message'    => $message,
                'link'       => ltrim($link, '/'),
                'type'       => $type,
                'is_read'    => 0,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ];
        }

        if (!empty($lote)) {
            $this->insertBatch($lote);
        }
    }

    /**
     * Obtiene las notificaciones más recientes de un usuario.
     */
    public function obtenerParaUsuario(int $userId, int $limite = 12): array
    {
        if ($userId <= 0 || !$this->db->tableExists($this->table)) {
            return [];
        }

        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->findAll($limite);
    }

    /**
     * Cuenta cuántas notificaciones sin leer tiene un usuario.
     */
    public function contarNoLeidas(int $userId): int
    {
        if ($userId <= 0 || !$this->db->tableExists($this->table)) {
            return 0;
        }

        return (int) $this->where('user_id', $userId)
                          ->where('is_read', 0)
                          ->countAllResults();
    }

    /**
     * Verifica si ya existe una notificación idéntica reciente para evitar duplicados (ej. aviso de vencimiento).
     */
    public function existeReciente(int $userId, string $type, string $title, int $horas = 24): bool
    {
        if ($userId <= 0 || !$this->db->tableExists($this->table)) {
            return false;
        }

        $desde = date('Y-m-d H:i:s', strtotime("-{$horas} hours"));

        return $this->where('user_id', $userId)
                    ->where('type', $type)
                    ->where('title', $title)
                    ->where('created_at >=', $desde)
                    ->countAllResults() > 0;
    }
}