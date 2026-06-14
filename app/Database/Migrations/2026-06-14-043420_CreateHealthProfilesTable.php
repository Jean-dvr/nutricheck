<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHealthProfilesTable extends Migration
{
    public function up() {
    $this->forge->addField([
        'id' => ['type' => 'INT', 'auto_increment' => true],
        'user_id' => ['type' => 'INT', 'unique' => true],
        'weight_kg' => ['type' => 'DECIMAL', 'constraint' => '5,2'],
        'height_cm' => ['type' => 'INT'],
        'current_bmi' => ['type' => 'DECIMAL', 'constraint' => '4,2', 'null' => true],
        'goal' => ['type' => 'ENUM', 'constraint' => ['lose_fat', 'gain_muscle', 'maintenance']],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('health_profiles');
    }
        public function down() { $this->forge->dropTable('health_profiles'); }

}
