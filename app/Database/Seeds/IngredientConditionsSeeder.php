<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IngredientConditionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // --- ALERGIAS ---
            [
                'ingredient_id' => 13, // Cazón
                'condition_id' => 12   // Alergia al pescado y mariscos
            ], 
            [
                'ingredient_id' => 15, // Atún en lata
                'condition_id' => 12   // Alergia al pescado y mariscos
            ],
            [
                'ingredient_id' => 6,  // Huevos
                'condition_id' => 13   // Alergia al huevo
            ], 
            
            // --- INTOLERANCIAS ---
            [
                'ingredient_id' => 20, // Leche Descremada
                'condition_id' => 14   // Intolerancia a la lactosa
            ],
            [
                'ingredient_id' => 22, // Queso Blanco
                'condition_id' => 14   // Intolerancia a la lactosa
            ], 
            [
                'ingredient_id' => 9,  // Avena (Por posible contaminación cruzada)
                'condition_id' => 5    // Enfermedad Celíaca
            ], 
            
            // --- PATOLOGÍAS ---
            [
                'ingredient_id' => 8,  // Plátano maduro (Alto índice glucémico)
                'condition_id' => 2    // Diabetes T2
            ], 
            [
                'ingredient_id' => 8,  // Plátano maduro
                'condition_id' => 8    // Resistencia a la insulina
            ], 
            [
                'ingredient_id' => 11, // Carne Magra / Roja
                'condition_id' => 10   // Hiperuricemia
            ], 
            [
                'ingredient_id' => 22, // Queso blanco (Alto en grasas y sodio)
                'condition_id' => 6    // Dislipidemia
            ], 
            [
                'ingredient_id' => 14, // Ají Dulce / Irritantes
                'condition_id' => 9    // Gastritis / Reflujo
            ], 
            [
                'ingredient_id' => 7,  // Caraotas (Beneficioso)
                'condition_id' => 7    // Anemia Ferropénica
            ],

            // --- NUEVAS ASOCIACIONES (IDs 26 al 50) ---
            [
                'ingredient_id' => 26, // Pasta Integral (Contiene gluten)
                'condition_id' => 5    // Enfermedad Celíaca (Sensibilidad al Gluten)
            ],
            [
                'ingredient_id' => 44, // Yogur Griego Natural
                'condition_id' => 14   // Intolerancia a la Lactosa
            ],
            [
                'ingredient_id' => 49, // Papelón (Alto índice glucémico)
                'condition_id' => 1    // Diabetes Tipo 1
            ],
            [
                'ingredient_id' => 49, // Papelón (Alto índice glucémico)
                'condition_id' => 2    // Diabetes Tipo 2
            ],
            [
                'ingredient_id' => 49, // Papelón
                'condition_id' => 8    // Resistencia a la Insulina
            ],
            [
                'ingredient_id' => 49, // Papelón
                'condition_id' => 4    // Obesidad
            ],
            [
                'ingredient_id' => 30, // Cebolla (Irritante gástrico)
                'condition_id' => 9    // Gastritis / Reflujo
            ],
            [
                'ingredient_id' => 31, // Pimentón (Irritante gástrico)
                'condition_id' => 9    // Gastritis / Reflujo
            ],
            [
                'ingredient_id' => 32, // Ajo (Irritante gástrico)
                'condition_id' => 9    // Gastritis / Reflujo
            ],
            [
                'ingredient_id' => 42, // Limón (Ácido / Irritante gástrico)
                'condition_id' => 9    // Gastritis / Reflujo
            ],
            [
                'ingredient_id' => 39, // Espinaca (Fuente vegetal de hierro)
                'condition_id' => 7    // Anemia Ferropénica
            ],
            [
                'ingredient_id' => 45, // Garbanzos (Fuente vegetal de hierro)
                'condition_id' => 7    // Anemia Ferropénica
            ],
            [
                'ingredient_id' => 46, // Arvejas (Fuente vegetal de hierro)
                'condition_id' => 7    // Anemia Ferropénica
            ],
        ];

        $this->db->table('ingredient_conditions')->insertBatch($data);
    }
}