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
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [ // FK: ajustado
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'ingredient_id' => [ // FK: ajustado
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'quantity' => [
                'type'       => 'DECIMAL',
                'constraint' => '6,2',
                'null'       => true,
                'unsigned' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['user_id', 'ingredient_id']);
        
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ingredient_id', 'ingredients', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('user_pantries');
    }
    public function down() { $this->forge->dropTable('user_pantries'); }
}