<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Ricardo DBA',
                'email'      => 'dbasdbah@gmail.com',
                'password'   => password_hash('12345', PASSWORD_BCRYPT),
                'rol'        => 'admin',
                'sex'        => 'male',          
                'birth_date' => '1995-05-26', 
                'avatar'     => 'admin_profile.png', // Ejemplo: Ponemos una imagen personalizada                
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Dra. María de los Ángeles',
                'email'      => 'angelesfit@nutricheck.com',
                'password'   => password_hash('123456', PASSWORD_BCRYPT),
                'rol'        => 'nutricionista',
                'sex'        => 'famale',          
                'birth_date' => '1996-07-10', 
                'avatar'        => 'default-avatar.png',    
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Paciente Prueba',
                'email'      => 'paciente@gmail.com',
                'password'   => password_hash('123456', PASSWORD_BCRYPT),
                'rol'        => 'free',
                'sex'        => 'male',          
                'birth_date' => '1990-08-20',  
                'avatar'        => 'default-avatar.png',   
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('users')->insertBatch($data);
    }
}