<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecipeConditionsTable extends Migration
{
    public function up() 
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'recipe_id'    => ['type' => 'INT'],
            'condition_id' => ['type' => 'INT'],
        ]);

        // 1. Llave primaria simple
        $this->forge->addKey('id', true);
        
        // 2. Índice único para evitar etiquetas duplicadas en una receta
        $this->forge->addUniqueKey(['recipe_id', 'condition_id']);
        
        // 3. Índice de búsqueda (esencial para el filtro de recetas aptas/no aptas)
        $this->forge->addKey('condition_id');

        // Llaves foráneas
        $this->forge->addForeignKey('recipe_id', 'recipes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('condition_id', 'health_conditions', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('recipe_conditions');
    }

    public function down() 
    { 
        $this->forge->dropTable('recipe_conditions'); 
    }
}