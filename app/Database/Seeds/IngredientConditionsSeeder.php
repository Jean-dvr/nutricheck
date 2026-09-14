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
        ];

        $this->db->table('ingredient_conditions')->insertBatch($data);
    }
}