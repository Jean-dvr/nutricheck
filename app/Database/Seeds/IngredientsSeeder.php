<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IngredientsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Pechuga de pollo',
                'category' => 'proteina', 
                'calories_per_100g' => 165, 
                'protein_g' => 31, 'carb_g' => 0, 
                'fat_g' => 3.6
            ],
            [
                'name' => 'Arroz integral',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 111, 
                'protein_g' => 2.6, 
                'carb_g' => 23, 
                'fat_g' => 0.9
            ],
            [
                'name' => 'Aguacate',
                'category' => 'grasa', 
                'calories_per_100g' => 160, 
                'protein_g' => 2, 
                'carb_g' => 8.5, 
                'fat_g' => 14.7
            ],
            [
                'name' => 'Tomate',
                'category' => 'vegetal', 
                'calories_per_100g' => 18, 
                'protein_g' => 0.9, 
                'carb_g' => 3.9, 
                'fat_g' => 0.2
            ],
            [
                'name' => 'Harina de maíz precocida',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 360, 
                'protein_g' => 7, 
                'carb_g' => 79, 
                'fat_g' => 1
            ],
            [
                'name' => 'Huevos',
                'category' => 'proteina', 
                'calories_per_100g' => 155, 
                'protein_g' => 13, 
                'carb_g' => 1.1, 
                'fat_g' => 11
            ],
            [
                'name' => 'Caraotas Negras',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 340, 
                'protein_g' => 21, 
                'carb_g' => 60, 
                'fat_g' => 1
            ],
            [
                'name' => 'Plátano Maduro',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 122, 
                'protein_g' => 1.3, 
                'carb_g' => 32, 
                'fat_g' => 0.4
            ],
            [
                'name' => 'Avena en Hojuelas',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 389, 
                'protein_g' => 16.9, 
                'carb_g' => 66, 
                'fat_g' => 6.9
            ],
            [
                'name' => 'Zanahoria',
                'category' => 'vegetal', 
                'calories_per_100g' => 41, 
                'protein_g' => 0.9, 
                'carb_g' => 9.6, 
                'fat_g' => 0.2
            ],
            [
                'name' => 'Carne Magra (Muchacho)',
                'category' => 'proteina', 
                'calories_per_100g' => 143, 
                'protein_g' => 26, 
                'carb_g' => 0, 
                'fat_g' => 4
            ],
            [
                'name' => 'Cambur',
                'category' => 'fruta', 
                'calories_per_100g' => 89, 
                'protein_g' => 1.1, 
                'carb_g' => 22.8, 
                'fat_g' => 0.3
            ],
            [
                'name' => 'Cazón',
                'category' => 'proteina', 
                'calories_per_100g' => 130, 
                'protein_g' => 21, 
                'carb_g' => 0, 
                'fat_g' => 4.5
            ],
            [
                'name' => 'Ají Dulce',
                'category' => 'vegetal', 
                'calories_per_100g' => 25, 
                'protein_g' => 1, 
                'carb_g' => 5, 
                'fat_g' => 0.2
            ],
            [
                'name' => 'Atún en Agua (Lata)',
                'category' => 'proteina', 
                'calories_per_100g' => 116, 
                'protein_g' => 26, 
                'carb_g' => 0, 
                'fat_g' => 0.8
            ],
            [
                'name' => 'Yuca (Mandioca)',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 160, 
                'protein_g' => 1.4, 
                'carb_g' => 38, 
                'fat_g' => 0.3
            ],
            [
                'name' => 'Casabe',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 340, 
                'protein_g' => 1.5, 
                'carb_g' => 82, 
                'fat_g' => 0.5
            ],
            [
                'name' => 'Lentejas',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 116, 
                'protein_g' => 9, 
                'carb_g' => 20, 
                'fat_g' => 0.4
            ],
            [
                'name' => 'Auyama (Calabaza)',
                'category' => 'vegetal', 
                'calories_per_100g' => 26, 
                'protein_g' => 1, 
                'carb_g' => 6.5, 
                'fat_g' => 0.1
            ],
            [
                'name' => 'Leche Descremada',
                'category' => 'lacteo', 
                'calories_per_100g' => 34, 
                'protein_g' => 3.4, 
                'carb_g' => 5, 
                'fat_g' => 0.1
            ],
            [
                'name' => 'Maíz Tierno',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 86, 
                'protein_g' => 3.2, 
                'carb_g' => 19, 
                'fat_g' => 1.2
            ],
            [
                'name' => 'Queso Blanco Bajo en Sal',
                'category' => 'lacteo', 
                'calories_per_100g' => 220, 
                'protein_g' => 18, 
                'carb_g' => 2, 
                'fat_g' => 15
            ],
            [
                'name' => 'Lechoza (Papaya)',
                'category' => 'fruta', 
                'calories_per_100g' => 43, 
                'protein_g' => 0.5, 
                'carb_g' => 11, 
                'fat_g' => 0.3
            ],
            [
                'name' => 'Cacao en Polvo',
                'category' => 'especia', 
                'calories_per_100g' => 228, 
                'protein_g' => 20, 
                'carb_g' => 58, 
                'fat_g' => 14
            ],
            [
                'name' => 'Piña',
                'category' => 'fruta', 
                'calories_per_100g' => 50, 
                'protein_g' => 0.5, 
                'carb_g' => 13, 
                'fat_g' => 0.1
            ],
        ];

        $this->db->table('ingredients')->insertBatch($data);
    }
}