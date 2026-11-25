<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IngredientsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // --- INGREDIENTES BASE (IDs 1 al 25) ---
            // ID 1
            [
                'name' => 'Pechuga de pollo',
                'category' => 'proteina', 
                'calories_per_100g' => 165, 
                'protein_g' => 31, 
                'carb_g' => 0, 
                'fat_g' => 3.6
            ],
            // ID 2
            [
                'name' => 'Arroz integral',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 111, 
                'protein_g' => 2.6, 
                'carb_g' => 23, 
                'fat_g' => 0.9
            ],
            // ID 3
            [
                'name' => 'Aguacate',
                'category' => 'grasa', 
                'calories_per_100g' => 160, 
                'protein_g' => 2, 
                'carb_g' => 8.5, 
                'fat_g' => 14.7
            ],
            // ID 4
            [
                'name' => 'Tomate',
                'category' => 'vegetal', 
                'calories_per_100g' => 18, 
                'protein_g' => 0.9, 
                'carb_g' => 3.9, 
                'fat_g' => 0.2
            ],
            // ID 5
            [
                'name' => 'Harina de maíz precocida',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 360, 
                'protein_g' => 7, 
                'carb_g' => 79, 
                'fat_g' => 1
            ],
            // ID 6
            [
                'name' => 'Huevos',
                'category' => 'proteina', 
                'calories_per_100g' => 155, 
                'protein_g' => 13, 
                'carb_g' => 1.1, 
                'fat_g' => 11
            ],
            // ID 7
            [
                'name' => 'Caraotas Negras',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 340, 
                'protein_g' => 21, 
                'carb_g' => 60, 
                'fat_g' => 1
            ],
            // ID 8
            [
                'name' => 'Plátano Maduro',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 122, 
                'protein_g' => 1.3, 
                'carb_g' => 32, 
                'fat_g' => 0.4
            ],
            // ID 9
            [
                'name' => 'Avena en Hojuelas',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 389, 
                'protein_g' => 16.9, 
                'carb_g' => 66, 
                'fat_g' => 6.9
            ],
            // ID 10
            [
                'name' => 'Zanahoria',
                'category' => 'vegetal', 
                'calories_per_100g' => 41, 
                'protein_g' => 0.9, 
                'carb_g' => 9.6, 
                'fat_g' => 0.2
            ],
            // ID 11
            [
                'name' => 'Carne Magra (Muchacho)',
                'category' => 'proteina', 
                'calories_per_100g' => 143, 
                'protein_g' => 26, 
                'carb_g' => 0, 
                'fat_g' => 4
            ],
            // ID 12
            [
                'name' => 'Cambur',
                'category' => 'fruta', 
                'calories_per_100g' => 89, 
                'protein_g' => 1.1, 
                'carb_g' => 22.8, 
                'fat_g' => 0.3
            ],
            // ID 13
            [
                'name' => 'Cazón',
                'category' => 'proteina', 
                'calories_per_100g' => 130, 
                'protein_g' => 21, 
                'carb_g' => 0, 
                'fat_g' => 4.5
            ],
            // ID 14
            [
                'name' => 'Ají Dulce',
                'category' => 'vegetal', 
                'calories_per_100g' => 25, 
                'protein_g' => 1, 
                'carb_g' => 5, 
                'fat_g' => 0.2
            ],
            // ID 15
            [
                'name' => 'Atún en Agua (Lata)',
                'category' => 'proteina', 
                'calories_per_100g' => 116, 
                'protein_g' => 26, 
                'carb_g' => 0, 
                'fat_g' => 0.8
            ],
            // ID 16
            [
                'name' => 'Yuca (Mandioca)',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 160, 
                'protein_g' => 1.4, 
                'carb_g' => 38, 
                'fat_g' => 0.3
            ],
            // ID 17
            [
                'name' => 'Casabe',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 340, 
                'protein_g' => 1.5, 
                'carb_g' => 82, 
                'fat_g' => 0.5
            ],
            // ID 18
            [
                'name' => 'Lentejas',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 116, 
                'protein_g' => 9, 
                'carb_g' => 20, 
                'fat_g' => 0.4
            ],
            // ID 19
            [
                'name' => 'Auyama (Calabaza)',
                'category' => 'vegetal', 
                'calories_per_100g' => 26, 
                'protein_g' => 1, 
                'carb_g' => 6.5, 
                'fat_g' => 0.1
            ],
            // ID 20
            [
                'name' => 'Leche Descremada',
                'category' => 'lacteo', 
                'calories_per_100g' => 34, 
                'protein_g' => 3.4, 
                'carb_g' => 5, 
                'fat_g' => 0.1
            ],
            // ID 21
            [
                'name' => 'Maíz Tierno',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 86, 
                'protein_g' => 3.2, 
                'carb_g' => 19, 
                'fat_g' => 1.2
            ],
            // ID 22
            [
                'name' => 'Queso Blanco Bajo en Sal',
                'category' => 'lacteo', 
                'calories_per_100g' => 220, 
                'protein_g' => 18, 
                'carb_g' => 2, 
                'fat_g' => 15
            ],
            // ID 23
            [
                'name' => 'Lechoza (Papaya)',
                'category' => 'fruta', 
                'calories_per_100g' => 43, 
                'protein_g' => 0.5, 
                'carb_g' => 11, 
                'fat_g' => 0.3
            ],
            // ID 24
            [
                'name' => 'Cacao en Polvo',
                'category' => 'especia', 
                'calories_per_100g' => 228, 
                'protein_g' => 20, 
                'carb_g' => 58, 
                'fat_g' => 14
            ],
            // ID 25
            [
                'name' => 'Piña',
                'category' => 'fruta', 
                'calories_per_100g' => 50, 
                'protein_g' => 0.5, 
                'carb_g' => 13, 
                'fat_g' => 0.1
            ],

            // --- NUEVOS INGREDIENTES (IDs 26 al 50) ---
            // ID 26
            [
                'name' => 'Pasta Integral',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 348, 
                'protein_g' => 13, 
                'carb_g' => 71, 
                'fat_g' => 1.5
            ],
            // ID 27
            [
                'name' => 'Papa',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 77, 
                'protein_g' => 2, 
                'carb_g' => 17, 
                'fat_g' => 0.1
            ],
            // ID 28
            [
                'name' => 'Ocumo',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 112, 
                'protein_g' => 1.5, 
                'carb_g' => 26, 
                'fat_g' => 0.2
            ],
            // ID 29
            [
                'name' => 'Apio Criollo',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 104, 
                'protein_g' => 1.1, 
                'carb_g' => 24.5, 
                'fat_g' => 0.2
            ],
            // ID 30
            [
                'name' => 'Cebolla',
                'category' => 'vegetal', 
                'calories_per_100g' => 40, 
                'protein_g' => 1.1, 
                'carb_g' => 9.3, 
                'fat_g' => 0.1
            ],
            // ID 31
            [
                'name' => 'Pimentón',
                'category' => 'vegetal', 
                'calories_per_100g' => 31, 
                'protein_g' => 1, 
                'carb_g' => 6, 
                'fat_g' => 0.3
            ],
            // ID 32
            [
                'name' => 'Ajo',
                'category' => 'vegetal', 
                'calories_per_100g' => 149, 
                'protein_g' => 6.4, 
                'carb_g' => 33, 
                'fat_g' => 0.5
            ],
            // ID 33
            [
                'name' => 'Cilantro',
                'category' => 'vegetal', 
                'calories_per_100g' => 23, 
                'protein_g' => 2.1, 
                'carb_g' => 3.7, 
                'fat_g' => 0.5
            ],
            // ID 34
            [
                'name' => 'Calabacín',
                'category' => 'vegetal', 
                'calories_per_100g' => 17, 
                'protein_g' => 1.2, 
                'carb_g' => 3.1, 
                'fat_g' => 0.3
            ],
            // ID 35
            [
                'name' => 'Berenjena',
                'category' => 'vegetal', 
                'calories_per_100g' => 25, 
                'protein_g' => 1, 
                'carb_g' => 5.9, 
                'fat_g' => 0.2
            ],
            // ID 36
            [
                'name' => 'Repollo',
                'category' => 'vegetal', 
                'calories_per_100g' => 25, 
                'protein_g' => 1.3, 
                'carb_g' => 5.8, 
                'fat_g' => 0.1
            ],
            // ID 37
            [
                'name' => 'Remolacha',
                'category' => 'vegetal', 
                'calories_per_100g' => 43, 
                'protein_g' => 1.6, 
                'carb_g' => 9.6, 
                'fat_g' => 0.2
            ],
            // ID 38
            [
                'name' => 'Vainitas',
                'category' => 'vegetal', 
                'calories_per_100g' => 31, 
                'protein_g' => 1.8, 
                'carb_g' => 7, 
                'fat_g' => 0.2
            ],
            // ID 39
            [
                'name' => 'Espinaca',
                'category' => 'vegetal', 
                'calories_per_100g' => 23, 
                'protein_g' => 2.9, 
                'carb_g' => 3.6, 
                'fat_g' => 0.4
            ],
            // ID 40
            [
                'name' => 'Pepino',
                'category' => 'vegetal', 
                'calories_per_100g' => 15, 
                'protein_g' => 0.7, 
                'carb_g' => 3.6, 
                'fat_g' => 0.1
            ],
            // ID 41
            [
                'name' => 'Lechuga',
                'category' => 'vegetal', 
                'calories_per_100g' => 15, 
                'protein_g' => 1.4, 
                'carb_g' => 2.9, 
                'fat_g' => 0.2
            ],
            // ID 42
            [
                'name' => 'Limón',
                'category' => 'fruta', 
                'calories_per_100g' => 29, 
                'protein_g' => 1.1, 
                'carb_g' => 9.3, 
                'fat_g' => 0.3
            ],
            // ID 43
            [
                'name' => 'Aceite de Oliva',
                'category' => 'grasa', 
                'calories_per_100g' => 884, 
                'protein_g' => 0, 
                'carb_g' => 0, 
                'fat_g' => 100
            ],
            // ID 44
            [
                'name' => 'Yogur Griego Natural',
                'category' => 'lacteo', 
                'calories_per_100g' => 59, 
                'protein_g' => 10, 
                'carb_g' => 3.6, 
                'fat_g' => 0.4
            ],
            // ID 45
            [
                'name' => 'Garbanzos',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 364, 
                'protein_g' => 19, 
                'carb_g' => 61, 
                'fat_g' => 6
            ],
            // ID 46
            [
                'name' => 'Arvejas',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 341, 
                'protein_g' => 24.5, 
                'carb_g' => 60, 
                'fat_g' => 1.2
            ],
            // ID 47
            [
                'name' => 'Semillas de Chía',
                'category' => 'grasa', 
                'calories_per_100g' => 486, 
                'protein_g' => 16.5, 
                'carb_g' => 42, 
                'fat_g' => 30.7
            ],
            // ID 48
            [
                'name' => 'Linaza',
                'category' => 'grasa', 
                'calories_per_100g' => 534, 
                'protein_g' => 18.3, 
                'carb_g' => 28.9, 
                'fat_g' => 42.2
            ],
            // ID 49
            [
                'name' => 'Papelón',
                'category' => 'carbohidrato', 
                'calories_per_100g' => 350, 
                'protein_g' => 0.5, 
                'carb_g' => 85, 
                'fat_g' => 0.1
            ],
            // ID 50
            [
                'name' => 'Canela',
                'category' => 'especia', 
                'calories_per_100g' => 247, 
                'protein_g' => 4, 
                'carb_g' => 81, 
                'fat_g' => 1.2
            ],
        ];

        $this->db->table('ingredients')->insertBatch($data);
    }
}