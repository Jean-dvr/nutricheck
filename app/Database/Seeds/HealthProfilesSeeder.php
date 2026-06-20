<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HealthProfilesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['user_id' => 1, 'weight_kg' => 70.00, 'height_cm' => 175, 'current_bmi' => 22.8, 'goal' => 'maintenance'],
            ['user_id' => 3, 'weight_kg' => 85.00, 'height_cm' => 165, 'current_bmi' => 31.2, 'goal' => 'lose_fat'],
        ];
        $this->db->table('health_profiles')->insertBatch($data);
    }
}