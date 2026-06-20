<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserPantriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['user_id' => 3, 'ingredient_id' => 3, 'quantity' => 500.00], // Paciente tiene 500g de avena
            ['user_id' => 1, 'ingredient_id' => 1, 'quantity' => 250.00], // Ricardo tiene 250g de maní
        ];
        $this->db->table('user_pantries')->insertBatch($data);
    }
}