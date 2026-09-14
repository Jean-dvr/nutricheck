<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HealthConditionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
           // --- PATOLOGÍAS ---
            [
                'name' => 'Diabetes Tipo 1', 
                'type' => 'pathology'
            ],
            [
                'name' => 'Diabetes Tipo 2', 
                'type' => 'pathology'
            ],
            [
                'name' => 'Hipertensión Arterial', 
                'type' => 'pathology'
            ],
            [
                'name' => 'Obesidad', 
                'type' => 'pathology'
            ],
            [
                'name' => 'Enfermedad Celíaca (Sensibilidad al Gluten)', 
                'type' => 'pathology'
            ],
            [
                'name' => 'Dislipidemia', 
                'type' => 'pathology'
            ],
            [
                'name' => 'Anemia Ferropénica', 
                'type' => 'pathology'
            ],
            [
                'name' => 'Resistencia a la Insulina', 
                'type' => 'pathology'
            ],
            [
                'name' => 'Gastritis / Reflujo', 
                'type' => 'pathology'
            ],
            [
                'name' => 'Hiperuricemia', 
                'type' => 'pathology'
            ],

            // --- ALERGIAS ---
            [
                'name' => 'Alergia al Maní', 
                'type' => 'allergy'
            ],
            [
                'name' => 'Alergia al Pescado y Mariscos', 
                'type' => 'allergy'
            ],
            [
                'name' => 'Alergia al Huevo', 
                'type' => 'allergy'
            ],

            // --- INTOLERANCIAS ---
            [
                'name' => 'Intolerancia a la Lactosa', 
                'type' => 'intolerance'
            ],
        ];

        $this->db->table('health_conditions')->insertBatch($data);
    }
}