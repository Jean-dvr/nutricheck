<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserPantriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 3, 
                'ingredient_id' => 9, // ID corregido para la Avena en Hojuelas
                'quantity' => 500.00
            ], // Paciente tiene 500g de avena
            [
                'user_id' => 1, 
                'ingredient_id' => 5, // Cambiado a Harina de Maíz (El maní no está en tu top 25 actual)
                'quantity' => 250.00
            ], // Ricardo tiene 250g de Harina
        ];

        $this->db->table('user_pantries')->insertBatch($data);
    }
}