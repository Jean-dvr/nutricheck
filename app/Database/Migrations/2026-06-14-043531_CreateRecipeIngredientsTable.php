<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecipeIngredientsTable extends Migration
{
    public function up() 
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'recipe_id'       => ['type' => 'INT'],
            'ingredient_id'   => ['type' => 'INT'],
            'quantity'        => ['type' => 'DECIMAL', 'constraint' => '6,2'],
            'unit_of_measure' => ['type' => 'VARCHAR', 'constraint' => '20'],
        ]);

        // 1. Llave primaria simple
        $this->forge->addKey('id', true);
        
        // 2. Índice único (Una receta no debe tener listado el mismo ingrediente dos veces en filas separadas)
        $this->forge->addUniqueKey(['recipe_id', 'ingredient_id']);
        
        // 3. Índice de búsqueda para cuando el motor busque "recetas que contengan este ingrediente"
        $this->forge->addKey('ingredient_id');

        // Llaves foráneas
        $this->forge->addForeignKey('recipe_id', 'recipes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ingredient_id', 'ingredients', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('recipe_ingredients');
    }

    public function down() 
    { 
        $this->forge->dropTable('recipe_ingredients'); 
    }
}