<?php
namespace App\Models;
use CodeIgniter\Model;

class PaymentsModel extends Model
{
    protected $table            = 'payments';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'user_id', 
        'amount', 
        'payment_method', 
        'reference_number', 
        'receipt_image', 'status'
    ];
    
    protected $useTimestamps    = true; // Activa created_at y updated_at automáticamente
}