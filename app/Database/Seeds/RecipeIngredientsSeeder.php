<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipeIngredientsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Receta 1: Pabellón Saludable
            ['recipe_id' => 1, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 1, 'ingredient_id' => 2, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 1, 'ingredient_id' => 7, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 1, 'ingredient_id' => 8, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            
            // Receta 2: Arepa Asada con Huevos Pericos
            ['recipe_id' => 2, 'ingredient_id' => 5, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 2, 'ingredient_id' => 6, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 2, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            
            // Receta 3: Arepa de Avena y Chía
            ['recipe_id' => 3, 'ingredient_id' => 5, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 3, 'ingredient_id' => 9, 'quantity' => 30, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 3, 'ingredient_id' => 22, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            
            // Receta 4: Arepa de Zanahoria con Queso
            ['recipe_id' => 4, 'ingredient_id' => 5, 'quantity' => 60, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 4, 'ingredient_id' => 10, 'quantity' => 30, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 4, 'ingredient_id' => 22, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            
            // Receta 5: Empanadas Horneadas de Carne Machada
            ['recipe_id' => 5, 'ingredient_id' => 5, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 5, 'ingredient_id' => 11, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            
            // Receta 6: Panquecas de Cambur y Avena
            ['recipe_id' => 6, 'ingredient_id' => 12, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            ['recipe_id' => 6, 'ingredient_id' => 9, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 6, 'ingredient_id' => 6, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 6, 'ingredient_id' => 20, 'quantity' => 50, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],
            
            // Receta 7: Pollo Guisado con Papas y Zanahorias
            ['recipe_id' => 7, 'ingredient_id' => 1, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 7, 'ingredient_id' => 4, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 7, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            
            // Receta 8: Carne Molida con Vegetales Escondidos
            ['recipe_id' => 8, 'ingredient_id' => 11, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 8, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            
            // Receta 9: Asado Negro Saludable
            ['recipe_id' => 9, 'ingredient_id' => 11, 'quantity' => 300, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            
            // Receta 10: Pechuga a la Plancha con Yuca Hervida
            ['recipe_id' => 10, 'ingredient_id' => 1, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 10, 'ingredient_id' => 16, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 10, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            
            // Receta 11: Cazón Guisado
            ['recipe_id' => 11, 'ingredient_id' => 13, 'quantity' => 250, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 11, 'ingredient_id' => 14, 'quantity' => 3, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            
            // Receta 12: Rueda de Pescado al Horno
            ['recipe_id' => 12, 'ingredient_id' => 13, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            
            // Receta 13: Ensalada Fresca de Atún y Aguacate
            ['recipe_id' => 13, 'ingredient_id' => 15, 'quantity' => 1, 'unit_of_measure' => 'lata', 'is_main_ingredient' => true],
            ['recipe_id' => 13, 'ingredient_id' => 3, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            
            // Receta 14: Sardinas Asadas con Casabe
            ['recipe_id' => 14, 'ingredient_id' => 15, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 14, 'ingredient_id' => 17, 'quantity' => 1, 'unit_of_measure' => 'porcion', 'is_main_ingredient' => true],
            
            // Receta 15: Hervido de Res Magra
            ['recipe_id' => 15, 'ingredient_id' => 11, 'quantity' => 250, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 15, 'ingredient_id' => 19, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            
            // Receta 16: Sopa de Pollo Levanta Muertos
            ['recipe_id' => 16, 'ingredient_id' => 1, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 16, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            
            // Receta 17: Lentejas Guisadas Ligeras
            ['recipe_id' => 17, 'ingredient_id' => 18, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 17, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            
            // Receta 18: Crema de Auyama
            ['recipe_id' => 18, 'ingredient_id' => 19, 'quantity' => 300, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 18, 'ingredient_id' => 20, 'quantity' => 50, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],
            
            // Receta 19: Pisca Andina Saludable
            ['recipe_id' => 19, 'ingredient_id' => 20, 'quantity' => 200, 'unit_of_measure' => 'ml', 'is_main_ingredient' => true],
            ['recipe_id' => 19, 'ingredient_id' => 6, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            
            // Receta 20: Cachapa de Maíz Tierno a la Plancha
            ['recipe_id' => 20, 'ingredient_id' => 21, 'quantity' => 3, 'unit_of_measure' => 'jojotos', 'is_main_ingredient' => true],
            ['recipe_id' => 20, 'ingredient_id' => 22, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            
            // Receta 21: Pastel de Plátano Horneado
            ['recipe_id' => 21, 'ingredient_id' => 8, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 21, 'ingredient_id' => 11, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            
            // Receta 22: Canoas de Plátano al Horno
            ['recipe_id' => 22, 'ingredient_id' => 8, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            ['recipe_id' => 22, 'ingredient_id' => 1, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 22, 'ingredient_id' => 22, 'quantity' => 30, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            
            // Receta 23: Ensalada de Gallina (Versión Yogur)
            ['recipe_id' => 23, 'ingredient_id' => 1, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 23, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            
            // Receta 24: Wrap de Lechuga con Atún
            ['recipe_id' => 24, 'ingredient_id' => 15, 'quantity' => 1, 'unit_of_measure' => 'lata', 'is_main_ingredient' => true],
            ['recipe_id' => 24, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            
            // Receta 25: Pizza en Base de Casabe
            ['recipe_id' => 25, 'ingredient_id' => 17, 'quantity' => 1, 'unit_of_measure' => 'torta', 'is_main_ingredient' => true],
            ['recipe_id' => 25, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 25, 'ingredient_id' => 22, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            
            // Receta 26: Batido de Lechoza
            ['recipe_id' => 26, 'ingredient_id' => 23, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            
            // Receta 27: Merengada de Cacao Sin Azúcar
            ['recipe_id' => 27, 'ingredient_id' => 20, 'quantity' => 250, 'unit_of_measure' => 'ml', 'is_main_ingredient' => true],
            ['recipe_id' => 27, 'ingredient_id' => 24, 'quantity' => 15, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            
            // Receta 28: Galletas de Avena y Coco
            ['recipe_id' => 28, 'ingredient_id' => 9, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 28, 'ingredient_id' => 12, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            
            // Receta 29: Trozos de Piña con Canela
            ['recipe_id' => 29, 'ingredient_id' => 25, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            
            // Receta 30: Bastones de Zanahoria con Crema de Caraotas
            ['recipe_id' => 30, 'ingredient_id' => 7, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 30, 'ingredient_id' => 10, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],

            // Receta 31: Pasta Integral con Carne Molida Magra y Sofrito Criollo
            ['recipe_id' => 31, 'ingredient_id' => 26, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 31, 'ingredient_id' => 11, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 31, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 31, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 31, 'ingredient_id' => 14, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 31, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],

            // Receta 32: Pasta Integral al Ajillo con Pollo y Espinacas
            ['recipe_id' => 32, 'ingredient_id' => 26, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 32, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 32, 'ingredient_id' => 39, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 32, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],
            ['recipe_id' => 32, 'ingredient_id' => 43, 'quantity' => 5, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],

            // Receta 33: Ensalada Fría de Pasta Integral con Atún y Vegetales
            ['recipe_id' => 33, 'ingredient_id' => 26, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 33, 'ingredient_id' => 15, 'quantity' => 1, 'unit_of_measure' => 'lata', 'is_main_ingredient' => true],
            ['recipe_id' => 33, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 33, 'ingredient_id' => 38, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 33, 'ingredient_id' => 44, 'quantity' => 30, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 33, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 34: Pasta Integral con Berenjenas Asadas y Tomate Natural
            ['recipe_id' => 34, 'ingredient_id' => 26, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 34, 'ingredient_id' => 35, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 34, 'ingredient_id' => 4, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 34, 'ingredient_id' => 22, 'quantity' => 30, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 34, 'ingredient_id' => 32, 'quantity' => 1, 'unit_of_measure' => 'diente', 'is_main_ingredient' => false],

            // Receta 35: Pasta Corta Integral con Cazón Guisado Margariteño
            ['recipe_id' => 35, 'ingredient_id' => 26, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 35, 'ingredient_id' => 13, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 35, 'ingredient_id' => 14, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 35, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 35, 'ingredient_id' => 31, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 35, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 36: Pasticho Saludable de Berenjena y Pasta Integral
            ['recipe_id' => 36, 'ingredient_id' => 35, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 36, 'ingredient_id' => 26, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 36, 'ingredient_id' => 11, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 36, 'ingredient_id' => 4, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 36, 'ingredient_id' => 22, 'quantity' => 60, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 37: Pasta Integral Primavera con Calabacín y Pollo a la Plancha
            ['recipe_id' => 37, 'ingredient_id' => 26, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 37, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 37, 'ingredient_id' => 34, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 37, 'ingredient_id' => 31, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 37, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 37, 'ingredient_id' => 43, 'quantity' => 5, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],

            // Receta 38: Papas Horneadas Rellenas de Pollo Desmechado y Aguacate
            ['recipe_id' => 38, 'ingredient_id' => 27, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 38, 'ingredient_id' => 1, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 38, 'ingredient_id' => 3, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 38, 'ingredient_id' => 44, 'quantity' => 30, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 38, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 39: Ensalada Rusa Criolla Ligera con Remolacha y Yogur
            ['recipe_id' => 39, 'ingredient_id' => 27, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 39, 'ingredient_id' => 37, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 39, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 39, 'ingredient_id' => 6, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 39, 'ingredient_id' => 44, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 40: Tortilla Española Saludable de Papa y Espinaca al Horno
            ['recipe_id' => 40, 'ingredient_id' => 27, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 40, 'ingredient_id' => 6, 'quantity' => 3, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 40, 'ingredient_id' => 39, 'quantity' => 60, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 40, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 40, 'ingredient_id' => 43, 'quantity' => 5, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],

            // Receta 41: Puré de Papa y Auyama con Carne Magra Guisada
            ['recipe_id' => 41, 'ingredient_id' => 27, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 41, 'ingredient_id' => 19, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 41, 'ingredient_id' => 11, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 41, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 41, 'ingredient_id' => 31, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 42: Papas Salteadas al Ajo con Atún y Vainitas
            ['recipe_id' => 42, 'ingredient_id' => 27, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 42, 'ingredient_id' => 15, 'quantity' => 1, 'unit_of_measure' => 'lata', 'is_main_ingredient' => true],
            ['recipe_id' => 42, 'ingredient_id' => 38, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 42, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],
            ['recipe_id' => 42, 'ingredient_id' => 43, 'quantity' => 5, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],

            // Receta 43: Pastel de Papa Horneado con Carne Molida y Queso Blanco
            ['recipe_id' => 43, 'ingredient_id' => 27, 'quantity' => 250, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 43, 'ingredient_id' => 11, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 43, 'ingredient_id' => 22, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 43, 'ingredient_id' => 20, 'quantity' => 50, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],
            ['recipe_id' => 43, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 44: Ensalada Tibia de Papa, Huevo Cocido y Pepino
            ['recipe_id' => 44, 'ingredient_id' => 27, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 44, 'ingredient_id' => 6, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 44, 'ingredient_id' => 40, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 44, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 44, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 44, 'ingredient_id' => 43, 'quantity' => 5, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],

            // Receta 45: Yuca Sancochada con Mojo Criollo y Carne Asada Magra
            ['recipe_id' => 45, 'ingredient_id' => 16, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 45, 'ingredient_id' => 11, 'quantity' => 180, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 45, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],
            ['recipe_id' => 45, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 45, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 45, 'ingredient_id' => 43, 'quantity' => 5, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],

            // Receta 46: Buñuelos de Yuca Horneados con Queso Blanco
            ['recipe_id' => 46, 'ingredient_id' => 16, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 46, 'ingredient_id' => 22, 'quantity' => 60, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 46, 'ingredient_id' => 6, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 46, 'ingredient_id' => 48, 'quantity' => 15, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 47: Yuca al Horno Estilo Bastones con Pollo y Aguacate
            ['recipe_id' => 47, 'ingredient_id' => 16, 'quantity' => 180, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 47, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 47, 'ingredient_id' => 3, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 47, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 47, 'ingredient_id' => 43, 'quantity' => 5, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],

            // Receta 48: Puré de Ocumo y Apio Criollo con Pescado al Ajillo
            ['recipe_id' => 48, 'ingredient_id' => 28, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 48, 'ingredient_id' => 29, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 48, 'ingredient_id' => 13, 'quantity' => 180, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 48, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],
            ['recipe_id' => 48, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 49: Pastel de Yuca Relleno de Cazón Guisado
            ['recipe_id' => 49, 'ingredient_id' => 16, 'quantity' => 250, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 49, 'ingredient_id' => 13, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 49, 'ingredient_id' => 14, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 49, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 49, 'ingredient_id' => 31, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 50: Arepa de Yuca Asada con Perico y Aguacate
            ['recipe_id' => 50, 'ingredient_id' => 16, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 50, 'ingredient_id' => 5, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 50, 'ingredient_id' => 6, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 50, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 50, 'ingredient_id' => 3, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 51: Crema de Apio Criollo con Pollo Desmechado
            ['recipe_id' => 51, 'ingredient_id' => 29, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 51, 'ingredient_id' => 1, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 51, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 51, 'ingredient_id' => 32, 'quantity' => 1, 'unit_of_measure' => 'diente', 'is_main_ingredient' => false],
            ['recipe_id' => 51, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 52: Arroz con Pollo Criollo Saludable y Vegetales
            ['recipe_id' => 52, 'ingredient_id' => 2, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 52, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 52, 'ingredient_id' => 14, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 52, 'ingredient_id' => 31, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 52, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 52, 'ingredient_id' => 38, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 53: Arroz Integral Salteado con Carne Magra y Repollo
            ['recipe_id' => 53, 'ingredient_id' => 2, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 53, 'ingredient_id' => 11, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 53, 'ingredient_id' => 36, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 53, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 53, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 53, 'ingredient_id' => 32, 'quantity' => 1, 'unit_of_measure' => 'diente', 'is_main_ingredient' => false],

            // Receta 54: Arroz con Coco Ligero y Papelón
            ['recipe_id' => 54, 'ingredient_id' => 2, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 54, 'ingredient_id' => 20, 'quantity' => 250, 'unit_of_measure' => 'ml', 'is_main_ingredient' => true],
            ['recipe_id' => 54, 'ingredient_id' => 49, 'quantity' => 20, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 54, 'ingredient_id' => 50, 'quantity' => 5, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 55: Arroz Integral con Caraotas Negras y Ensalada Rayada
            ['recipe_id' => 55, 'ingredient_id' => 2, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 55, 'ingredient_id' => 7, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 55, 'ingredient_id' => 36, 'quantity' => 60, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 55, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 55, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 56: Arroz Marinero Criollo Saludable con Cazón
            ['recipe_id' => 56, 'ingredient_id' => 2, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 56, 'ingredient_id' => 13, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 56, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 56, 'ingredient_id' => 31, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 56, 'ingredient_id' => 38, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 56, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],

            // Receta 57: Croquetas de Arroz Integral y Espinaca Horneadas
            ['recipe_id' => 57, 'ingredient_id' => 2, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 57, 'ingredient_id' => 39, 'quantity' => 60, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 57, 'ingredient_id' => 6, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 57, 'ingredient_id' => 22, 'quantity' => 30, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 57, 'ingredient_id' => 48, 'quantity' => 15, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 58: Arroz Integral con Atún, Maíz Tierno y Aguacate
            ['recipe_id' => 58, 'ingredient_id' => 2, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 58, 'ingredient_id' => 15, 'quantity' => 1, 'unit_of_measure' => 'lata', 'is_main_ingredient' => true],
            ['recipe_id' => 58, 'ingredient_id' => 21, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 58, 'ingredient_id' => 3, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 58, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 58, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 59: Garbanzos Guisados con Pollo y Espinacas
            ['recipe_id' => 59, 'ingredient_id' => 45, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 59, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 59, 'ingredient_id' => 39, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 59, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 59, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 59, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],

            // Receta 60: Ensalada Fresca de Garbanzos, Pepino y Queso Blanco
            ['recipe_id' => 60, 'ingredient_id' => 45, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 60, 'ingredient_id' => 40, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 60, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 60, 'ingredient_id' => 22, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 60, 'ingredient_id' => 43, 'quantity' => 5, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],
            ['recipe_id' => 60, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 61: Sopa de Arvejas Amarillas con Zanahoria y Apio Criollo
            ['recipe_id' => 61, 'ingredient_id' => 46, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 61, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 61, 'ingredient_id' => 29, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 61, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 61, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 62: Hamburguesas Veganas de Lentejas y Avena con Ensalada
            ['recipe_id' => 62, 'ingredient_id' => 18, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 62, 'ingredient_id' => 9, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 62, 'ingredient_id' => 41, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 62, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 62, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 62, 'ingredient_id' => 32, 'quantity' => 1, 'unit_of_measure' => 'diente', 'is_main_ingredient' => false],

            // Receta 63: Caraotas Negras Guisadas con Ají Dulce y Plátano Horneado
            ['recipe_id' => 63, 'ingredient_id' => 7, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 63, 'ingredient_id' => 8, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            ['recipe_id' => 63, 'ingredient_id' => 14, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 63, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 63, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],

            // Receta 64: Guiso de Arvejas con Carne Magra y Papa
            ['recipe_id' => 64, 'ingredient_id' => 46, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 64, 'ingredient_id' => 11, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 64, 'ingredient_id' => 27, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 64, 'ingredient_id' => 31, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 64, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 65: Bowl Criollo de Garbanzos Tostados, Aguacate y Remolacha
            ['recipe_id' => 65, 'ingredient_id' => 45, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 65, 'ingredient_id' => 3, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            ['recipe_id' => 65, 'ingredient_id' => 37, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 65, 'ingredient_id' => 41, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 65, 'ingredient_id' => 47, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 65, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 66: Tortilla de Cazón Estilo Oriental
            ['recipe_id' => 66, 'ingredient_id' => 13, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 66, 'ingredient_id' => 6, 'quantity' => 3, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 66, 'ingredient_id' => 14, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 66, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 66, 'ingredient_id' => 32, 'quantity' => 1, 'unit_of_measure' => 'diente', 'is_main_ingredient' => false],
            ['recipe_id' => 66, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 67: Croquetas de Atún y Papa al Horno
            ['recipe_id' => 67, 'ingredient_id' => 15, 'quantity' => 1, 'unit_of_measure' => 'lata', 'is_main_ingredient' => true],
            ['recipe_id' => 67, 'ingredient_id' => 27, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 67, 'ingredient_id' => 6, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 67, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 67, 'ingredient_id' => 48, 'quantity' => 15, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 68: Ceviche Criollo de Cazón con Aguacate y Limón
            ['recipe_id' => 68, 'ingredient_id' => 13, 'quantity' => 180, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 68, 'ingredient_id' => 3, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            ['recipe_id' => 68, 'ingredient_id' => 42, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 68, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 68, 'ingredient_id' => 14, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 68, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 69: Aguacates Rellenos de Ensalada de Atún y Maíz Tierno
            ['recipe_id' => 69, 'ingredient_id' => 3, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            ['recipe_id' => 69, 'ingredient_id' => 15, 'quantity' => 1, 'unit_of_measure' => 'lata', 'is_main_ingredient' => true],
            ['recipe_id' => 69, 'ingredient_id' => 21, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 69, 'ingredient_id' => 30, 'quantity' => 0.25, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 69, 'ingredient_id' => 44, 'quantity' => 30, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 69, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 70: Pimentones Rellenos de Cazón Guisado Gratinados
            ['recipe_id' => 70, 'ingredient_id' => 31, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 70, 'ingredient_id' => 13, 'quantity' => 180, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 70, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 70, 'ingredient_id' => 14, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 70, 'ingredient_id' => 22, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 71: Tostadas de Casabe con Atún al Ajillo y Tomate
            ['recipe_id' => 71, 'ingredient_id' => 17, 'quantity' => 1, 'unit_of_measure' => 'torta', 'is_main_ingredient' => true],
            ['recipe_id' => 71, 'ingredient_id' => 15, 'quantity' => 1, 'unit_of_measure' => 'lata', 'is_main_ingredient' => true],
            ['recipe_id' => 71, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 71, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],
            ['recipe_id' => 71, 'ingredient_id' => 43, 'quantity' => 5, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],
            ['recipe_id' => 71, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 72: Berenjenas Rellenas de Carne Magra y Tomate al Horno
            ['recipe_id' => 72, 'ingredient_id' => 35, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 72, 'ingredient_id' => 11, 'quantity' => 180, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 72, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 72, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 72, 'ingredient_id' => 32, 'quantity' => 1, 'unit_of_measure' => 'diente', 'is_main_ingredient' => false],
            ['recipe_id' => 72, 'ingredient_id' => 22, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 73: Calabacines Rellenos de Pollo Desmechado y Maíz Tierno
            ['recipe_id' => 73, 'ingredient_id' => 34, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 73, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 73, 'ingredient_id' => 21, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 73, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 73, 'ingredient_id' => 22, 'quantity' => 30, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 74: Fajitas de Pollo Criollas en Hojas de Lechuga
            ['recipe_id' => 74, 'ingredient_id' => 1, 'quantity' => 160, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 74, 'ingredient_id' => 41, 'quantity' => 60, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 74, 'ingredient_id' => 31, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 74, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 74, 'ingredient_id' => 3, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 74, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 75: Albóndigas de Carne Magra y Avena en Salsa de Tomate Natural
            ['recipe_id' => 75, 'ingredient_id' => 11, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 75, 'ingredient_id' => 9, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 75, 'ingredient_id' => 6, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 75, 'ingredient_id' => 4, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 75, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 75, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],

            // Receta 76: Carne Mechada Saludable con Tajadas Horneadas y Casabe
            ['recipe_id' => 76, 'ingredient_id' => 11, 'quantity' => 180, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 76, 'ingredient_id' => 8, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            ['recipe_id' => 76, 'ingredient_id' => 17, 'quantity' => 1, 'unit_of_measure' => 'porcion', 'is_main_ingredient' => true],
            ['recipe_id' => 76, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 76, 'ingredient_id' => 31, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 76, 'ingredient_id' => 14, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 76, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],

            // Receta 77: Pinchos de Pechuga de Pollo, Piña y Pimentón a la Plancha
            ['recipe_id' => 77, 'ingredient_id' => 1, 'quantity' => 180, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 77, 'ingredient_id' => 25, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 77, 'ingredient_id' => 31, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 77, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 77, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 78: Bistec de Muchacho Encebollado con Ocumo Sancochado
            ['recipe_id' => 78, 'ingredient_id' => 11, 'quantity' => 180, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 78, 'ingredient_id' => 28, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 78, 'ingredient_id' => 30, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 78, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],
            ['recipe_id' => 78, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 79: Rollo de Pechuga de Pollo Relleno de Espinaca y Queso Blanco
            ['recipe_id' => 79, 'ingredient_id' => 1, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 79, 'ingredient_id' => 39, 'quantity' => 60, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 79, 'ingredient_id' => 22, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 79, 'ingredient_id' => 32, 'quantity' => 1, 'unit_of_measure' => 'diente', 'is_main_ingredient' => false],

            // Receta 80: Sancocho de Pescado Oriental Ligero
            ['recipe_id' => 80, 'ingredient_id' => 13, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 80, 'ingredient_id' => 16, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 80, 'ingredient_id' => 28, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 80, 'ingredient_id' => 29, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 80, 'ingredient_id' => 14, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 80, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 80, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],
            ['recipe_id' => 80, 'ingredient_id' => 33, 'quantity' => 15, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 81: Crema de Calabacín y Espinaca con Yogur Griego
            ['recipe_id' => 81, 'ingredient_id' => 34, 'quantity' => 250, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 81, 'ingredient_id' => 39, 'quantity' => 60, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 81, 'ingredient_id' => 44, 'quantity' => 30, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 81, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 81, 'ingredient_id' => 32, 'quantity' => 1, 'unit_of_measure' => 'diente', 'is_main_ingredient' => false],

            // Receta 82: Sopa de Caraotas Negras Licuadas con Cilantro y Queso
            ['recipe_id' => 82, 'ingredient_id' => 7, 'quantity' => 180, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 82, 'ingredient_id' => 22, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 82, 'ingredient_id' => 14, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 82, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 82, 'ingredient_id' => 32, 'quantity' => 1, 'unit_of_measure' => 'diente', 'is_main_ingredient' => false],
            ['recipe_id' => 82, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 83: Crema de Zanahoria y Auyama con Semillas de Chía
            ['recipe_id' => 83, 'ingredient_id' => 19, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 83, 'ingredient_id' => 10, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 83, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 83, 'ingredient_id' => 47, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 84: Consomé Criollo de Pollo con Apio Criollo y Repollo
            ['recipe_id' => 84, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 84, 'ingredient_id' => 29, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 84, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 84, 'ingredient_id' => 36, 'quantity' => 60, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 84, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 85: Crema de Ocumo Blanco al Ajo con Pollo Desmechado
            ['recipe_id' => 85, 'ingredient_id' => 28, 'quantity' => 200, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 85, 'ingredient_id' => 1, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 85, 'ingredient_id' => 32, 'quantity' => 2, 'unit_of_measure' => 'dientes', 'is_main_ingredient' => false],
            ['recipe_id' => 85, 'ingredient_id' => 30, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 86: Sopa Minestrone Criolla de Garbanzos y Vegetales
            ['recipe_id' => 86, 'ingredient_id' => 45, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 86, 'ingredient_id' => 26, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 86, 'ingredient_id' => 4, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 86, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 86, 'ingredient_id' => 38, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 86, 'ingredient_id' => 34, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 87: Ensalada César Criolla de Pollo con Aderezo de Yogur Griego
            ['recipe_id' => 87, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 87, 'ingredient_id' => 41, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 87, 'ingredient_id' => 17, 'quantity' => 0.5, 'unit_of_measure' => 'torta', 'is_main_ingredient' => false],
            ['recipe_id' => 87, 'ingredient_id' => 44, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 87, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 87, 'ingredient_id' => 32, 'quantity' => 1, 'unit_of_measure' => 'diente', 'is_main_ingredient' => false],

            // Receta 88: Ensalada de Remolacha, Zanahoria y Huevo Cocido
            ['recipe_id' => 88, 'ingredient_id' => 37, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 88, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            ['recipe_id' => 88, 'ingredient_id' => 6, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 88, 'ingredient_id' => 33, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 88, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 88, 'ingredient_id' => 43, 'quantity' => 5, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],

            // Receta 89: Ensalada Tropical de Pollo, Piña, Pepino y Aguacate
            ['recipe_id' => 89, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 89, 'ingredient_id' => 25, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 89, 'ingredient_id' => 40, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 89, 'ingredient_id' => 3, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 89, 'ingredient_id' => 41, 'quantity' => 60, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 89, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 90: Ensalada de Repollo y Zanahoria con Pollo Desmechado
            ['recipe_id' => 90, 'ingredient_id' => 1, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 90, 'ingredient_id' => 36, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 90, 'ingredient_id' => 10, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 90, 'ingredient_id' => 44, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 90, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 91: Ensalada Mediterránea Criolla de Berenjena Asada y Garbanzos
            ['recipe_id' => 91, 'ingredient_id' => 35, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 91, 'ingredient_id' => 45, 'quantity' => 120, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 91, 'ingredient_id' => 4, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 91, 'ingredient_id' => 40, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 91, 'ingredient_id' => 30, 'quantity' => 0.25, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 91, 'ingredient_id' => 43, 'quantity' => 5, 'unit_of_measure' => 'ml', 'is_main_ingredient' => false],
            ['recipe_id' => 91, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],

            // Receta 92: Ensalada Verde de Espinaca, Piña, Aguacate y Queso Blanco
            ['recipe_id' => 92, 'ingredient_id' => 39, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 92, 'ingredient_id' => 25, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 92, 'ingredient_id' => 3, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 92, 'ingredient_id' => 22, 'quantity' => 40, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 92, 'ingredient_id' => 47, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 93: Papelón con Limón y Semillas de Chía Refrescante
            ['recipe_id' => 93, 'ingredient_id' => 49, 'quantity' => 25, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 93, 'ingredient_id' => 42, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 93, 'ingredient_id' => 47, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 94: Pudín de Chía con Leche Descremada, Cacao y Cambur
            ['recipe_id' => 94, 'ingredient_id' => 20, 'quantity' => 200, 'unit_of_measure' => 'ml', 'is_main_ingredient' => true],
            ['recipe_id' => 94, 'ingredient_id' => 47, 'quantity' => 25, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 94, 'ingredient_id' => 24, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 94, 'ingredient_id' => 12, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 94, 'ingredient_id' => 50, 'quantity' => 3, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 95: Parfait de Yogur Griego, Piña, Avena y Linaza
            ['recipe_id' => 95, 'ingredient_id' => 44, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 95, 'ingredient_id' => 25, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 95, 'ingredient_id' => 9, 'quantity' => 30, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 95, 'ingredient_id' => 48, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 95, 'ingredient_id' => 50, 'quantity' => 3, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 96: Arepitas Dulces Horneadas con Canela y Queso Blanco
            ['recipe_id' => 96, 'ingredient_id' => 5, 'quantity' => 80, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 96, 'ingredient_id' => 22, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 96, 'ingredient_id' => 49, 'quantity' => 15, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 96, 'ingredient_id' => 50, 'quantity' => 3, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 97: Batido Verde Energético de Espinaca, Piña, Pepino y Linaza
            ['recipe_id' => 97, 'ingredient_id' => 39, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 97, 'ingredient_id' => 25, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 97, 'ingredient_id' => 40, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 97, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
            ['recipe_id' => 97, 'ingredient_id' => 48, 'quantity' => 10, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 98: Mandocas Horneadas Saludables de Plátano Maduro y Queso
            ['recipe_id' => 98, 'ingredient_id' => 8, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            ['recipe_id' => 98, 'ingredient_id' => 5, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 98, 'ingredient_id' => 22, 'quantity' => 50, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 98, 'ingredient_id' => 49, 'quantity' => 15, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 99: Ponqué Saludable de Cambur, Avena, Cacao y Huevos
            ['recipe_id' => 99, 'ingredient_id' => 12, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => true],
            ['recipe_id' => 99, 'ingredient_id' => 9, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 99, 'ingredient_id' => 6, 'quantity' => 2, 'unit_of_measure' => 'unidades', 'is_main_ingredient' => false],
            ['recipe_id' => 99, 'ingredient_id' => 24, 'quantity' => 20, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],
            ['recipe_id' => 99, 'ingredient_id' => 50, 'quantity' => 5, 'unit_of_measure' => 'g', 'is_main_ingredient' => false],

            // Receta 100: Tizana Criolla Natural de Lechoza, Piña y Cambur
            ['recipe_id' => 100, 'ingredient_id' => 23, 'quantity' => 150, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 100, 'ingredient_id' => 25, 'quantity' => 100, 'unit_of_measure' => 'g', 'is_main_ingredient' => true],
            ['recipe_id' => 100, 'ingredient_id' => 12, 'quantity' => 1, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => true],
            ['recipe_id' => 100, 'ingredient_id' => 42, 'quantity' => 0.5, 'unit_of_measure' => 'unidad', 'is_main_ingredient' => false],
        ];

        $this->db->table('recipe_ingredients')->insertBatch($data);
    }
}