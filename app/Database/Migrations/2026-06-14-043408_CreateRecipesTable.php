<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecipesTable extends Migration
{
    public function up() {
    $this->forge->addField([
        'id' => ['type' => 'INT', 'auto_increment' => true],
        'title' => ['type' => 'VARCHAR', 'constraint' => '150'],
        'preparation' => ['type' => 'TEXT'],
        'total_calories' => ['type' => 'INT'],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('recipes');
    }
        public function down() { $this->forge->dropTable('recipes'); }

}
