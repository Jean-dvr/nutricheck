<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IngredientConditionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['ingredient_id' => 1, 'condition_id' => 2], // Maní -> Alergia al maní
            ['ingredient_id' => 2, 'condition_id' => 3], // Leche -> Intolerancia a la lactosa
        ];
        $this->db->table('ingredient_conditions')->insertBatch($data);
    }
}