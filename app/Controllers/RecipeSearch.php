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
        
        $data['ingredientes_disponibles'] = $ingModel->orderBy('name', 'ASC')->findAll();
        $data['recetas_encontradas'] = [];
        $data['busqueda_realizada'] = false;

        if ($this->request->getMethod() === 'POST' || $this->request->getMethod() === 'post') {
            $data['busqueda_realizada'] = true;
            $ingredientesSeleccionados = $this->request->getPost('ingredientes');

            if (!empty($ingredientesSeleccionados)) {
                
                $userId = session()->get('loggedUser');
                
                $userCondModel  = new UserConditionsModel();
                $ingCondModel   = new IngredientConditionsModel();
                $recipeIngModel = new RecipeIngredientsModel();
                $recipesModel   = new RecipesModel();

                $misCondiciones = $userCondModel->where('user_id', $userId)->findAll();
                $idsMisCondiciones = array_column($misCondiciones, 'condition_id');

                $recetasProhibidas = [];

                if (!empty($idsMisCondiciones)) {
                    $ingDañinos = $ingCondModel->whereIn('condition_id', $idsMisCondiciones)->findAll();
                    $ingredientesProhibidos = array_column($ingDañinos, 'ingredient_id');

                    if (!empty($ingredientesProhibidos)) {
                        $recetasMalas = $recipeIngModel->whereIn('ingredient_id', $ingredientesProhibidos)->findAll();
                        $recetasProhibidas = array_unique(array_column($recetasMalas, 'recipe_id'));
                    }
                }

                if (!empty($recetasProhibidas)) {
                    $recipeIngModel->whereNotIn('recipe_id', $recetasProhibidas);
                }
                $todosLosRequisitos = $recipeIngModel->findAll();

                $puntuacionRecetas = [];

                foreach ($todosLosRequisitos as $req) {
                    $idReceta = $req['recipe_id'];
                    $idIngrediente = $req['ingredient_id'];

                    if (!isset($puntuacionRecetas[$idReceta])) {
                        $puntuacionRecetas[$idReceta] = ['pide' => 0, 'tengo' => 0];
                    }

                    $puntuacionRecetas[$idReceta]['pide']++;

                    if (in_array($idIngrediente, $ingredientesSeleccionados)) {
                        $puntuacionRecetas[$idReceta]['tengo']++;
                    }
                }

                $recetasAprobadasIds = [];
                foreach ($puntuacionRecetas as $idReceta => $datos) {
                    $porcentaje = ($datos['tengo'] / $datos['pide']) * 100;
                    if ($porcentaje >= 50) { 
                        $recetasAprobadasIds[] = $idReceta;
                    }
                }

                $recetasSegurasIds = array_diff($recetasAprobadasIds, $recetasProhibidas);

                if (!empty($recetasSegurasIds)) {
                    // MODIFICACIÓN IMPORTANTE AQUÍ: Solo traemos las recetas que están aprobadas (is_approved = 1)
                    $recetas = $recipesModel->whereIn('id', $recetasSegurasIds)
                                            ->where('is_approved', 1)
                                            ->findAll();
                    
                    if(!empty($recetas)) {
                        $db = \Config\Database::connect();
                        $tagsData = $db->table('tags')
                            ->select('tags.*, recipe_tags.recipe_id')
                            ->join('recipe_tags', 'recipe_tags.tag_id = tags.id')
                            ->whereIn('recipe_tags.recipe_id', $recetasSegurasIds)
                            ->get()->getResultArray();
                        
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
                    $data['recetas_encontradas'] = [];
                }

            } else {
                session()->setFlashdata('fail', 'Por favor, selecciona al menos un ingrediente de tu despensa.');
            }
        }

        return view('recipesearch/index', $data);
    }
}