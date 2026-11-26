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
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [ // FK: ajustado
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'condition_id' => [ // FK: ajustado
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['user_id', 'condition_id']);
        $this->forge->addKey('condition_id');

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('condition_id', 'health_conditions', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('user_conditions');
    }
    public function down() { $this->forge->dropTable('user_conditions'); }
}