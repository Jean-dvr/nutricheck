<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PremiumFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Obtenemos el rol del usuario desde la sesión
        $rol = session()->get('rol');
        
        // Si el usuario tiene el plan gratuito, le bloqueamos el paso
        if ($rol === 'free') {
            // Lo regresamos al dashboard con un mensaje informándole por qué no puede entrar
            return redirect()->to(base_url('dashboard'))->with('fail', '🔒 NutriCheck News es un módulo exclusivo. ¡Adquiere el plan Premium para acceder a artículos de nuestros especialistas!');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}