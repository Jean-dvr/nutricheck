<?php

namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\UserModel;

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
        
        // LÓGICA DE APROBACIÓN: Si es admin, se aprueba solo. Si es nutricionista, va a revisión.
        $estadoPost = ($rolUsuario === 'admin') ? 'approved' : 'pending';

        $postsModel = new PostsModel();
        $datosPost = [
            'user_id'    => session()->get('loggedUser'),
            'title'      => trim($this->request->getPost('title')),
            'category'   => $this->request->getPost('category'),
            'contents'   => trim($this->request->getPost('contents')),
            'status'     => $estadoPost,
            'image_url'  => $nombreFoto
        ];

        if ($postsModel->insert($datosPost)) {
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

        return view('newspaper/pendientes', ['posts' => $postsPendientes]);
    }

    public function aprobar($id)
    {
        if (session()->get('rol') !== 'admin') return redirect()->to(base_url('newspaper'));
        $postsModel = new PostsModel();
        $postsModel->update($id, ['status' => 'approved']);
        return redirect()->to(base_url('newspaper/pendientes'))->with('success', '¡Publicación aprobada con éxito!');
    }

    public function rechazar($id)
    {
        if (session()->get('rol') !== 'admin') return redirect()->to(base_url('newspaper'));
        $postsModel = new PostsModel();
        $postsModel->delete($id); // Borramos el post rechazado
        return redirect()->to(base_url('newspaper/pendientes'))->with('fail', 'Publicación rechazada y eliminada.');
    }
    
    public function eliminar($id)
    {
        // Medida de seguridad: Solo el admin puede eliminar publicaciones directas
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('newspaper'));
        }
        
        $postsModel = new \App\Models\PostsModel();
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