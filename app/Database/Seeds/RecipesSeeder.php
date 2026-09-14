<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipesSeeder extends Seeder
{
    public function run()
    {
        $data = [
           // --- DESAYUNOS ---
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
                'image_url' => 'arepa_perico.jpg'
            ],
            [
                'title' => 'Arepa de Avena y Chía',
                'preparation' => 'Mezclar harina de maíz, hojuelas de avena, chía y agua. Asar y rellenar con queso blanco bajo en sal.',
                'prep_time_minutes' => 15,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 280,
                'is_approved' => 1,
                'image_url' => 'arepa_avena.jpg'
            ],
            [
                'title' => 'Arepa de Zanahoria con Queso',
                'preparation' => 'Rallar zanahoria e integrar a la masa de maíz. Asar y rellenar con queso fresco.',
                'prep_time_minutes' => 20,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 260,
                'is_approved' => 1,
                'image_url' => 'arepa_zanahoria.jpg'
            ],
            [
                'title' => 'Empanadas Horneadas de Carne Machada',
                'preparation' => 'Hacer masa de maíz. Rellenar con carne magra mechada. Hornear a 200°C hasta dorar en lugar de freír.',
                'prep_time_minutes' => 40,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 350,
                'is_approved' => 1,
                'image_url' => 'empanadas_horno.jpg'
            ],
            [
                'title' => 'Panquecas de Cambur y Avena',
                'preparation' => 'Licuar cambur maduro, avena, huevo y un chorrito de leche. Cocinar en sartén antiadherente.',
                'prep_time_minutes' => 15,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 310,
                'is_approved' => 1,
                'image_url' => 'panquecas_cambur.jpg'
            ],
            
            // --- ALMUERZOS: CARNES Y AVES ---
            [
                'title' => 'Pollo Guisado con Papas y Zanahorias',
                'preparation' => 'Guisar pechuga de pollo con tomate, cebolla, ajo, cilantro, papas y zanahorias. Sin aceites añadidos.',
                'prep_time_minutes' => 35,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 380,
                'is_approved' => 1,
                'image_url' => 'pollo_guisado.jpg'
            ],
            [
                'title' => 'Carne Molida con Vegetales Escondidos',
                'preparation' => 'Sofreír carne magra al natural. Añadir calabacín y zanahoria rallada para dar volumen sin calorías.',
                'prep_time_minutes' => 30,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 340,
                'is_approved' => 1,
                'image_url' => 'carne_vegetales.jpg'
            ],
            [
                'title' => 'Asado Negro Saludable (Sin Papelón Excesivo)',
                'preparation' => 'Sellar muchacho redondo. Cocinar a fuego lento con vino tinto, cebolla y estevia en lugar de papelón.',
                'prep_time_minutes' => 120,
                'difficulty' => 'dificil',
                'portions' => 4,
                'total_calories' => 420,
                'is_approved' => 1,
                'image_url' => 'asado_negro.jpg'
            ],
            [
                'title' => 'Pechuga a la Plancha con Yuca Hervida',
                'preparation' => 'Macerar pollo con ajo y orégano. Hacer a la plancha. Acompañar con yuca hervida y ensalada de tomate.',
                'prep_time_minutes' => 25,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 360,
                'is_approved' => 1,
                'image_url' => 'pollo_yuca.jpg'
            ],

            // --- ALMUERZOS: PESCADOS (COSTA VENEZOLANA) ---
            [
                'title' => 'Cazón Guisado (Estilo Margarita)',
                'preparation' => 'Hervir y desmenuzar el cazón. Guisar con abundante ají dulce, cebolla, cebollín y onoto.',
                'prep_time_minutes' => 50,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 290,
                'is_approved' => 1,
                'image_url' => 'cazon_guisado.jpg'
            ],
            [
                'title' => 'Rueda de Pescado al Horno',
                'preparation' => 'Colocar rueda de carite o corvina en papel aluminio con pimentón, cebolla y limón. Hornear por 25 min.',
                'prep_time_minutes' => 30,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 280,
                'is_approved' => 1,
                'image_url' => 'pescado_horno.jpg'
            ],
            [
                'title' => 'Ensalada Fresca de Atún y Aguacate',
                'preparation' => 'Mezclar atún al agua escurrido, cebolla morada picada, cilantro y cubos de aguacate. Aderezar con limón.',
                'prep_time_minutes' => 10,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 310,
                'is_approved' => 1,
                'image_url' => 'ensalada_atun.jpg'
            ],
            [
                'title' => 'Sardinas Asadas con Casabe',
                'preparation' => 'Limpiar sardinas frescas, asar en budare con un toque de sal. Acompañar con casabe tostado.',
                'prep_time_minutes' => 20,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 330,
                'is_approved' => 1,
                'image_url' => 'sardinas_asadas.jpg'
            ],

            // --- SOPAS Y GRANOS ---
            [
                'title' => 'Hervido de Res Magra',
                'preparation' => 'Hacer caldo con lagarto sin hueso desgrasado. Añadir ocumo, auyama, apio, cilantro y hierbabuena.',
                'prep_time_minutes' => 90,
                'difficulty' => 'media',
                'portions' => 4,
                'total_calories' => 380,
                'is_approved' => 1,
                'image_url' => 'hervido_res.jpg'
            ],
            [
                'title' => 'Sopa de Pollo Levanta Muertos',
                'preparation' => 'Caldo base de pechuga, zanahoria, papas, fideos integrales y abundante cilantro.',
                'prep_time_minutes' => 45,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 270,
                'is_approved' => 1,
                'image_url' => 'sopa_pollo.jpg'
            ],
            [
                'title' => 'Lentejas Guisadas Ligeras',
                'preparation' => 'Guisar lentejas con zanahoria, papas y un sofrito crudo de ajo y pimentón (sin tocineta ni embutidos).',
                'prep_time_minutes' => 60,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 320,
                'is_approved' => 1,
                'image_url' => 'lentejas.jpg'
            ],
            [
                'title' => 'Crema de Auyama (Calabaza)',
                'preparation' => 'Hervir auyama con cebolla y ajo. Licuar con un poco del caldo y un chorrito de leche descremada.',
                'prep_time_minutes' => 25,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 150,
                'is_approved' => 1,
                'image_url' => 'crema_auyama.jpg'
            ],
            [
                'title' => 'Pisca Andina Saludable',
                'preparation' => 'Caldo de papa con cilantro y cebollín. Usar leche descremada y huevos pochados. Acompañar con arepa de trigo integral.',
                'prep_time_minutes' => 30,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 260,
                'is_approved' => 1,
                'image_url' => 'pisca_andina.jpg'
            ],

            // --- CENAS ---
            [
                'title' => 'Cachapa de Maíz Tierno a la Plancha',
                'preparation' => 'Licuar maíz tierno. Cocinar en budare sin mantequilla extra. Rellenar con queso de mano bajo en grasa.',
                'prep_time_minutes' => 25,
                'difficulty' => 'media',
                'portions' => 1,
                'total_calories' => 390,
                'is_approved' => 1,
                'image_url' => 'cachapa_fit.jpg'
            ],
            [
                'title' => 'Pastel de Plátano Horneado',
                'preparation' => 'Sancochar plátano maduro y hacer puré. Intercalar capas de plátano y carne molida magra. Hornear.',
                'prep_time_minutes' => 60,
                'difficulty' => 'media',
                'portions' => 4,
                'total_calories' => 410,
                'is_approved' => 1,
                'image_url' => 'pastel_platano.jpg'
            ],
            [
                'title' => 'Canoas de Plátano al Horno',
                'preparation' => 'Hornear plátano maduro entero. Abrir por la mitad y rellenar con pollo esmechado y queso blanco gratinado.',
                'prep_time_minutes' => 40,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 380,
                'is_approved' => 1,
                'image_url' => 'canoas_platano.jpg'
            ],
            [
                'title' => 'Ensalada de Gallina (Versión Yogur)',
                'preparation' => 'Sustituir la mayonesa por yogur natural griego. Mezclar con pollo desmenuzado, papa, zanahoria y guisantes.',
                'prep_time_minutes' => 45,
                'difficulty' => 'media',
                'portions' => 4,
                'total_calories' => 250,
                'is_approved' => 1,
                'image_url' => 'ensalada_gallina.jpg'
            ],
            [
                'title' => 'Wrap de Lechuga con Atún',
                'preparation' => 'Usar hojas de lechuga romana como tortilla. Rellenar con atún, tomate y pepino.',
                'prep_time_minutes' => 10,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 180,
                'is_approved' => 1,
                'image_url' => 'wrap_lechuga.jpg'
            ],
            [
                'title' => 'Pizza en Base de Casabe',
                'preparation' => 'Usar una torta de casabe. Agregar pasta de tomate natural, vegetales y queso mozzarella ligero. Gratinar.',
                'prep_time_minutes' => 15,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 290,
                'is_approved' => 1,
                'image_url' => 'pizza_casabe.jpg'
            ],

            // --- SNACKS Y MERIENDAS ---
            [
                'title' => 'Batido de Lechoza (Papaya)',
                'preparation' => 'Licuar lechoza con agua y estevia. Excelente para la digestión.',
                'prep_time_minutes' => 5,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 90,
                'is_approved' => 1,
                'image_url' => 'batido_lechoza.jpg'
            ],
            [
                'title' => 'Merengada de Cacao Sin Azúcar',
                'preparation' => 'Licuar leche descremada con cacao puro en polvo venezolano y edulcorante. Servir fría.',
                'prep_time_minutes' => 5,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 120,
                'is_approved' => 1,
                'image_url' => 'merengada_cacao.jpg'
            ],
            [
                'title' => 'Galletas de Avena y Coco',
                'preparation' => 'Mezclar avena, coco rallado, cambur machacado. Hacer bolitas y hornear por 15 min.',
                'prep_time_minutes' => 20,
                'difficulty' => 'facil',
                'portions' => 4,
                'total_calories' => 150,
                'is_approved' => 1,
                'image_url' => 'galletas_avena.jpg'
            ],
            [
                'title' => 'Trozos de Piña con Canela',
                'preparation' => 'Picar piña fresca en cubos y espolvorear canela. Refrescante y diurético.',
                'prep_time_minutes' => 5,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 80,
                'is_approved' => 1,
                'image_url' => 'pina_canela.jpg'
            ],
            [
                'title' => 'Bastones de Zanahoria con Crema de Caraotas',
                'preparation' => 'Licuar caraotas cocidas con un toque de ajo y limón (tipo hummus). Dipear con bastones de zanahoria fresca.',
                'prep_time_minutes' => 10,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 140,
                'is_approved' => 1,
                'image_url' => 'hummus_caraotas.jpg'
            ],
        ];

        $this->db->table('recipes')->insertBatch($data);
    }
}