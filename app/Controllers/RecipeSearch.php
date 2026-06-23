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
        
        // Cargamos todos los ingredientes para mostrarlos en la vista
        $data['ingredientes_disponibles'] = $ingModel->orderBy('name', 'ASC')->findAll();
        $data['recetas_encontradas'] = [];
        $data['busqueda_realizada'] = false;

        // Si el usuario envió el formulario
        if ($this->request->getMethod() === 'POST' || $this->request->getMethod() === 'post') {
            $data['busqueda_realizada'] = true;
            $ingredientesSeleccionados = $this->request->getPost('ingredientes');

            if (!empty($ingredientesSeleccionados)) {
                
                $userId = session()->get('loggedUser');
                
                // Instanciamos todos los modelos necesarios
                $userCondModel  = new UserConditionsModel();
                $ingCondModel   = new IngredientConditionsModel();
                $recipeIngModel = new RecipeIngredientsModel();
                $recipesModel   = new RecipesModel();

                // =========================================================
                // FASE A: EL FILTRO DE SEGURIDAD MÉDICA
                // Objetivo: Identificar qué recetas le harían daño al usuario
                // =========================================================
                $misCondiciones = $userCondModel->where('user_id', $userId)->findAll();
                $idsMisCondiciones = array_column($misCondiciones, 'condition_id');

                $recetasProhibidas = [];

                if (!empty($idsMisCondiciones)) {
                    // Buscamos qué ingredientes disparan las alergias/condiciones del usuario
                    $ingDañinos = $ingCondModel->whereIn('condition_id', $idsMisCondiciones)->findAll();
                    $ingredientesProhibidos = array_column($ingDañinos, 'ingredient_id');

                    if (!empty($ingredientesProhibidos)) {
                        // Buscamos qué recetas contienen esos ingredientes prohibidos
                        $recetasMalas = $recipeIngModel->whereIn('ingredient_id', $ingredientesProhibidos)->findAll();
                        $recetasProhibidas = array_unique(array_column($recetasMalas, 'recipe_id'));
                    }
                }

                // =========================================================
                // FASE B: MATCH PORCENTUAL (Evitando "La Trampa del 100%")
                // Objetivo: Ver si el usuario tiene suficientes ingredientes
                // =========================================================
                
                // 1. Buscamos los requisitos solo de las recetas que NO están prohibidas
                if (!empty($recetasProhibidas)) {
                    $recipeIngModel->whereNotIn('recipe_id', $recetasProhibidas);
                }
                $todosLosRequisitos = $recipeIngModel->findAll();

                $puntuacionRecetas = [];

                // 2. Contabilizamos qué pide cada receta vs qué tiene el usuario en su despensa
                foreach ($todosLosRequisitos as $req) {
                    $idReceta = $req['recipe_id'];
                    $idIngrediente = $req['ingredient_id'];

                    // Preparamos los contadores para esta receta si no existen
                    if (!isset($puntuacionRecetas[$idReceta])) {
                        $puntuacionRecetas[$idReceta] = [
                            'pide' => 0,
                            'tengo' => 0
                        ];
                    }

                    // Sumamos 1 al total de ingredientes que exige esta receta
                    $puntuacionRecetas[$idReceta]['pide']++;

                    // Si el ingrediente requerido está dentro de los que seleccionó el usuario
                    if (in_array($idIngrediente, $ingredientesSeleccionados)) {
                        $puntuacionRecetas[$idReceta]['tengo']++;
                    }
                }

                // 3. Filtramos las recetas aprobando solo las que superen el 50% de coincidencia
                $recetasAprobadasIds = [];
                foreach ($puntuacionRecetas as $idReceta => $datos) {
                    // Fórmula: (Los que tengo / Los que pide) * 100
                    $porcentaje = ($datos['tengo'] / $datos['pide']) * 100;

                    // Si el usuario tiene el 50% o más de los ingredientes, la consideramos válida
                    if ($porcentaje >= 50) { 
                        $recetasAprobadasIds[] = $idReceta;
                    }
                }

                // =========================================================
                // FASE C: DEPURACIÓN Y OBTENCIÓN FINAL
                // =========================================================
                
                $recetasSegurasIds = array_diff($recetasAprobadasIds, $recetasProhibidas);

                if (!empty($recetasSegurasIds)) {
                    // 1. Obtenemos los datos base de las recetas
                    $recetas = $recipesModel->whereIn('id', $recetasSegurasIds)->findAll();
                    
                    // 2. Consultamos las etiquetas relacionadas con estas recetas
                    $db = \Config\Database::connect();
                    $tagsData = $db->table('tags')
                        ->select('tags.*, recipe_tags.recipe_id')
                        ->join('recipe_tags', 'recipe_tags.tag_id = tags.id')
                        ->whereIn('recipe_tags.recipe_id', $recetasSegurasIds)
                        ->get()->getResultArray();
                    
                    // 3. Asignamos las etiquetas a cada receta
                    foreach ($recetas as &$receta) {
                        $receta['tags'] = array_filter($tagsData, function($tag) use ($receta) {
                            return $tag['recipe_id'] == $receta['id'];
                        });
                    }
                    
                    $data['recetas_encontradas'] = $recetas;
                } else {
                    $data['recetas_encontradas'] = [];
                }

            } else {
                // Si envió el formulario sin marcar ningún ingrediente
                session()->setFlashdata('fail', 'Por favor, selecciona al menos un ingrediente de tu despensa.');
            }
        }

        return view('recipesearch/index', $data);
    }
}