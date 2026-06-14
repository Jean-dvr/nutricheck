<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecipeIngredientsTable extends Migration
{
   public function up() {
    $this->forge->addField([
        'recipe_id' => ['type' => 'INT'],
        'ingredient_id' => ['type' => 'INT'],
        'quantity' => ['type' => 'DECIMAL', 'constraint' => '6,2'],
        'unit_of_measure' => ['type' => 'VARCHAR', 'constraint' => '20'],
    ]);
    $this->forge->addKey(['recipe_id', 'ingredient_id'], true);
    $this->forge->addForeignKey('recipe_id', 'recipes', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('ingredient_id', 'ingredients', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('recipe_ingredients');
    }
        public function down() { $this->forge->dropTable('recipe_ingredients'); }

}
