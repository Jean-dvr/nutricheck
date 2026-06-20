<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MealLogsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['user_id' => 3, 'recipe_id' => 1, 'meal_type' => 'breakfast', 'log_date' => date('Y-m-d')],
            ['user_id' => 1, 'recipe_id' => 2, 'meal_type' => 'snack', 'log_date' => date('Y-m-d')],
        ];
        $this->db->table('meal_logs')->insertBatch($data);
    }
}