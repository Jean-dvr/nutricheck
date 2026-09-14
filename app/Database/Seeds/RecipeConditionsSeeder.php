<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipeConditionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Alergia al Pescado (12) - Recetas con Cazón o Atún
            ['recipe_id' => 11, 'condition_id' => 12],
            ['recipe_id' => 12, 'condition_id' => 12],
            ['recipe_id' => 13, 'condition_id' => 12],
            ['recipe_id' => 14, 'condition_id' => 12],
            ['recipe_id' => 24, 'condition_id' => 12],
            
            // Alergia al Huevo (13) - Recetas con Huevo
            ['recipe_id' => 2, 'condition_id' => 13],
            ['recipe_id' => 6, 'condition_id' => 13],
            ['recipe_id' => 19, 'condition_id' => 13],

            // Intolerancia a la Lactosa (14) - Recetas con Queso Blanco o Leche
            ['recipe_id' => 3, 'condition_id' => 14],
            ['recipe_id' => 4, 'condition_id' => 14],
            ['recipe_id' => 6, 'condition_id' => 14],
            ['recipe_id' => 18, 'condition_id' => 14],
            ['recipe_id' => 19, 'condition_id' => 14],
            ['recipe_id' => 20, 'condition_id' => 14],
            ['recipe_id' => 22, 'condition_id' => 14],
            ['recipe_id' => 25, 'condition_id' => 14],
            ['recipe_id' => 27, 'condition_id' => 14],

            // Enfermedad Celíaca (5) - Recetas con Avena
            ['recipe_id' => 3, 'condition_id' => 5],
            ['recipe_id' => 6, 'condition_id' => 5],
            ['recipe_id' => 28, 'condition_id' => 5],

            // Diabetes T2 (2) y Resistencia a la Insulina (8) - Recetas con Plátano Maduro
            ['recipe_id' => 1, 'condition_id' => 2], ['recipe_id' => 1, 'condition_id' => 8],
            ['recipe_id' => 21, 'condition_id' => 2], ['recipe_id' => 21, 'condition_id' => 8],
            ['recipe_id' => 22, 'condition_id' => 2], ['recipe_id' => 22, 'condition_id' => 8],

            // Hiperuricemia (10) - Recetas con Carne Magra
            ['recipe_id' => 5, 'condition_id' => 10],
            ['recipe_id' => 8, 'condition_id' => 10],
            ['recipe_id' => 9, 'condition_id' => 10],
            ['recipe_id' => 15, 'condition_id' => 10],
            ['recipe_id' => 21, 'condition_id' => 10],

            // Dislipidemia (6) - Recetas con Queso Blanco
            ['recipe_id' => 3, 'condition_id' => 6],
            ['recipe_id' => 4, 'condition_id' => 6],
            ['recipe_id' => 20, 'condition_id' => 6],
            ['recipe_id' => 22, 'condition_id' => 6],
            ['recipe_id' => 25, 'condition_id' => 6],

            // Gastritis / Reflujo (9) - Recetas con Ají Dulce
            ['recipe_id' => 11, 'condition_id' => 9],
            
            // Anemia Ferropénica (7) - Recetas con Caraotas (Beneficioso)
            ['recipe_id' => 1, 'condition_id' => 7],
            ['recipe_id' => 30, 'condition_id' => 7],
        ];

        $this->db->table('recipe_conditions')->insertBatch($data);
    }
}