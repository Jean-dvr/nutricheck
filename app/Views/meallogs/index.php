<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCheck - Racha de Comidas</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('/assets/css/meallogs.css?v=2.0') ?>">
    <style>
        /* Distintivo de verificación según el tipo de usuario */
        .dash-navbar .user-verification-badge {
            width: 23px;
            height: 23px;
            object-fit: contain;
            flex-shrink: 0;
            display: inline-block;
        }

        .meal-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            justify-content: flex-end;
        }
        .btn-meal-action {
            border: none;
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }
        .btn-meal-action:hover { opacity: 0.88; }
        .btn-meal-edit {
            background-color: #fff3ed;
            color: #f1682d;
            border: 1px solid #f1682d;
        }
        .btn-meal-delete {
            background-color: #fdecea;
            color: #c62828;
            border: 1px solid #c62828;
        }
        .field-warning {
            display: block;
            color: #c62828;
            font-size: 0.78rem;
            margin-top: 4px;
        }
        .d-none { display: none !important; }

        /* Encabezado de sección con botón Volver al Inicio */
        .section-header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .section-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .btn-volver-inicio {
            display: inline-block;
            padding: 8px 24px;
            border-radius: 50rem;
            border: 1px solid #6c757d;
            background-color: transparent;
            color: #6c757d;
            font-size: 0.92rem;
            font-weight: 500;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .btn-volver-inicio:hover {
            background-color: #6c757d;
            color: #ffffff;
        }

        /* Estilos de la campanita de notificaciones (idénticos al Dashboard) */
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

        /* Modal ligero de edición */
        .edit-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            padding: 16px;
        }
        .edit-modal-backdrop.active { display: flex; }
        .edit-modal-card {
            background: #fff;
            border-radius: 14px;
            width: 100%;
            max-width: 480px;
            padding: 22px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }
        .edit-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }
        .edit-modal-close {
            background: transparent;
            border: none;
            font-size: 1.4rem;
            cursor: pointer;
            line-height: 1;
        }

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

<!-- Cabecera Integrada -->
<header class="dash-navbar">
    <div class="logo-container">
        <a href="<?= base_url('/') ?>" class="logo-wrapper">
            <img src="<?= base_url('/assets/imagenes/logo_naranja.png') ?>" alt="NutriCheck" class="dash-logo">
        </a>
    </div>

    <div class="user-menu-wrapper">
        <?php if ($ncRolMenu === 'admin'): ?>
            <a href="<?= base_url('dashboard/pagos') ?>" class="btn-top btn-admin">💳 Validar Pagos</a>
        <?php endif; ?>

        <!-- Campanita de Notificaciones -->
        <div class="nc-notif-dropdown">
            <button type="button" class="nc-bell-btn" id="notifMenuBtn" aria-label="Notificaciones" title="Notificaciones">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <?php if ($ncNoLeidas > 0): ?>
                    <span class="nc-bell-badge"><?= $ncNoLeidas > 9 ? '9+' : esc((string) $ncNoLeidas) ?></span>
                <?php endif; ?>
            </button>

            <div class="nc-notif-menu" id="notifDropdownContent">
                <div class="nc-notif-header">
                    <span class="nc-notif-header-title">🔔 Notificaciones</span>
                    <?php if ($ncNoLeidas > 0): ?>
                        <a href="<?= base_url('notificaciones/leer-todas') ?>" class="nc-mark-all-link">Marcar todas leídas</a>
                    <?php endif; ?>
                </div>

                <div class="nc-notif-list">
                    <?php if (empty($ncNotifs)): ?>
                        <div class="nc-notif-empty">No tienes notificaciones por el momento.</div>
                    <?php else: ?>
                        <?php foreach ($ncNotifs as $notif): ?>
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
                                        <?php if ($esNoLeida): ?>
                                            <span class="nc-unread-dot" title="No leída"></span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="nc-notif-msg"><?= esc((string) ($notif['message'] ?? '')) ?></p>
                                    <?php if ($fechaTxt !== ''): ?>
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
                    $userId = session()->get('loggedUser');
                    $avatarFile = null;
                    if ($userId) {
                        $db = \Config\Database::connect();
                        $userQuery = $db->table('users')->select('avatar')->where('id', $userId)->get()->getRow();
                        if ($userQuery && !empty($userQuery->avatar)) {
                            $avatarFile = $userQuery->avatar;
                        }
                    }
                    $fotoPerfil = ($avatarFile && file_exists(FCPATH . 'assets/avatars/' . $avatarFile))
                        ? base_url('assets/avatars/' . $avatarFile)
                        : base_url('assets/imagenes/iconusuario.png');
                ?>
                <img src="<?= $fotoPerfil ?>" alt="Avatar" class="user-avatar">
                <span class="user-name"><?= esc((string) (session()->get('name') ?? 'Usuario')) ?></span>
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
                    if (in_array($ncRolMenu, ['free', 'premium', 'pro'], true)):
                ?>
                    <a href="<?= base_url('premium/checkout') ?>" class="text-orange">NutricheckPro</a>
                <?php elseif ($ncRolMenu === 'admin'): ?>
                    <a href="<?= base_url('dashboard/pagos') ?>" class="text-orange">NutricheckPro (Pagos)</a>
                <?php endif; ?>
                <hr>
                <a href="<?= base_url('logout') ?>" class="text-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</header>

<main class="meallogs-container">

    <!-- Título Principal de la Sección -->
    <div class="section-header section-header-bar">
        <div class="section-title-group">
            <img src="<?= base_url('/assets/imagenes/fuegonaranja.png') ?>" alt="Fuego" class="header-icon">
            <h1>Racha de Comidas</h1>
        </div>
        <a href="<?= base_url('dashboard') ?>" class="btn-volver-inicio">Volver al Inicio</a>
    </div>

    <div class="meallogs-grid">

        <!-- Columna Izquierda: Formulario de Registro -->
        <section class="form-card">
            <h2>Registrar Nueva Comida</h2>

            <form action="<?= base_url('comidas/guardar') ?>" method="POST" enctype="multipart/form-data" id="formRegistroComida">
                <?= csrf_field() ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="meal_date">Fecha</label>
                        <input type="date" name="meal_date" id="meal_date" value="<?= esc(old('meal_date', date('Y-m-d'))) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="meal_time">Hora</label>
                        <input type="time" name="meal_time" id="meal_time" value="<?= esc(old('meal_time', date('H:i'))) ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="meal_type">Tipo de Comida</label>
                    <?php $tipoAnterior = old('meal_type', ''); ?>
                    <select name="meal_type" id="meal_type" required>
                        <option value="" disabled <?= $tipoAnterior === '' ? 'selected' : '' ?>>Selecciona el tipo...</option>
                        <option value="breakfast" <?= $tipoAnterior === 'breakfast' ? 'selected' : '' ?>>☕ Desayuno</option>
                        <option value="lunch" <?= $tipoAnterior === 'lunch' ? 'selected' : '' ?>>🍲 Almuerzo</option>
                        <option value="dinner" <?= $tipoAnterior === 'dinner' ? 'selected' : '' ?>>🥗 Cena</option>
                        <option value="snack" <?= $tipoAnterior === 'snack' ? 'selected' : '' ?>>🍎 Snack / Merienda / Antojo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">¿Qué comiste? (Descripción)</label>
                    <textarea
                        name="description"
                        id="description"
                        rows="3"
                        placeholder="Ej: 2 huevos revueltos, 1 arepa..."
                        required
                    ><?= esc(old('description', '')) ?></textarea>
                    <small id="avisoDescRegistro" class="field-warning d-none">
                        Solo se permiten letras, números y espacios (sin símbolos ni caracteres especiales).
                    </small>
                </div>

                <div class="form-group">
                    <label for="foto_comida_input">Foto del Plato (Opcional)</label>
                    <input type="file" name="foto_comida" accept="image/png, image/jpeg, image/jpg" id="foto_comida_input">
                </div>

                <div class="image-preview-container">
                    <img id="preview_comida" src="" class="d-none" alt="Vista previa">
                </div>

                <button type="submit" class="btn-submit">REGISTRAR</button>
            </form>
        </section>

        <!-- Columna Derecha: Calendario e Historial -->
        <section class="history-section">

            <!-- Widget Calendario Semanal Interactivo -->
            <div class="calendar-widget">
                <div class="calendar-header">
                    <span class="month-title" id="monthYearTitle"></span>
                    <div class="calendar-nav">
                        <button type="button" id="prevWeekBtn">‹</button>
                        <button type="button" id="nextWeekBtn">›</button>
                    </div>
                </div>
                <div class="calendar-days" id="calendarDaysContainer"></div>
            </div>

            <h3 class="history-title">Historial Reciente</h3>

            <!-- Contenedor Dinámico de Comidas del Día Seleccionado -->
            <div id="historyMealsContainer" class="history-list"></div>

        </section>
    </div>
</main>

<!-- Modal para Editar Registro de Comida -->
<div class="edit-modal-backdrop" id="modalEditarComida" aria-hidden="true">
    <div class="edit-modal-card">
        <div class="edit-modal-header">
            <h3 style="margin: 0; color: #f1682d;">Editar Registro de Comida</h3>
            <button type="button" class="edit-modal-close" id="cerrarModalEditar" aria-label="Cerrar">&times;</button>
        </div>

        <form action="<?= base_url('comidas/editar') ?>" method="POST" enctype="multipart/form-data" id="formEditarComida">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="edit_meal_id">

            <div class="form-row">
                <div class="form-group">
                    <label for="edit_meal_date">Fecha</label>
                    <input type="date" name="meal_date" id="edit_meal_date" required>
                </div>
                <div class="form-group">
                    <label for="edit_meal_time">Hora</label>
                    <input type="time" name="meal_time" id="edit_meal_time" required>
                </div>
            </div>

            <div class="form-group">
                <label for="edit_meal_type">Tipo de Comida</label>
                <select name="meal_type" id="edit_meal_type" required>
                    <option value="breakfast">☕ Desayuno</option>
                    <option value="lunch">🍲 Almuerzo</option>
                    <option value="dinner">🥗 Cena</option>
                    <option value="snack">🍎 Snack / Merienda / Antojo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="edit_description">¿Qué comiste? (Descripción)</label>
                <textarea name="description" id="edit_description" rows="3" required></textarea>
                <small id="avisoDescEditar" class="field-warning d-none">
                    Solo se permiten letras, números y espacios (sin símbolos ni caracteres especiales).
                </small>
            </div>

            <div class="form-group">
                <label for="edit_foto_comida">Cambiar Foto del Plato (Opcional)</label>
                <input type="file" name="foto_comida" id="edit_foto_comida" accept="image/png, image/jpeg, image/jpg">
            </div>

            <div class="meal-actions" style="margin-top: 16px;">
                <button type="button" class="btn-meal-action" id="cancelarModalEditar">Cancelar</button>
                <button type="submit" class="btn-meal-action btn-meal-edit">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<!-- Banner Publicitario Horizontal con Rotación y Tiempo -->
<?php
$rolAnuncioH = session()->get('rol');
$urlsBannersH = [];
$listaBannersH = [];

if (in_array($rolAnuncioH, ['free', 'admin'], true)):
    $bannersModelH = new \App\Models\BannersModel();
    $dbBannersH = \Config\Database::connect();
    if ($dbBannersH->fieldExists('orientation', 'banners')) {
        $listaBannersH = $bannersModelH->where('orientation', 'horizontal')->orderBy('created_at', 'DESC')->findAll();
    }

    if (!empty($listaBannersH)) {
        foreach ($listaBannersH as $bItem) {
            $urlsBannersH[] = base_url('assets/ads/' . $bItem['image_url']);
        }
    } else {
        $promoOreo = file_exists(FCPATH . 'assets/imagenes/promooreo.jpg')
            ? base_url('/assets/imagenes/promooreo.jpg')
            : base_url('/assets/ads/promooreo.jpg');
        $promoPepsi = file_exists(FCPATH . 'assets/imagenes/promopepsi.jpg')
            ? base_url('/assets/imagenes/promopepsi.jpg')
            : base_url('/assets/ads/promopepsi.jpg');
        $urlsBannersH = [$promoOreo, $promoPepsi];
    }
?>
<aside class="ad-banner-horizontal" id="adBannerHorizontal">
    <div class="ad-header">
        <span class="ad-tag"><?= $rolAnuncioH === 'admin' ? '⚙️ Publicidad Horizontal (1160x70px)' : 'Publicidad' ?></span>
        <div class="ad-controls">
            <?php if ($rolAnuncioH === 'admin'): ?>
                <span class="ad-admin-count">📊 Activos: <?= count($listaBannersH) ?></span>
                <button type="button" id="btnAbrirModalBannersH" class="ad-admin-btn ad-btn-manage">🗑️ Gestionar</button>
                <form action="<?= base_url('dashboard/actualizarAnuncio') ?>" method="POST" enctype="multipart/form-data" class="ad-admin-form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="orientation" value="horizontal">
                    <input type="file" name="nuevo_anuncio" class="ad-admin-file" accept="image/png, image/jpeg, image/jpg" required>
                    <button type="submit" class="ad-admin-btn ad-btn-upload">➕ Subir</button>
                </form>
                <button type="button" id="closeAdBtn" class="ad-close-btn" aria-label="Cerrar publicidad" title="Ocultar barra temporalmente">×</button>
            <?php else: ?>
                <span id="adTimerBadge" class="ad-timer">Cambia en 30s</span>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($rolAnuncioH === 'admin' && empty($listaBannersH)): ?>
        <div class="ad-placeholder-box">Sube un banner horizontal (JPG/PNG) para personalizar la rotación de esta barra</div>
    <?php else: ?>
        <a href="<?= $rolAnuncioH === 'admin' ? 'javascript:void(0)' : base_url('premium/checkout') ?>" class="ad-link">
            <img id="adBannerImage" src="<?= esc($urlsBannersH[0]) ?>" alt="NutriCheck Pro Banner" class="ad-image">
        </a>
    <?php endif; ?>
</aside>

<?php if ($rolAnuncioH === 'admin'): ?>
<div class="ad-modal-backdrop" id="modalGestionarBannersH" aria-hidden="true">
    <div class="ad-modal-card">
        <div class="ad-modal-header">
            <h3>⚙️ Gestionar Banners Horizontales en Rotación</h3>
            <button type="button" class="ad-modal-close" id="cerrarModalBannersH" aria-label="Cerrar">&times;</button>
        </div>
        <div class="ad-modal-body">
            <?php if (empty($listaBannersH)): ?>
                <div class="ad-modal-empty">📭 No hay banners horizontales subidos actualmente.</div>
            <?php else: ?>
                <div class="ad-modal-grid">
                    <?php foreach ($listaBannersH as $bannerH): ?>
                        <div class="ad-modal-item">
                            <img src="<?= base_url('assets/ads/' . $bannerH['image_url']) ?>" alt="Banner Horizontal">
                            <div class="ad-modal-item-footer">
                                <a href="<?= base_url('dashboard/eliminarAnuncio/' . $bannerH['id']) ?>" onclick="return confirm('¿Seguro que deseas eliminar este banner horizontal permanentemente?')" class="ad-modal-delete">❌ Quitar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Dropdown Usuario y Campanita de Notificaciones
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdownContent = document.getElementById('userDropdownContent');
    const notifMenuBtn = document.getElementById('notifMenuBtn');
    const notifDropdownContent = document.getElementById('notifDropdownContent');

    if (userMenuBtn && userDropdownContent) {
        userMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (notifDropdownContent) notifDropdownContent.classList.remove('show');
            userDropdownContent.classList.toggle('show');
        });
    }

    if (notifMenuBtn && notifDropdownContent) {
        notifMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (userDropdownContent) userDropdownContent.classList.remove('show');
            notifDropdownContent.classList.toggle('show');
        });

        notifDropdownContent.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }

    window.addEventListener('click', () => {
        if (userDropdownContent) userDropdownContent.classList.remove('show');
        if (notifDropdownContent) notifDropdownContent.classList.remove('show');
    });

    // Previsualización de Imagen en Registro
    const fotoInput = document.getElementById('foto_comida_input');
    const preview = document.getElementById('preview_comida');
    if (fotoInput && preview) {
        fotoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            } else {
                preview.src = '';
                preview.classList.add('d-none');
            }
        });
    }

    // Validación en tiempo real: solo letras, números y espacios (sin caracteres especiales)
    const regexPermitidos = /[^a-zA-Z0-9ÁÉÍÓÚÜÑáéíóúüñ\s]/g;
    function vincularFiltroDescripcion(textareaEl, avisoEl) {
        if (!textareaEl) return;
        textareaEl.addEventListener('input', function () {
            const original = this.value;
            const limpio = original.replace(regexPermitidos, '');
            if (original !== limpio) {
                this.value = limpio;
                if (avisoEl) avisoEl.classList.remove('d-none');
            } else if (avisoEl) {
                avisoEl.classList.add('d-none');
            }
        });
    }

    vincularFiltroDescripcion(
        document.getElementById('description'),
        document.getElementById('avisoDescRegistro')
    );
    vincularFiltroDescripcion(
        document.getElementById('edit_description'),
        document.getElementById('avisoDescEditar')
    );

    // Data de Comidas desde BD y CSRF
    const comidasDB = <?= json_encode($historial_comidas ?? []) ?>;
    const baseAssetUrl = "<?= base_url('assets/meallogsimg/') ?>/";
    const eliminarBaseUrl = "<?= base_url('comidas/eliminar') ?>/";
    const csrfName = "<?= csrf_token() ?>";
    const csrfHash = "<?= csrf_hash() ?>";
    let currentDate = new window.Date();

    const monthYearTitle = document.getElementById('monthYearTitle');
    const calendarDaysContainer = document.getElementById('calendarDaysContainer');
    const historyMealsContainer = document.getElementById('historyMealsContainer');
    const prevBtn = document.getElementById('prevWeekBtn');
    const nextBtn = document.getElementById('nextWeekBtn');

    // Elementos del Modal de Edición
    const modalEditar = document.getElementById('modalEditarComida');
    const cerrarModalBtn = document.getElementById('cerrarModalEditar');
    const cancelarModalBtn = document.getElementById('cancelarModalEditar');

    function abrirModalEdicion(comida) {
        document.getElementById('edit_meal_id').value = comida.id;
        document.getElementById('edit_meal_date').value = comida.meal_date || '';
        document.getElementById('edit_meal_time').value = (comida.meal_time || '').slice(0, 5);
        document.getElementById('edit_meal_type').value = comida.meal_type || 'snack';
        document.getElementById('edit_description').value = comida.description || '';
        document.getElementById('edit_foto_comida').value = '';
        const avisoEdit = document.getElementById('avisoDescEditar');
        if (avisoEdit) avisoEdit.classList.add('d-none');
        modalEditar.classList.add('active');
    }

    function cerrarModalEdicion() {
        modalEditar.classList.remove('active');
    }

    if (cerrarModalBtn) cerrarModalBtn.addEventListener('click', cerrarModalEdicion);
    if (cancelarModalBtn) cancelarModalBtn.addEventListener('click', cerrarModalEdicion);
    if (modalEditar) {
        modalEditar.addEventListener('click', (e) => {
            if (e.target === modalEditar) cerrarModalEdicion();
        });
    }

    const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const dayNames = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];

    function getFormattedDate(date) {
        const yyyy = date.getFullYear();
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const dd = String(date.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }

    function formatAMPM(timeString) {
        if (!timeString) return '';
        let [hours, minutes] = timeString.split(':');
        hours = parseInt(hours, 10);
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        return `${hours}:${minutes} ${ampm}`;
    }

    function renderMealsForDate(selectedDate) {
        const dateKey = getFormattedDate(selectedDate);
        const today = new window.Date();
        today.setHours(0, 0, 0, 0);

        const selDateObj = new window.Date(selectedDate);
        selDateObj.setHours(0, 0, 0, 0);
        const isPast = selDateObj < today;

        const mealsOfDay = comidasDB.filter(c => c.meal_date === dateKey);
        historyMealsContainer.innerHTML = '';

        if (mealsOfDay.length === 0) {
            historyMealsContainer.innerHTML = `
                <div class="empty-history-card">
                    <p>${isPast ? 'Sin registros para este día' : 'No has registrado ninguna comida hoy.'}</p>
                </div>
            `;
            return;
        }

        mealsOfDay.forEach(comida => {
            const dateParts = comida.meal_date.split('-');
            const formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
            const formattedTime = formatAMPM(comida.meal_time);

            let badgeClass = 'badge-snack';
            let badgeText = 'SNACK';

            const typeLower = (comida.meal_type || '').toLowerCase();
            if (typeLower === 'breakfast' || typeLower === 'desayuno') {
                badgeClass = 'badge-desayuno';
                badgeText = 'DESAYUNO';
            } else if (typeLower === 'lunch' || typeLower === 'almuerzo') {
                badgeClass = 'badge-almuerzo';
                badgeText = 'ALMUERZO';
            } else if (typeLower === 'dinner' || typeLower === 'cena') {
                badgeClass = 'badge-cena';
                badgeText = 'CENA';
            }

            const card = document.createElement('div');
            card.className = 'history-card';

            const photoBlock = comida.image_path
                ? `<img src="${baseAssetUrl}${comida.image_path}" class="meal-photo" alt="Plato">`
                : `<div class="no-photo"><span>Sin foto</span></div>`;

            card.innerHTML = `
                <div class="photo-container">${photoBlock}</div>
                <div class="info-container">
                    <div class="card-top-row">
                        <span class="meal-badge ${badgeClass}">${badgeText}</span>
                        <span class="meal-datetime">${formattedDate} | ${formattedTime}</span>
                    </div>
                    <p class="meal-description"></p>
                    <div class="meal-actions">
                        <button type="button" class="btn-meal-action btn-meal-edit btn-editar-comida">Editar</button>
                        <form action="${eliminarBaseUrl}${comida.id}" method="POST" class="form-eliminar-comida" style="display:inline;">
                            <input type="hidden" name="${csrfName}" value="${csrfHash}">
                            <button type="submit" class="btn-meal-action btn-meal-delete">Eliminar</button>
                        </form>
                    </div>
                </div>
            `;

            card.querySelector('.meal-description').textContent = comida.description || '';
            card.querySelector('.btn-editar-comida').addEventListener('click', () => abrirModalEdicion(comida));
            card.querySelector('.form-eliminar-comida').addEventListener('submit', (e) => {
                if (!confirm('¿Deseas eliminar este registro de comida?')) {
                    e.preventDefault();
                }
            });

            historyMealsContainer.appendChild(card);
        });
    }

    function renderWeek(date) {
        calendarDaysContainer.innerHTML = '';
        const startOfWeek = new window.Date(date);
        startOfWeek.setDate(date.getDate() - date.getDay());

        monthYearTitle.textContent = `${months[startOfWeek.getMonth()]} ${startOfWeek.getFullYear()}`;

        for (let i = 0; i < 7; i++) {
            const day = new window.Date(startOfWeek);
            day.setDate(startOfWeek.getDate() + i);
            const isSelected = day.toDateString() === date.toDateString();

            const dayDiv = document.createElement('div');
            dayDiv.className = `day-col ${isSelected ? 'current-day' : ''}`;
            dayDiv.innerHTML = `
                <span class="day-name">${dayNames[day.getDay()]}</span>
                <span class="day-num">${day.getDate()}</span>
                ${isSelected ? '<span class="active-dot"></span>' : ''}
            `;

            dayDiv.addEventListener('click', () => {
                currentDate = day;
                renderWeek(currentDate);
            });

            calendarDaysContainer.appendChild(dayDiv);
        }

        renderMealsForDate(date);
    }

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            currentDate.setDate(currentDate.getDate() - 7);
            renderWeek(currentDate);
        });
        nextBtn.addEventListener('click', () => {
            currentDate.setDate(currentDate.getDate() + 7);
            renderWeek(currentDate);
        });
    }

    renderWeek(currentDate);

    // Lógica de Banner Publicitario Horizontal con Rotación
    const adBanner = document.getElementById('adBannerHorizontal');
    const closeAdBtn = document.getElementById('closeAdBtn');
    const adTimerBadge = document.getElementById('adTimerBadge');
    const adBannerImage = document.getElementById('adBannerImage');

    const adImages = <?= json_encode($urlsBannersH) ?>;
    let currentAdIndex = 0;
    let timerInterval = null;

    if (adBanner && adTimerBadge && adBannerImage && adImages.length > 0) {
        let timeLeft = 30;
        timerInterval = setInterval(() => {
            timeLeft--;
            if (timeLeft <= 0) {
                timeLeft = 30;
                currentAdIndex = (currentAdIndex + 1) % adImages.length;
                adBannerImage.src = adImages[currentAdIndex];
            }
            adTimerBadge.textContent = `Cambia en ${timeLeft}s`;
        }, 1000);
    }

    if (adBanner && closeAdBtn) {
        closeAdBtn.addEventListener('click', () => {
            adBanner.style.display = 'none';
            if (timerInterval) clearInterval(timerInterval);
        });
    }

    // Modal de gestión de banners horizontales (Admin)
    const btnAbrirModalH = document.getElementById('btnAbrirModalBannersH');
    const modalBannersH = document.getElementById('modalGestionarBannersH');
    const cerrarModalH = document.getElementById('cerrarModalBannersH');

    if (btnAbrirModalH && modalBannersH) {
        btnAbrirModalH.addEventListener('click', () => {
            modalBannersH.classList.add('active');
        });
        if (cerrarModalH) {
            cerrarModalH.addEventListener('click', () => {
                modalBannersH.classList.remove('active');
            });
        }
        modalBannersH.addEventListener('click', (e) => {
            if (e.target === modalBannersH) {
                modalBannersH.classList.remove('active');
            }
        });
    }
});
</script>

</body>
</html>