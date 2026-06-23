<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCheck - Panel de Control</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #f4f6f9; }
        .navbar-brand { font-weight: 700; color: #f1682d !important; letter-spacing: 1px;}
    </style>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-5">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
            NutriCheck
        </a>
        
        <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Navegación">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div id="my-nav" class="collapse navbar-collapse">
            
            <ul class="navbar-nav mr-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="<?= base_url('dashboard') ?>">Inicio</a>
                </li>
                
                <?php if(session()->has('rol')): ?>
                    <li class="nav-item ml-lg-3 mt-2 mt-lg-0">
                        <?php 
                            $rol = session()->get('rol');
                            if ($rol === 'admin'): 
                        ?>
                            <span class="badge badge-danger px-3 py-2 shadow-sm" style="font-size: 0.85rem;">🛡️ Admin</span>
                        
                        <?php elseif ($rol === 'nutricionista'): ?>
                            <span class="badge badge-success px-3 py-2 shadow-sm" style="font-size: 0.85rem;">🩺 Nutricionista</span>
                        
                        <?php elseif ($rol === 'premium'): ?>
                            <span class="badge px-3 py-2 shadow-sm" style="background-color: #ffc107; color: #856404; font-size: 0.85rem;">⭐ NutriCheck Premium</span>
                        
                        <?php elseif ($rol === 'free'): ?>
                            <span class="badge badge-secondary px-3 py-2 shadow-sm" style="font-size: 0.85rem;">👤 Paciente</span>
                        
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            </ul>
            
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-outline-danger btn-sm mt-1 font-weight-bold rounded-pill px-3" href="<?= base_url('logout') ?>">
                        Cerrar Sesión
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<div class="container">

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('fail')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <?= session()->getFlashdata('fail') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>