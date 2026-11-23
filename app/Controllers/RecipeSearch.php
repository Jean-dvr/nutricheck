<?php

namespace App\Controllers;

use App\Models\IngredientsModel;
use App\Models\RecipesModel;
use App\Models\RecipeIngredientsModel;
use App\Models\UserConditionsModel;
use App\Models\IngredientConditionsModel;

class RecipeSearch extends BaseController
{
    public function index()
    {
        $ingModel = new IngredientsModel();

        $data = [
            'ingredientes_disponibles' => $ingModel->orderBy('name', 'ASC')->findAll(),
            'recetas_encontradas'      => [],
            'busqueda_realizada'       => false,
        ];

        $metodo = strtolower($this->request->getMethod());

        if ($metodo === 'post') {
            $data['busqueda_realizada'] = true;

            // 1. Validar texto del buscador rápido (solo letras y espacios)
            $reglas = config('Validation')->buscarRecetas;
            if (!$this->validate($reglas)) {
                $errores = $this->validator->getErrors();
                session()->setFlashdata('fail', reset($errores));
                return view('recipesearch/index', $data);
            }

            // 2. Normalizar y validar IDs de ingredientes seleccionados
            $rawIngredientes = $this->request->getPost('ingredientes');
            $ingredientesSeleccionados = is_array($rawIngredientes)
                ? array_values(array_unique(array_filter(array_map('intval', $rawIngredientes), fn($id) => $id > 0)))
                : [];

            if (empty($ingredientesSeleccionados)) {
                session()->setFlashdata('fail', 'Por favor, selecciona al menos un ingrediente de tu despensa.');
                return view('recipesearch/index', $data);
            }

            $userId         = session()->get('loggedUser');
            $userCondModel  = new UserConditionsModel();
            $ingCondModel   = new IngredientConditionsModel();
            $recipeIngModel = new RecipeIngredientsModel();
            $recipesModel   = new RecipesModel();

            // 3. Obtener recetas prohibidas según condiciones médicas del usuario
            $recetasProhibidas = [];
            if (!empty($userId)) {
                $misCondiciones    = $userCondModel->where('user_id', $userId)->findAll();
                $idsMisCondiciones = array_column($misCondiciones, 'condition_id');

                if (!empty($idsMisCondiciones)) {
                    $ingDaninos = $ingCondModel->whereIn('condition_id', $idsMisCondiciones)->findAll();
                    $idsIngProhibidos = array_column($ingDaninos, 'ingredient_id');

                    if (!empty($idsIngProhibidos)) {
                        $recetasMalas = $recipeIngModel->whereIn('ingredient_id', $idsIngProhibidos)->findAll();
                        $recetasProhibidas = array_unique(array_column($recetasMalas, 'recipe_id'));
                    }
                }
            }

            // 4. Evaluar coherencia de cada receta respecto a los ingredientes elegidos
            $todosLosRequisitos = $recipeIngModel->findAll();
            $estadisticasRecetas = [];

            foreach ($todosLosRequisitos as $req) {
                $idReceta      = (int) $req['recipe_id'];
                $idIngrediente = (int) $req['ingredient_id'];

                if (in_array($idReceta, $recetasProhibidas, true)) {
                    continue;
                }

                if (!isset($estadisticasRecetas[$idReceta])) {
                    $estadisticasRecetas[$idReceta] = [
                        'total_ingredientes' => 0,
                        'coincidencias'      => 0,
                    ];
                }

                $estadisticasRecetas[$idReceta]['total_ingredientes']++;

                if (in_array($idIngrediente, $ingredientesSeleccionados, true)) {
                    $estadisticasRecetas[$idReceta]['coincidencias']++;
                }
            }

            // 5. Filtrar recetas coherentes:
            // - Al menos 1 ingrediente seleccionado debe formar parte de la receta
            // - Cobertura mínima del 50% de los ingredientes de la receta
            $recetasCandidatas = [];
            foreach ($estadisticasRecetas as $idReceta => $stat) {
                if ($stat['coincidencias'] < 1 || $stat['total_ingredientes'] < 1) {
                    continue;
                }

                $cobertura = ($stat['coincidencias'] / $stat['total_ingredientes']) * 100;
                if ($cobertura >= 50) {
                    $recetasCandidatas[$idReceta] = [
                        'coincidencias' => $stat['coincidencias'],
                        'cobertura'     => $cobertura,
                    ];
                }
            }

            if (!empty($recetasCandidatas)) {
                $idsAprobados = array_keys($recetasCandidatas);

                $recetas = $recipesModel
                    ->whereIn('id', $idsAprobados)
                    ->where('is_approved', 1)
                    ->findAll();

                if (!empty($recetas)) {
                    // Ordenar por mayor número de ingredientes coincidentes y mayor cobertura
                    usort($recetas, function ($a, $b) use ($recetasCandidatas) {
                        $statA = $recetasCandidatas[(int) $a['id']];
                        $statB = $recetasCandidatas[(int) $b['id']];

                        if ($statB['coincidencias'] !== $statA['coincidencias']) {
                            return $statB['coincidencias'] <=> $statA['coincidencias'];
                        }
                        return $statB['cobertura'] <=> $statA['cobertura'];
                    });

                    $idsFinales = array_column($recetas, 'id');
                    $db = \Config\Database::connect();
                    $tagsData = $db->table('tags')
                        ->select('tags.*, recipe_tags.recipe_id')
                        ->join('recipe_tags', 'recipe_tags.tag_id = tags.id')
                        ->whereIn('recipe_tags.recipe_id', $idsFinales)
                        ->get()
                        ->getResultArray();

                    foreach ($recetas as &$receta) {
                        $receta['coincidencias'] = $recetasCandidatas[(int) $receta['id']]['coincidencias'];
                        $receta['cobertura']     = round($recetasCandidatas[(int) $receta['id']]['cobertura']);
                        $receta['tags']          = array_filter(
                            $tagsData,
                            fn($tag) => (int) $tag['recipe_id'] === (int) $receta['id']
                        );
                    }
                    unset($receta);

                    $data['recetas_encontradas'] = $recetas;
                }
            }
        }

        return view('recipesearch/index', $data);
    }
}