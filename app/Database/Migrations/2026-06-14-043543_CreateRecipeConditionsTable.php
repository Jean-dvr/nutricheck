<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecipeConditionsTable extends Migration
{
    public function up() 
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'recipe_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'condition_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['recipe_id', 'condition_id']);
        $this->forge->addKey('condition_id');

        $this->forge->addForeignKey('recipe_id', 'recipes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('condition_id', 'health_conditions', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('recipe_conditions');
    }

    public function down() { $this->forge->dropTable('recipe_conditions'); }
}