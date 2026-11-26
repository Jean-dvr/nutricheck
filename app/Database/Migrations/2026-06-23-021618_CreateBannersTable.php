<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBannersTable extends Migration
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
            'image_url' => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ],
            'orientation' => [
                'type'       => 'ENUM',
                'constraint' => ['vertical', 'horizontal'],
                'default'    => 'vertical'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('banners');
    }
    public function down() { $this->forge->dropTable('banners'); }
}