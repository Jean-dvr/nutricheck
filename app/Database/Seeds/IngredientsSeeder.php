<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IngredientsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Maní Tostado', 'calories_per_100g' => 567.00],
            ['name' => 'Leche Líquida Completa', 'calories_per_100g' => 61.00],
            ['name' => 'Avena en Hojuelas', 'calories_per_100g' => 389.00],
        ];
        $this->db->table('ingredients')->insertBatch($data);
    }
}