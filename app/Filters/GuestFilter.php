<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Filtro de Invitados (Guest) para NutriCheck.
 * Intercepta a los usuarios que ya iniciaron sesión y los redirige al Dashboard
 * si intentan acceder a las pantallas públicas de autenticación.
 */
class GuestFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si el usuario YA tiene la bandera de seguridad activa en su sesión
        if (session()->get('isLoggedIn')) {
            // Interceptamos el vuelo y lo regresamos a su área de trabajo
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Intencionalmente vacío
    }
}