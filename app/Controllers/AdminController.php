<?php

namespace App\Controllers;

use App\Models\IngredientsModel;
use App\Models\RecipesModel;
use App\Models\RecipeIngredientsModel;
use App\Models\TagsModel;
use App\Models\RecipeTagsModel;
use App\Models\NotificationsModel;

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
        $nombreIng = trim((string) $this->request->getPost('name'));

        $ingModel = new IngredientsModel();
        $ingModel->insert([
            'name'              => $nombreIng,
            'category'          => $this->request->getPost('category'),
            'calories_per_100g' => $this->request->getPost('calories'),
            'protein_g'         => $this->request->getPost('protein') ?? 0,
            'carb_g'            => $this->request->getPost('carb') ?? 0,
            'fat_g'             => $this->request->getPost('fat') ?? 0,
        ]);

        // Notificar cambio en el sistema al resto del personal
        $notifModel = new NotificationsModel();
        $notifModel->notificarPorRoles(
            ['admin', 'nutricionista'],
            'Nuevo ingrediente registrado',
            "Se agregó el ingrediente \"{$nombreIng}\" a la base nutricional.",
            'admin',
            'sistema',
            (int) session()->get('loggedUser')
        );

        return redirect()->to(base_url('admin'))->with('success', '¡Ingrediente agregado exitosamente!');
    }

    public function guardarEtiqueta()
    {
        if (!$this->verificarAcceso()) return redirect()->to(base_url('recetas'));
        $nombreTag = trim((string) $this->request->getPost('name'));

        $tagsModel = new TagsModel();
        $tagsModel->insert([
            'name'      => $nombreTag,
            'color_hex' => $this->request->getPost('color_hex'),
        ]);

        // Notificar cambio en el sistema al resto del personal
        $notifModel = new NotificationsModel();
        $notifModel->notificarPorRoles(
            ['admin', 'nutricionista'],
            'Nueva etiqueta nutricional',
            "Se creó la etiqueta \"{$nombreTag}\" para clasificación de recetas.",
            'admin',
            'sistema',
            (int) session()->get('loggedUser')
        );

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
        $tituloReceta     = trim((string) $this->request->getPost('title'));
        $autorId          = (int) session()->get('loggedUser');

        $recipesModel = new RecipesModel();
        $recipeId = $recipesModel->insert([
            'user_id'           => $autorId,
            'title'             => $tituloReceta,
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

        // Notificaciones según quién creó la receta
        $notifModel  = new NotificationsModel();
        $nombreAutor = (string) (session()->get('name') ?? 'Especialista');

        if ($estadoAprobacion === 0) {
            // Nutricionista envió receta -> notificar al Administrador para aprobación
            $notifModel->notificarPorRoles(
                ['admin'],
                'Nueva receta por aprobar',
                "{$nombreAutor} envió la receta \"{$tituloReceta}\" para revisión.",
                'admin',
                'receta'
            );
        } else {
            // Administrador publicó receta directamente -> notificar a los Nutricionistas
            $notifModel->notificarPorRoles(
                ['nutricionista'],
                'Nueva receta publicada',
                "Se publicó la receta \"{$tituloReceta}\" en el catálogo de NutriCheck.",
                'recetas',
                'receta'
            );
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
        $receta = $recipesModel->find($id);

        if (!$receta) {
            return redirect()->to(base_url('admin'))->with('fail', 'Receta no encontrada.');
        }

        $recipesModel->update($id, ['is_approved' => 1]);

        // Notificar al nutricionista creador (o a los nutricionistas si es una receta antigua sin user_id)
        $notifModel = new NotificationsModel();
        $autorId    = (int) ($receta['user_id'] ?? 0);
        $adminId    = (int) session()->get('loggedUser');

        if ($autorId > 0 && $autorId !== $adminId) {
            $notifModel->notificarUsuario(
                $autorId,
                '¡Receta aprobada!',
                "Tu receta \"{$receta['title']}\" fue aprobada por el administrador y ya es visible en el buscador.",
                'recetas',
                'receta'
            );
        } else {
            $notifModel->notificarPorRoles(
                ['nutricionista'],
                'Nueva receta aprobada',
                "La receta \"{$receta['title']}\" fue aprobada y ya está disponible en el buscador.",
                'recetas',
                'receta'
            );
        }
        
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