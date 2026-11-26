<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCheck - Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('/assets/css/dashboard.css?v=2.0') ?>">
    <style>
        /* Distintivo de verificación según el tipo de usuario */
        .dash-navbar .user-verification-badge {
            width: 23px;
            height: 23px;
            object-fit: contain;
            flex-shrink: 0;
            display: inline-block;
        }

        /* Estilos de la campanita de notificaciones en Dashboard */
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
        .nc-mark-all-link { font-size: 0.75rem; font-weight: 600; color: #f1682d; text-decoration: none; }
        .nc-mark-all-link:hover { text-decoration: underline; }
        .nc-notif-list { max-height: 360px; overflow-y: auto; }
        .nc-notif-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            text-decoration: none;
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
        .nc-notif-msg { font-size: 0.78rem; color: #666666; line-height: 1.35; margin-bottom: 4px; word-wrap: break-word; }
        .nc-notif-time { font-size: 0.7rem; color: #999999; display: block; }
        .nc-notif-empty { padding: 26px 16px; text-align: center; color: #888888; font-size: 0.84rem; }

        @media (max-width: 576px) {
            .nc-notif-menu {
                position: fixed;
                top: 68px;
                left: 12px;
                right: 12px;
                width: auto;
            }
            .dash-navbar .user-verification-badge {
                width: 20px;
                height: 20px;
            }
        }
    </style>
</head>
<body>

<?php
    // Consulta segura de notificaciones recientes y contador de no leídas
    $ncUserId   = (int) session()->get('loggedUser');
    $ncRolMenu  = (string) (session()->get('rol') ?? '');
    $ncNotifs   = [];
    $ncNoLeidas = 0;

    // Distintivo correspondiente al rol del usuario.
    $ncDistintivos = [
        'admin'         => 'verificadoadmin.png',
        'nutricionista' => 'verificadonutricionista.png',
        'premium'       => 'verificadopremium.png',
    ];
    $ncDistintivo = $ncDistintivos[$ncRolMenu] ?? null;

    if ($ncUserId > 0) {
        try {
            $ncDb = \Config\Database::connect();
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
        <a href="<?= base_url('/') ?>" class="logo-wrapper">
            <img src="<?= base_url('/assets/imagenes/logo_naranja.png') ?>" alt="NutriCheck" class="dash-logo">
        </a>
    </div>

    <div class="user-menu-wrapper">
        <?php if($ncRolMenu === 'admin'): ?>
            <a href="<?= base_url('dashboard/pagos') ?>" class="btn-top btn-admin">Validar Pagos</a>
        <?php endif; ?>

        <!-- Campanita de Notificaciones -->
        <div class="nc-notif-dropdown">
            <button type="button" class="nc-bell-btn" id="notifMenuBtn" aria-label="Notificaciones" title="Notificaciones">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <?php if($ncNoLeidas > 0): ?>
                    <span class="nc-bell-badge"><?= $ncNoLeidas > 9 ? '9+' : esc((string) $ncNoLeidas) ?></span>
                <?php endif; ?>
            </button>

            <div class="nc-notif-menu" id="notifDropdownContent">
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
                <?php if ($ncDistintivo !== null): ?>
                    <img
                        src="<?= base_url('assets/imagenes/' . $ncDistintivo) ?>"
                        alt="Usuario verificado"
                        class="user-verification-badge"
                    >
                <?php endif; ?>
                <span class="arrow-down">▼</span>
            </button>
            <div class="dropdown-content" id="userDropdownContent">
                <a href="<?= base_url('dashboard') ?>">Inicio</a>
                <a href="<?= base_url('perfil') ?>">Configuración</a>
                <?php 
                    $rolMenu = session()->get('rol');
                    if (in_array($rolMenu, ['free', 'premium', 'pro'], true)): 
                ?>
                    <a href="<?= base_url('premium/checkout') ?>" class="text-orange">NutricheckPro</a>
                <?php elseif ($rolMenu === 'admin'): ?>
                    <a href="<?= base_url('dashboard/pagos') ?>" class="text-orange">NutricheckPro (Pagos)</a>
                <?php endif; ?>
                <hr>
                <a href="<?= base_url('logout') ?>" class="text-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const notifMenuBtn = document.getElementById('notifMenuBtn');
    const notifDropdownContent = document.getElementById('notifDropdownContent');
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdownContent = document.getElementById('userDropdownContent');

    if (notifMenuBtn && notifDropdownContent) {
        notifMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (userDropdownContent) {
                userDropdownContent.classList.remove('show');
            }
            notifDropdownContent.classList.toggle('show');
        });

        notifDropdownContent.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        if (userMenuBtn) {
            userMenuBtn.addEventListener('click', () => {
                notifDropdownContent.classList.remove('show');
            });
        }

        window.addEventListener('click', () => {
            notifDropdownContent.classList.remove('show');
        });
    }
});
</script>