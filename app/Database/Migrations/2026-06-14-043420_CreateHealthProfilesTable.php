<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHealthProfilesTable extends Migration
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
            'user_id' => [ // FK: ajustado a INT(11) UNSIGNED para coincidir con users.id
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'unique'     => true,
            ],
            'weight_kg' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'unsigned'   => true,
            ],
            'height_cm' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'current_bmi' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,2',
                'unsigned'   => true,
                'null'       => true,
            ],
            'goal' => [
                'type'       => 'ENUM',
                'constraint' => ['lose_fat', 'gain_muscle', 'maintenance'],
            ],
            'waist_measure' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('health_profiles');
    }
    public function down() { $this->forge->dropTable('health_profiles'); }
}