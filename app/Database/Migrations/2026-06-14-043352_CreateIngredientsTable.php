<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIngredientsTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'category' => [
                'type'       => 'ENUM',
                'constraint' => ['proteina', 'carbohidrato', 'grasa', 'vegetal', 'fruta', 'lacteo', 'especia', 'otro'],
                'default'    => 'otro',
            ],
            'calories_per_100g' => [
                'type'       => 'DECIMAL',
                'constraint' => '6,2',
            ],
            'protein_g' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0,
            ],
            'carb_g' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0,
            ],
            'fat_g' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0,
            ],
            'image_url' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('ingredients');
    }
    public function down() { $this->forge->dropTable('ingredients'); }
}
