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
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'recipe_id' => [ // FK: ajustado
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'ingredient_id' => [ // FK: ajustado
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'quantity' => [
                'type'       => 'DECIMAL',
                'constraint' => '6,2',
                'unsigned' => true
            ],
            'unit_of_measure' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'is_main_ingredient' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
                'default'    => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['recipe_id', 'ingredient_id']);
        
        $this->forge->addKey('ingredient_id');
        $this->forge->addKey('recipe_id'); // Te recomiendo agregar este índice también

        // Llaves foráneas
        $this->forge->addForeignKey('recipe_id', 'recipes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ingredient_id', 'ingredients', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('recipe_ingredients');
    }
    public function down() { $this->forge->dropTable('recipe_ingredients');}
}