<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserPantriesTable extends Migration
{
    public function up() {
    $this->forge->addField([
        'user_id' => ['type' => 'INT'],
        'ingredient_id' => ['type' => 'INT'],
        'quantity' => ['type' => 'DECIMAL', 'constraint' => '6,2', 'null' => true],
    ]);
    $this->forge->addKey(['user_id', 'ingredient_id'], true);
    $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('ingredient_id', 'ingredients', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('user_pantries');
    }
        public function down() { $this->forge->dropTable('user_pantries'); }
        
}
