<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PostsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id'    => 2, // Lo publica la Dra. María de los Ángeles (ID 2)
                'title'      => 'Los peligros del azúcar oculto',
                'contents'   => 'El azúcar oculto en los alimentos procesados es el principal causante de...',
                'image_url'  => 'https://ejemplo.com/azucar.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'    => 1, // Lo publica el Admin
                'title'      => 'Nueva actualización de NutriCheck',
                'contents'   => 'Hemos añadido la nueva calculadora de IMC. Entra en tu perfil para...',
                'image_url'  => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('posts')->insertBatch($data);
    }
}