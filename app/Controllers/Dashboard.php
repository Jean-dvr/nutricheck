<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Redirige al login si intentan entrar sin iniciar sesión
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        return view('Dashboard/index');
    }
}