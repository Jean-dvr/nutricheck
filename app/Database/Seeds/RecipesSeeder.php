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

            // --- BASE: PASTA INTEGRAL (IDs 31 al 37) ---
            // Receta 31
            [
                'title' => 'Pasta Integral con Carne Molida Magra y Sofrito Criollo',
                'preparation' => 'Cocinar pasta integral al dente. Preparar salsa natural licuando tomate, cebolla, ajo y ají dulce; cocinar con carne magra molida sin grasas añadidas.',
                'prep_time_minutes' => 35,
                'difficulty' => 'facil',
                'portions' => 3,
                'total_calories' => 410,
                'is_approved' => 1,
                'image_url' => 'pasta_bolonesa_criolla.jpg'
            ],
            // Receta 32
            [
                'title' => 'Pasta Integral al Ajillo con Pollo y Espinacas',
                'preparation' => 'Saltear pechuga de pollo en tiras con ajo laminado y una cucharadita de aceite de oliva. Incorporar hojas frescas de espinaca y mezclar con la pasta integral.',
                'prep_time_minutes' => 25,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 390,
                'is_approved' => 1,
                'image_url' => 'pasta_pollo_espinaca.jpg'
            ],
            // Receta 33
            [
                'title' => 'Ensalada Fría de Pasta Integral con Atún y Vegetales',
                'preparation' => 'Mezclar pasta corta integral fría con atún en agua escurrido, zanahoria en cubos y vainitas cocidas al vapor. Aderezar con yogur griego natural y limón.',
                'prep_time_minutes' => 20,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 340,
                'is_approved' => 1,
                'image_url' => 'ensalada_pasta_atun.jpg'
            ],
            // Receta 34
            [
                'title' => 'Pasta Integral con Berenjenas Asadas y Tomate Natural',
                'preparation' => 'Asar cubos de berenjena y ajo al horno. Mezclar con pasta integral, salsa de tomate casera y un toque de queso blanco bajo en sal rallado.',
                'prep_time_minutes' => 40,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 360,
                'is_approved' => 1,
                'image_url' => 'pasta_berenjena.jpg'
            ],
            // Receta 35
            [
                'title' => 'Pasta Corta Integral con Cazón Guisado Margariteño',
                'preparation' => 'Preparar un guiso ligero de cazón desmenuzado con ají dulce, cebolla, pimentón y cilantro fresco. Servir sobre pasta integral recién cocida.',
                'prep_time_minutes' => 45,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 380,
                'is_approved' => 1,
                'image_url' => 'pasta_cazon.jpg'
            ],
            // Receta 36
            [
                'title' => 'Pasticho Saludable de Berenjena y Pasta Integral',
                'preparation' => 'Alternar láminas de berenjena asada, láminas de pasta integral, guiso de carne magra con tomate y queso blanco bajo en sal. Hornear por 30 minutos.',
                'prep_time_minutes' => 65,
                'difficulty' => 'dificil',
                'portions' => 4,
                'total_calories' => 430,
                'is_approved' => 1,
                'image_url' => 'pasticho_saludable.jpg'
            ],
            // Receta 37
            [
                'title' => 'Pasta Integral Primavera con Calabacín y Pollo a la Plancha',
                'preparation' => 'Saltear julianas de calabacín, pimentón y zanahoria con aceite de oliva. Servir con pasta integral y pechuga de pollo a la plancha en tiras.',
                'prep_time_minutes' => 30,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 375,
                'is_approved' => 1,
                'image_url' => 'pasta_primavera_pollo.jpg'
            ],

            // --- BASE: PAPA (IDs 38 al 44) ---
            // Receta 38
            [
                'title' => 'Papas Horneadas Rellenas de Pollo Desmechado y Aguacate',
                'preparation' => 'Hornear papas enteras envueltas hasta ablandar. Abrir por la mitad y rellenar con pechuga de pollo desmechada mezclada con yogur griego, cilantro y aguacate.',
                'prep_time_minutes' => 50,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 360,
                'is_approved' => 1,
                'image_url' => 'papas_rellenas_pollo.jpg'
            ],
            // Receta 39
            [
                'title' => 'Ensalada Rusa Criolla Ligera con Remolacha y Yogur',
                'preparation' => 'Sancochar papa, zanahoria y remolacha en cubos. Mezclar en frío con huevo cocido picado y aderezo ligero de yogur griego natural en lugar de mayonesa.',
                'prep_time_minutes' => 40,
                'difficulty' => 'facil',
                'portions' => 4,
                'total_calories' => 230,
                'is_approved' => 1,
                'image_url' => 'ensalada_rusa_fit.jpg'
            ],
            // Receta 40
            [
                'title' => 'Tortilla Española Saludable de Papa y Espinaca al Horno',
                'preparation' => 'Cocinar rodajas finas de papa y cebolla al vapor con un toque de aceite de oliva. Mezclar con huevos batidos y espinaca picada; cuajar al horno.',
                'prep_time_minutes' => 35,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 290,
                'is_approved' => 1,
                'image_url' => 'tortilla_papa_espinaca.jpg'
            ],
            // Receta 41
            [
                'title' => 'Puré de Papa y Auyama con Carne Magra Guisada',
                'preparation' => 'Sancochar partes iguales de papa y auyama para lograr un puré cremoso sin mantequilla. Acompañar con muchacho redondo guisado en salsa de tomate y pimentón.',
                'prep_time_minutes' => 55,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 370,
                'is_approved' => 1,
                'image_url' => 'pure_auyama_carne.jpg'
            ],
            // Receta 42
            [
                'title' => 'Papas Salteadas al Ajo con Atún y Vainitas',
                'preparation' => 'Hervir papas en cubos junto con vainitas troceadas. Saltear brevemente con ajo picado, aceite de oliva y servir con lomitos de atún en agua.',
                'prep_time_minutes' => 25,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 310,
                'is_approved' => 1,
                'image_url' => 'papas_atun_vainitas.jpg'
            ],
            // Receta 43
            [
                'title' => 'Pastel de Papa Horneado con Carne Molida y Queso Blanco',
                'preparation' => 'Preparar puré de papa suavizado con leche descremada. Colocar una base en refractario, rellenar con carne magra guisada con cebolla, cubrir con puré y gratinar queso.',
                'prep_time_minutes' => 55,
                'difficulty' => 'media',
                'portions' => 4,
                'total_calories' => 395,
                'is_approved' => 1,
                'image_url' => 'pastel_papa_carne.jpg'
            ],
            // Receta 44
            [
                'title' => 'Ensalada Tibia de Papa, Huevo Cocido y Pepino',
                'preparation' => 'Combinar papas cocidas en rodajas con pepino fresco, huevo duro y cilantro picado. Aderezar con jugo de limón y aceite de oliva extra virgen.',
                'prep_time_minutes' => 25,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 265,
                'is_approved' => 1,
                'image_url' => 'ensalada_papa_huevo.jpg'
            ],

            // --- BASE: YUCA Y VERDURAS CRIOLLAS (IDs 45 al 51) ---
            // Receta 45
            [
                'title' => 'Yuca Sancochada con Mojo Criollo y Carne Asada Magra',
                'preparation' => 'Hervir yuca hasta que ablande. Bañar con un mojo ligero de ajo machacado, cilantro, limón y aceite de oliva. Acompañar con bistec de carne magra asada.',
                'prep_time_minutes' => 35,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 410,
                'is_approved' => 1,
                'image_url' => 'yuca_mojo_carne.jpg'
            ],
            // Receta 46
            [
                'title' => 'Buñuelos de Yuca Horneados con Queso Blanco',
                'preparation' => 'Hacer puré de yuca sancochada y mezclar con queso blanco bajo en sal, huevo y semillas de linaza. Formar bolitas y hornear a 190°C hasta dorar.',
                'prep_time_minutes' => 40,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 285,
                'is_approved' => 1,
                'image_url' => 'bunuelos_yuca_horno.jpg'
            ],
            // Receta 47
            [
                'title' => 'Yuca al Horno Estilo Bastones con Pollo y Aguacate',
                'preparation' => 'Cortar yuca sancochada en bastones, pincelar con aceite de oliva y hornear hasta quedar crujientes. Servir con pechuga a la plancha, tomate y aguacate.',
                'prep_time_minutes' => 45,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 390,
                'is_approved' => 1,
                'image_url' => 'bastones_yuca_pollo.jpg'
            ],
            // Receta 48
            [
                'title' => 'Puré de Ocumo y Apio Criollo con Pescado al Ajillo',
                'preparation' => 'Sancochar ocumo y apio criollo hasta obtener un puré suave y nutritivo. Servir junto con filete de cazón o pescado blanco cocinado al ajillo con cilantro.',
                'prep_time_minutes' => 40,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 330,
                'is_approved' => 1,
                'image_url' => 'pure_ocumo_pescado.jpg'
            ],
            // Receta 49
            [
                'title' => 'Pastel de Yuca Relleno de Cazón Guisado',
                'preparation' => 'Amasar yuca sancochada hasta obtener una pasta manejable. Armar capas intercaladas con cazón guisado con ají dulce, cebolla y pimentón. Hornear 25 minutos.',
                'prep_time_minutes' => 60,
                'difficulty' => 'dificil',
                'portions' => 4,
                'total_calories' => 365,
                'is_approved' => 1,
                'image_url' => 'pastel_yuca_cazon.jpg'
            ],
            // Receta 50
            [
                'title' => 'Arepa de Yuca Asada con Perico y Aguacate',
                'preparation' => 'Mezclar puré de yuca sancochada con un toque de harina de maíz para dar firmeza. Asar en budare y rellenar con huevos pericos con tomate y rebanadas de aguacate.',
                'prep_time_minutes' => 30,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 345,
                'is_approved' => 1,
                'image_url' => 'arepa_yuca_perico.jpg'
            ],
            // Receta 51
            [
                'title' => 'Crema de Apio Criollo con Pollo Desmechado',
                'preparation' => 'Hervir apio criollo con cebolla y ajo en caldo natural de pollo. Licuar hasta lograr una crema aterciopelada y servir coronada con pechuga desmechada y cilantro.',
                'prep_time_minutes' => 30,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 240,
                'is_approved' => 1,
                'image_url' => 'crema_apio_pollo.jpg'
            ],

            // --- BASE: ARROZ INTEGRAL (IDs 52 al 58) ---
            // Receta 52
            [
                'title' => 'Arroz con Pollo Criollo Saludable y Vegetales',
                'preparation' => 'Cocinar arroz integral en caldo desgrasado de pechuga de pollo con sofrito de ají dulce, pimentón, zanahoria en cubos y vainitas picadas.',
                'prep_time_minutes' => 45,
                'difficulty' => 'media',
                'portions' => 4,
                'total_calories' => 385,
                'is_approved' => 1,
                'image_url' => 'arroz_pollo_fit.jpg'
            ],
            // Receta 53
            [
                'title' => 'Arroz Integral Salteado con Carne Magra y Repollo',
                'preparation' => 'Saltear tiras finas de carne magra con ajo, cebolla, repollo en julianas y zanahoria rallada. Integrar arroz integral previamente cocido a fuego alto.',
                'prep_time_minutes' => 30,
                'difficulty' => 'facil',
                'portions' => 3,
                'total_calories' => 370,
                'is_approved' => 1,
                'image_url' => 'arroz_salteado_carne.jpg'
            ],
            // Receta 54
            [
                'title' => 'Arroz con Coco Ligero y Papelón',
                'preparation' => 'Cocinar arroz integral en leche descremada aromatizada con astillas de canela y una pequeña porción de papelón rallado para lograr un postre criollo moderado.',
                'prep_time_minutes' => 40,
                'difficulty' => 'facil',
                'portions' => 4,
                'total_calories' => 235,
                'is_approved' => 1,
                'image_url' => 'arroz_leche_papelon.jpg'
            ],
            // Receta 55
            [
                'title' => 'Arroz Integral con Caraotas Negras y Ensalada Rayada',
                'preparation' => 'Servir una porción balanceada de arroz integral con caraotas negras guisadas al natural y ensalada fresca de repollo y zanahoria aderezada con limón.',
                'prep_time_minutes' => 40,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 360,
                'is_approved' => 1,
                'image_url' => 'arroz_caraotas_ensalada.jpg'
            ],
            // Receta 56
            [
                'title' => 'Arroz Marinero Criollo Saludable con Cazón',
                'preparation' => 'Sofreír ajo, tomate y pimentón. Añadir cazón troceado, vainitas y arroz integral; cocinar con caldo ligero hasta absorber el líquido.',
                'prep_time_minutes' => 45,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 355,
                'is_approved' => 1,
                'image_url' => 'arroz_marinero_cazon.jpg'
            ],
            // Receta 57
            [
                'title' => 'Croquetas de Arroz Integral y Espinaca Horneadas',
                'preparation' => 'Mezclar arroz integral cocido con espinaca picada, huevo, linaza molida y queso blanco bajo en sal. Formar croquetas y hornear hasta dorar.',
                'prep_time_minutes' => 35,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 275,
                'is_approved' => 1,
                'image_url' => 'croquetas_arroz_espinaca.jpg'
            ],
            // Receta 58
            [
                'title' => 'Arroz Integral con Atún, Maíz Tierno y Aguacate',
                'preparation' => 'Armar un bowl fresco con base de arroz integral tibio, atún en agua, granos de maíz tierno cocidos, cubos de aguacate, cilantro y jugo de limón.',
                'prep_time_minutes' => 20,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 395,
                'is_approved' => 1,
                'image_url' => 'bowl_arroz_atun.jpg'
            ],

            // --- BASE: GRANOS (CARAOTAS, LENTEJAS, GARBANZOS, ARVEJAS) (IDs 59 al 65) ---
            // Receta 59
            [
                'title' => 'Garbanzos Guisados con Pollo y Espinacas',
                'preparation' => 'Guisar garbanzos previamente ablandados con cubos de pechuga de pollo, tomate, cebolla y ajo. Añadir espinaca fresca en los últimos 5 minutos de cocción.',
                'prep_time_minutes' => 50,
                'difficulty' => 'media',
                'portions' => 4,
                'total_calories' => 390,
                'is_approved' => 1,
                'image_url' => 'garbanzos_pollo_espinaca.jpg'
            ],
            // Receta 60
            [
                'title' => 'Ensalada Fresca de Garbanzos, Pepino y Queso Blanco',
                'preparation' => 'Combinar garbanzos cocidos fríos con pepino y tomate en cubos, más queso blanco bajo en sal. Aliñar con aceite de oliva y jugo de limón.',
                'prep_time_minutes' => 15,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 330,
                'is_approved' => 1,
                'image_url' => 'ensalada_garbanzos.jpg'
            ],
            // Receta 61
            [
                'title' => 'Sopa de Arvejas Amarillas con Zanahoria y Apio Criollo',
                'preparation' => 'Hervir arvejas partidas con zanahoria, apio criollo y cebolla hasta obtener una sopa espesa y reconfortante. Finalizar con cilantro fresco picado.',
                'prep_time_minutes' => 55,
                'difficulty' => 'facil',
                'portions' => 4,
                'total_calories' => 280,
                'is_approved' => 1,
                'image_url' => 'sopa_arvejas.jpg'
            ],
            // Receta 62
            [
                'title' => 'Hamburguesas Veganas de Lentejas y Avena con Ensalada',
                'preparation' => 'Procesar lentejas cocidas con avena en hojuelas, cebolla y ajo. Formar medallones, dorar en plancha antiadherente y servir sobre hojas de lechuga y tomate.',
                'prep_time_minutes' => 35,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 295,
                'is_approved' => 1,
                'image_url' => 'hamburguesa_lentejas.jpg'
            ],
            // Receta 63
            [
                'title' => 'Caraotas Negras Guisadas con Ají Dulce y Plátano Horneado',
                'preparation' => 'Cocinar caraotas negras con un sofrito natural de ají dulce, cebolla y ajo sin carnes grasas. Acompañar con tajadas de plátano maduro horneado.',
                'prep_time_minutes' => 60,
                'difficulty' => 'facil',
                'portions' => 3,
                'total_calories' => 350,
                'is_approved' => 1,
                'image_url' => 'caraotas_platano_horno.jpg'
            ],
            // Receta 64
            [
                'title' => 'Guiso de Arvejas con Carne Magra y Papa',
                'preparation' => 'Preparar un estofado nutritivo de arvejas con dados de carne magra, papa en cubos, pimentón y tomate natural cocido a fuego lento.',
                'prep_time_minutes' => 55,
                'difficulty' => 'media',
                'portions' => 4,
                'total_calories' => 375,
                'is_approved' => 1,
                'image_url' => 'guiso_arvejas_carne.jpg'
            ],
            // Receta 65
            [
                'title' => 'Bowl Criollo de Garbanzos Tostados, Aguacate y Remolacha',
                'preparation' => 'Hornear garbanzos cocidos hasta que queden crocantes. Servir sobre base de lechuga, remolacha rallada, aguacate, semillas de chía y limón.',
                'prep_time_minutes' => 30,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 345,
                'is_approved' => 1,
                'image_url' => 'bowl_garbanzos_aguacate.jpg'
            ],

            // --- PESCADOS Y MARISCOS (IDs 66 al 71) ---
            // Receta 66
            [
                'title' => 'Tortilla de Cazón Estilo Oriental',
                'preparation' => 'Batir huevos con cilantro picado. Incorporar cazón guisado previamente con ají dulce, cebolla y ajo; cuajar en sartén antiadherente a fuego bajo.',
                'prep_time_minutes' => 30,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 320,
                'is_approved' => 1,
                'image_url' => 'tortilla_cazon.jpg'
            ],
            // Receta 67
            [
                'title' => 'Croquetas de Atún y Papa al Horno',
                'preparation' => 'Mezclar puré de papa cocida con atún en agua escurrido, huevo, cebolla rallada y linaza molida. Formar tortitas y hornear hasta dorar.',
                'prep_time_minutes' => 35,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 275,
                'is_approved' => 1,
                'image_url' => 'croquetas_atun_papa.jpg'
            ],
            // Receta 68
            [
                'title' => 'Ceviche Criollo de Cazón con Aguacate y Limón',
                'preparation' => 'Cocinar trozos pequeños de cazón al vapor y enfriar. Marinar en abundante jugo de limón con cebolla morada, ají dulce, cilantro fresco y cubos de aguacate.',
                'prep_time_minutes' => 25,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 260,
                'is_approved' => 1,
                'image_url' => 'ceviche_cazon.jpg'
            ],
            // Receta 69
            [
                'title' => 'Aguacates Rellenos de Ensalada de Atún y Maíz Tierno',
                'preparation' => 'Cortar aguacates por la mitad y retirar la semilla. Rellenar con atún en agua mezclado con granos de maíz tierno, cebolla picada, yogur griego y limón.',
                'prep_time_minutes' => 15,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 340,
                'is_approved' => 1,
                'image_url' => 'aguacate_relleno_atun.jpg'
            ],
            // Receta 70
            [
                'title' => 'Pimentones Rellenos de Cazón Guisado Gratinados',
                'preparation' => 'Cortar pimentones a la mitad y limpiar las semillas. Rellenar con cazón guisado con tomate y ají dulce, cubrir con queso blanco bajo en sal y hornear 20 minutos.',
                'prep_time_minutes' => 45,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 285,
                'is_approved' => 1,
                'image_url' => 'pimentones_rellenos_cazon.jpg'
            ],
            // Receta 71
            [
                'title' => 'Tostadas de Casabe con Atún al Ajillo y Tomate',
                'preparation' => 'Tostar triángulos de casabe en budare. Cubrir con atún salteado brevemente con ajo, aceite de oliva, tomate en cubos y cilantro fresco.',
                'prep_time_minutes' => 15,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 295,
                'is_approved' => 1,
                'image_url' => 'tostadas_casabe_atun.jpg'
            ],

            // --- CARNES MAGRAS Y AVES (IDs 72 al 79) ---
            // Receta 72
            [
                'title' => 'Berenjenas Rellenas de Carne Magra y Tomate al Horno',
                'preparation' => 'Asar berenjenas partidas a la mitad, vaciar la pulpa y mezclarla con carne magra molida guisada con tomate, cebolla y ajo. Rellenar y gratinar con queso blanco.',
                'prep_time_minutes' => 50,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 350,
                'is_approved' => 1,
                'image_url' => 'berenjenas_rellenas_carne.jpg'
            ],
            // Receta 73
            [
                'title' => 'Calabacines Rellenos de Pollo Desmechado y Maíz Tierno',
                'preparation' => 'Ahuecar calabacines sancochados ligeramente. Rellenar con pechuga de pollo desmechada guisada con cebolla y maíz tierno; gratinar con queso blanco bajo en sal.',
                'prep_time_minutes' => 40,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 310,
                'is_approved' => 1,
                'image_url' => 'calabacin_relleno_pollo.jpg'
            ],
            // Receta 74
            [
                'title' => 'Fajitas de Pollo Criollas en Hojas de Lechuga',
                'preparation' => 'Saltear tiras de pechuga de pollo con julianas de pimentón y cebolla. Servir dentro de hojas firmes de lechuga con rebanadas de aguacate y gotas de limón.',
                'prep_time_minutes' => 25,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 290,
                'is_approved' => 1,
                'image_url' => 'fajitas_pollo_lechuga.jpg'
            ],
            // Receta 75
            [
                'title' => 'Albóndigas de Carne Magra y Avena en Salsa de Tomate Natural',
                'preparation' => 'Mezclar carne magra molida con avena en hojuelas, huevo y ajo machacado. Formar albóndigas, sellar en sartén y terminar de cocinar en salsa licuada de tomate y cebolla.',
                'prep_time_minutes' => 40,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 365,
                'is_approved' => 1,
                'image_url' => 'albondigas_avena_tomate.jpg'
            ],
            // Receta 76
            [
                'title' => 'Carne Mechada Saludable con Tajadas Horneadas y Casabe',
                'preparation' => 'Desmechar muchacho redondo cocido y guisar con tomate, pimentón, ají dulce y ajo sin exceso de aceite. Acompañar con tajadas de plátano maduro al horno y casabe.',
                'prep_time_minutes' => 65,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 415,
                'is_approved' => 1,
                'image_url' => 'carne_mechada_casabe.jpg'
            ],
            // Receta 77
            [
                'title' => 'Pinchos de Pechuga de Pollo, Piña y Pimentón a la Plancha',
                'preparation' => 'Armar brochetas intercalando cubos de pechuga de pollo marinados con limón, trozos de piña fresca, pimentón y cebolla. Cocinar a la plancha hasta dorar.',
                'prep_time_minutes' => 30,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 280,
                'is_approved' => 1,
                'image_url' => 'pinchos_pollo_pina.jpg'
            ],
            // Receta 78
            [
                'title' => 'Bistec de Muchacho Encebollado con Ocumo Sancochado',
                'preparation' => 'Asar filetes de carne magra con ajo machacado y cubrir con aros de cebolla salteados al agua. Servir acompañado de ruedas de ocumo blanco sancochado con cilantro.',
                'prep_time_minutes' => 35,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 385,
                'is_approved' => 1,
                'image_url' => 'bistec_encebollado_ocumo.jpg'
            ],
            // Receta 79
            [
                'title' => 'Rollo de Pechuga de Pollo Relleno de Espinaca y Queso Blanco',
                'preparation' => 'Abrir una pechuga de pollo en filete fino, rellenar con hojas de espinaca salteadas con ajo y tiras de queso blanco bajo en sal. Enrollar y hornear por 25 minutos.',
                'prep_time_minutes' => 40,
                'difficulty' => 'dificil',
                'portions' => 2,
                'total_calories' => 330,
                'is_approved' => 1,
                'image_url' => 'rollo_pollo_espinaca.jpg'
            ],

            // --- SOPAS Y CREMAS (IDs 80 al 86) ---
            // Receta 80
            [
                'title' => 'Sancocho de Pescado Oriental Ligero',
                'preparation' => 'Preparar caldo aromático con ají dulce, cebolla y ajo. Añadir trozos de yuca, ocumo, apio criollo y ruedas de cazón; finalizar con abundante cilantro fresco.',
                'prep_time_minutes' => 50,
                'difficulty' => 'media',
                'portions' => 4,
                'total_calories' => 320,
                'is_approved' => 1,
                'image_url' => 'sancocho_pescado_fit.jpg'
            ],
            // Receta 81
            [
                'title' => 'Crema de Calabacín y Espinaca con Yogur Griego',
                'preparation' => 'Hervir calabacín troceado con cebolla y ajo en caldo ligero. Licuar junto con hojas frescas de espinaca y una cucharada de yogur griego natural para dar cremosidad.',
                'prep_time_minutes' => 25,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 135,
                'is_approved' => 1,
                'image_url' => 'crema_calabacin_espinaca.jpg'
            ],
            // Receta 82
            [
                'title' => 'Sopa de Caraotas Negras Licuadas con Cilantro y Queso',
                'preparation' => 'Licuar caraotas negras guisadas con ají dulce, cebolla y ajo hasta obtener una sopa espesa. Servir caliente con cubitos de queso blanco bajo en sal y cilantro picado.',
                'prep_time_minutes' => 20,
                'difficulty' => 'facil',
                'portions' => 3,
                'total_calories' => 295,
                'is_approved' => 1,
                'image_url' => 'sopa_caraotas_licuadas.jpg'
            ],
            // Receta 83
            [
                'title' => 'Crema de Zanahoria y Auyama con Semillas de Chía',
                'preparation' => 'Cocinar zanahoria y auyama con cebolla hasta que estén tiernas. Licuar hasta lograr una crema homogénea y servir decorada con semillas de chía hidratadas.',
                'prep_time_minutes' => 30,
                'difficulty' => 'facil',
                'portions' => 3,
                'total_calories' => 165,
                'is_approved' => 1,
                'image_url' => 'crema_zanahoria_auyama.jpg'
            ],
            // Receta 84
            [
                'title' => 'Consomé Criollo de Pollo con Apio Criollo y Repollo',
                'preparation' => 'Hervir pechuga de pollo desgrasada con apio criollo, zanahoria en ruedas, tiras de repollo y cilantro. Servir desmechando el pollo dentro del caldo claro.',
                'prep_time_minutes' => 45,
                'difficulty' => 'facil',
                'portions' => 3,
                'total_calories' => 245,
                'is_approved' => 1,
                'image_url' => 'consome_pollo_apio.jpg'
            ],
            // Receta 85
            [
                'title' => 'Crema de Ocumo Blanco al Ajo con Pollo Desmechado',
                'preparation' => 'Sancochar ocumo blanco con dientes de ajo y cebolla. Procesar con el agua de cocción hasta obtener una textura suave y servir con pechuga de pollo desmechada.',
                'prep_time_minutes' => 35,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 270,
                'is_approved' => 1,
                'image_url' => 'crema_ocumo_pollo.jpg'
            ],
            // Receta 86
            [
                'title' => 'Sopa Minestrone Criolla de Garbanzos y Vegetales',
                'preparation' => 'Cocinar garbanzos ablandados en caldo de tomate natural con zanahoria, vainitas, calabacín en cubos y un puñado de pasta corta integral.',
                'prep_time_minutes' => 50,
                'difficulty' => 'media',
                'portions' => 4,
                'total_calories' => 310,
                'is_approved' => 1,
                'image_url' => 'sopa_minestrone_garbanzos.jpg'
            ],

            // --- ENSALADAS COMPLETAS (IDs 87 al 92) ---
            // Receta 87
            [
                'title' => 'Ensalada César Criolla de Pollo con Aderezo de Yogur Griego',
                'preparation' => 'Trocear lechuga fresca, añadir pechuga de pollo a la plancha en tiras y trocitos de casabe tostado al ajo. Aderezar con yogur griego natural, limón y ajo.',
                'prep_time_minutes' => 20,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 315,
                'is_approved' => 1,
                'image_url' => 'ensalada_cesar_criolla.jpg'
            ],
            // Receta 88
            [
                'title' => 'Ensalada de Remolacha, Zanahoria y Huevo Cocido',
                'preparation' => 'Cortar remolacha en rodajas y rallar zanahoria previamente cocidas. Acompañar con huevos sancochados en cuartos, cilantro picado y vinagreta ligera de limón y aceite de oliva.',
                'prep_time_minutes' => 30,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 240,
                'is_approved' => 1,
                'image_url' => 'ensalada_remolacha_huevo.jpg'
            ],
            // Receta 89
            [
                'title' => 'Ensalada Tropical de Pollo, Piña, Pepino y Aguacate',
                'preparation' => 'Mezclar sobre cama de lechuga cubos de pechuga de pollo asada, piña fresca, pepino en medias lunas y aguacate. Aliñar con jugo de limón.',
                'prep_time_minutes' => 20,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 330,
                'is_approved' => 1,
                'image_url' => 'ensalada_tropical_pollo.jpg'
            ],
            // Receta 90
            [
                'title' => 'Ensalada de Repollo y Zanahoria con Pollo Desmechado',
                'preparation' => 'Rallar repollo fresco y zanahoria muy finos. Integrar pechuga de pollo desmechada y aderezar con yogur griego natural, jugo de limón y una pizca de sal.',
                'prep_time_minutes' => 15,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 260,
                'is_approved' => 1,
                'image_url' => 'ensalada_repollo_pollo.jpg'
            ],
            // Receta 91
            [
                'title' => 'Ensalada Mediterránea Criolla de Berenjena Asada y Garbanzos',
                'preparation' => 'Asar cubos de berenjena y mezclar tibios con garbanzos cocidos, tomate, pepino y cebolla morada. Aderezar con aceite de oliva y limón.',
                'prep_time_minutes' => 35,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 325,
                'is_approved' => 1,
                'image_url' => 'ensalada_berenjena_garbanzos.jpg'
            ],
            // Receta 92
            [
                'title' => 'Ensalada Verde de Espinaca, Piña, Aguacate y Queso Blanco',
                'preparation' => 'Combinar hojas frescas de espinaca con trozos de piña dulce, rebanadas de aguacate, dados de queso blanco bajo en sal y semillas de chía.',
                'prep_time_minutes' => 10,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 285,
                'is_approved' => 1,
                'image_url' => 'ensalada_espinaca_pina.jpg'
            ],

            // --- MERIENDAS, DESAYUNOS LIGEROS Y BEBIDAS (IDs 93 al 100) ---
            // Receta 93
            [
                'title' => 'Papelón con Limón y Semillas de Chía Refrescante',
                'preparation' => 'Disolver papelón rallado en agua fría con abundante jugo de limón recién exprimido. Agregar semillas de chía y dejar hidratar 10 minutos antes de servir.',
                'prep_time_minutes' => 10,
                'difficulty' => 'facil',
                'portions' => 2,
                'total_calories' => 115,
                'is_approved' => 1,
                'image_url' => 'papelon_limon_chia.jpg'
            ],
            // Receta 94
            [
                'title' => 'Pudín de Chía con Leche Descremada, Cacao y Cambur',
                'preparation' => 'Mezclar leche descremada con semillas de chía, cacao en polvo sin azúcar y canela; refrigerar por 2 horas. Servir coronado con rodajas de cambur.',
                'prep_time_minutes' => 10,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 220,
                'is_approved' => 1,
                'image_url' => 'pudin_chia_cacao.jpg'
            ],
            // Receta 95
            [
                'title' => 'Parfait de Yogur Griego, Piña, Avena y Linaza',
                'preparation' => 'Alternar en un vaso capas de yogur griego natural, trocitos de piña fresca, avena en hojuelas tostada, linaza molida y un toque de canela.',
                'prep_time_minutes' => 10,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 245,
                'is_approved' => 1,
                'image_url' => 'parfait_yogur_pina.jpg'
            ],
            // Receta 96
            [
                'title' => 'Arepitas Dulces Horneadas con Canela y Queso Blanco',
                'preparation' => 'Amasar harina de maíz precocida con agua tibia, canela en polvo y un toque mínimo de papelón rallado. Formar arepitas delgadas, hornear hasta inflar y rellenar con queso.',
                'prep_time_minutes' => 25,
                'difficulty' => 'media',
                'portions' => 2,
                'total_calories' => 290,
                'is_approved' => 1,
                'image_url' => 'arepitas_dulces_horno.jpg'
            ],
            // Receta 97
            [
                'title' => 'Batido Verde Energético de Espinaca, Piña, Pepino y Linaza',
                'preparation' => 'Licuar hojas de espinaca lavadas con piña en trozos, pepino sin semillas, agua fría, jugo de limón y una cucharadita de linaza molida.',
                'prep_time_minutes' => 5,
                'difficulty' => 'facil',
                'portions' => 1,
                'total_calories' => 110,
                'is_approved' => 1,
                'image_url' => 'batido_verde_criollo.jpg'
            ],
            // Receta 98
            [
                'title' => 'Mandocas Horneadas Saludables de Plátano Maduro y Queso',
                'preparation' => 'Mezclar puré de plátano maduro cocido con harina de maíz, queso blanco bajo en sal rallado y un toque de papelón. Formar los lazos y hornear 20 minutos.',
                'prep_time_minutes' => 35,
                'difficulty' => 'media',
                'portions' => 3,
                'total_calories' => 275,
                'is_approved' => 1,
                'image_url' => 'mandocas_horneadas.jpg'
            ],
            // Receta 99
            [
                'title' => 'Ponqué Saludable de Cambur, Avena, Cacao y Huevos',
                'preparation' => 'Licuar cambures maduros con huevos, avena en hojuelas, cacao puro en polvo y canela. Verter en molde y hornear a 180°C durante 25 minutos.',
                'prep_time_minutes' => 35,
                'difficulty' => 'facil',
                'portions' => 4,
                'total_calories' => 210,
                'is_approved' => 1,
                'image_url' => 'ponque_cambur_cacao.jpg'
            ],
            // Receta 100
            [
                'title' => 'Tizana Criolla Natural de Lechoza, Piña y Cambur',
                'preparation' => 'Picar lechoza, piña y cambur en cubos pequeños. Bañar con jugo natural de lechoza licuada con agua y gotas de limón sin azúcares refinados.',
                'prep_time_minutes' => 15,
                'difficulty' => 'facil',
                'portions' => 3,
                'total_calories' => 125,
                'is_approved' => 1,
                'image_url' => 'tizana_criolla_fit.jpg'
            ],
        ];

        $this->db->table('recipes')->insertBatch($data);
    }
}