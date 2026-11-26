<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserConditionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1, 
                'condition_id' => 6
            ], // Ricardo -> Dislipidemia
            [
                'user_id' => 3, 
                'condition_id' => 7
            ], // Paciente -> Anemia Ferropénica
            [
                'user_id' => 4, 
                'condition_id' => 8
            ], // Usuario 4 -> Resistencia a la Insulina
            [
                'user_id' => 4, 
                'condition_id' => 10
            ], // Usuario 4 -> Hiperuricemia
        ];
        
        $this->db->table('user_conditions')->insertBatch($data);
    }
}