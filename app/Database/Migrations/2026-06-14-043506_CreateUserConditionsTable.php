<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserConditionsTable extends Migration
{
    public function up() {
    $this->forge->addField([
        'user_id' => ['type' => 'INT'],
        'condition_id' => ['type' => 'INT'],
    ]);
    $this->forge->addKey(['user_id', 'condition_id'], true);
    $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('condition_id', 'health_conditions', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('user_conditions');
    }
        public function down() { $this->forge->dropTable('user_conditions'); }

}
