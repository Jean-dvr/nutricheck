<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIngredientConditionsTable extends Migration
{
    public function up() {
    $this->forge->addField([
        'ingredient_id' => ['type' => 'INT'],
        'condition_id' => ['type' => 'INT'],
    ]);
    $this->forge->addKey(['ingredient_id', 'condition_id'], true);
    $this->forge->addForeignKey('ingredient_id', 'ingredients', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('condition_id', 'health_conditions', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('ingredient_conditions');
    }
        public function down() { $this->forge->dropTable('ingredient_conditions'); }

}
