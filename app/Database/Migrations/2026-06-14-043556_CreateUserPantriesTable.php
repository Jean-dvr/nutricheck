<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserPantriesTable extends Migration
{
    public function up() 
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id'       => ['type' => 'INT'],
            'ingredient_id' => ['type' => 'INT'],
            'quantity'      => ['type' => 'DECIMAL', 'constraint' => '6,2', 'null' => true],
        ]);

        // 1. Llave primaria simple
        $this->forge->addKey('id', true);
        
        // 2. Índice único (Un usuario no puede tener dos filas para "Manzana", solo una fila actualizando la 'quantity')
        $this->forge->addUniqueKey(['user_id', 'ingredient_id']);
        
        // 3. Índice de búsqueda
        $this->forge->addKey('ingredient_id');

        // Llaves foráneas
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ingredient_id', 'ingredients', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('user_pantries');
    }

    public function down() 
    { 
        $this->forge->dropTable('user_pantries'); 
    }
}