<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MealLogsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['user_id' => 3, 'meal_type' => 'breakfast', 'meal_date' => date('Y-m-d'), 'meal_time' => date('10:30:00'), 'description' => 'Avena con frutas', 'image_path' => null, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['user_id' => 1, 'meal_type' => 'snack', 'meal_date' => date('Y-m-d'), 'meal_time' => date('00:30:00'), 'description' => 'Snack saludable', 'image_path' => null, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('meal_logs')->insertBatch($data);
    }
}