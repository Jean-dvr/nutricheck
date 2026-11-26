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

            // =========================================================================
            // RECETAS 31 A LA 100 (AGRUPADAS POR CONDICIÓN MÉDICA)
            // =========================================================================

            // Hipertensión Arterial (1) - Recetas con Queso Blanco o Embutidos/Sal
            ['recipe_id' => 31, 'condition_id' => 1],
            ['recipe_id' => 33, 'condition_id' => 1],
            ['recipe_id' => 36, 'condition_id' => 1],
            ['recipe_id' => 43, 'condition_id' => 1],
            ['recipe_id' => 46, 'condition_id' => 1],
            ['recipe_id' => 60, 'condition_id' => 1],
            ['recipe_id' => 79, 'condition_id' => 1],
            ['recipe_id' => 82, 'condition_id' => 1],
            ['recipe_id' => 92, 'condition_id' => 1],
            ['recipe_id' => 96, 'condition_id' => 1],
            ['recipe_id' => 98, 'condition_id' => 1],

            // Diabetes T2 (2) y Resistencia a la Insulina (8) - Recetas con Plátano Maduro, Papelón o Cambur
            ['recipe_id' => 33, 'condition_id' => 2], ['recipe_id' => 33, 'condition_id' => 8],
            ['recipe_id' => 54, 'condition_id' => 2], ['recipe_id' => 54, 'condition_id' => 8],
            ['recipe_id' => 63, 'condition_id' => 2], ['recipe_id' => 63, 'condition_id' => 8],
            ['recipe_id' => 76, 'condition_id' => 2], ['recipe_id' => 76, 'condition_id' => 8],
            ['recipe_id' => 93, 'condition_id' => 2], ['recipe_id' => 93, 'condition_id' => 8],
            ['recipe_id' => 94, 'condition_id' => 2], ['recipe_id' => 94, 'condition_id' => 8],
            ['recipe_id' => 96, 'condition_id' => 2], ['recipe_id' => 96, 'condition_id' => 8],
            ['recipe_id' => 98, 'condition_id' => 2], ['recipe_id' => 98, 'condition_id' => 8],
            ['recipe_id' => 99, 'condition_id' => 2], ['recipe_id' => 99, 'condition_id' => 8],
            ['recipe_id' => 100, 'condition_id' => 2], ['recipe_id' => 100, 'condition_id' => 8],

            // Enfermedad Celíaca (5) - Recetas con Avena o Pasta de Trigo
            ['recipe_id' => 32, 'condition_id' => 5],
            ['recipe_id' => 37, 'condition_id' => 5],
            ['recipe_id' => 62, 'condition_id' => 5],
            ['recipe_id' => 75, 'condition_id' => 5],
            ['recipe_id' => 95, 'condition_id' => 5],
            ['recipe_id' => 99, 'condition_id' => 5],

            // Dislipidemia (6) - Recetas con Queso Blanco o Huevo Entero
            ['recipe_id' => 31, 'condition_id' => 6],
            ['recipe_id' => 36, 'condition_id' => 6],
            ['recipe_id' => 40, 'condition_id' => 6],
            ['recipe_id' => 43, 'condition_id' => 6],
            ['recipe_id' => 44, 'condition_id' => 6],
            ['recipe_id' => 46, 'condition_id' => 6],
            ['recipe_id' => 50, 'condition_id' => 6],
            ['recipe_id' => 60, 'condition_id' => 6],
            ['recipe_id' => 66, 'condition_id' => 6],
            ['recipe_id' => 79, 'condition_id' => 6],
            ['recipe_id' => 82, 'condition_id' => 6],
            ['recipe_id' => 88, 'condition_id' => 6],
            ['recipe_id' => 92, 'condition_id' => 6],
            ['recipe_id' => 96, 'condition_id' => 6],
            ['recipe_id' => 98, 'condition_id' => 6],

            // Anemia Ferropénica (7) - Recetas con Caraotas, Lentejas, Espinaca o Carne Magra (Beneficioso)
            ['recipe_id' => 34, 'condition_id' => 7],
            ['recipe_id' => 40, 'condition_id' => 7],
            ['recipe_id' => 41, 'condition_id' => 7],
            ['recipe_id' => 43, 'condition_id' => 7],
            ['recipe_id' => 45, 'condition_id' => 7],
            ['recipe_id' => 53, 'condition_id' => 7],
            ['recipe_id' => 55, 'condition_id' => 7],
            ['recipe_id' => 57, 'condition_id' => 7],
            ['recipe_id' => 59, 'condition_id' => 7],
            ['recipe_id' => 62, 'condition_id' => 7],
            ['recipe_id' => 63, 'condition_id' => 7],
            ['recipe_id' => 64, 'condition_id' => 7],
            ['recipe_id' => 72, 'condition_id' => 7],
            ['recipe_id' => 75, 'condition_id' => 7],
            ['recipe_id' => 76, 'condition_id' => 7],
            ['recipe_id' => 78, 'condition_id' => 7],
            ['recipe_id' => 79, 'condition_id' => 7],
            ['recipe_id' => 81, 'condition_id' => 7],
            ['recipe_id' => 82, 'condition_id' => 7],
            ['recipe_id' => 92, 'condition_id' => 7],
            ['recipe_id' => 97, 'condition_id' => 7],

            // Gastritis / Reflujo (9) - Recetas con Ají Dulce, Tomate Ácido, Piña o Cacao
            ['recipe_id' => 31, 'condition_id' => 9],
            ['recipe_id' => 34, 'condition_id' => 9],
            ['recipe_id' => 35, 'condition_id' => 9],
            ['recipe_id' => 37, 'condition_id' => 9],
            ['recipe_id' => 49, 'condition_id' => 9],
            ['recipe_id' => 56, 'condition_id' => 9],
            ['recipe_id' => 63, 'condition_id' => 9],
            ['recipe_id' => 66, 'condition_id' => 9],
            ['recipe_id' => 70, 'condition_id' => 9],
            ['recipe_id' => 71, 'condition_id' => 9],
            ['recipe_id' => 72, 'condition_id' => 9],
            ['recipe_id' => 75, 'condition_id' => 9],
            ['recipe_id' => 77, 'condition_id' => 9],
            ['recipe_id' => 89, 'condition_id' => 9],
            ['recipe_id' => 92, 'condition_id' => 9],
            ['recipe_id' => 94, 'condition_id' => 9],
            ['recipe_id' => 95, 'condition_id' => 9],
            ['recipe_id' => 97, 'condition_id' => 9],
            ['recipe_id' => 99, 'condition_id' => 9],
            ['recipe_id' => 100, 'condition_id' => 9],

            // Hiperuricemia (10) - Recetas con Carne Magra o Pescado/Cazón
            ['recipe_id' => 34, 'condition_id' => 10],
            ['recipe_id' => 41, 'condition_id' => 10],
            ['recipe_id' => 42, 'condition_id' => 10],
            ['recipe_id' => 43, 'condition_id' => 10],
            ['recipe_id' => 45, 'condition_id' => 10],
            ['recipe_id' => 48, 'condition_id' => 10],
            ['recipe_id' => 49, 'condition_id' => 10],
            ['recipe_id' => 53, 'condition_id' => 10],
            ['recipe_id' => 56, 'condition_id' => 10],
            ['recipe_id' => 58, 'condition_id' => 10],
            ['recipe_id' => 64, 'condition_id' => 10],
            ['recipe_id' => 66, 'condition_id' => 10],
            ['recipe_id' => 67, 'condition_id' => 10],
            ['recipe_id' => 68, 'condition_id' => 10],
            ['recipe_id' => 69, 'condition_id' => 10],
            ['recipe_id' => 70, 'condition_id' => 10],
            ['recipe_id' => 71, 'condition_id' => 10],
            ['recipe_id' => 72, 'condition_id' => 10],
            ['recipe_id' => 75, 'condition_id' => 10],
            ['recipe_id' => 76, 'condition_id' => 10],
            ['recipe_id' => 78, 'condition_id' => 10],
            ['recipe_id' => 80, 'condition_id' => 10],

            // Síndrome de Intestino Irritable (11) - Recetas con Granos (Caraotas, Garbanzos, Lentejas, Arvejas) o Repollo
            ['recipe_id' => 53, 'condition_id' => 11],
            ['recipe_id' => 55, 'condition_id' => 11],
            ['recipe_id' => 59, 'condition_id' => 11],
            ['recipe_id' => 60, 'condition_id' => 11],
            ['recipe_id' => 61, 'condition_id' => 11],
            ['recipe_id' => 62, 'condition_id' => 11],
            ['recipe_id' => 63, 'condition_id' => 11],
            ['recipe_id' => 64, 'condition_id' => 11],
            ['recipe_id' => 65, 'condition_id' => 11],
            ['recipe_id' => 82, 'condition_id' => 11],
            ['recipe_id' => 84, 'condition_id' => 11],
            ['recipe_id' => 86, 'condition_id' => 11],
            ['recipe_id' => 90, 'condition_id' => 11],
            ['recipe_id' => 91, 'condition_id' => 11],

            // Hipotiroidismo (12) - Recetas con Yuca o Repollo Crudo/Cocido
            ['recipe_id' => 45, 'condition_id' => 12],
            ['recipe_id' => 46, 'condition_id' => 12],
            ['recipe_id' => 47, 'condition_id' => 12],
            ['recipe_id' => 49, 'condition_id' => 12],
            ['recipe_id' => 50, 'condition_id' => 12],
            ['recipe_id' => 53, 'condition_id' => 12],
            ['recipe_id' => 84, 'condition_id' => 12],
            ['recipe_id' => 90, 'condition_id' => 12],
        ];

        $this->db->table('recipe_conditions')->insertBatch($data);
    }
}