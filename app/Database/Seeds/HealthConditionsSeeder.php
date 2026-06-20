<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HealthConditionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Diabetes Tipo 1', 'type' => 'pathology'],
            ['name' => 'Alergia al Maní', 'type' => 'allergy'],
            ['name' => 'Intolerancia a la Lactosa', 'type' => 'intolerance'],
        ];

        $this->db->table('health_conditions')->insertBatch($data);
    }
}