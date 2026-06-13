<?php

namespace App\Models;

use CodeIgniter\Model;


 /*Modelo de Usuarios para NutriCheck.
 Gestiona la conexión y las reglas de interacción con la tabla de usuarios en la base de datos.
 */
class UsuarioModel extends Model
{

    // CONFIGURACIÓN DE LA TABLA
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id_usuario';
    protected $useAutoIncrement = true;
    
    // Queremos que las consultas nos devuelvan arreglos para un manejo más rápido
    protected $returnType       = 'array';

    // SEGURIDAD DE ASIGNACIÓN MASIVA
    
    // ¡Súper importante! Solo estos campos pueden ser modificados por el usuario.
    // Protege contra la inyección de columnas no autorizadas (ej. cambiar un rol o permisos).
    protected $allowedFields    = ['nombre', 'correo', 'password'];

    
    // AUDITORÍA AUTOMÁTICA
    // Le indica a CodeIgniter que maneje las fechas de creación y actualización automáticamente.
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}