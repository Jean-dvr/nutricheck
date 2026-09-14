<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipeTagsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 1: Vegano, 2: Alto en Proteína, 3: Keto, 4: Sin Gluten, 5: Desayuno
            ['recipe_id' => 1, 'tag_id' => 2], ['recipe_id' => 1, 'tag_id' => 4],
            ['recipe_id' => 2, 'tag_id' => 4], ['recipe_id' => 2, 'tag_id' => 5],
            ['recipe_id' => 3, 'tag_id' => 5], ['recipe_id' => 4, 'tag_id' => 4], 
            ['recipe_id' => 4, 'tag_id' => 5], ['recipe_id' => 5, 'tag_id' => 2], 
            ['recipe_id' => 5, 'tag_id' => 5], ['recipe_id' => 6, 'tag_id' => 5],
            ['recipe_id' => 7, 'tag_id' => 2], ['recipe_id' => 7, 'tag_id' => 4],
            ['recipe_id' => 8, 'tag_id' => 2], ['recipe_id' => 8, 'tag_id' => 4],
            ['recipe_id' => 9, 'tag_id' => 2], ['recipe_id' => 9, 'tag_id' => 4],
            ['recipe_id' => 10, 'tag_id' => 2], ['recipe_id' => 10, 'tag_id' => 4],
            ['recipe_id' => 11, 'tag_id' => 2], ['recipe_id' => 11, 'tag_id' => 4],
            ['recipe_id' => 12, 'tag_id' => 2], ['recipe_id' => 12, 'tag_id' => 3],
            ['recipe_id' => 12, 'tag_id' => 4], ['recipe_id' => 13, 'tag_id' => 2], 
            ['recipe_id' => 13, 'tag_id' => 3], ['recipe_id' => 13, 'tag_id' => 4],
            ['recipe_id' => 14, 'tag_id' => 2], ['recipe_id' => 15, 'tag_id' => 2], 
            ['recipe_id' => 15, 'tag_id' => 4], ['recipe_id' => 16, 'tag_id' => 2], 
            ['recipe_id' => 16, 'tag_id' => 4], ['recipe_id' => 17, 'tag_id' => 1], 
            ['recipe_id' => 17, 'tag_id' => 2], ['recipe_id' => 17, 'tag_id' => 4],
            ['recipe_id' => 18, 'tag_id' => 1], ['recipe_id' => 18, 'tag_id' => 4],
            ['recipe_id' => 19, 'tag_id' => 5], ['recipe_id' => 20, 'tag_id' => 5],
            ['recipe_id' => 21, 'tag_id' => 2], ['recipe_id' => 21, 'tag_id' => 4],
            ['recipe_id' => 22, 'tag_id' => 2], ['recipe_id' => 22, 'tag_id' => 4],
            ['recipe_id' => 23, 'tag_id' => 2], ['recipe_id' => 23, 'tag_id' => 4],
            ['recipe_id' => 24, 'tag_id' => 2], ['recipe_id' => 24, 'tag_id' => 3], 
            ['recipe_id' => 24, 'tag_id' => 4], ['recipe_id' => 25, 'tag_id' => 4],
            ['recipe_id' => 26, 'tag_id' => 1], ['recipe_id' => 26, 'tag_id' => 4],
            ['recipe_id' => 27, 'tag_id' => 4], ['recipe_id' => 28, 'tag_id' => 1],
            ['recipe_id' => 29, 'tag_id' => 1], ['recipe_id' => 29, 'tag_id' => 4],
            ['recipe_id' => 30, 'tag_id' => 1], ['recipe_id' => 30, 'tag_id' => 4],
        ];
        
        $this->db->table('recipe_tags')->insertBatch($data);
    }
}
