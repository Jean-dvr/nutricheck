<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PostsModel; // Importamos el modelo

class PostsSeeder extends Seeder
{
    public function run()
    {
        $postsModel = new PostsModel();

        // Generamos la fecha actual para estandarizar los timestamps
        $now = date('Y-m-d H:i:s');

        $data = [
            // ==========================================
            // CATEGORÍA: NOVEDADES (Anuncios del Admin)
            // ==========================================
            [
                'user_id'    => 1, // Admin
                'title'      => '¡Bienvenidos a la versión Beta de NutriCheck!',
                'contents'   => 'Estamos emocionados de lanzar nuestra plataforma oficial. Aquí podrás llevar un control detallado de tus planes nutricionales y medidas corporales. ¡Explora todas las funciones!',
                'category'   => 'novedades',
                'image_url'  => 'https://images.unsplash.com/photo-1494390248081-4e521a5940db',
                'created_at' => clone_date($now, '-5 days'),
                'updated_at' => clone_date($now, '-5 days'),
            ],
            [
                'user_id'    => 1, 
                'title'      => 'Nueva actualización de NutriCheck: Calculadora de IMC',
                'contents'   => 'Hemos añadido la nueva calculadora de IMC. Entra en tu perfil para actualizar tus datos físicos y obtener un diagnóstico inmediato de tu estado actual.', //
                'category'   => 'novedades',
                'image_url'  => null, //
                'created_at' => clone_date($now, '-2 days'),
                'updated_at' => clone_date($now, '-2 days'),
            ],

            // ==========================================
            // CATEGORÍA: NUTRICIÓN (Dra. María de los Ángeles)
            // ==========================================
            [
                'user_id'    => 2, // Dra. María de los Ángeles[cite: 18]
                'title'      => 'Los peligros del azúcar oculto', //[cite: 18]
                'contents'   => 'El azúcar oculto en los alimentos procesados es el principal causante de la resistencia a la insulina. Revisa siempre las etiquetas: jarabe de maíz, dextrosa y maltodextrina también son azúcar.', //[cite: 18]
                'category'   => 'nutricion',
                'image_url'  => 'https://images.unsplash.com/photo-1621252178222-1f8cb174959c',
                'created_at' => clone_date($now, '-4 days'),
                'updated_at' => clone_date($now, '-4 days'),
            ],
            [
                'user_id'    => 2,
                'title'      => 'Mito resuelto: ¿Los carbohidratos engordan de noche?',
                'contents'   => 'El cuerpo no tiene un reloj que convierte los carbohidratos en grasa mágicamente después de las 6 PM. Lo que importa es el balance calórico total al final del día. No le temas a una arepa en la cena si entra en tus macros.',
                'category'   => 'nutricion',
                'image_url'  => 'https://images.unsplash.com/photo-1505253758473-96b7015fcd40',
                'created_at' => clone_date($now, '-3 days'),
                'updated_at' => clone_date($now, '-3 days'),
            ],
            [
                'user_id'    => 2,
                'title'      => 'La importancia de la fibra dietética',
                'contents'   => 'Consumir al menos 25-30 gramos de fibra al día mejora la digestión, previene picos de glucosa y te mantiene saciado por más tiempo. Incluye más vegetales de hojas verdes y granos enteros.',
                'category'   => 'nutricion',
                'image_url'  => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd',
                'created_at' => clone_date($now, '-1 days'),
                'updated_at' => clone_date($now, '-1 days'),
            ],

            // ==========================================
            // CATEGORÍA: RECETAS (Dra. María de los Ángeles)
            // ==========================================
            [
                'user_id'    => 2,
                'title'      => 'Snack Rápido: Hummus de Caraotas Negras',
                'contents'   => 'Una excelente alternativa al hummus tradicional. Licúa caraotas negras cocidas, un toque de ajo, limón, comino y una pizca de sal. Ideal para dipear con bastones de zanahoria o apio. ¡Lleno de hierro y proteína!',
                'category'   => 'recetas',
                'image_url'  => 'https://images.unsplash.com/photo-1576021182211-9ea8dcb365ef',
                'created_at' => clone_date($now, '-3 days'),
                'updated_at' => clone_date($now, '-3 days'),
            ],
            [
                'user_id'    => 2,
                'title'      => 'Desayuno Power: Avena Trasnochada',
                'contents'   => 'Deja avena en hojuelas remojando toda la noche con leche descremada, semillas de chía y un toque de canela. En la mañana, corónalo con medio cambur picado. Perfecto para días apurados.',
                'category'   => 'recetas',
                'image_url'  => 'https://images.unsplash.com/photo-1517673132405-a56a62b18caf',
                'created_at' => clone_date($now, '-2 days'),
                'updated_at' => clone_date($now, '-2 days'),
            ],
            [
                'user_id'    => 2,
                'title'      => 'Cena Ligera: Canoas de Calabacín',
                'contents'   => 'Corta un calabacín a la mitad, retira el centro y rellena con pollo esmechado y tomate picado. Hornea por 20 minutos. Una cena bajísima en calorías y muy saciante.',
                'category'   => 'recetas',
                'image_url'  => null,
                'created_at' => clone_date($now, '-1 days'),
                'updated_at' => clone_date($now, '-1 days'),
            ],

            // ==========================================
            // CATEGORÍA: BIENESTAR / SALUD (Dra. María)
            // ==========================================
            [
                'user_id'    => 2,
                'title'      => 'Cómo el estrés crónico sabotea tu pérdida de peso',
                'contents'   => 'El cortisol elevado crónicamente promueve la acumulación de grasa abdominal y aumenta los antojos por alimentos dulces. Dormir bien y practicar la respiración profunda no es lujo, es necesidad médica.',
                'category'   => 'bienestar',
                'image_url'  => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773',
                'created_at' => clone_date($now, '-4 days'),
                'updated_at' => clone_date($now, '-4 days'),
            ],
            [
                'user_id'    => 2,
                'title'      => 'Hidratación más allá del agua',
                'contents'   => 'No tienes que beber 8 vasos de agua pura si te cuesta. Las infusiones frías sin azúcar, el caldo de vegetales y frutas ricas en agua como la lechoza o la patilla también cuentan para tu requerimiento diario.',
                'category'   => 'bienestar',
                'image_url'  => 'https://images.unsplash.com/photo-1523362628745-0c100150b504',
                'created_at' => clone_date($now, '-2 days'),
                'updated_at' => clone_date($now, '-2 days'),
            ],

            // ==========================================
            // CATEGORÍA: GENERAL (Cualquier usuario)
            // ==========================================
            [
                'user_id'    => 1,
                'title'      => 'Mantenimiento programado de la plataforma',
                'contents'   => 'Estimados usuarios, este domingo de 2:00 AM a 4:00 AM realizaremos labores de mantenimiento en la base de datos. La aplicación podría presentar intermitencias.',
                'category'   => 'general', //[cite: 18]
                'image_url'  => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id'    => 2,
                'title'      => 'Recordatorio para mis pacientes',
                'contents'   => 'Por favor, recuerden actualizar sus diarios de alimentación antes de nuestras consultas presenciales. Esto me ayuda a optimizar el tiempo de nuestra cita y hacer ajustes más precisos a sus planes.',
                'category'   => 'general', //[cite: 18]
                'image_url'  => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        // Insertamos los posts uno por uno usando el Modelo[cite: 18]
        foreach ($data as $post) {
            $postsModel->insert($post); //[cite: 18]
        }
    }
}

/**
 * Función auxiliar (helper) exclusiva de este archivo para restar días 
 * a la fecha actual y que los posts parezcan publicados en días diferentes, 
 * dándole realismo al timeline del sistema.
 */
function clone_date(string $baseDate, string $modifier): string {
    return date('Y-m-d H:i:s', strtotime($baseDate . ' ' . $modifier));
}