<?php

namespace App\Controllers;

use App\Models\IngredientsModel;
use App\Models\RecipesModel;
use App\Models\RecipeIngredientsModel;
use App\Models\UserConditionsModel;
use App\Models\IngredientConditionsModel;

/**
 * Controlador del Buscador de Recetas por Despensa.
 * Carga los ingredientes disponibles, excluye recetas incompatibles con el
 * cuadro clínico del usuario y envía las recetas seguras con sus ingredientes
 * asociados para el filtrado reactivo y la vista detallada en modal.
 */
class RecipeSearch extends BaseController
{
    public function index()
    {
        $ingModel       = new IngredientsModel();
        $recipesModel   = new RecipesModel();
        $recipeIngModel = new RecipeIngredientsModel();
        $userCondModel  = new UserConditionsModel();
        $ingCondModel   = new IngredientConditionsModel();

        // 1. Obtener ingredientes ordenados alfabéticamente para la despensa
        $ingredientesDisponibles = $ingModel->orderBy('name', 'ASC')->findAll();

        // 2. Identificar recetas prohibidas según las condiciones médicas del usuario
        $userId            = session()->get('loggedUser');
        $recetasProhibidas = [];

        if (!empty($userId)) {
            $misCondiciones    = $userCondModel->where('user_id', $userId)->findAll();
            $idsMisCondiciones = array_column($misCondiciones, 'condition_id');

            if (!empty($idsMisCondiciones)) {
                $ingDaninos       = $ingCondModel->whereIn('condition_id', $idsMisCondiciones)->findAll();
                $idsIngProhibidos = array_column($ingDaninos, 'ingredient_id');

                if (!empty($idsIngProhibidos)) {
                    $recetasMalas      = $recipeIngModel->whereIn('ingredient_id', $idsIngProhibidos)->findAll();
                    $recetasProhibidas = array_map('intval', array_unique(array_column($recetasMalas, 'recipe_id')));
                }
            }
        }

        // 3. Mapear qué ingredientes (IDs) pertenece a cada receta
        $todosRequisitos       = $recipeIngModel->findAll();
        $ingredientesPorReceta = [];

        foreach ($todosRequisitos as $req) {
            $idReceta      = (int) $req['recipe_id'];
            $idIngrediente = (int) $req['ingredient_id'];

            if (in_array($idReceta, $recetasProhibidas, true)) {
                continue;
            }

            $ingredientesPorReceta[$idReceta][] = $idIngrediente;
        }

        // 4. Consultar todas las recetas aprobadas y excluir las prohibidas
        $queryRecetas = $recipesModel->where('is_approved', 1);
        if (!empty($recetasProhibidas)) {
            $queryRecetas->whereNotIn('id', $recetasProhibidas);
        }
        $recetas = $queryRecetas->orderBy('title', 'ASC')->findAll();

        // 5. Adjuntar etiquetas (tags), IDs y detalle completo de ingredientes a cada receta
        if (!empty($recetas)) {
            $idsRecetas = array_map('intval', array_column($recetas, 'id'));
            $db         = \Config\Database::connect();

            $tagsData = $db->table('tags')
                ->select('tags.*, recipe_tags.recipe_id')
                ->join('recipe_tags', 'recipe_tags.tag_id = tags.id')
                ->whereIn('recipe_tags.recipe_id', $idsRecetas)
                ->get()
                ->getResultArray();

            $ingredientesDetalleData = $db->table('recipe_ingredients')
                ->select('recipe_ingredients.recipe_id, recipe_ingredients.ingredient_id, recipe_ingredients.quantity, recipe_ingredients.unit_of_measure, recipe_ingredients.is_main_ingredient, ingredients.name, ingredients.category')
                ->join('ingredients', 'ingredients.id = recipe_ingredients.ingredient_id')
                ->whereIn('recipe_ingredients.recipe_id', $idsRecetas)
                ->orderBy('recipe_ingredients.is_main_ingredient', 'DESC')
                ->orderBy('ingredients.name', 'ASC')
                ->get()
                ->getResultArray();

            $detallePorReceta = [];
            foreach ($ingredientesDetalleData as $itemIng) {
                $rid = (int) $itemIng['recipe_id'];
                $detallePorReceta[$rid][] = [
                    'ingredient_id'      => (int) $itemIng['ingredient_id'],
                    'name'               => (string) $itemIng['name'],
                    'category'           => (string) ($itemIng['category'] ?? ''),
                    'quantity'           => $itemIng['quantity'],
                    'unit_of_measure'    => (string) ($itemIng['unit_of_measure'] ?? ''),
                    'is_main_ingredient' => (int) ($itemIng['is_main_ingredient'] ?? 0),
                ];
            }

            foreach ($recetas as &$receta) {
                $idReceta                     = (int) $receta['id'];
                $receta['ingredient_ids']     = array_values(array_unique($ingredientesPorReceta[$idReceta] ?? []));
                $receta['ingredients_detail'] = $detallePorReceta[$idReceta] ?? [];
                $receta['tags']               = array_values(array_filter(
                    $tagsData,
                    fn($tag) => (int) $tag['recipe_id'] === $idReceta
                ));
            }
            unset($receta);
        }

        // Validar filtro de texto si se envió por POST
        if (strtolower($this->request->getMethod()) === 'post') {
            $reglas = config('Validation')->buscarRecetas ?? [];
            if (!empty($reglas) && !$this->validate($reglas)) {
                $errores = $this->validator->getErrors();
                session()->setFlashdata('fail', reset($errores));
            }
        }

        return view('recipesearch/index', [
            'ingredientes_disponibles' => $ingredientesDisponibles,
            'recetas_encontradas'      => $recetas,
            'busqueda_realizada'       => true,
        ]);
    }
}