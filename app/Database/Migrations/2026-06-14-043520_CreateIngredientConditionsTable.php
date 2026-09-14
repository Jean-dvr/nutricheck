<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIngredientConditionsTable extends Migration
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
            'ingredient_id' => [ // FK: ajustado
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'condition_id' => [ // FK: ajustado
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        // 1. Llave primaria simple
        $this->forge->addKey('id', true);
        
        // 2. Índice único para evitar duplicados
        $this->forge->addUniqueKey(['ingredient_id', 'condition_id']);
        
        // 3. Índice de búsqueda para filtros automáticos de alergias
        $this->forge->addKey('ingredient_id');
        $this->forge->addKey('condition_id');

        // Llaves foráneas
        $this->forge->addForeignKey('ingredient_id', 'ingredients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('condition_id', 'health_conditions', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('ingredient_conditions');
    }

    public function down() { $this->forge->dropTable('ingredient_conditions');}
}