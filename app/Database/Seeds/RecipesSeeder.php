<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title'          => 'Tazón de Avena y Leche',
                'preparation'    => 'Mezclar la avena con la leche tibia.',
                'total_calories' => 450
            ],
            [
                'title'          => 'Snack de Maní Energético',
                'preparation'    => 'Porción directa de maní tostado.',
                'total_calories' => 280
            ],
            [ 
                'title'   => 'Arepa de Avena y Chía con Perico',
                'preparation' => 'Mezclar harina de maíz, avena y chía con agua. Asar en budare. Sofreír cebolla y tomate con un toque de agua o rocío de aceite, agregar los huevos batidos.',
                'total_calories' => 320
            ],
            [
                'title' => 'Pabellón Saludable (Pollo y Arroz Integral)',
                'preparation' => 'Servir arroz integral cocido, caraotas guisadas sin azúcar, pechuga de pollo desmechada al natural y plátano maduro horneado (no frito).',
                'total_calories' => 450
            ],
            [
                'title' => 'Pisillo de Cazón Margariteño',
                'preparation' => 'Hervir y desmenuzar el cazón. Sofreír con abundante ajo, cebolla, ají dulce y onoto. Cocinar a fuego lento hasta secar.',
                'total_calories' => 280
            ],
            [
                'title' => 'Cachapa Integral de Maíz Tierno',
                'preparation' => 'Licuar maíz tierno con un chorrito de leche descremada y stevia. Cocinar en budare y rellenar con queso blanco pasteurizado bajo en grasa.',
                'total_calories' => 310
            ],
            [
                'title' => 'Crema de Auyama y Apio',
                'preparation' => 'Hervir auyama, apio, cebolla y ajo en caldo de pollo natural. Licuar todo con cilantro fresco hasta obtener una crema homogénea.',
                'total_calories' => 150
            ],
            [
                'title' => 'Bollitos Pelones Fit (Rellenos de Pollo)',
                'preparation' => 'Amasar harina de maíz con caldo. Hacer esferas, ahuecar y rellenar con guiso de pollo. Hervir en agua y bañar en salsa de tomate natural casera.',
                'total_calories' => 380
            ],
            [
                'title' => 'Asado Negro Magro (Sin Papelón)',
                'preparation' => 'Sellar muchacho redondo. Cocinar a presión con vino tinto, cebolla, ajo y stevia/monk fruit para simular el dulzor característico, reduciendo la salsa.',
                'total_calories' => 420
            ],
            [
                'title' => 'Ensalada de Gallina con Yogur Griego',
                'preparation' => 'Mezclar pechuga de gallina (o pollo) desmechada, zanahoria y papa hervida en cubos. Sustituir la mayonesa por yogur griego natural y un toque de mostaza.',
                'total_calories' => 300
            ],
            [
                'title' => 'Yuca Hervida con Guasacaca Natural',
                'preparation' => 'Hervir la yuca hasta ablandar. Licuar aguacate, cilantro, pimentón verde, ajo y vinagre para la guasacaca. Servir juntos.',
                'total_calories' => 260
            ],
            [
                'title' => 'Pastel de Chucho Horneado',
                'preparation' => 'Alternar capas de plátano horneado en tajadas, guiso de cazón y queso blanco bajo en sal. Hornear hasta gratinar ligeramente.',
                'total_calories' => 410
            ],
            [
                'title' => 'Sopa de Lagarto Magro con Verduras',
                'preparation' => 'Hacer consomé desgrasando previamente la carne de res (lagarto). Añadir ocumo, apio, auyama, zanahoria y mucho cilantro.',
                'total_calories' => 350
            ],
            [
                'title' => 'Pescado Coro-Coro al Horno con Tostones',
                'preparation' => 'Adobar el pescado con ajo y limón, hornear. Hacer tostones de plátano verde usando Airfryer o al horno con rocío de aceite.',
                'total_calories' => 390
            ],
            [
                'title' => 'Chupe de Pollo Ligero',
                'preparation' => 'Caldo de pollo con pechuga desmechada, granos de maíz tierno, cilantro y un toque de leche descremada al final para dar color.',
                'total_calories' => 290
            ],
            [
                'title' => 'Hallaquitas Aliñadas',
                'preparation' => 'Amasar harina de maíz con un sofrito licuado de pimentón, ají dulce y cebolla. Envolver en hojas de maíz y hervir.',
                'total_calories' => 220
            ],
            [
                'title' => 'Tizana Natural (Sin Azúcar)',
                'preparation' => 'Picar patilla, melón, lechosa y piña. Mezclar con jugo de naranja natural puro. Servir muy frío, usando la fructosa natural como endulzante.',
                'total_calories' => 120
            ],
            // Mas asequibles 
            [
                'title'          => 'Arepa Asada con Queso Blanco (Bajo en Sal)',
                'preparation'    => 'Amasar harina de maíz con agua. Asar en budare sin aceite. Rellenar con queso blanco bajo en sal. (Apto: Celíacos, Hipertensos. No apto: Intolerantes a la lactosa).',
                'total_calories' => 280
            ],
            [
                'title'          => 'Huevos Pericos en Agua',
                'preparation'    => 'Sofreír tomate y cebolla usando dos cucharadas de agua en vez de aceite. Agregar huevos batidos. (Apto: Diabéticos, Celíacos. No apto: Alergia al huevo).',
                'total_calories' => 180
            ],
            [
                'title'          => 'Caraotas Negras Guisadas (Sin Azúcar)',
                'preparation'    => 'Ablandar caraotas. Hacer sofrito de cebolla y ajo sin aceite. Hervir hasta espesar sin añadir azúcar ni papelón. (Ideal: Diabéticos, Obesidad, Celíacos).',
                'total_calories' => 340
            ],
            [
                'title'          => 'Pollo Sudado con Zanahoria',
                'preparation'    => 'Sellar pechuga de pollo picada en sus propios jugos. Agregar rodajas de tomate, cebolla y zanahoria. Tapar a fuego lento. (Apto: Todas las patologías básicas).',
                'total_calories' => 280
            ],
            [
                'title'          => 'Tajadas de Plátano Horneadas',
                'preparation'    => 'Cortar plátano maduro. Hornear a 180°C o usar Airfryer sin aceite hasta dorar. (Apto: Celíacos. Moderar porciones en Diabéticos).',
                'total_calories' => 150
            ],
            [
                'title'          => 'Carne Molida Guisada al Natural',
                'preparation'    => 'Cocinar carne magra en su propia grasa. Añadir cebolla, ajo y puré de tomate natural licuado. (Apto: Celíacos, Diabéticos, Alergias huevo/pescado).',
                'total_calories' => 310
            ],
            [
                'title'          => 'Sopita de Pollo con Zanahoria',
                'preparation'    => 'Hervir pollo sin piel con trozos de zanahoria, cebolla y cilantro. Desgrasar el caldo antes de servir. (Ideal: Obesidad, Hipertensión).',
                'total_calories' => 210
            ],
            [
                'title'          => 'Ensalada Rallada de Repollo y Zanahoria (Aderezo de Limón)',
                'preparation'    => 'Rallar repollo y zanahoria. Aderezar solo con limón y una pizca de sal, omitiendo la mayonesa. (Ideal: Obesidad, Diabéticos, Celíacos).',
                'total_calories' => 60
            ],
            [
                'title'          => 'Arepa Andina Integral al Budare',
                'preparation'    => 'Amasar harina de trigo integral con agua y un toque de sal. Cocinar en budare a fuego muy lento. (Ideal: Diabéticos. NO APTO: Celíacos).',
                'total_calories' => 240
            ],
            [
                'title'          => 'Atol de Avena con Leche Deslactosada',
                'preparation'    => 'Hervir leche deslactosada, agregar avena y canela. Espesar sin usar azúcar. (Apto: Intolerancia a la lactosa, Diabéticos).',
                'total_calories' => 210
            ],
            [
                'title'          => 'Ensalada de Tomate, Cebolla y Aguacate',
                'preparation'    => 'Picar ingredientes en gajos. El aguacate provee grasas saludables. Aderezar con limón. (Ideal: Hipertensos, Obesidad).',
                'total_calories' => 150
            ],
            [
                'title'          => 'Sardinas Guisadas con Tomate',
                'preparation'    => 'Lavar sardinas al natural. Guisar con tomate y cebolla. Excelente fuente de Omega 3. (Ideal: Hipertensos. NO APTO: Alergia al pescado).',
                'total_calories' => 260
            ],
            [
                'title'          => 'Tortilla de Plátano al Horno',
                'preparation'    => 'Hacer puré de plátano sancochado, mezclar con huevo batido y hornear en molde de silicón. (NO APTO: Alergia al huevo).',
                'total_calories' => 270
            ],
            [
                'title'          => 'Arroz Blanco con Zanahoria Rallada',
                'preparation'    => 'Cocinar arroz blanco añadiendo zanahoria rallada al agua para aumentar la fibra y reducir el índice glucémico del plato. (Apto: Celíacos).',
                'total_calories' => 180
            ],
            [
                'title'          => 'Cachapa en Budare (Masa Pura, Sin Mantequilla)',
                'preparation'    => 'Licuar maíz tierno sin añadir azúcar. Cocinar directo en el budare. Servir seca o con queso bajo en grasa. (Ideal: Diabéticos, Celíacos).',
                'total_calories' => 220
            ]
        ];
        $this->db->table('recipes')->insertBatch($data);
    }
}