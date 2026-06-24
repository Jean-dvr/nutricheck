<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Pabellón Saludable (Pollo y Arroz Integral)',
                'preparation' => 'Servir arroz integral cocido, caraotas guisadas, pechuga de pollo desmechada al natural y plátano maduro horneado.',
                'prep_time_minutes' => 45,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 450,
                'is_approved' => 1,
                'image_url' => 'pabellon_fit.jpg'
            ],
            [
                'title' => 'Arepa Asada con Huevos Pericos',
                'preparation' => 'Amasar harina de maíz. Asar en budare. Sofreír tomate con un toque de agua y agregar los huevos batidos.',
                'prep_time_minutes' => 20,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 320,
                'is_approved' => 1,
                'image_url' => 'arepa_perico.jpg',
            ]
        ];
        $this->db->table('recipes')->insertBatch($data);
    }
}