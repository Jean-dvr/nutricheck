<?php

namespace App\Controllers;

use App\Models\IngredientsModel;
use App\Models\RecipesModel;
use App\Models\RecipeIngredientsModel;
use App\Models\TagsModel;
use App\Models\RecipeTagsModel;

class AdminController extends BaseController
{
    private function verificarAcceso()
    {
        $rol = session()->get('rol');
        if ($rol !== 'admin' && $rol !== 'nutricionista') {
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->verificarAcceso()) return redirect()->to(base_url('recetas'));

        $ingModel = new IngredientsModel();
        $tagsModel = new TagsModel();
        $recipesModel = new RecipesModel();

        // Mandamos las recetas existentes a la vista para poder gestionarlas
        $data = [
            'ingredientes' => $ingModel->orderBy('name', 'ASC')->findAll(),
            'etiquetas'    => $tagsModel->orderBy('name', 'ASC')->findAll(),
            'recetas'      => $recipesModel->orderBy('id', 'DESC')->findAll()
        ];

        return view('management/panel', $data);
    }

    public function guardarIngrediente()
    {
        if (!$this->verificarAcceso()) return redirect()->to(base_url('recetas'));
        $ingModel = new IngredientsModel();
        $ingModel->insert([
            'name'              => $this->request->getPost('name'),
            'category'          => $this->request->getPost('category'),
            'calories_per_100g' => $this->request->getPost('calories'),
            'protein_g'         => $this->request->getPost('protein') ?? 0,
            'carb_g'            => $this->request->getPost('carb') ?? 0,
            'fat_g'             => $this->request->getPost('fat') ?? 0,
        ]);
        return redirect()->to(base_url('admin'))->with('success', '¡Ingrediente agregado exitosamente!');
    }

    public function guardarEtiqueta()
    {
        if (!$this->verificarAcceso()) return redirect()->to(base_url('recetas'));
        $tagsModel = new TagsModel();
        $tagsModel->insert([
            'name'      => $this->request->getPost('name'),
            'color_hex' => $this->request->getPost('color_hex'),
        ]);
        return redirect()->to(base_url('admin'))->with('success', '¡Etiqueta creada exitosamente!');
    }

    public function guardarReceta()
    {
        if (!$this->verificarAcceso()) return redirect()->to(base_url('recetas'));

        $file = $this->request->getFile('imagen');
        $imgName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imgName = $file->getRandomName();
            $file->move(FCPATH . 'assets/recipeimg', $imgName);
        }

        // WORKFLOW DE APROBACIÓN: Si es Admin se aprueba sola (1), si es Nutricionista queda pendiente (0)
        $estadoAprobacion = (session()->get('rol') === 'admin') ? 1 : 0;

        $recipesModel = new RecipesModel();
        $recipeId = $recipesModel->insert([
            'title'             => $this->request->getPost('title'),
            'preparation'       => $this->request->getPost('preparation'),
            'prep_time_minutes' => $this->request->getPost('prep_time'),
            'difficulty'        => $this->request->getPost('difficulty'),
            'portions'          => $this->request->getPost('portions'),
            'total_calories'    => $this->request->getPost('total_calories'),
            'image_url'         => $imgName,
            'is_approved'       => $estadoAprobacion
        ]);

        $etiquetasSeleccionadas = $this->request->getPost('tags');
        if (!empty($etiquetasSeleccionadas)) {
            $recipeTagsModel = new RecipeTagsModel();
            foreach ($etiquetasSeleccionadas as $tag_id) {
                $recipeTagsModel->insert(['recipe_id' => $recipeId, 'tag_id' => $tag_id]);
            }
        }

        $ingredientesIds = $this->request->getPost('ingredient_id');
        $cantidades      = $this->request->getPost('quantity');
        $medidas         = $this->request->getPost('unit');
        $esPrincipal     = $this->request->getPost('is_main');

        if (!empty($ingredientesIds)) {
            $recipeIngModel = new RecipeIngredientsModel();
            for ($i = 0; $i < count($ingredientesIds); $i++) {
                if (!empty($ingredientesIds[$i]) && !empty($cantidades[$i])) {
                    $recipeIngModel->insert([
                        'recipe_id'          => $recipeId,
                        'ingredient_id'      => $ingredientesIds[$i],
                        'quantity'           => $cantidades[$i],
                        'unit_of_measure'    => $medidas[$i],
                        'is_main_ingredient' => $esPrincipal[$i]
                    ]);
                }
            }
        }

        $mensaje = ($estadoAprobacion == 1) ? '¡Receta armada y publicada exitosamente!' : '¡Receta enviada! Está pendiente de aprobación por un Administrador.';
        return redirect()->to(base_url('admin'))->with('success', $mensaje);
    }

    // ==========================================================
    // NUEVAS FUNCIONES DE GESTIÓN (CRUD Y WORKFLOW)
    // ==========================================================

    public function aprobarReceta(int $id)
    {
        // Solo un administrador puede aprobar
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('admin'))->with('fail', 'No tienes permisos para aprobar recetas.');
        }

        $recipesModel = new RecipesModel();
        $recipesModel->update($id, ['is_approved' => 1]);
        
        return redirect()->to(base_url('admin'))->with('success', 'La receta ha sido aprobada y ahora es pública.');
    }

    public function eliminarReceta(int $id)
    {
        if (!$this->verificarAcceso()) return redirect()->to(base_url('recetas'));
        
        $recipesModel = new RecipesModel();
        $recipesModel->delete($id);

        return redirect()->to(base_url('admin'))->with('success', 'Receta eliminada correctamente.');
    }

    public function editarReceta(int $id)
    {
        if (!$this->verificarAcceso()) return redirect()->to(base_url('recetas'));

        $recipesModel = new RecipesModel();
        $data['receta'] = $recipesModel->find($id);

        if(!$data['receta']) return redirect()->to(base_url('admin'))->with('fail', 'Receta no encontrada.');

        return view('management/edit_recipe', $data);
    }

    public function actualizarReceta()
    {
        if (!$this->verificarAcceso()) return redirect()->to(base_url('recetas'));

        $id = $this->request->getPost('id');
        $recipesModel = new RecipesModel();

        $dataActualizacion = [
            'title'             => $this->request->getPost('title'),
            'preparation'       => $this->request->getPost('preparation'),
            'prep_time_minutes' => $this->request->getPost('prep_time'),
            'difficulty'        => $this->request->getPost('difficulty'),
            'portions'          => $this->request->getPost('portions'),
            'total_calories'    => $this->request->getPost('total_calories'),
        ];

        // Verificar si subió una nueva imagen
        $file = $this->request->getFile('imagen');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imgName = $file->getRandomName();
            $file->move(FCPATH . 'assets/recipeimg', $imgName);
            $dataActualizacion['image_url'] = $imgName;
        }

        $recipesModel->update($id, $dataActualizacion);

        return redirect()->to(base_url('admin'))->with('success', 'Datos de receta actualizados correctamente.');
    }
}