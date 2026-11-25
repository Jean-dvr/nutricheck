<?php

namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\UserModel;
use App\Models\NotificationsModel;

/**
 * Controlador del módulo Newspaper (noticias, eventos, recetas y novedades).
 */
class Newspaper extends BaseController
{
    /**
     * Lista publicaciones aprobadas filtradas por categoría (o todas si es 'general').
     */
    public function index()
    {
        $postsModel      = new PostsModel();
        $userModel       = new UserModel();
        $rolUsuario      = session()->get('rol');
        $categoriaActual = $this->request->getGet('cat') ?? 'general';

        if ($categoriaActual === 'general') {
            $posts = $postsModel->where('status', 'approved')
                                ->orderBy('created_at', 'DESC')
                                ->findAll();
        } else {
            $posts = $postsModel->where('category', $categoriaActual)
                                ->where('status', 'approved')
                                ->orderBy('created_at', 'DESC')
                                ->findAll();
        }

        // Adjunta nombre y avatar del autor a cada publicación
        foreach ($posts as &$post) {
            $autor                = $userModel->find($post['user_id']);
            $post['autor_nombre'] = $autor ? $autor['name'] : 'NutriCheck Staff';
            $post['autor_avatar'] = $autor ? $autor['avatar'] : 'default-avatar.png';
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
        ]);
    }

    /**
     * Muestra el formulario para redactar una nueva publicación.
     */
    public function crear()
    {
        return view('newspaper/crear');
    }

    /**
     * Valida los datos, guarda la imagen opcional y crea la publicación.
     */
    public function guardar()
    {
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
            $errores      = $this->validator->getErrors();
            $primerError  = reset($errores);

            return redirect()->to(base_url('newspaper/crear'))
                             ->withInput()
                             ->with('errors', $errores)
                             ->with('fail', $primerError);
        }

        // Procesa la foto opcional del artículo
        $archivoFoto = $this->request->getFile('foto_post');
        $nombreFoto  = null;

        if ($archivoFoto && $archivoFoto->getError() !== UPLOAD_ERR_NO_FILE) {
            if (!$archivoFoto->isValid()) {
                return redirect()->to(base_url('newspaper/crear'))
                                 ->withInput()
                                 ->with('fail', 'La imagen es muy pesada o está dañada. Máximo 2MB.');
            }

            $extension = strtolower((string) $archivoFoto->guessExtension());
            if (!in_array($extension, ['png', 'jpg', 'jpeg'], true)) {
                return redirect()->to(base_url('newspaper/crear'))
                                 ->withInput()
                                 ->with('fail', 'Formato de imagen no permitido. Solo JPG o PNG.');
            }

            $nombreFoto = $archivoFoto->getRandomName();
            $archivoFoto->move(FCPATH . 'assets/postsimg', $nombreFoto);
        }

        $rolUsuario = session()->get('rol');
        $categoria  = (string) $this->request->getPost('category');

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
            return redirect()->to(base_url('newspaper/crear'))
                             ->withInput()
                             ->with('fail', 'No se pudo guardar la publicación en la base de datos.');
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
                    'newspaper/crear',
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