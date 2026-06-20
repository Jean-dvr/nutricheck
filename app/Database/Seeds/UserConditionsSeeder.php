<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserConditionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['user_id' => 3, 'condition_id' => 3], // Paciente Prueba tiene Intolerancia a la lactosa
            ['user_id' => 1, 'condition_id' => 2], // Ricardo DBA tiene Alergia al maní
        ];
        $this->db->table('user_conditions')->insertBatch($data);
    }
}