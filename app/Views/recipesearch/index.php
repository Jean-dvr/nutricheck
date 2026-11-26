<?php
/**
 * Vista: Buscador de Recetas por Despensa
 * @var array $ingredientes_disponibles
 * @var array $recetas_encontradas
 * @var bool  $busqueda_realizada
 */

// Agrupa ingredientes por categoría para organizar la despensa
$ingredientes_agrupados = [];
if (!empty($ingredientes_disponibles)) {
    foreach ($ingredientes_disponibles as $ing) {
        $categoria = ucfirst((string) ($ing['category'] ?? 'General'));
        $ingredientes_agrupados[$categoria][] = $ing;
    }
}

$seleccionadosPost = (isset($_POST['ingredientes']) && is_array($_POST['ingredientes']))
    ? array_map('intval', $_POST['ingredientes'])
    : [];

$filtroTextoPost = (string) ($_POST['filtro_ingrediente'] ?? '');

// Mapa estructurado de recetas para alimentar el modal de detalle sin recargar la vista
$mapaRecetasModal = [];
if (!empty($recetas_encontradas)) {
    foreach ($recetas_encontradas as $r) {
        $rid = (int) $r['id'];
        $mapaRecetasModal[$rid] = [
            'id'                 => $rid,
            'title'              => (string) ($r['title'] ?? ''),
            'image_url'          => !empty($r['image_url']) ? base_url('assets/recipeimg/' . $r['image_url']) : '',
            'prep_time_minutes'  => $r['prep_time_minutes'] ?? null,
            'difficulty'         => (string) ($r['difficulty'] ?? 'media'),
            'portions'           => $r['portions'] ?? null,
            'total_calories'     => $r['total_calories'] ?? null,
            'preparation'        => (string) ($r['preparation'] ?? ''),
            'tags'               => $r['tags'] ?? [],
            'ingredients_detail' => $r['ingredients_detail'] ?? [],
        ];
    }
}
?>
<?= view('template/cabecera') ?>

<style>
    .pantry-container {
        max-height: 460px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #adb5bd #f8f9fa;
    }
    .pantry-container::-webkit-scrollbar { width: 6px; }
    .pantry-container::-webkit-scrollbar-thumb { background-color: #adb5bd; border-radius: 10px; }

    .recipe-header-title-icon {
        width: 34px;
        height: 34px;
        object-fit: contain;
        margin-right: 10px;
        vertical-align: -5px;
    }

    .recipe-header-actions {
        gap: 8px;
    }

    .recipe-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 15px;
        overflow: hidden;
        cursor: pointer;
    }
    .recipe-card:hover,
    .recipe-card:focus {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        outline: none;
    }
    .recipe-img-top {
        height: 180px;
        object-fit: cover;
        background-color: #eee;
    }
    .recipe-open-hint {
        color: #f1682d;
        font-size: 0.78rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .category-header {
        background-color: #e9ecef;
        color: #495057;
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 600;
        margin-top: 15px;
        margin-bottom: 10px;
    }

    /* Estilos del Modal de Receta Ampliada */
    .recipe-modal-content {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
    }
    .recipe-modal-hero {
        position: relative;
        width: 100%;
        height: 260px;
        background-color: #f1f3f5;
        overflow: hidden;
    }
    .recipe-modal-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .recipe-modal-close-float {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.92);
        color: #333333;
        font-size: 1.4rem;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
        cursor: pointer;
        z-index: 5;
        transition: transform 0.18s ease, background-color 0.18s ease;
    }
    .recipe-modal-close-float:hover {
        background: #ffffff;
        transform: scale(1.06);
    }
    .recipe-modal-close-inline {
        border: none;
        background: #f1f3f5;
        color: #495057;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        font-size: 1.3rem;
        line-height: 1;
        cursor: pointer;
        flex-shrink: 0;
    }
    .recipe-modal-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 1.25rem;
    }
    .recipe-stat-box {
        background-color: #f8f9fa;
        border: 1px solid #eef0f2;
        border-radius: 12px;
        padding: 10px 8px;
        text-align: center;
    }
    .recipe-stat-value {
        display: block;
        color: #212529;
        font-weight: 700;
        font-size: 0.92rem;
    }
    .recipe-stat-label {
        display: block;
        color: #6c757d;
        font-size: 0.72rem;
        margin-top: 2px;
    }
    .recipe-modal-section-title {
        color: #f1682d;
        font-weight: 700;
        font-size: 1rem;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 6px;
        margin-bottom: 12px;
    }
    .recipe-ing-list {
        list-style: none;
        padding: 0;
        margin: 0 0 1.35rem 0;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }
    .recipe-ing-item {
        background-color: #fcfcfc;
        border: 1px solid #eceff1;
        border-radius: 10px;
        padding: 8px 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        font-size: 0.86rem;
    }
    .recipe-ing-item.en-despensa {
        background-color: #edf9f0;
        border-color: #b7e4c7;
    }
    .recipe-ing-name {
        font-weight: 600;
        color: #2c2c2c;
    }
    .recipe-ing-qty {
        font-size: 0.8rem;
        font-weight: 700;
        color: #6c757d;
        white-space: nowrap;
    }
    .recipe-prep-box {
        background-color: #fafafa;
        border: 1px solid #eeeeee;
        border-radius: 12px;
        padding: 16px;
        color: #444444;
        font-size: 0.92rem;
        line-height: 1.65;
        white-space: pre-line;
    }

    @media (max-width: 767.98px) {
        .recipe-modal-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .recipe-ing-list {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .recipe-header-title {
            font-size: 1.55rem;
        }
        .recipe-header-title-icon {
            width: 26px;
            height: 26px;
            margin-right: 8px;
            vertical-align: -4px;
        }
        .recipe-header-actions .btn {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
            font-size: 0.85rem;
        }
        .pantry-container {
            max-height: 320px;
        }
        .recipe-modal-hero {
            height: 200px;
        }
    }
</style>

<div class="container mt-4 mb-5">

    <!-- Encabezado -->
    <div class="mb-4 border-bottom pb-3">
        <div class="mb-3">
            <h2 class="recipe-header-title" style="color: #6c757d; font-weight: 700;">
                <img src="<?= base_url('assets/imagenes/iconlupanaranja.png') ?>" alt="" class="recipe-header-title-icon"> Buscador de Recetas
            </h2>
            <p class="text-muted mb-0">Selecciona los ingredientes de tu despensa y las recetas se actualizarán automáticamente.</p>
        </div>
        <div class="d-flex flex-wrap align-items-center recipe-header-actions">
            <?php if (in_array(session()->get('rol'), ['admin', 'nutricionista'], true)): ?>
                <a href="<?= base_url('admin') ?>" class="btn btn-outline-success font-weight-bold rounded-pill px-4 shadow-sm text-nowrap flex-shrink-0">
                    <i class="fas fa-plus"></i> Creador de Recetas
                </a>
            <?php endif; ?>

            <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm text-nowrap flex-shrink-0">
                Volver al Inicio
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Columna izquierda: Despensa -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px; background-color: #fcfcfc;">
                <div class="card-header bg-white border-0 pt-4 pb-2">
                    <h5 class="font-weight-bold text-dark mb-1"> Mi Despensa</h5>

                    <input
                        type="text"
                        id="buscadorIngredientes"
                        name="filtro_ingrediente"
                        form="formBuscador"
                        value="<?= esc($filtroTextoPost) ?>"
                        class="form-control form-control-sm mt-3 rounded-pill"
                        placeholder="Buscar ingrediente rápido..."
                        autocomplete="off"
                    >

                    <!-- Limpiar filtros -->
                    <div class="d-flex mt-3">
                        <button type="button" id="btnLimpiarFiltros" class="btn btn-sm btn-outline-secondary rounded-pill px-3 btn-block">
                            Limpiar filtros
                        </button>
                    </div>
                </div>

                <div class="card-body pt-2">
                    <form action="<?= base_url('recetas') ?>" method="POST" id="formBuscador">
                        <?= csrf_field() ?>

                        <div class="pantry-container px-2 border rounded bg-white shadow-sm mb-3 pb-3" id="listaIngredientes">
                            <?php if (empty($ingredientes_agrupados)): ?>
                                <p class="text-muted small text-center mt-4">No hay ingredientes registrados.</p>
                            <?php else: ?>
                                <?php foreach ($ingredientes_agrupados as $categoria => $ingredientes): ?>
                                    <div class="categoria-grupo">
                                        <div class="category-header text-uppercase small">
                                            <?= esc($categoria) ?>
                                        </div>

                                        <?php foreach ($ingredientes as $ingrediente): ?>
                                            <?php
                                                $idIng            = (int) $ingrediente['id'];
                                                $estaSeleccionado = in_array($idIng, $seleccionadosPost, true) ? 'checked' : '';
                                            ?>
                                            <div class="custom-control custom-checkbox mb-2 ingrediente-item">
                                                <input
                                                    type="checkbox"
                                                    class="custom-control-input filtro-ingrediente-chk"
                                                    name="ingredientes[]"
                                                    value="<?= $idIng ?>"
                                                    id="ing_<?= $idIng ?>"
                                                    <?= $estaSeleccionado ?>
                                                >
                                                <label class="custom-control-label text-dark" for="ing_<?= $idIng ?>" style="cursor: pointer; width: 100%;">
                                                    <span class="nombre-ingrediente"><?= esc($ingrediente['name']) ?></span>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <button
                            type="submit"
                            id="btnBuscarRecetas"
                            class="btn btn-block text-white font-weight-bold shadow-sm rounded-pill"
                            style="background-color: #f7b52c; padding: 11px; transition: 0.3s;"
                            onmouseover="this.style.backgroundColor='#e09f1c'"
                            onmouseout="this.style.backgroundColor='#f7b52c'"
                        >
                            Actualizar búsqueda
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Columna derecha: Resultados -->
        <div class="col-lg-8">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 border-bottom pb-2" style="gap: 8px;">
                <h5 class="font-weight-bold mb-0 text-muted">Resultados de la Búsqueda</h5>
                <span id="contadorRecetas" class="badge badge-pill px-3 py-2 text-nowrap" style="background-color: #fff3ed; color: #f1682d;">
                    <?= count($recetas_encontradas) ?> recetas
                </span>
            </div>

            <div id="sinResultadosBox" class="alert alert-warning border-0 shadow-sm text-center py-5 <?= !empty($recetas_encontradas) ? 'd-none' : '' ?>" style="border-radius: 15px; background-color: #fff8f3;">
                <h1 class="mb-3" style="font-size: 4rem;">🚫</h1>
                <h5 class="font-weight-bold text-danger">No encontramos recetas con esa combinación</h5>
                <p class="text-muted mb-0 px-md-5">Prueba desmarcando algún ingrediente o usando <strong>Limpiar filtros</strong> para ver todas las recetas seguras disponibles.</p>
            </div>

            <div class="row" id="contenedorRecetas">
                <?php foreach ($recetas_encontradas as $receta): ?>
                    <?php
                        $ingIdsString = implode(',', array_map('intval', $receta['ingredient_ids'] ?? []));
                    ?>
                    <div
                        class="col-md-6 mb-4 receta-card-item"
                        data-ingredientes="<?= esc($ingIdsString) ?>"
                    >
                        <div
                            class="card recipe-card shadow-sm border-0 h-100"
                            role="button"
                            tabindex="0"
                            data-recipe-id="<?= (int) $receta['id'] ?>"
                            aria-label="Ver detalles completos de <?= esc($receta['title']) ?>"
                        >
                            <?php if (!empty($receta['image_url'])): ?>
                                <img src="<?= base_url('assets/recipeimg/' . esc($receta['image_url'])) ?>" class="card-img-top recipe-img-top" alt="<?= esc($receta['title']) ?>" onerror="this.src=''">
                            <?php else: ?>
                                <img src="" class="card-img-top recipe-img-top" alt="Receta deliciosa">
                            <?php endif; ?>

                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="font-weight-bold text-dark mb-0"><?= esc($receta['title']) ?></h5>
                                </div>

                                <div class="mb-3">
                                    <span class="badge badge-success px-2 py-1 mr-1 mb-1"><i class="fas fa-check-circle"></i> Segura</span>
                                    <?php if (!empty($receta['tags'])): ?>
                                        <?php foreach ($receta['tags'] as $tag): ?>
                                            <span class="badge badge-pill text-white mr-1 mb-1" style="background-color: <?= esc($tag['color_hex'] ?? '#6c757d') ?>;">
                                                <?= esc($tag['name']) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex justify-content-center text-muted small mb-3 p-2 rounded" style="background-color: #f8f9fa;">
                                    <div class="text-center w-50 border-right" title="Tiempo de preparación">
                                        <span class="d-block text-dark font-weight-bold">⏱ <?= esc($receta['prep_time_minutes'] ?? '--') ?></span> min
                                    </div>
                                    <div class="text-center w-50" title="Dificultad">
                                        <span class="d-block text-dark font-weight-bold text-capitalize">🍳 <?= esc($receta['difficulty'] ?? 'Media') ?></span> Dificultad
                                    </div>
                                </div>

                                <p class="card-text text-muted small flex-grow-1 mb-3" style="display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= esc($receta['preparation']) ?>
                                </p>

                                <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">
                                        🔥 <?= !empty($receta['total_calories']) ? esc($receta['total_calories']) . ' kcal' : '-- kcal' ?>
                                    </span>
                                    <span class="recipe-open-hint">
                                        Ver receta completa <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<!-- Modal Popup: Vista Ampliada de Receta -->
<div class="modal fade" id="modalDetalleReceta" tabindex="-1" role="dialog" aria-labelledby="modalRecetaTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content recipe-modal-content shadow-lg">

            <div class="recipe-modal-hero" id="modalRecetaHero">
                <img id="modalRecetaImg" src="" alt="Imagen de la receta">
                <button type="button" class="recipe-modal-close-float" data-dismiss="modal" aria-label="Cerrar">&times;</button>
            </div>

            <div class="modal-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h4 id="modalRecetaTitulo" class="font-weight-bold text-dark mb-0 pr-2"></h4>
                    <button type="button" id="modalRecetaCloseInline" class="recipe-modal-close-inline d-none" data-dismiss="modal" aria-label="Cerrar">&times;</button>
                </div>

                <!-- Etiquetas -->
                <div id="modalRecetaTags" class="mb-3"></div>

                <!-- Resumen de Métricas: Tiempo, Dificultad, Calorías y Porciones -->
                <div class="recipe-modal-stats">
                    <div class="recipe-stat-box">
                        <span class="recipe-stat-value" id="modalRecetaTiempo">--</span>
                        <span class="recipe-stat-label">Tiempo</span>
                    </div>
                    <div class="recipe-stat-box">
                        <span class="recipe-stat-value" id="modalRecetaDificultad">--</span>
                        <span class="recipe-stat-label">Dificultad</span>
                    </div>
                    <div class="recipe-stat-box">
                        <span class="recipe-stat-value" id="modalRecetaCalorias">--</span>
                        <span class="recipe-stat-label">Calorías</span>
                    </div>
                    <div class="recipe-stat-box">
                        <span class="recipe-stat-value" id="modalRecetaPorciones">--</span>
                        <span class="recipe-stat-label">Porciones</span>
                    </div>
                </div>

                <!-- Lista de Ingredientes -->
                <h6 class="recipe-modal-section-title">🛒 Ingredientes</h6>
                <ul id="modalRecetaIngredientes" class="recipe-ing-list"></ul>

                <!-- Preparación Completa -->
                <h6 class="recipe-modal-section-title">📝 Preparación</h6>
                <div id="modalRecetaPreparacion" class="recipe-prep-box"></div>
            </div>

            <div class="modal-footer bg-light border-0 py-2 px-3 px-md-4">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 font-weight-bold" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const buscador        = document.getElementById('buscadorIngredientes');
    const btnLimpiar      = document.getElementById('btnLimpiarFiltros');
    const checkboxes      = Array.from(document.querySelectorAll('.filtro-ingrediente-chk'));
    const tarjetasRecetas = Array.from(document.querySelectorAll('.receta-card-item'));
    const cardsClickables = Array.from(document.querySelectorAll('.recipe-card[data-recipe-id]'));
    const sinResultados   = document.getElementById('sinResultadosBox');
    const contadorRecetas = document.getElementById('contadorRecetas');

    // Datos completos de cada receta indexados por ID para el popup
    const recetasData = <?= json_encode($mapaRecetasModal, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

    // Elementos del modal
    const modalHero         = document.getElementById('modalRecetaHero');
    const modalImg          = document.getElementById('modalRecetaImg');
    const modalCloseInline  = document.getElementById('modalRecetaCloseInline');
    const modalTitulo       = document.getElementById('modalRecetaTitulo');
    const modalTags         = document.getElementById('modalRecetaTags');
    const modalTiempo       = document.getElementById('modalRecetaTiempo');
    const modalDificultad   = document.getElementById('modalRecetaDificultad');
    const modalCalorias     = document.getElementById('modalRecetaCalorias');
    const modalPorciones    = document.getElementById('modalRecetaPorciones');
    const modalIngredientes = document.getElementById('modalRecetaIngredientes');
    const modalPreparacion  = document.getElementById('modalRecetaPreparacion');

    function obtenerIdsReceta(card) {
        const raw = (card.dataset.ingredientes || '').trim();
        if (!raw) return [];
        return raw.split(',')
            .map(v => parseInt(v, 10))
            .filter(n => Number.isInteger(n) && n > 0);
    }

    function obtenerSeleccionadosActuales() {
        return checkboxes
            .filter(chk => chk.checked)
            .map(chk => parseInt(chk.value, 10))
            .filter(n => Number.isInteger(n) && n > 0);
    }

    function formatearDificultad(valor) {
        const mapa = {
            facil: 'Fácil',
            media: 'Media',
            dificil: 'Difícil'
        };
        const clave = String(valor || 'media').toLowerCase().trim();
        return mapa[clave] || (clave.charAt(0).toUpperCase() + clave.slice(1));
    }

    function formatearCantidad(qty, unit) {
        const partes = [];
        if (qty !== null && qty !== undefined && String(qty).trim() !== '') {
            const num = parseFloat(qty);
            partes.push(Number.isNaN(num) ? String(qty).trim() : String(num));
        }
        if (unit && String(unit).trim() !== '') {
            partes.push(String(unit).trim());
        }
        return partes.join(' ');
    }

    function abrirModalReceta(recipeId) {
        const receta = recetasData[recipeId];
        if (!receta) return;

        // Imagen superior (si falla o no existe, se oculta el hero y se muestra la X inline)
        if (receta.image_url) {
            modalHero.classList.remove('d-none');
            modalCloseInline.classList.add('d-none');
            modalImg.onerror = function () {
                modalHero.classList.add('d-none');
                modalCloseInline.classList.remove('d-none');
            };
            modalImg.src = receta.image_url;
            modalImg.alt = receta.title;
        } else {
            modalHero.classList.add('d-none');
            modalCloseInline.classList.remove('d-none');
            modalImg.src = '';
        }

        modalTitulo.textContent = receta.title || 'Receta';

        // Etiquetas
        modalTags.innerHTML = '';
        const badgeSegura = document.createElement('span');
        badgeSegura.className = 'badge badge-success px-2 py-1 mr-1 mb-1';
        badgeSegura.innerHTML = '<i class="fas fa-check-circle"></i> Segura';
        modalTags.appendChild(badgeSegura);

        if (Array.isArray(receta.tags)) {
            receta.tags.forEach(tag => {
                const span = document.createElement('span');
                span.className = 'badge badge-pill text-white mr-1 mb-1 px-2 py-1';
                span.style.backgroundColor = tag.color_hex || '#6c757d';
                span.textContent = tag.name || '';
                modalTags.appendChild(span);
            });
        }

        // Métricas
        modalTiempo.textContent = receta.prep_time_minutes ? `⏱ ${receta.prep_time_minutes} min` : '⏱ --';
        modalDificultad.textContent = `🍳 ${formatearDificultad(receta.difficulty)}`;
        modalCalorias.textContent = receta.total_calories ? `🔥 ${receta.total_calories} kcal` : '🔥 --';

        const porcionesNum = parseInt(receta.portions, 10);
        if (Number.isInteger(porcionesNum) && porcionesNum > 0) {
            modalPorciones.textContent = `🍽️ ${porcionesNum} ${porcionesNum === 1 ? 'porción' : 'porciones'}`;
        } else {
            modalPorciones.textContent = '🍽️ --';
        }

        // Lista de ingredientes detallados
        const seleccionados = obtenerSeleccionadosActuales();
        modalIngredientes.innerHTML = '';

        if (Array.isArray(receta.ingredients_detail) && receta.ingredients_detail.length > 0) {
            receta.ingredients_detail.forEach(ing => {
                const li = document.createElement('li');
                const estaEnDespensa = seleccionados.includes(parseInt(ing.ingredient_id, 10));
                li.className = 'recipe-ing-item' + (estaEnDespensa ? ' en-despensa' : '');

                const leftWrap = document.createElement('div');
                const nombreSpan = document.createElement('span');
                nombreSpan.className = 'recipe-ing-name';
                nombreSpan.textContent = (estaEnDespensa ? '✓ ' : '') + (ing.name || '');
                leftWrap.appendChild(nombreSpan);

                if (parseInt(ing.is_main_ingredient, 10) === 1) {
                    const badgeMain = document.createElement('span');
                    badgeMain.className = 'badge badge-pill ml-1';
                    badgeMain.style.backgroundColor = '#fff3ed';
                    badgeMain.style.color = '#f1682d';
                    badgeMain.style.fontSize = '0.68rem';
                    badgeMain.textContent = 'Principal';
                    leftWrap.appendChild(badgeMain);
                }

                const qtySpan = document.createElement('span');
                qtySpan.className = 'recipe-ing-qty';
                qtySpan.textContent = formatearCantidad(ing.quantity, ing.unit_of_measure);

                li.appendChild(leftWrap);
                li.appendChild(qtySpan);
                modalIngredientes.appendChild(li);
            });
        } else {
            const liVacio = document.createElement('li');
            liVacio.className = 'text-muted small';
            liVacio.textContent = 'No hay ingredientes detallados para esta receta.';
            modalIngredientes.appendChild(liVacio);
        }

        // Preparación completa
        modalPreparacion.textContent = receta.preparation || 'Sin instrucciones de preparación registradas.';

        if (window.jQuery && typeof window.jQuery('#modalDetalleReceta').modal === 'function') {
            window.jQuery('#modalDetalleReceta').modal('show');
        }
    }

    cardsClickables.forEach(card => {
        card.addEventListener('click', function () {
            abrirModalReceta(this.dataset.recipeId);
        });
        card.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                abrirModalReceta(this.dataset.recipeId);
            }
        });
    });

    function filtrarRecetasEnVivo() {
        const seleccionados = obtenerSeleccionadosActuales();
        let visiblesCount = 0;

        tarjetasRecetas.forEach(card => {
            const ingReceta = obtenerIdsReceta(card);

            const mostrar = (seleccionados.length === 0)
                ? true
                : seleccionados.every(id => ingReceta.includes(id));

            card.style.display = mostrar ? '' : 'none';
            if (mostrar) visiblesCount++;
        });

        if (contadorRecetas) {
            contadorRecetas.textContent = `${visiblesCount} ${visiblesCount === 1 ? 'receta' : 'recetas'}`;
        }
        if (sinResultados) {
            sinResultados.classList.toggle('d-none', visiblesCount > 0);
        }
    }

    function filtrarListaIngredientes() {
        if (!buscador) return;
        const filtro = buscador.value.toLowerCase().trim();

        document.querySelectorAll('.ingrediente-item').forEach(item => {
            const nombre = item.querySelector('.nombre-ingrediente').textContent.toLowerCase();
            item.style.display = nombre.includes(filtro) ? '' : 'none';
        });

        document.querySelectorAll('.categoria-grupo').forEach(grupo => {
            const hayVisibles = Array.from(grupo.querySelectorAll('.ingrediente-item'))
                .some(el => el.style.display !== 'none');
            const encabezado = grupo.querySelector('.category-header');
            if (encabezado) {
                encabezado.style.display = hayVisibles ? '' : 'none';
            }
        });
    }

    checkboxes.forEach(chk => chk.addEventListener('change', filtrarRecetasEnVivo));

    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', function () {
            checkboxes.forEach(chk => { chk.checked = false; });
            if (buscador) {
                buscador.value = '';
                filtrarListaIngredientes();
            }
            filtrarRecetasEnVivo();
        });
    }

    if (buscador) {
        buscador.addEventListener('input', filtrarListaIngredientes);
    }

    filtrarListaIngredientes();
    filtrarRecetasEnVivo();
});
</script>

<?= view('template/piepagina') ?>