<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationsTable extends Migration
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
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'message' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'link' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => 'dashboard',
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['pago', 'receta', 'noticia', 'oferta', 'sistema'],
                'default'    => 'sistema',
            ],
            'is_read' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Definir la llave primaria
        $this->forge->addKey('id', true);
        $this->forge->addKey(['user_id', 'is_read']);

        // Llave foránea hacia la tabla users
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('notifications', true);
    }

    public function down()
    {
        $this->forge->dropTable('notifications', true);
    }
}