<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TagsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // --- ETIQUETAS BASE (IDs 1 al 5) ---
            // ID 1
            [
                'name' => 'Vegano', 
                'color_hex' => '#28a745'
            ],
            // ID 2
            [
                'name' => 'Alto en Proteína', 
                'color_hex' => '#dc3545'
            ],
            // ID 3
            [
                'name' => 'Keto', 
                'color_hex' => '#ffc107'
            ],
            // ID 4
            [
                'name' => 'Sin Gluten', 
                'color_hex' => '#17a2b8'
            ],
            // ID 5
            [
                'name' => 'Desayuno', 
                'color_hex' => '#fd7e14'
            ],

            // --- NUEVAS ETIQUETAS (IDs 6 al 11) ---
            // ID 6
            [
                'name' => 'Almuerzo', 
                'color_hex' => '#007bff'
            ],
            // ID 7
            [
                'name' => 'Cena', 
                'color_hex' => '#6f42c1'
            ],
            // ID 8
            [
                'name' => 'Merienda', 
                'color_hex' => '#e83e8c'
            ],
            // ID 9
            [
                'name' => 'Bajo en Sodio', 
                'color_hex' => '#20c997'
            ],
            // ID 10
            [
                'name' => 'Rico en Fibra', 
                'color_hex' => '#198754'
            ],
            // ID 11
            [
                'name' => 'Económico', 
                'color_hex' => '#6c757d'
            ],
        ];
        
        $this->db->table('tags')->insertBatch($data);
    }
}
