<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserConditionsTable extends Migration
{
    public function up() 
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id'      => ['type' => 'INT'],
            'condition_id' => ['type' => 'INT'],
        ]);

        // 1. Llave primaria simple
        $this->forge->addKey('id', true);
        
        // 2. Índice único para evitar duplicados
        $this->forge->addUniqueKey(['user_id', 'condition_id']);
        
        // 3. Índice de búsqueda para optimizar filtros por condición
        $this->forge->addKey('condition_id');

        // Llaves foráneas
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('condition_id', 'health_conditions', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('user_conditions');
    }

    public function down() 
    { 
        $this->forge->dropTable('user_conditions'); 
    }
}


