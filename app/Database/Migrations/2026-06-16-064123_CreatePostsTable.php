<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'user_id'     => ['type' => 'INT'], // Llave foránea
            'title'       => ['type' => 'VARCHAR', 'constraint' => '255'],
            'contents'    => ['type' => 'TEXT'],
            'category'    => ['type' => 'ENUM', 'constraint' => ['general', 'eventos', 'recetas'], 'default' => 'general'],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved'], 'default' => 'pending'],
            'image_url'   => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        // Definir la llave primaria
        $this->forge->addKey('id', true);

        // Definir la llave foránea (relación con tabla usuarios)
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        // Crear la tabla
        $this->forge->createTable('posts');
    }

    public function down() { $this->forge->dropTable('posts');}
}