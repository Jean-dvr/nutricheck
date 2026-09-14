<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMealLogsTable extends Migration
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
            'meal_type' => [
                'type'       => 'ENUM',
                'constraint' => ['breakfast', 'lunch', 'dinner', 'snack'],
            ],
            'meal_date' => [
                'type' => 'DATE',
            ],
            'meal_time' => [
                'type' => 'TIME',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'image_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('meal_logs');
    }
    public function down() { $this->forge->dropTable('meal_logs'); }
}