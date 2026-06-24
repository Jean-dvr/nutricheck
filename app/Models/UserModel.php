<?php

namespace App\Models;

use CodeIgniter\Model;


 /*Modelo de Usuarios para NutriCheck.
 Gestiona la conexión y las reglas de interacción con la tabla de usuarios en la base de datos.
 */
class UserModel extends Model
{
    protected $table            = 'users'; 
    protected $primaryKey       = 'id';    
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'name',
        'email',
        'password',
        'rol',
        'created_at',
        'updated_at',
        'deleted_at',
        'sex',
        'birth_date',
        'avatar',
        'premium_expires_at'
        ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $useSoftDeletes   = true;
    protected $deletedField     = 'deleted_at';
}