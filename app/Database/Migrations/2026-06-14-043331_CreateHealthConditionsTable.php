<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHealthConditionsTable extends Migration
{
    public function up() {
    $this->forge->addField([
        'id'   => ['type' => 'INT', 'auto_increment' => true],
        'name' => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true],
        'type' => ['type' => 'ENUM', 'constraint' => ['pathology', 'allergy', 'intolerance']],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('health_conditions');
    }
        public function down() { $this->forge->dropTable('health_conditions'); }

}
