<?php

namespace App\Models;

use CodeIgniter\Model;

class BannersModel extends Model
{
    protected $table            = 'banners';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['image_url', 'orientation', 'created_at'];
    
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; // No necesitamos updated_at aquí
}