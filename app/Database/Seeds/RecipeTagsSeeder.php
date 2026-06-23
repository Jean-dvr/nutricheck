<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipeTagsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['recipe_id' => 1, 'tag_id' => 2], // Pabellón -> Alto en Proteína
            ['recipe_id' => 1, 'tag_id' => 4], // Pabellón -> Sin Gluten
            ['recipe_id' => 2, 'tag_id' => 5], // Arepa -> Desayuno
            ['recipe_id' => 2, 'tag_id' => 4], // Arepa -> Sin Gluten
        ];
        $this->db->table('recipe_tags')->insertBatch($data);
    }
}
