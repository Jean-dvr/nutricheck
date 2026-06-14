<?php

namespace App\Controllers;

class Home extends BaseController
{
    // Esta función carga la vista V1 (Bienvenidos)
    public function index(): string
    {
        return view('V1');
    }

    // Esta función carga la vista V2 (Crear Cuenta)
    public function registro(): string
    {
        return view('V2-2');
    }

    // Esta función carga la vista V2 (Iniciar Sesion)
    public function iniciar_sesion(): string
    {
        return view('V2-1'); 
    }
}