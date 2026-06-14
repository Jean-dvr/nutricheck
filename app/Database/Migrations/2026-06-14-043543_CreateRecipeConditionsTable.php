<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecipeConditionsTable extends Migration
{
    public function up() {
    $this->forge->addField([
        'recipe_id' => ['type' => 'INT'],
        'condition_id' => ['type' => 'INT'],
    ]);
    $this->forge->addKey(['recipe_id', 'condition_id'], true);
    $this->forge->addForeignKey('recipe_id', 'recipes', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('condition_id', 'health_conditions', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('recipe_conditions');
    }
        public function down() { $this->forge->dropTable('recipe_conditions'); }  

}
