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
        ];

        $this->db->table('recipe_ingredients')->insertBatch($data);
    }
}