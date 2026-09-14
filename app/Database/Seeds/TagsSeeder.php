<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TagsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Vegano', 
                'color_hex' => '#28a745'
            ],
            [
                'name' => 'Alto en Proteína', 
                'color_hex' => '#dc3545'
            ],
            [
                'name' => 'Keto', 
                'color_hex' => '#ffc107'
            ],
            [
                'name' => 'Sin Gluten', 
                'color_hex' => '#17a2b8'
            ],
            [
                'name' => 'Desayuno', 
                'color_hex' => '#fd7e14'
            ]
        ];
        
        $this->db->table('tags')->insertBatch($data);
    }
}
