<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecipesTable extends Migration
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
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
                'default'        => null
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'preparation' => [
                'type' => 'TEXT',
            ],
            'prep_time_minutes' => [
                'type' => 'INT',
                'null' => true,
            ],
            'difficulty' => [
                'type'       => 'ENUM',
                'constraint' => ['facil', 'media', 'dificil'],
                'default'    => 'media',
            ],
            'portions' => [
                'type'    => 'INT',
                'default' => 1,
            ],
            'total_calories' => [
                'type' => 'INT',
            ],
            'is_approved' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 1,
            ],
            'image_url' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('recipes');
    }
    public function down() { $this->forge->dropTable('recipes'); }
}