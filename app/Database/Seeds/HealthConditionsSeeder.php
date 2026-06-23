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
            // Patologías
            ['name' => 'Diabetes Tipo 2', 'type' => 'pathology'],
            ['name' => 'Hipertensión Arterial', 'type' => 'pathology'],
            ['name' => 'Obesidad', 'type' => 'pathology'],
             // Intolerancias
            ['name' => 'Enfermedad Celíaca (Sensibilidad al Gluten)', 'type' => 'intolerance'],
            ['name' => 'Intolerancia a la Lactosa', 'type' => 'intolerance'],
             // Alergias
            ['name' => 'Alergia al Pescado y Mariscos', 'type' => 'allergy'],
            ['name' => 'Alergia al Huevo', 'type' => 'allergy'],
            
        ];

        $this->db->table('health_conditions')->insertBatch($data);
    }
}