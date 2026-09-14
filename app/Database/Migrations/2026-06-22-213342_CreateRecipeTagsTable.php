<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecipeTagsTable extends Migration
{
    public function up() 
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'recipe_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'tag_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['recipe_id', 'tag_id']);

        $this->forge->addForeignKey('recipe_id', 'recipes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tag_id', 'tags', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('recipe_tags');
    }
    public function down() { $this->forge->dropTable('recipe_tags'); }
}