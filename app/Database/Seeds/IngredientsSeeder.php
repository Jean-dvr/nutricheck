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
            ['name' => 'Avena en hojuelas', 'calories_per_100g' => 389.00],
            ['name' => 'Cazón (Tiburón pequeño)', 'calories_per_100g' => 130.00],
            ['name' => 'Pechuga de pollo', 'calories_per_100g' => 165.00],
            ['name' => 'Arroz integral', 'calories_per_100g' => 111.00],
            ['name' => 'Yuca', 'calories_per_100g' => 160.00],
            ['name' => 'Auyama', 'calories_per_100g' => 26.00],
            ['name' => 'Queso blanco pasteurizado (Bajo en sal)', 'calories_per_100g' => 250.00],
            ['name' => 'Carne magra (Muchacho redondo)', 'calories_per_100g' => 155.00],
            ['name' => 'Cilantro', 'calories_per_100g' => 23.00],
            ['name' => 'Maíz tierno', 'calories_per_100g' => 86.00],
            ['name' => 'Harina de maíz precocida', 'calories_per_100g' => 360.00],
            ['name' => 'Huevos', 'calories_per_100g' => 155.00],
            ['name' => 'Tomate', 'calories_per_100g' => 18.00],
            ['name' => 'Cebolla', 'calories_per_100g' => 40.00],
            ['name' => 'Caraotas negras', 'calories_per_100g' => 341.00],
            ['name' => 'Arroz blanco', 'calories_per_100g' => 130.00],
            ['name' => 'Plátano maduro', 'calories_per_100g' => 122.00],
            ['name' => 'Carne molida magra', 'calories_per_100g' => 155.00],
            ['name' => 'Repollo blanco', 'calories_per_100g' => 25.00],
            ['name' => 'Zanahoria', 'calories_per_100g' => 41.00],
            ['name' => 'Harina de trigo integral', 'calories_per_100g' => 340.00],
            ['name' => 'Sardinas en lata (al natural)', 'calories_per_100g' => 180.00],
            ['name' => 'Queso blanco duro (Bajo en sal)', 'calories_per_100g' => 250.00],
            ['name' => 'Aguacate', 'calories_per_100g' => 160.00],
            ['name' => 'Leche deslactosada', 'calories_per_100g' => 42.00]
        ];

        $this->db->table('ingredients')->insertBatch($data);
    }
}