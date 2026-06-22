<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIngredientConditionsTable extends Migration
{
    public function up() 
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ingredient_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'condition_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['ingredient_id', 'condition_id']);
        
        $this->forge->addKey('ingredient_id');
        $this->forge->addKey('condition_id');

        $this->forge->addForeignKey('ingredient_id', 'ingredients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('condition_id', 'health_conditions', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('ingredient_conditions');
    }

    public function down() { $this->forge->dropTable('ingredient_conditions'); }
}