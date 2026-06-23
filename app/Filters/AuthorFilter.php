<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthorFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Obtenemos el rol actual del usuario desde la sesión
        $rol = session()->get('rol');
        
        // Si el usuario NO es un admin y NO es un nutricionista, le bloqueamos el acceso
        if ($rol !== 'admin' && $rol !== 'nutricionista') {
            // Lo redirigimos de vuelta al periódico con un mensaje de error
            return redirect()->to(base_url('newspaper'))->with('fail', 'Acceso denegado: Solo los profesionales de la salud pueden crear publicaciones.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) 
    {
        // No necesitamos hacer nada después de que cargue la página
    }
}