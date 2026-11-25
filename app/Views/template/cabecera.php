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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; background-color: #f4f6f9; }
        .navbar-brand { font-weight: 700; color: #f1682d !important; letter-spacing: 1px; }

        /* Navbar Principal (estética idéntica al Dashboard) */
        .dash-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 40px;
            height: 70px;
            background-color: #FFFFFF;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            margin-bottom: 3rem;
            position: relative;
            z-index: 1100;
        }
        .dash-navbar .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 4px;
            text-decoration: none !important;
        }
        .dash-navbar .dash-logo {
            height: 38px;
            width: auto;
            display: block;
        }
        .dash-navbar .user-menu-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .dash-navbar .btn-top {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none !important;
            line-height: 1.2;
            transition: background 0.2s, opacity 0.2s;
            white-space: nowrap;
        }
        .dash-navbar .btn-admin {
            background-color: #dc3545;
            color: #FFFFFF !important;
        }
        .dash-navbar .btn-admin:hover {
            opacity: 0.92;
            color: #FFFFFF !important;
        }

        /* Campanita de Notificaciones (idéntica al Dashboard) */
        .nc-notif-dropdown { position: relative; }
        .nc-bell-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #ececec;
            background-color: #f8f9fa;
            color: #4a4a4a;
            cursor: pointer;
            padding: 0;
            transition: background-color 0.2s, border-color 0.2s, color 0.2s;
        }
        .nc-bell-btn:hover,
        .nc-bell-btn:focus {
            background-color: #fff3ed;
            border-color: #f1682d;
            color: #f1682d;
            outline: none;
        }
        .nc-bell-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 19px;
            height: 19px;
            padding: 0 5px;
            border-radius: 10px;
            background-color: #dc3545;
            color: #ffffff;
            font-size: 0.68rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
            line-height: 1;
        }
        .nc-notif-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 48px;
            width: 340px;
            max-width: calc(100vw - 24px);
            background-color: #ffffff;
            border-radius: 14px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.14);
            border: 1px solid #eeeeee;
            z-index: 1200;
            overflow: hidden;
            text-align: left;
        }
        .nc-notif-menu.show { display: block; }
        .nc-notif-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background-color: #fafafa;
            border-bottom: 1px solid #eeeeee;
        }
        .nc-notif-header-title { font-weight: 700; font-size: 0.9rem; color: #333333; }
        .nc-mark-all-link { font-size: 0.75rem; font-weight: 600; color: #f1682d !important; text-decoration: none; }
        .nc-mark-all-link:hover { text-decoration: underline; }
        .nc-notif-list { max-height: 360px; overflow-y: auto; }
        .nc-notif-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            text-decoration: none !important;
            border-bottom: 1px solid #f2f2f2;
            background-color: #ffffff;
            transition: background-color 0.15s;
        }
        .nc-notif-item:last-child { border-bottom: none; }
        .nc-notif-item.nc-unread { background-color: #fff8f3; }
        .nc-notif-item:hover { background-color: #f4f6f9; }
        .nc-notif-icon { font-size: 1.15rem; line-height: 1.2; flex-shrink: 0; margin-top: 2px; }
        .nc-notif-body { flex: 1; min-width: 0; }
        .nc-notif-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            font-size: 0.84rem;
            font-weight: 700;
            color: #2c2c2c;
            margin-bottom: 3px;
        }
        .nc-unread-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #f1682d;
            flex-shrink: 0;
        }
        .nc-notif-msg { font-size: 0.78rem; color: #666666; line-height: 1.35; margin: 0 0 4px 0; word-wrap: break-word; }
        .nc-notif-time { font-size: 0.7rem; color: #999999; display: block; }
        .nc-notif-empty { padding: 26px 16px; text-align: center; color: #888888; font-size: 0.84rem; }

        /* Menú Desplegable de Usuario (idéntico al Dashboard) */
        .dash-navbar .user-dropdown { position: relative; }
        .dash-navbar .dropdown-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }
        .dash-navbar .dropdown-trigger:focus { outline: none; }
        .dash-navbar .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }
        .dash-navbar .user-name {
            font-weight: 700;
            font-size: 1rem;
            color: #4A4A4A;
        }
        .dash-navbar .arrow-down {
            font-size: 0.7rem;
            color: #777777;
        }
        .dash-navbar .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 45px;
            background-color: #FFFFFF;
            min-width: 180px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 10px 0;
            z-index: 1200;
            text-align: left;
        }
        .dash-navbar .dropdown-content.show { display: block; }
        .dash-navbar .dropdown-content a {
            color: #4A4A4A;
            padding: 10px 20px;
            text-decoration: none !important;
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .dash-navbar .dropdown-content a:hover { background-color: #F8F9FA; }
        .dash-navbar .dropdown-content hr {
            border: 0;
            border-top: 1px solid #EAEAEA;
            margin: 5px 0;
        }
        .dash-navbar .text-orange {
            color: #F8B133 !important;
            font-weight: 700;
        }
        .dash-navbar .text-orange:hover {
            color: #FF8F1C !important;
        }

        @media (max-width: 768px) {
            .dash-navbar { padding: 10px 16px; }
            .dash-navbar .user-name { display: none; }
        }
    </style>
</head>
<body>

<?php
    // Consulta segura de avatar y notificaciones desde BD
    $ncUserId   = (int) session()->get('loggedUser');
    $ncRolMenu  = (string) (session()->get('rol') ?? '');
    $avatarFile = null;
    $ncNotifs   = [];
    $ncNoLeidas = 0;

    if ($ncUserId > 0) {
        try {
            $ncDb = \Config\Database::connect();
            $userQuery = $ncDb->table('users')->select('avatar')->where('id', $ncUserId)->get()->getRow();
            if ($userQuery && !empty($userQuery->avatar)) {
                $avatarFile = (string) $userQuery->avatar;
            }

            if ($ncDb->tableExists('notifications')) {
                $ncNotifs = $ncDb->table('notifications')
                    ->where('user_id', $ncUserId)
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->limit(12)
                    ->get()
                    ->getResultArray();

                $ncNoLeidas = (int) $ncDb->table('notifications')
                    ->where('user_id', $ncUserId)
                    ->where('is_read', 0)
                    ->countAllResults();
            }
        } catch (\Throwable $e) {
            $ncNotifs   = [];
            $ncNoLeidas = 0;
        }
    }

    // Definimos la ruta de la imagen: si existe el archivo físico, lo muestra; si no, usa el icono por defecto
    $fotoPerfil = ($avatarFile !== null && $avatarFile !== '' && file_exists(FCPATH . 'assets/avatars/' . $avatarFile))
        ? base_url('assets/avatars/' . $avatarFile)
        : base_url('assets/imagenes/iconusuario.png');

    $ncIconosTipo = [
        'pago'    => '💳',
        'receta'  => '🍲',
        'noticia' => '📰',
        'oferta'  => '🎁',
        'sistema' => '⚙️',
    ];
?>

<header class="dash-navbar">
    <div class="logo-container">
        <a href="<?= base_url('dashboard') ?>" class="logo-wrapper">
            <img src="<?= base_url('/assets/imagenes/logo_naranja.png') ?>" alt="NutriCheck" class="dash-logo">
        </a>
    </div>

    <div class="user-menu-wrapper">
        <?php if($ncRolMenu === 'admin'): ?>
            <a href="<?= base_url('dashboard/pagos') ?>" class="btn-top btn-admin">💳 Validar Pagos</a>
        <?php endif; ?>

        <!-- Campanita de Notificaciones -->
        <div class="nc-notif-dropdown">
            <button type="button" class="nc-bell-btn" id="tplNotifBtn" aria-label="Notificaciones" title="Notificaciones">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <?php if($ncNoLeidas > 0): ?>
                    <span class="nc-bell-badge"><?= $ncNoLeidas > 9 ? '9+' : esc((string) $ncNoLeidas) ?></span>
                <?php endif; ?>
            </button>

            <div class="nc-notif-menu" id="tplNotifMenu">
                <div class="nc-notif-header">
                    <span class="nc-notif-header-title">🔔 Notificaciones</span>
                    <?php if($ncNoLeidas > 0): ?>
                        <a href="<?= base_url('notificaciones/leer-todas') ?>" class="nc-mark-all-link">Marcar todas leídas</a>
                    <?php endif; ?>
                </div>

                <div class="nc-notif-list">
                    <?php if(empty($ncNotifs)): ?>
                        <div class="nc-notif-empty">No tienes notificaciones por el momento.</div>
                    <?php else: ?>
                        <?php foreach($ncNotifs as $notif): ?>
                            <?php
                                $esNoLeida = ((int) ($notif['is_read'] ?? 0) === 0);
                                $tipo      = (string) ($notif['type'] ?? 'sistema');
                                $icono     = $ncIconosTipo[$tipo] ?? '🔔';
                                $fechaTxt  = !empty($notif['created_at']) ? date('d/m/Y h:i A', strtotime((string) $notif['created_at'])) : '';
                            ?>
                            <a href="<?= base_url('notificaciones/leer/' . (int) ($notif['id'] ?? 0)) ?>" class="nc-notif-item <?= $esNoLeida ? 'nc-unread' : '' ?>">
                                <span class="nc-notif-icon"><?= $icono ?></span>
                                <div class="nc-notif-body">
                                    <div class="nc-notif-title">
                                        <span><?= esc((string) ($notif['title'] ?? '')) ?></span>
                                        <?php if($esNoLeida): ?>
                                            <span class="nc-unread-dot" title="No leída"></span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="nc-notif-msg"><?= esc((string) ($notif['message'] ?? '')) ?></p>
                                    <?php if($fechaTxt !== ''): ?>
                                        <span class="nc-notif-time"><?= esc($fechaTxt) ?></span>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Menú Desplegable de Usuario -->
        <div class="user-dropdown">
            <button type="button" class="dropdown-trigger" id="tplUserBtn">
                <img src="<?= esc($fotoPerfil) ?>" alt="Avatar" class="user-avatar">
                <span class="user-name"><?= esc((string) (session()->get('name') ?? 'Usuario')) ?></span>
                <span class="arrow-down">▼</span>
            </button>
            <div class="dropdown-content" id="tplUserMenu">
                <a href="<?= base_url('perfil') ?>">Configuración</a>
                <?php if(in_array($ncRolMenu, ['free', 'premium', 'pro'], true)): ?>
                    <a href="<?= base_url('premium/checkout') ?>" class="text-orange">NutricheckPro</a>
                <?php elseif($ncRolMenu === 'admin'): ?>
                    <a href="<?= base_url('dashboard/pagos') ?>" class="text-orange">NutricheckPro (Pagos)</a>
                <?php endif; ?>
                <hr>
                <a href="<?= base_url('logout') ?>" class="text-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifBtn  = document.getElementById('tplNotifBtn');
    const notifMenu = document.getElementById('tplNotifMenu');
    const userBtn   = document.getElementById('tplUserBtn');
    const userMenu  = document.getElementById('tplUserMenu');

    if (notifBtn && notifMenu) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (userMenu) userMenu.classList.remove('show');
            notifMenu.classList.toggle('show');
        });

        notifMenu.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    if (userBtn && userMenu) {
        userBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (notifMenu) notifMenu.classList.remove('show');
            userMenu.classList.toggle('show');
        });

        userMenu.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    window.addEventListener('click', function () {
        if (notifMenu) notifMenu.classList.remove('show');
        if (userMenu) userMenu.classList.remove('show');
    });
});
</script>

<div class="container">

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <strong><?= session()->getFlashdata('success') ?></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('fail')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <strong><?= session()->getFlashdata('fail') ?></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>