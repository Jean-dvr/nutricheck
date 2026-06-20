<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title'          => 'Tazón de Avena y Leche',
                'preparation'    => 'Mezclar la avena con la leche tibia.',
                'total_calories' => 450
            ],
            [
                'title'          => 'Snack de Maní Energético',
                'preparation'    => 'Porción directa de maní tostado.',
                'total_calories' => 280
            ]
        ];
        $this->db->table('recipes')->insertBatch($data);
    }
}