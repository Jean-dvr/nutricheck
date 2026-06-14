<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIngredientsTable extends Migration
{
    public function up() {
    $this->forge->addField([
        'id' => ['type' => 'INT', 'auto_increment' => true],
        'name' => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true],
        'calories_per_100g' => ['type' => 'DECIMAL', 'constraint' => '6,2'],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('ingredients');
    }
        public function down() { $this->forge->dropTable('ingredients'); }

}
