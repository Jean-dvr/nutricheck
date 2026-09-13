<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCheck - Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('/assets/css/dashboard.css?v=999') ?>">
</head>
<body>

<header class="dash-navbar">
    <div class="logo-container">
        <a href="<?= base_url('dashboard') ?>" class="logo-wrapper">
            <img src="<?= base_url('/assets/imagenes/logo_naranja.png') ?>" alt="NutriCheck" class="dash-logo">
        </a>
    </div>

    <div class="user-menu-wrapper">
        <?php if(session()->get('rol') === 'admin'): ?>
            <a href="<?= base_url('dashboard/pagos') ?>" class="btn-top btn-admin">💳 Validar Pagos</a>
        <?php endif; ?>

        <div class="user-dropdown">
            <button type="button" class="dropdown-trigger" id="userMenuBtn">
                
                <?php 
                    // Consulta directa a la BD usando el ID de la sesión para máxima seguridad
                    $userId = session()->get('loggedUser');
                    $avatarFile = null;
                    
                    if ($userId) {
                        $db = \Config\Database::connect();
                        $userQuery = $db->table('users')->select('avatar')->where('id', $userId)->get()->getRow();
                        if ($userQuery && !empty($userQuery->avatar)) {
                            $avatarFile = $userQuery->avatar;
                        }
                    }

                    // Definimos la ruta de la imagen: si existe el archivo físico, lo muestra; si no, usa el icono por defecto
                    $fotoPerfil = ($avatarFile && file_exists(FCPATH . 'assets/avatars/' . $avatarFile))
                        ? base_url('assets/avatars/' . $avatarFile) 
                        : base_url('assets/imagenes/iconusuario.png');
                ?>
                <img src="<?= $fotoPerfil ?>" alt="Avatar" class="user-avatar" style="width: 38px; height: 38px; object-fit: cover; border-radius: 50%;">
                
                <span class="user-name"><?= session()->get('name') ?? 'Amaranta Montaño' ?></span>
                <span class="arrow-down">▼</span>
            </button>
            <div class="dropdown-content" id="userDropdownContent">
                <a href="<?= base_url('perfil') ?>">Configuración</a>
                <?php if(session()->get('rol') !== 'premium' && session()->get('rol') !== 'pro'): ?>
                    <a href="<?= base_url('premium/checkout') ?>" class="text-orange">NutricheckPro</a>
                <?php endif; ?>
                <a href="#">Ayuda</a>
                <hr>
                <a href="<?= base_url('logout') ?>" class="text-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</header>