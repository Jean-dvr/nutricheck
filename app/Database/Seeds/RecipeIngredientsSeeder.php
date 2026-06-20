<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipeIngredientsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['recipe_id' => 1, 'ingredient_id' => 2, 'quantity' => 200.00, 'unit_of_measure' => 'ml'],
            ['recipe_id' => 1, 'ingredient_id' => 3, 'quantity' => 100.00, 'unit_of_measure' => 'gramos'],
            ['recipe_id' => 2, 'ingredient_id' => 1, 'quantity' => 50.00, 'unit_of_measure' => 'gramos'],
        ];
        $this->db->table('recipe_ingredients')->insertBatch($data);
    }
}