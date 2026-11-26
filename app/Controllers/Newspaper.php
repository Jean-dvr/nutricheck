<?php

namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\SavedPostsModel;
use App\Models\UserModel;
use App\Models\NotificationsModel;

/**
 * Controlador del módulo Newspaper (noticias, eventos, recetas especiales y guardados).
 */
class Newspaper extends BaseController
{
    /**
     * Lista publicaciones aprobadas filtradas por categoría o guardados del usuario.
     */
    public function index()
    {
        $postsModel = new PostsModel();
        $userModel  = new UserModel();
        $db         = \Config\Database::connect();

        $userId     = (int) session()->get('loggedUser');
        $rolUsuario = (string) (session()->get('rol') ?? '');

        $categoriaActual = strtolower((string) ($this->request->getGet('cat') ?? 'general'));
        $categoriasValidas = ['general', 'eventos', 'recetas', 'guardados', 'novedades'];
        if (!in_array($categoriaActual, $categoriasValidas, true)) {
            $categoriaActual = 'general';
        }

        // Obtener IDs de publicaciones guardadas por el usuario actual
        $savedPostIds = [];
        $tieneTablaGuardados = $db->tableExists('saved_posts');

        if ($tieneTablaGuardados && $userId > 0) {
            $savedModel = new SavedPostsModel();
            $guardadosRows = $savedModel->where('user_id', $userId)
                                        ->orderBy('created_at', 'DESC')
                                        ->orderBy('id', 'DESC')
                                        ->findAll();
            $savedPostIds = array_map('intval', array_column($guardadosRows, 'post_id'));
        }

        // Consultar publicaciones según el filtro activo
        if ($categoriaActual === 'guardados') {
            if (empty($savedPostIds)) {
                $posts = [];
            } else {
                $postsRaw = $postsModel->where('status', 'approved')
                                       ->whereIn('id', $savedPostIds)
                                       ->findAll();

                // Preservar el orden en que el usuario las guardó (más reciente primero)
                $postsPorId = [];
                foreach ($postsRaw as $p) {
                    $postsPorId[(int) $p['id']] = $p;
                }

                $posts = [];
                foreach ($savedPostIds as $sid) {
                    if (isset($postsPorId[$sid])) {
                        $posts[] = $postsPorId[$sid];
                    }
                }
            }
        } elseif ($categoriaActual === 'general') {
            $posts = $postsModel->where('status', 'approved')
                                ->orderBy('created_at', 'DESC')
                                ->findAll();
        } else {
            $posts = $postsModel->where('category', $categoriaActual)
                                ->where('status', 'approved')
                                ->orderBy('created_at', 'DESC')
                                ->findAll();
        }

        // Mapeo de insignias por rol (igual que en cabecera)
        $distintivos = [
            'admin'         => 'verificadoadmin.png',
            'nutricionista' => 'verificadonutricionista.png',
            'premium'       => 'verificadopremium.png',
            'pro'           => 'verificadopremium.png',
        ];

        $autoresCache = [];
        foreach ($posts as &$post) {
            $autorId = (int) ($post['user_id'] ?? 0);
            if (!array_key_exists($autorId, $autoresCache)) {
                $autoresCache[$autorId] = $autorId > 0 ? $userModel->find($autorId) : null;
            }
            $autor = $autoresCache[$autorId];

            $avatarArchivo = ($autor && !empty($autor['avatar'])) ? (string) $autor['avatar'] : '';
            $avatarUrl = ($avatarArchivo !== '' && file_exists(FCPATH . 'assets/avatars/' . $avatarArchivo))
                ? base_url('assets/avatars/' . $avatarArchivo)
                : base_url('assets/imagenes/iconusuario.png');

            $autorRol   = $autor ? strtolower((string) ($autor['rol'] ?? '')) : '';
            $badgeFile  = $distintivos[$autorRol] ?? null;

            $post['autor_nombre']     = $autor ? (string) $autor['name'] : 'NutriCheck Staff';
            $post['autor_avatar']     = $avatarArchivo;
            $post['autor_avatar_url'] = $avatarUrl;
            $post['autor_badge_url']  = $badgeFile ? base_url('assets/imagenes/' . $badgeFile) : '';
            $post['is_saved']         = in_array((int) $post['id'], $savedPostIds, true);
        }
        unset($post);

        $pendientesCount = ($rolUsuario === 'admin')
            ? $postsModel->where('status', 'pending')->countAllResults()
            : 0;

        return view('newspaper/index', [
            'posts'            => $posts,
            'categoria_actual' => $categoriaActual,
            'rol_usuario'      => $rolUsuario,
            'pendientes_count' => $pendientesCount,
            'guardados_count'  => count($savedPostIds),
        ]);
    }

    /**
     * Guarda o quita una publicación de los favoritos del usuario (AJAX).
     */
    public function toggleGuardado(int $postId)
    {
        $userId = (int) session()->get('loggedUser');
        if ($userId <= 0) {
            return $this->response->setStatusCode(401)->setJSON([
                'success'  => false,
                'message'  => 'Debes iniciar sesión para guardar publicaciones.',
                'csrfName' => csrf_token(),
                'csrfHash' => csrf_hash(),
            ]);
        }

        $db = \Config\Database::connect();
        if (!$db->tableExists('saved_posts')) {
            return $this->response->setStatusCode(500)->setJSON([
                'success'  => false,
                'message'  => 'La tabla saved_posts aún no ha sido creada en la base de datos.',
                'csrfName' => csrf_token(),
                'csrfHash' => csrf_hash(),
            ]);
        }

        $postsModel = new PostsModel();
        $post = $postsModel->where('id', $postId)->where('status', 'approved')->first();

        if (!$post) {
            return $this->response->setStatusCode(404)->setJSON([
                'success'  => false,
                'message'  => 'La publicación no existe o no está disponible.',
                'csrfName' => csrf_token(),
                'csrfHash' => csrf_hash(),
            ]);
        }

        $savedModel = new SavedPostsModel();
        $existente = $savedModel->where('user_id', $userId)
                                ->where('post_id', $postId)
                                ->first();

        if ($existente) {
            $savedModel->delete($existente['id']);
            $guardado = false;
        } else {
            $savedModel->insert([
                'user_id'    => $userId,
                'post_id'    => $postId,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $guardado = true;
        }

        return $this->response->setJSON([
            'success'  => true,
            'saved'    => $guardado,
            'post_id'  => $postId,
            'csrfName' => csrf_token(),
            'csrfHash' => csrf_hash(),
        ]);
    }

    /**
     * Muestra el formulario para redactar una nueva publicación (solo admin y nutricionista).
     */
    public function crear()
    {
        if (!in_array(session()->get('rol'), ['admin', 'nutricionista'], true)) {
            return redirect()->to(base_url('newspaper'))->with('fail', 'No tienes permisos para crear publicaciones.');
        }

        return view('newspaper/crear');
    }

    /**
     * Valida los datos, guarda la imagen opcional y crea la publicación.
     */
    public function guardar()
    {
        $rolUsuario = (string) (session()->get('rol') ?? '');
        if (!in_array($rolUsuario, ['admin', 'nutricionista'], true)) {
            return redirect()->to(base_url('newspaper'))->with('fail', 'Solo administradores y nutricionistas pueden publicar.');
        }

        $desdeModal = $this->request->getPost('origen') === 'modal';
        $catRetorno = (string) ($this->request->getPost('cat_retorno') ?: 'general');
        $rutaError  = $desdeModal
            ? base_url('newspaper?cat=' . urlencode($catRetorno))
            : base_url('newspaper/crear');

        $validationConfig = config('Validation');
        $reglas           = $validationConfig->crearPost;

        // Extrae mensajes personalizados si vienen definidos dentro de cada campo
        $mensajes = [];
        foreach ($reglas as $campo => $definicion) {
            if (is_array($definicion) && isset($definicion['errors'])) {
                $mensajes[$campo] = $definicion['errors'];
            }
        }

        // Valida y devuelve el motivo exacto del primer error detectado
        if (!$this->validate($reglas, $mensajes)) {
            $errores     = $this->validator->getErrors();
            $primerError = reset($errores);

            $redirect = redirect()->to($rutaError)
                                  ->withInput()
                                  ->with('errors', $errores)
                                  ->with('fail', $primerError);
            if ($desdeModal) {
                $redirect->with('open_create_modal', true);
            }
            return $redirect;
        }

        // Procesa la foto opcional del artículo
        $archivoFoto = $this->request->getFile('foto_post');
        $nombreFoto  = null;

        if ($archivoFoto && $archivoFoto->getError() !== UPLOAD_ERR_NO_FILE) {
            if (!$archivoFoto->isValid()) {
                $redirect = redirect()->to($rutaError)
                                      ->withInput()
                                      ->with('fail', 'La imagen es muy pesada o está dañada. Máximo 2MB.');
                if ($desdeModal) {
                    $redirect->with('open_create_modal', true);
                }
                return $redirect;
            }

            $extension = strtolower((string) $archivoFoto->guessExtension());
            if (!in_array($extension, ['png', 'jpg', 'jpeg'], true)) {
                $redirect = redirect()->to($rutaError)
                                      ->withInput()
                                      ->with('fail', 'Formato de imagen no permitido. Solo JPG o PNG.');
                if ($desdeModal) {
                    $redirect->with('open_create_modal', true);
                }
                return $redirect;
            }

            $rutaDestino = FCPATH . 'assets/postsimg';
            if (!is_dir($rutaDestino)) {
                mkdir($rutaDestino, 0775, true);
            }

            $nombreFoto = $archivoFoto->getRandomName();
            $archivoFoto->move($rutaDestino, $nombreFoto);
        }

        $categoria = (string) $this->request->getPost('category');

        // Restringe 'novedades' exclusivamente al administrador
        if ($categoria === 'novedades' && $rolUsuario !== 'admin') {
            $categoria = 'general';
        }

        // El admin publica directo; los nutricionistas pasan a moderación
        $estadoPost = ($rolUsuario === 'admin') ? 'approved' : 'pending';

        $postsModel = new PostsModel();
        $datosPost  = [
            'user_id'   => session()->get('loggedUser'),
            'title'     => trim((string) $this->request->getPost('title')),
            'category'  => $categoria,
            'contents'  => trim((string) $this->request->getPost('contents')),
            'status'    => $estadoPost,
            'image_url' => $nombreFoto,
        ];

        if (!$postsModel->insert($datosPost)) {
            $redirect = redirect()->to($rutaError)
                                  ->withInput()
                                  ->with('fail', 'No se pudo guardar la publicación en la base de datos.');
            if ($desdeModal) {
                $redirect->with('open_create_modal', true);
            }
            return $redirect;
        }

        // Envía notificaciones según estado y categoría
        $notifModel  = new NotificationsModel();
        $nombreAutor = (string) (session()->get('name') ?? 'Especialista');
        $resumen     = function_exists('mb_strimwidth')
            ? mb_strimwidth($datosPost['contents'], 0, 110, '...')
            : substr($datosPost['contents'], 0, 110);

        if ($estadoPost === 'pending') {
            $notifModel->notificarPorRoles(
                ['admin'],
                'Nueva publicación pendiente',
                "{$nombreAutor} envió el artículo \"{$datosPost['title']}\" para moderación.",
                'newspaper/pendientes',
                'noticia'
            );
        } elseif ($categoria === 'novedades') {
            $notifModel->notificarPorRoles(
                ['free'],
                "Oferta NutriCheckPro: {$datosPost['title']}",
                $resumen,
                'premium/checkout',
                'oferta'
            );
            $notifModel->notificarPorRoles(
                ['premium', 'pro'],
                "Promoción NutriCheckPro: {$datosPost['title']}",
                $resumen,
                'newspaper?cat=novedades',
                'oferta'
            );
            $notifModel->notificarPorRoles(
                ['nutricionista'],
                'Novedad del sistema',
                "El administrador publicó: \"{$datosPost['title']}\".",
                'newspaper?cat=novedades',
                'sistema'
            );
        } else {
            $tituloNotif = ($categoria === 'eventos')
                ? 'Nuevo evento en Noticias'
                : 'Nueva publicación en Noticias';

            $notifModel->notificarPorRoles(
                ['premium', 'pro', 'nutricionista'],
                $tituloNotif,
                "Ya puedes leer: \"{$datosPost['title']}\".",
                'newspaper?cat=' . $categoria,
                'noticia',
                (int) session()->get('loggedUser')
            );
        }

        $mensaje = ($estadoPost === 'pending')
            ? 'Publicación enviada. Un administrador la revisará pronto.'
            : 'Publicación creada y visible exitosamente.';

        return redirect()->to(base_url('newspaper?cat=' . $datosPost['category']))->with('success', $mensaje);
    }

    // -------------------------------------------------------------
    // FUNCIONES EXCLUSIVAS DEL ADMINISTRADOR
    // -------------------------------------------------------------

    /**
     * Lista publicaciones pendientes de aprobación (solo admin).
     */
    public function pendientes()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('newspaper'));
        }

        $postsModel      = new PostsModel();
        $userModel       = new UserModel();
        $postsPendientes = $postsModel->where('status', 'pending')->orderBy('created_at', 'ASC')->findAll();

        foreach ($postsPendientes as &$post) {
            $autor                = $userModel->find($post['user_id']);
            $post['autor_nombre'] = $autor ? $autor['name'] : 'Desconocido';
            $post['autor_avatar'] = $autor ? $autor['avatar'] : 'default-avatar.png';
        }
        unset($post);

        return view('newspaper/pendientes', ['posts' => $postsPendientes]);
    }

    /**
     * Aprueba una publicación pendiente y notifica al autor y usuarios premium.
     */
    public function aprobar(int $id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('newspaper'));
        }

        $postsModel = new PostsModel();
        $post       = $postsModel->find($id);

        if (!$post) {
            return redirect()->to(base_url('newspaper/pendientes'))->with('fail', 'La publicación no existe.');
        }

        $postsModel->update($id, ['status' => 'approved']);

        $notifModel = new NotificationsModel();
        $adminId    = (int) session()->get('loggedUser');
        $autorId    = (int) ($post['user_id'] ?? 0);
        $linkPost   = 'newspaper?cat=' . ($post['category'] ?? 'general');

        if ($autorId > 0 && $autorId !== $adminId) {
            $notifModel->notificarUsuario(
                $autorId,
                '¡Publicación aprobada!',
                "Tu artículo \"{$post['title']}\" fue aprobado y ya está visible en Noticias.",
                $linkPost,
                'noticia'
            );
        }

        $tituloNotif = (($post['category'] ?? '') === 'eventos')
            ? 'Nuevo evento en Noticias'
            : 'Nueva publicación en Noticias';

        $notifModel->notificarPorRoles(
            ['premium', 'pro'],
            $tituloNotif,
            "Ya está disponible: \"{$post['title']}\".",
            $linkPost,
            'noticia'
        );

        return redirect()->to(base_url('newspaper/pendientes'))->with('success', '¡Publicación aprobada con éxito!');
    }

    /**
     * Rechaza y elimina una publicación pendiente, notificando al autor.
     */
    public function rechazar(int $id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('newspaper'));
        }

        $postsModel = new PostsModel();
        $post       = $postsModel->find($id);

        if ($post) {
            $autorId = (int) ($post['user_id'] ?? 0);
            $titulo  = (string) ($post['title'] ?? 'Publicación');

            $postsModel->delete($id);

            if ($autorId > 0 && $autorId !== (int) session()->get('loggedUser')) {
                $notifModel = new NotificationsModel();
                $notifModel->notificarUsuario(
                    $autorId,
                    'Publicación rechazada',
                    "Tu artículo \"{$titulo}\" no fue aprobado en moderación.",
                    'newspaper',
                    'noticia'
                );
            }
        }

        return redirect()->to(base_url('newspaper/pendientes'))->with('fail', 'Publicación rechazada y eliminada.');
    }

    /**
     * Elimina una publicación y su imagen física en disco (solo admin).
     */
    public function eliminar(int $id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('newspaper'));
        }

        $postsModel = new PostsModel();
        $post       = $postsModel->find($id);

        if ($post) {
            if (!empty($post['image_url'])) {
                $rutaImagen = FCPATH . 'assets/postsimg/' . basename($post['image_url']);
                if (is_file($rutaImagen)) {
                    @unlink($rutaImagen);
                }
            }

            $postsModel->delete($id);
            return redirect()->back()->with('success', 'Publicación eliminada correctamente del periódico.');
        }

        return redirect()->back()->with('fail', 'La publicación no existe o ya fue eliminada.');
    }
}