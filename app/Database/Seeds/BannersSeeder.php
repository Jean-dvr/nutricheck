<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BannersSeeder extends Seeder
{
    public function run()
    {
        $ahora = date('Y-m-d H:i:s');

        $banners = [
            // Banners Verticales (Dashboard)
            [
                'image_url'   => 'ad1.jpg',
                'orientation' => 'vertical',
                'created_at'  => $ahora,
            ],
            [
                'image_url'   => 'ad2.jpg',
                'orientation' => 'vertical',
                'created_at'  => $ahora,
            ],
            [
                'image_url'   => 'ad3.jpg',
                'orientation' => 'vertical',
                'created_at'  => $ahora,
            ],

            // Banners Horizontales (Racha de Comidas)
            [
                'image_url'   => 'ad11.jpg',
                'orientation' => 'horizontal',
                'created_at'  => $ahora,
            ],
            [
                'image_url'   => 'ad22.jpg',
                'orientation' => 'horizontal',
                'created_at'  => $ahora,
            ],
        ];

        $builder = $this->db->table('banners');

        foreach ($banners as $banner) {
            $existe = $builder
                ->where('image_url', $banner['image_url'])
                ->where('orientation', $banner['orientation'])
                ->countAllResults();

            if ($existe === 0) {
                $builder->insert($banner);
            }
        }
    }
}