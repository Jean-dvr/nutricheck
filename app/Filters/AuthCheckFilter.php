<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Middleware de Autenticación para NutriCheck.
 * Se encarga de proteger las rutas privadas interceptando las peticiones HTTP
 * antes de que alcancen a los controladores.
 */

class AuthCheckFilter implements FilterInterface
{
   /**
     * Se ejecuta ANTES de que el sistema cargue el Controlador solicitado (ej. Dashboard).
     * Actúa como el "guardia de seguridad" de las rutas protegidas.
     *
     * @param RequestInterface $request La petición HTTP entrante.
     * @param array|null $arguments Argumentos adicionales pasados a la ruta.
     * @return mixed Si retorna un redirect, aborta la carga del controlador.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verificamos la bandera de seguridad 'isLoggedIn' que creamos en Authen::ingresar()
        if (!session()->get('isLoggedIn')) {
            // Si no existe, interceptamos el vuelo y rebotamos al usuario
            return redirect()->to(base_url('login'))->with('fail', 'Debes iniciar sesión para acceder a esta área.');
        }
    }

    /**
     * Se ejecuta DESPUÉS de que el Controlador ha procesado la lógica y está
     * a punto de enviar la vista (HTML) al navegador del usuario.
     *
     * @param RequestInterface $request La petición HTTP original.
     * @param ResponseInterface $response La respuesta que el servidor va a enviar.
     * @param array|null $arguments Argumentos adicionales.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // En un filtro de autenticación puro, no necesitamos modificar la respuesta final,
        // por lo que este método se deja vacío intencionalmente.
    }
}
