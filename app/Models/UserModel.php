<?php

namespace App\Models;

use CodeIgniter\Model;


 /*Modelo de Usuarios para NutriCheck.
 Gestiona la conexión y las reglas de interacción con la tabla de usuarios en la base de datos.
 */
class UserModel extends Model
{

    // CONFIGURACIÓN DE LA TABLA
    protected $table            = 'users'; // Nombre de la tabla en la base de datos
    protected $primaryKey       = 'id';    // Clave primaria de la tabla
    protected $useAutoIncrement = true;
    // Queremos que las consultas nos devuelvan arreglos para un manejo más rápido
    protected $returnType       = 'array';

    // SEGURIDAD DE ASIGNACIÓN MASIVA
    
    // ¡Súper importante! Solo estos campos pueden ser modificados por el usuario.
    // Protege contra la inyección de columnas no autorizadas (ej. cambiar un rol o permisos).
    protected $allowedFields    = ['name', 'email', 'password'];

    
    // AUDITORÍA AUTOMÁTICA
    // Le indica a CodeIgniter que maneje las fechas de creación y actualización automáticamente.
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * @var bool $useSoftDeletes Activa la eliminación lógica. Cuando ejecutes un delete(),
     * el registro NO se borrará físicamente del disco duro; se mantendrá guardado pero oculto.
     */
    protected $useSoftDeletes   = true;

    /**
     * @var string $deletedField Columna que almacena la fecha del borrado. Si este campo está en
     * NULL, el usuario está activo. Si tiene una fecha, CodeIgniter lo ignorará en las consultas
     * normales (findAll() o first()), simulando que ya no existe (ideal para resguardar historial médico).
     */
    protected $deletedField     = 'deleted_at';
}