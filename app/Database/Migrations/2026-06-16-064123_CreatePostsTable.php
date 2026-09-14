<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ],
            'contents'   => [
                'type' => 'TEXT'
                ],
            'category'   => [
                'type'       => 'ENUM',
                'constraint' => ['general','eventos','recetas','novedades','nutricion','bienestar'],
                'default'    => 'general'
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'approved'],
                'default'    => 'pending'
            ],
            'image_url'  => [
                'type' => 'VARCHAR',
                'constraint' => '255', 
                'null' => true
                ],
            'created_at' => [
                'type' => 'DATETIME', 
                'null' => true
                ],
            'updated_at' => [
                'type' => 'DATETIME', 
                'null' => true
                ],
        ]);

        // Definir la llave primaria
        $this->forge->addKey('id', true);
        
        // Llave foránea
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('posts');
    }

    public function down() {$this->forge->dropTable('posts');}
}