<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipeIngredientsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Para el Pabellón Saludable (Receta 1)
            ['recipe_id' => 1, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true], // Pollo
            ['recipe_id' => 1, 'ingredient_id' => 2, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true], // Arroz integral
            
            // Para la Arepa con Perico (Receta 2)
            ['recipe_id' => 2, 'ingredient_id' => 5, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],  // Harina de maíz
            ['recipe_id' => 2, 'ingredient_id' => 6, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true], // Huevos
            ['recipe_id' => 2, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false], // Tomate
        ];
        $this->db->table('recipe_ingredients')->insertBatch($data);
    }
}