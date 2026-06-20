<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipeConditionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['recipe_id' => 1, 'condition_id' => 3], // Receta 1 advierte Intolerancia a la lactosa
            ['recipe_id' => 2, 'condition_id' => 2], // Receta 2 advierte Alergia al maní
        ];
        $this->db->table('recipe_conditions')->insertBatch($data);
    }
}