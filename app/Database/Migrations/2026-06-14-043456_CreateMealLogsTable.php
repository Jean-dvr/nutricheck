<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMealLogsTable extends Migration
{
    public function up() {
    $this->forge->addField([
        'id' => ['type' => 'INT', 'auto_increment' => true],
        'user_id' => ['type' => 'INT'],
        'recipe_id' => ['type' => 'INT'],
        'meal_type' => ['type' => 'ENUM', 'constraint' => ['breakfast', 'lunch', 'dinner', 'snack']],
        'log_date' => ['type' => 'DATE'],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('recipe_id', 'recipes', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('meal_logs');
    }
        public function down() { $this->forge->dropTable('meal_logs'); }

}
