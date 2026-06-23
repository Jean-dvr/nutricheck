<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IngredientsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Pechuga de pollo', 'category' => 'proteina', 'calories_per_100g' => 165, 'protein_g' => 31, 'carb_g' => 0, 'fat_g' => 3.6],
            ['name' => 'Arroz integral', 'category' => 'carbohidrato', 'calories_per_100g' => 111, 'protein_g' => 2.6, 'carb_g' => 23, 'fat_g' => 0.9],
            ['name' => 'Aguacate', 'category' => 'grasa', 'calories_per_100g' => 160, 'protein_g' => 2, 'carb_g' => 8.5, 'fat_g' => 14.7],
            ['name' => 'Tomate', 'category' => 'vegetal', 'calories_per_100g' => 18, 'protein_g' => 0.9, 'carb_g' => 3.9, 'fat_g' => 0.2],
            ['name' => 'Harina de maíz precocida', 'category' => 'carbohidrato', 'calories_per_100g' => 360, 'protein_g' => 7, 'carb_g' => 79, 'fat_g' => 1],
            ['name' => 'Huevos', 'category' => 'proteina', 'calories_per_100g' => 155, 'protein_g' => 13, 'carb_g' => 1.1, 'fat_g' => 11],
        ];

        $this->db->table('ingredients')->insertBatch($data);
    }
}