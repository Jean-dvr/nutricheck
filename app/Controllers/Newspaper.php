<?php

namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\UserModel;
use App\Models\NotificationsModel;

class Newspaper extends BaseController
{
   public function index()
    {
        $postsModel = new PostsModel();
        $userModel = new UserModel();
        $rolUsuario = session()->get('rol');

        $categoriaActual = $this->request->getGet('cat') ?? 'general';

        // LÓGICA DE FILTRADO MODIFICADA
        if ($categoriaActual === 'general') {
            // Si está en 'general', traemos TODAS las publicaciones aprobadas
            $posts = $postsModel->where('status', 'approved')
                                ->orderBy('created_at', 'DESC')
                                ->findAll();
        } else {
            // Si está en otra pestaña, filtramos por esa categoría específica
            $posts = $postsModel->where('category', $categoriaActual)
                                ->where('status', 'approved')
                                ->orderBy('created_at', 'DESC')
                                ->findAll();
        }

        foreach ($posts as &$post) {
            $autor = $userModel->find($post['user_id']);
            $post['autor_nombre'] = $autor ? $autor['name'] : 'NutriCheck Staff';
            $post['autor_avatar'] = $autor ? $autor['avatar'] : 'default-avatar.png';
        }
        unset($post);

        $pendientesCount = 0;
        if ($rolUsuario === 'admin') {
            $pendientesCount = $postsModel->where('status', 'pending')->countAllResults();
        }

        $data = [
            'posts' => $posts,
            'categoria_actual' => $categoriaActual,
            'rol_usuario' => $rolUsuario,
            'pendientes_count' => $pendientesCount
        ];

        return view('newspaper/index', $data);
    }

    public function crear() { return view('newspaper/crear'); }

    public function guardar()
    {
        if (!$this->validate('crearPost')) {
            return redirect()->to(base_url('newspaper/crear'))->withInput()->with('fail', 'Verifica que todos los campos sean correctos.');
        }

        $archivoFoto = $this->request->getFile('foto_post');
        $nombreFoto = null; 
        
        if ($archivoFoto && $archivoFoto->getError() !== UPLOAD_ERR_NO_FILE) {
            if (!$archivoFoto->isValid()) {
                return redirect()->to(base_url('newspaper/crear'))->withInput()->with('fail', 'La imagen es muy pesada. Máximo 2MB.');
            }
            $extension = $archivoFoto->guessExtension();
            if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                $nombreFoto = $archivoFoto->getRandomName();
                $archivoFoto->move(FCPATH . 'assets/postsimg', $nombreFoto);
            } else {
                return redirect()->to(base_url('newspaper/crear'))->withInput()->with('fail', 'Solo JPG o PNG.');
            }
        }

        $rolUsuario = session()->get('rol');
        $categoria  = (string) $this->request->getPost('category');

        // Solo el administrador puede publicar en la categoría de promociones/ofertas (novedades)
        if ($categoria === 'novedades' && $rolUsuario !== 'admin') {
            $categoria = 'general';
        }
        
        // LÓGICA DE APROBACIÓN: Si es admin, se aprueba solo. Si es nutricionista, va a revisión.
        $estadoPost = ($rolUsuario === 'admin') ? 'approved' : 'pending';

        $postsModel = new PostsModel();
        $datosPost = [
            'user_id'    => session()->get('loggedUser'),
            'title'      => trim((string) $this->request->getPost('title')),
            'category'   => $categoria,
            'contents'   => trim((string) $this->request->getPost('contents')),
            'status'     => $estadoPost,
            'image_url'  => $nombreFoto
        ];

        if ($postsModel->insert($datosPost)) {
            $notifModel  = new NotificationsModel();
            $nombreAutor = (string) (session()->get('name') ?? 'Especialista');
            $resumen     = function_exists('mb_strimwidth')
                ? mb_strimwidth($datosPost['contents'], 0, 110, '...')
                : substr($datosPost['contents'], 0, 110);

            if ($estadoPost === 'pending') {
                // Notificar al Admin que hay una publicación esperando moderación
                $notifModel->notificarPorRoles(
                    ['admin'],
                    'Nueva publicación pendiente',
                    "{$nombreAutor} envió el artículo \"{$datosPost['title']}\" para moderación.",
                    'newspaper/pendientes',
                    'noticia'
                );
            } else {
                // Publicación directa del Admin
                if ($categoria === 'novedades') {
                    // Oferta/Promoción NutriCheckPro -> Free va al checkout y Premium al periódico
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
            }

            $mensaje = ($estadoPost === 'pending') 
                ? 'Publicación enviada. Un administrador la revisará pronto.' 
                : 'Publicación creada y visible exitosamente.';
            return redirect()->to(base_url('newspaper?cat=' . $datosPost['category']))->with('success', $mensaje);
        } else {
            return redirect()->to(base_url('newspaper/crear'))->withInput()->with('fail', 'Error al guardar.');
        }
    }

    // -------------------------------------------------------------
    // FUNCIONES EXCLUSIVAS DEL ADMINISTRADOR
    // -------------------------------------------------------------
    public function pendientes()
    {
        if (session()->get('rol') !== 'admin') return redirect()->to(base_url('newspaper'));

        $postsModel = new PostsModel();
        $userModel = new UserModel();

        // Traemos todos los pendientes
        $postsPendientes = $postsModel->where('status', 'pending')->orderBy('created_at', 'ASC')->findAll();

        foreach ($postsPendientes as &$post) {
            $autor = $userModel->find($post['user_id']);
            $post['autor_nombre'] = $autor ? $autor['name'] : 'Desconocido';
            $post['autor_avatar'] = $autor ? $autor['avatar'] : 'default-avatar.png';
        }
        unset($post);

        return view('newspaper/pendientes', ['posts' => $postsPendientes]);
    }

    public function aprobar(int $id)
    {
        if (session()->get('rol') !== 'admin') return redirect()->to(base_url('newspaper'));

        $postsModel = new PostsModel();
        $post = $postsModel->find($id);

        if (!$post) {
            return redirect()->to(base_url('newspaper/pendientes'))->with('fail', 'La publicación no existe.');
        }

        $postsModel->update($id, ['status' => 'approved']);

        $notifModel = new NotificationsModel();
        $adminId    = (int) session()->get('loggedUser');
        $autorId    = (int) ($post['user_id'] ?? 0);
        $linkPost   = 'newspaper?cat=' . ($post['category'] ?? 'general');

        // 1. Notificar al nutricionista autor que su artículo fue aprobado
        if ($autorId > 0 && $autorId !== $adminId) {
            $notifModel->notificarUsuario(
                $autorId,
                '¡Publicación aprobada!',
                "Tu artículo \"{$post['title']}\" fue aprobado y ya está visible en Noticias.",
                $linkPost,
                'noticia'
            );
        }

        // 2. Notificar a los usuarios Premium sobre la nueva publicación o evento
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

    public function rechazar(int $id)
    {
        if (session()->get('rol') !== 'admin') return redirect()->to(base_url('newspaper'));

        $postsModel = new PostsModel();
        $post = $postsModel->find($id);

        if ($post) {
            $autorId = (int) ($post['user_id'] ?? 0);
            $titulo  = (string) ($post['title'] ?? 'Publicación');

            $postsModel->delete($id); // Borramos el post rechazado

            // Notificar al autor que su publicación fue rechazada
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
    
    public function eliminar(int $id)
    {
        // Medida de seguridad: Solo el admin puede eliminar publicaciones directas
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('newspaper'));
        }
        
        $postsModel = new PostsModel();
        $post = $postsModel->find($id);
        
        if ($post) {
            // Borrar la imagen física de la carpeta assets/postsimg si existe
            if (!empty($post['image_url'])) {
                $rutaImagen = FCPATH . 'assets/postsimg/' . $post['image_url'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }
            
            // Eliminar el registro de la base de datos
            $postsModel->delete($id);
            return redirect()->back()->with('success', 'Publicación eliminada correctamente del periódico.');
        }

        return redirect()->back()->with('fail', 'La publicación no existe o ya fue eliminada.');
    }
}