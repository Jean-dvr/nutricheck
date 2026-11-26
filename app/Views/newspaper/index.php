<?php
/**
 * Variables inyectadas por el Controlador Newspaper
 * @var array  $posts
 * @var string $categoria_actual
 * @var string $rol_usuario
 * @var int    $pendientes_count
 * @var int    $guardados_count
 */

$puedeCrear     = in_array($rol_usuario, ['admin', 'nutricionista'], true);
$esAdmin        = ($rol_usuario === 'admin');
$mostrarCardAdd = ($puedeCrear && $categoria_actual !== 'guardados');

$etiquetasCategoria = [
    'general'   => 'General',
    'eventos'   => 'Eventos',
    'recetas'   => 'Recetas Especiales',
    'novedades' => 'Novedades',
];

// Mapa estructurado de publicaciones para el popup de lectura ampliada
$mapaPostsModal = [];
if (!empty($posts)) {
    foreach ($posts as $p) {
        $pid = (int) $p['id'];
        $catKey = (string) ($p['category'] ?? 'general');
        $mapaPostsModal[$pid] = [
            'id'               => $pid,
            'title'            => (string) ($p['title'] ?? ''),
            'contents'         => (string) ($p['contents'] ?? ''),
            'category'         => $catKey,
            'category_label'   => $etiquetasCategoria[$catKey] ?? ucfirst($catKey),
            'image_url'        => !empty($p['image_url']) ? base_url('assets/postsimg/' . $p['image_url']) : '',
            'created_at_fmt'   => !empty($p['created_at']) ? date('d/m/Y h:i A', strtotime((string) $p['created_at'])) : '',
            'autor_nombre'     => (string) ($p['autor_nombre'] ?? 'NutriCheck Staff'),
            'autor_avatar_url' => (string) ($p['autor_avatar_url'] ?? base_url('assets/imagenes/iconusuario.png')),
            'autor_badge_url'  => (string) ($p['autor_badge_url'] ?? ''),
            'is_saved'         => !empty($p['is_saved']),
            'delete_url'       => base_url('newspaper/eliminar/' . $pid),
        ];
    }
}

$categoriaPreseleccionada = old('category', in_array($categoria_actual, ['general', 'eventos', 'recetas', 'novedades'], true) ? $categoria_actual : 'general');
$abrirModalCrear = (bool) session()->getFlashdata('open_create_modal');
?>
<?= view('template/cabecera') ?>

<style>
    /* Encabezado Noticias */
    .news-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding-bottom: 18px;
        margin-bottom: 20px;
        border-bottom: 1px solid #e6e6e6;
    }
    .news-title-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 4px;
    }
    .news-megaphone-icon {
        width: 44px;
        height: 44px;
        object-fit: contain;
        flex-shrink: 0;
    }
    .news-title {
        font-size: 2rem;
        font-weight: 800;
        color: #6b6b6b;
        margin: 0;
        line-height: 1.1;
    }
    .news-subtitle {
        color: #7c7c7c;
        font-size: 0.9rem;
        margin: 0;
    }
    .news-header-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        flex-shrink: 0;
    }
    .news-btn-volver {
        border: 1.5px solid #8c8c8c;
        color: #6b6b6b;
        background-color: transparent;
        border-radius: 50rem;
        padding: 8px 24px;
        font-size: 0.92rem;
        font-weight: 500;
        text-decoration: none !important;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .news-btn-volver:hover {
        background-color: #6b6b6b;
        border-color: #6b6b6b;
        color: #ffffff;
    }
    .news-btn-pendientes {
        background-color: #dc3545;
        color: #ffffff !important;
        border-radius: 50rem;
        padding: 8px 18px;
        font-size: 0.86rem;
        font-weight: 700;
        text-decoration: none !important;
        white-space: nowrap;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.2);
        transition: opacity 0.2s ease;
    }
    .news-btn-pendientes:hover {
        opacity: 0.92;
    }

    /* Pestañas / Filtros Estilo Píldora Dorada */
    .news-filters-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
    }
    .news-filter-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-width: 135px;
        padding: 8px 22px;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none !important;
        border: 1.5px solid #F8B133;
        background-color: #ffffff;
        color: #6b6b6b;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .news-filter-pill:hover {
        background-color: #fff8ea;
        color: #4a4a4a;
    }
    .news-filter-pill.active {
        background-color: #F8B133;
        border-color: #F8B133;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(248, 177, 51, 0.25);
    }

    /* Tarjeta + Nueva Publicación */
    .news-add-card {
        width: 100%;
        height: 100%;
        min-height: 290px;
        background-color: transparent;
        border: 1.5px solid #6b6b6b;
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        color: #5c5c5c;
        transition: all 0.22s ease;
        padding: 24px;
    }
    .news-add-card:hover,
    .news-add-card:focus {
        background-color: #ffffff;
        border-color: #F8B133;
        color: #F8B133;
        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.06);
        transform: translateY(-2px);
        outline: none;
    }
    .news-add-plus {
        font-size: 3.4rem;
        font-weight: 600;
        line-height: 1;
    }
    .news-add-label {
        font-size: 0.95rem;
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    /* Tarjeta de Publicación */
    .news-post-card {
        background-color: #ffffff;
        border: 1.5px solid #ececec;
        border-radius: 16px;
        height: 100%;
        min-height: 290px;
        display: flex;
        flex-direction: column;
        padding: 18px 20px;
        cursor: pointer;
        transition: border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    .news-post-card:hover,
    .news-post-card:focus {
        border-color: #6b6b6b;
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.07);
        outline: none;
    }
    .news-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-bottom: 12px;
        margin-bottom: 14px;
        border-bottom: 1.5px solid #c9c9c9;
    }
    .news-author-info {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }
    .news-author-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        background-color: #7c7c7c;
        flex-shrink: 0;
    }
    .news-author-name-wrap {
        display: flex;
        align-items: center;
        gap: 6px;
        min-width: 0;
    }
    .news-author-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #5c5c5c;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .news-author-badge {
        width: 20px;
        height: 20px;
        object-fit: contain;
        flex-shrink: 0;
    }

    /* Botón Marcador (Guardar / Guardado) */
    .btn-bookmark-post {
        background: transparent;
        border: none;
        padding: 4px;
        cursor: pointer;
        color: #6b6b6b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: color 0.18s ease, transform 0.18s ease;
    }
    .btn-bookmark-post:hover {
        color: #F8B133;
        transform: scale(1.12);
    }
    .btn-bookmark-post.is-saved {
        color: #F8B133;
    }
    .btn-bookmark-post:focus {
        outline: none;
    }

    .news-card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
    }
    .news-post-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #5c5c5c;
        margin-bottom: 6px;
        word-wrap: break-word;
    }
    .news-post-excerpt {
        font-size: 0.85rem;
        color: #757575;
        line-height: 1.48;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-wrap: break-word;
    }
    .news-card-thumb {
        width: 100%;
        height: 135px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 12px;
        background-color: #f1f3f5;
    }
    .news-card-footer {
        margin-top: auto;
        padding-top: 10px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }
    .news-card-meta {
        font-size: 0.72rem;
        color: #8c8c8c;
        font-weight: 600;
    }
    .news-cat-chip {
        display: inline-block;
        padding: 2px 9px;
        border-radius: 50rem;
        background-color: #fff6e4;
        color: #d68c12;
        font-size: 0.7rem;
        font-weight: 700;
        margin-right: 6px;
    }
    .news-btn-delete-mini {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1px solid #f5c6cb;
        background-color: #fff5f5;
        color: #dc3545;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        text-decoration: none !important;
        transition: background-color 0.2s, color 0.2s;
        flex-shrink: 0;
    }
    .news-btn-delete-mini:hover {
        background-color: #dc3545;
        color: #ffffff;
    }

    /* Estado Vacío (Igual al mockup con ícono ?) */
    .news-empty-state {
        min-height: 290px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 36px 20px;
    }
    .news-empty-icon {
        width: 68px;
        height: 68px;
        color: #6b6b6b;
        margin-bottom: 14px;
    }
    .news-empty-text {
        font-size: 1.05rem;
        font-weight: 700;
        color: #6b6b6b;
        margin: 0;
    }

    /* Modales (Lectura y Redacción con estética limpia del mockup) */
    .news-modal-content {
        border: 1.5px solid #6b6b6b;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.16);
    }

    /* Modal Redactar Publicación */
    .news-compose-body {
        padding: 24px 26px 22px 26px;
        background-color: #ffffff;
    }
    .news-asunto-input {
        width: 100%;
        background-color: #e2e2e2;
        border: 1.5px solid transparent;
        border-radius: 12px;
        padding: 13px 18px;
        font-size: 1.25rem;
        font-weight: 800;
        color: #4f4f4f;
        outline: none;
        transition: border-color 0.2s ease, background-color 0.2s ease;
    }
    .news-asunto-input::placeholder {
        color: #6c6c6c;
        letter-spacing: 0.5px;
    }
    .news-asunto-input:focus {
        background-color: #ececec;
        border-color: #F8B133;
    }
    .news-content-textarea {
        width: 100%;
        border: none;
        resize: vertical;
        min-height: 190px;
        margin-top: 16px;
        padding: 6px 4px;
        font-size: 0.96rem;
        line-height: 1.6;
        color: #4a4a4a;
        outline: none;
    }
    .news-content-textarea::placeholder {
        color: #8c8c8c;
    }
    .news-compose-footer {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding-top: 14px;
        border-top: 1px solid #f0f0f0;
    }
    .news-compose-options {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }
    .news-compose-select {
        border: 1px solid #d5d5d5;
        border-radius: 10px;
        padding: 6px 12px;
        font-size: 0.84rem;
        font-weight: 600;
        color: #555555;
        background-color: #fafafa;
        outline: none;
    }
    .news-compose-select:focus {
        border-color: #F8B133;
    }
    .news-file-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 10px;
        border: 1px dashed #bdbdbd;
        background-color: #fafafa;
        color: #666666;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        margin: 0;
        transition: border-color 0.2s, color 0.2s;
    }
    .news-file-label:hover {
        border-color: #F8B133;
        color: #d68c12;
    }
    .news-btn-publicar {
        min-width: 155px;
        padding: 9px 26px;
        border-radius: 12px;
        border: 1.5px solid #F8B133;
        background-color: #ffffff;
        color: #6b6b6b;
        font-size: 0.98rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .news-btn-publicar:hover,
    .news-btn-publicar.ready {
        background-color: #F8B133;
        border-color: #F8B133;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(248, 177, 51, 0.28);
    }

    /* Modal Leer Publicación Completa */
    .news-read-body {
        padding: 24px 28px;
        background-color: #ffffff;
    }
    .news-read-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 14px;
        margin-bottom: 18px;
        border-bottom: 1.5px solid #8c8c8c;
    }
    .news-read-author {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }
    .news-read-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        background-color: #7c7c7c;
        flex-shrink: 0;
    }
    .news-read-author-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #5c5c5c;
        margin: 0;
    }
    .news-read-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }
    .news-modal-close-x {
        background: #f1f3f5;
        border: none;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        font-size: 1.35rem;
        line-height: 1;
        color: #555555;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .news-modal-close-x:hover {
        background: #e2e6ea;
    }
    .news-read-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #555555;
        margin-bottom: 10px;
        word-wrap: break-word;
    }
    .news-read-image {
        width: 100%;
        max-height: 340px;
        object-fit: cover;
        border-radius: 12px;
        margin: 12px 0 16px 0;
        background-color: #f1f3f5;
    }
    .news-read-text {
        font-size: 0.96rem;
        line-height: 1.7;
        color: #555555;
        white-space: pre-line;
        word-wrap: break-word;
        margin-bottom: 18px;
    }
    .news-read-footer {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding-top: 14px;
        border-top: 1px solid #eeeeee;
    }

    @media (max-width: 767.98px) {
        .news-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .news-title {
            font-size: 1.65rem;
        }
        .news-megaphone-icon {
            width: 36px;
            height: 36px;
        }
        .news-filter-pill {
            min-width: auto;
            padding: 7px 15px;
            font-size: 0.85rem;
        }
        .news-add-card,
        .news-post-card {
            min-height: 220px;
        }
        .news-compose-body,
        .news-read-body {
            padding: 18px 16px;
        }
        .news-asunto-input {
            font-size: 1.05rem;
            padding: 11px 14px;
        }
        .news-btn-publicar {
            width: 100%;
        }
        .news-read-author-name {
            font-size: 1.05rem;
        }
        .news-read-title {
            font-size: 1.2rem;
        }
    }
</style>

<div class="container mt-3 mb-5">

    <!-- Encabezado -->
    <div class="news-header">
        <div>
            <div class="news-title-row">
                <img src="<?= base_url('assets/imagenes/megafononaranja.png') ?>" alt="Noticias" class="news-megaphone-icon">
                <h1 class="news-title">Noticias</h1>
            </div>
            <p class="news-subtitle">Lo último en salud, jornadas médicas y nutrición.</p>
        </div>

        <div class="news-header-actions">
            <?php if ($esAdmin): ?>
                <a href="<?= base_url('newspaper/pendientes') ?>" class="news-btn-pendientes">
                    🛡️ Pendientes
                    <?php if (!empty($pendientes_count) && (int) $pendientes_count > 0): ?>
                        <span class="badge badge-light text-danger ml-1"><?= (int) $pendientes_count ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

            <a href="<?= base_url('dashboard') ?>" class="news-btn-volver">Volver al Inicio</a>
        </div>
    </div>

    <!-- Filtros de Categoría y Guardados -->
    <nav class="news-filters-bar" aria-label="Filtros de noticias">
        <a href="<?= base_url('newspaper?cat=general') ?>" class="news-filter-pill <?= $categoria_actual === 'general' ? 'active' : '' ?>">
            General
        </a>
        <a href="<?= base_url('newspaper?cat=eventos') ?>" class="news-filter-pill <?= $categoria_actual === 'eventos' ? 'active' : '' ?>">
            Eventos
        </a>
        <a href="<?= base_url('newspaper?cat=recetas') ?>" class="news-filter-pill <?= $categoria_actual === 'recetas' ? 'active' : '' ?>">
            Recetas Especiales
        </a>
        <a href="<?= base_url('newspaper?cat=guardados') ?>" class="news-filter-pill <?= $categoria_actual === 'guardados' ? 'active' : '' ?>">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M6 2h12a1 1 0 0 1 1 1v19l-7-4-7 4V3a1 1 0 0 1 1-1z"></path>
            </svg>
            Guardados
        </a>
    </nav>

    <!-- Grilla Principal -->
    <div class="row" id="newsGridContainer">

        <?php if ($mostrarCardAdd): ?>
            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <button
                    type="button"
                    class="news-add-card"
                    data-toggle="modal"
                    data-target="#modalCrearPublicacion"
                    aria-label="Nueva publicación"
                >
                    <span class="news-add-plus">+</span>
                    <span class="news-add-label">Nueva publicación</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (empty($posts)): ?>
            <div class="<?= $mostrarCardAdd ? 'col-12 col-sm-6 col-lg-8' : 'col-12' ?> mb-4" id="newsEmptyStateCol">
                <div class="news-empty-state">
                    <svg class="news-empty-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M4 3h16a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2h-5.6L12 21.6 9.6 18H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm8 3.2c-2 0-3.4 1.15-3.4 2.9h2.05c0-.72.52-1.22 1.3-1.22.74 0 1.22.42 1.22 1.04 0 .56-.32.92-1.08 1.38-.95.56-1.37 1.18-1.33 2.38h2.02c.02-.64.26-1 .98-1.44.96-.58 1.56-1.3 1.56-2.44 0-1.56-1.35-2.6-3.32-2.6zm-.05 7.55a1.25 1.25 0 1 0 0 2.5 1.25 1.25 0 0 0 0-2.5z"></path>
                    </svg>
                    <p class="news-empty-text">
                        <?= $categoria_actual === 'guardados'
                            ? 'Aún no tienes publicaciones guardadas.'
                            : 'Aún no hay publicaciones en esta sección.' ?>
                    </p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <?php
                    $pid      = (int) $post['id'];
                    $catKey   = (string) ($post['category'] ?? 'general');
                    $catLabel = $etiquetasCategoria[$catKey] ?? ucfirst($catKey);
                    $guardado = !empty($post['is_saved']);
                ?>
                <div class="col-12 col-sm-6 col-lg-4 mb-4 news-post-col" data-post-col-id="<?= $pid ?>">
                    <article
                        class="news-post-card"
                        role="button"
                        tabindex="0"
                        data-post-id="<?= $pid ?>"
                        aria-label="Abrir publicación <?= esc($post['title']) ?>"
                    >
                        <div class="news-card-header">
                            <div class="news-author-info">
                                <img
                                    src="<?= esc($post['autor_avatar_url']) ?>"
                                    alt="<?= esc($post['autor_nombre']) ?>"
                                    class="news-author-avatar"
                                >
                                <div class="news-author-name-wrap">
                                    <span class="news-author-name"><?= esc($post['autor_nombre']) ?></span>
                                    <?php if (!empty($post['autor_badge_url'])): ?>
                                        <img
                                            src="<?= esc($post['autor_badge_url']) ?>"
                                            alt="Verificado"
                                            class="news-author-badge"
                                        >
                                    <?php endif; ?>
                                </div>
                            </div>

                            <button
                                type="button"
                                class="btn-bookmark-post <?= $guardado ? 'is-saved' : '' ?>"
                                data-bookmark-id="<?= $pid ?>"
                                aria-label="<?= $guardado ? 'Quitar de guardados' : 'Guardar publicación' ?>"
                                title="<?= $guardado ? 'Quitar de guardados' : 'Guardar publicación' ?>"
                            >
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M6 2h12a1 1 0 0 1 1 1v19l-7-4-7 4V3a1 1 0 0 1 1-1z"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="news-card-body">
                            <h3 class="news-post-title"><?= esc($post['title']) ?></h3>

                            <?php if (!empty($post['image_url'])): ?>
                                <img
                                    src="<?= base_url('assets/postsimg/' . esc($post['image_url'])) ?>"
                                    alt="<?= esc($post['title']) ?>"
                                    class="news-card-thumb"
                                >
                            <?php endif; ?>

                            <p class="news-post-excerpt"><?= esc($post['contents']) ?></p>

                            <div class="news-card-footer">
                                <div class="news-card-meta">
                                    <span class="news-cat-chip"><?= esc($catLabel) ?></span>
                                    <span><?= !empty($post['created_at']) ? date('d/m/Y', strtotime((string) $post['created_at'])) : '' ?></span>
                                </div>

                                <?php if ($esAdmin): ?>
                                    <a
                                        href="<?= base_url('newspaper/eliminar/' . $pid) ?>"
                                        class="news-btn-delete-mini btn-delete-post-link"
                                        onclick="event.stopPropagation(); return confirm('¿Estás seguro de que deseas eliminar esta publicación permanentemente?');"
                                        title="Eliminar publicación"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>

<!-- Modal: Leer Publicación Completa -->
<div class="modal fade" id="modalVerPublicacion" tabindex="-1" role="dialog" aria-labelledby="readPostTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content news-modal-content">
            <div class="modal-body news-read-body">
                <div class="news-read-header">
                    <div class="news-read-author">
                        <img id="readPostAvatar" src="" alt="Autor" class="news-read-avatar">
                        <div>
                            <div class="d-flex align-items-center" style="gap: 7px;">
                                <h4 id="readPostAuthorName" class="news-read-author-name"></h4>
                                <img id="readPostAuthorBadge" src="" alt="Verificado" class="news-author-badge d-none">
                            </div>
                            <small id="readPostMeta" class="text-muted"></small>
                        </div>
                    </div>

                    <div class="news-read-actions">
                        <button
                            type="button"
                            id="readPostBookmarkBtn"
                            class="btn-bookmark-post"
                            data-bookmark-id=""
                            aria-label="Guardar publicación"
                            title="Guardar publicación"
                        >
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M6 2h12a1 1 0 0 1 1 1v19l-7-4-7 4V3a1 1 0 0 1 1-1z"></path>
                            </svg>
                        </button>
                        <button type="button" class="news-modal-close-x" data-dismiss="modal" aria-label="Cerrar">&times;</button>
                    </div>
                </div>

                <h3 id="readPostTitle" class="news-read-title"></h3>
                <img id="readPostImage" src="" alt="Imagen de la publicación" class="news-read-image d-none">
                <div id="readPostContent" class="news-read-text"></div>

                <div class="news-read-footer">
                    <div>
                        <?php if ($esAdmin): ?>
                            <a
                                href="#"
                                id="readPostDeleteLink"
                                class="btn btn-sm btn-outline-danger rounded-pill px-3 font-weight-bold"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta publicación permanentemente?');"
                            >
                                <i class="fas fa-trash-alt mr-1"></i> Eliminar
                            </a>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4 font-weight-bold" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Crear Nueva Publicación (Solo Admin y Nutricionista) -->
<?php if ($puedeCrear): ?>
<div class="modal fade" id="modalCrearPublicacion" tabindex="-1" role="dialog" aria-labelledby="composePostLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content news-modal-content">
            <form action="<?= base_url('newspaper/guardar') ?>" method="POST" enctype="multipart/form-data" id="formCrearPublicacion">
                <?= csrf_field() ?>
                <input type="hidden" name="origen" value="modal">
                <input type="hidden" name="cat_retorno" value="<?= esc($categoria_actual) ?>">

                <div class="modal-body news-compose-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span id="composePostLabel" class="small font-weight-bold text-muted text-uppercase">Nueva publicación</span>
                        <button type="button" class="news-modal-close-x" data-dismiss="modal" aria-label="Cerrar">&times;</button>
                    </div>

                    <input
                        type="text"
                        name="title"
                        id="composeTitleInput"
                        class="news-asunto-input"
                        placeholder="ASUNTO"
                        value="<?= esc(old('title', '')) ?>"
                        minlength="5"
                        maxlength="150"
                        required
                    >

                    <textarea
                        name="contents"
                        id="composeContentsInput"
                        class="news-content-textarea"
                        placeholder="Toca para escribir"
                        minlength="15"
                        required
                    ><?= esc(old('contents', '')) ?></textarea>

                    <div class="news-compose-footer">
                        <div class="news-compose-options">
                            <select name="category" class="news-compose-select" aria-label="Sección de publicación" required>
                                <option value="general" <?= $categoriaPreseleccionada === 'general' ? 'selected' : '' ?>>General</option>
                                <option value="eventos" <?= $categoriaPreseleccionada === 'eventos' ? 'selected' : '' ?>>Eventos</option>
                                <option value="recetas" <?= $categoriaPreseleccionada === 'recetas' ? 'selected' : '' ?>>Recetas Especiales</option>
                                <?php if ($esAdmin): ?>
                                    <option value="novedades" <?= $categoriaPreseleccionada === 'novedades' ? 'selected' : '' ?>>Novedades (Pro)</option>
                                <?php endif; ?>
                            </select>

                            <label for="composePhotoInput" class="news-file-label">
                                <i class="fas fa-image"></i>
                                <span id="composePhotoName">Imagen opcional</span>
                            </label>
                            <input type="file" id="composePhotoInput" name="foto_post" class="d-none" accept="image/png, image/jpeg, image/jpg">
                        </div>

                        <button type="submit" id="btnPublicarModal" class="news-btn-publicar">
                            Publicar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const postsData       = <?= json_encode($mapaPostsModal, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    const categoriaActual = <?= json_encode($categoria_actual) ?>;
    const toggleBaseUrl   = "<?= base_url('newspaper/guardado') ?>/";

    let csrfName = "<?= csrf_token() ?>";
    let csrfHash = "<?= csrf_hash() ?>";

    // Referencias del Modal de Lectura
    const readAvatar      = document.getElementById('readPostAvatar');
    const readAuthorName  = document.getElementById('readPostAuthorName');
    const readAuthorBadge = document.getElementById('readPostAuthorBadge');
    const readMeta        = document.getElementById('readPostMeta');
    const readTitle       = document.getElementById('readPostTitle');
    const readImage       = document.getElementById('readPostImage');
    const readContent     = document.getElementById('readPostContent');
    const readBookmarkBtn = document.getElementById('readPostBookmarkBtn');
    const readDeleteLink  = document.getElementById('readPostDeleteLink');

    function actualizarEstadoVisualGuardado(postId, estaGuardado) {
        if (postsData[postId]) {
            postsData[postId].is_saved = estaGuardado;
        }

        document.querySelectorAll(`.btn-bookmark-post[data-bookmark-id="${postId}"]`).forEach(btn => {
            btn.classList.toggle('is-saved', estaGuardado);
            const texto = estaGuardado ? 'Quitar de guardados' : 'Guardar publicación';
            btn.setAttribute('aria-label', texto);
            btn.setAttribute('title', texto);
        });

        // Si estamos en el filtro Guardados y se desmarca, quitamos la tarjeta al instante
        if (categoriaActual === 'guardados' && !estaGuardado) {
            const col = document.querySelector(`.news-post-col[data-post-col-id="${postId}"]`);
            if (col) {
                col.remove();
            }

            if (window.jQuery && readBookmarkBtn && String(readBookmarkBtn.dataset.bookmarkId) === String(postId)) {
                window.jQuery('#modalVerPublicacion').modal('hide');
            }

            const restantes = document.querySelectorAll('.news-post-col');
            if (restantes.length === 0) {
                const grid = document.getElementById('newsGridContainer');
                if (grid && !document.getElementById('newsEmptyStateCol')) {
                    grid.insertAdjacentHTML('beforeend', `
                        <div class="col-12 mb-4" id="newsEmptyStateCol">
                            <div class="news-empty-state">
                                <svg class="news-empty-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M4 3h16a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2h-5.6L12 21.6 9.6 18H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm8 3.2c-2 0-3.4 1.15-3.4 2.9h2.05c0-.72.52-1.22 1.3-1.22.74 0 1.22.42 1.22 1.04 0 .56-.32.92-1.08 1.38-.95.56-1.37 1.18-1.33 2.38h2.02c.02-.64.26-1 .98-1.44.96-.58 1.56-1.3 1.56-2.44 0-1.56-1.35-2.6-3.32-2.6zm-.05 7.55a1.25 1.25 0 1 0 0 2.5 1.25 1.25 0 0 0 0-2.5z"></path>
                                </svg>
                                <p class="news-empty-text">Aún no tienes publicaciones guardadas.</p>
                            </div>
                        </div>
                    `);
                }
            }
        }
    }

    function actualizarCsrfEnFormularios(nuevoNombre, nuevoHash) {
        if (!nuevoNombre || !nuevoHash) return;
        csrfName = nuevoNombre;
        csrfHash = nuevoHash;
        document.querySelectorAll(`input[name="${csrfName}"]`).forEach(input => {
            input.value = csrfHash;
        });
    }

    async function alternarGuardado(postId, boton) {
        if (!postId || boton.dataset.loading === '1') return;
        boton.dataset.loading = '1';

        try {
            const body = new window.URLSearchParams();
            body.append(csrfName, csrfHash);

            const resp = await fetch(`${toggleBaseUrl}${postId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                },
                body: body.toString(),
            });

            const data = await resp.json();
            if (data.csrfName && data.csrfHash) {
                actualizarCsrfEnFormularios(data.csrfName, data.csrfHash);
            }

            if (resp.ok && data.success) {
                actualizarEstadoVisualGuardado(postId, Boolean(data.saved));
            } else {
                alert(data.message || 'No se pudo actualizar el estado de guardado.');
            }
        } catch (err) {
            alert('Error de conexión al guardar la publicación.');
        } finally {
            boton.dataset.loading = '0';
        }
    }

    function abrirModalLectura(postId) {
        const post = postsData[postId];
        if (!post) return;

        readAvatar.src = post.autor_avatar_url;
        readAvatar.alt = post.autor_nombre;
        readAuthorName.textContent = post.autor_nombre;

        if (post.autor_badge_url) {
            readAuthorBadge.src = post.autor_badge_url;
            readAuthorBadge.classList.remove('d-none');
        } else {
            readAuthorBadge.src = '';
            readAuthorBadge.classList.add('d-none');
        }

        const metaPartes = [post.category_label];
        if (post.created_at_fmt) metaPartes.push(post.created_at_fmt);
        readMeta.textContent = metaPartes.join(' · ');

        readTitle.textContent = post.title;
        readContent.textContent = post.contents;

        if (post.image_url) {
            readImage.src = post.image_url;
            readImage.alt = post.title;
            readImage.classList.remove('d-none');
        } else {
            readImage.src = '';
            readImage.classList.add('d-none');
        }

        if (readBookmarkBtn) {
            readBookmarkBtn.dataset.bookmarkId = String(post.id);
            readBookmarkBtn.classList.toggle('is-saved', Boolean(post.is_saved));
            const txt = post.is_saved ? 'Quitar de guardados' : 'Guardar publicación';
            readBookmarkBtn.setAttribute('aria-label', txt);
            readBookmarkBtn.setAttribute('title', txt);
        }

        if (readDeleteLink) {
            readDeleteLink.href = post.delete_url;
        }

        if (window.jQuery && typeof window.jQuery('#modalVerPublicacion').modal === 'function') {
            window.jQuery('#modalVerPublicacion').modal('show');
        }
    }

    // Clic en tarjetas para abrir modal de lectura
    document.querySelectorAll('.news-post-card[data-post-id]').forEach(card => {
        card.addEventListener('click', function (e) {
            if (e.target.closest('.btn-bookmark-post') || e.target.closest('.btn-delete-post-link')) {
                return;
            }
            abrirModalLectura(this.dataset.postId);
        });

        card.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                abrirModalLectura(this.dataset.postId);
            }
        });
    });

    // Clic en botones de marcador (tarjetas y modal)
    document.querySelectorAll('.btn-bookmark-post').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const postId = parseInt(this.dataset.bookmarkId, 10);
            if (Number.isInteger(postId) && postId > 0) {
                alternarGuardado(postId, this);
            }
        });
    });

    // Estado dinámico del botón Publicar y nombre de imagen en el modal de redacción
    const composeTitle    = document.getElementById('composeTitleInput');
    const composeContents = document.getElementById('composeContentsInput');
    const btnPublicar     = document.getElementById('btnPublicarModal');
    const composePhoto    = document.getElementById('composePhotoInput');
    const composePhotoTxt = document.getElementById('composePhotoName');

    function actualizarEstadoPublicar() {
        if (!composeTitle || !composeContents || !btnPublicar) return;
        const listo = composeTitle.value.trim().length >= 5 && composeContents.value.trim().length >= 15;
        btnPublicar.classList.toggle('ready', listo);
    }

    if (composeTitle && composeContents) {
        composeTitle.addEventListener('input', actualizarEstadoPublicar);
        composeContents.addEventListener('input', actualizarEstadoPublicar);
        actualizarEstadoPublicar();
    }

    if (composePhoto && composePhotoTxt) {
        composePhoto.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                composePhotoTxt.textContent = this.files[0].name;
            } else {
                composePhotoTxt.textContent = 'Imagen opcional';
            }
        });
    }

    <?php if ($abrirModalCrear && $puedeCrear): ?>
    if (window.jQuery && typeof window.jQuery('#modalCrearPublicacion').modal === 'function') {
        window.jQuery('#modalCrearPublicacion').modal('show');
    }
    <?php endif; ?>
});
</script>

<?= view('template/piepagina') ?>