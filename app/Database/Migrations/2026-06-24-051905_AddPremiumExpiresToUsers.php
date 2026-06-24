<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddPremiumExpiresToUsers extends Migration
{
    public function up()
    {
        // Añadimos la columna a la tabla users
        $this->forge->addColumn('users', [
            'premium_expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'premium_expires_at');
    }
}
