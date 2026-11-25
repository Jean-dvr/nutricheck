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
?>
<?= view('template/cabecera') ?>

<style>
    .pantry-container {
        max-height: 460px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #f1682d #fcfcfc;
    }
    .pantry-container::-webkit-scrollbar { width: 6px; }
    .pantry-container::-webkit-scrollbar-thumb { background-color: #f1682d; border-radius: 10px; }

    .recipe-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 15px;
        overflow: hidden;
    }
    .recipe-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .recipe-img-top {
        height: 180px;
        object-fit: cover;
        background-color: #eee;
    }
    .category-header {
        background-color: #fff3ed;
        color: #f1682d;
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 600;
        margin-top: 15px;
        margin-bottom: 10px;
    }
</style>

<div class="container mt-4 mb-5">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 style="color: #f1682d; font-weight: 700;"><i class="fas fa-book-medical"></i> Buscador de Recetas</h2>
            <p class="text-muted mb-0">Selecciona los ingredientes de tu despensa y las recetas se actualizarán automáticamente.</p>
        </div>
        <div class="d-flex align-items-center">
            <?php if (in_array(session()->get('rol'), ['admin', 'nutricionista'], true)): ?>
                <a href="<?= base_url('admin') ?>" class="btn btn-outline-success font-weight-bold rounded-pill px-4 mr-2 shadow-sm">
                    <i class="fas fa-plus"></i> Creador de Recetas
                </a>
            <?php endif; ?>

            <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                Volver al Inicio
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Columna izquierda: Despensa -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px; background-color: #fcfcfc;">
                <div class="card-header bg-white border-0 pt-4 pb-2">
                    <h5 class="font-weight-bold text-dark mb-1">🛒 Mi Despensa</h5>

                    <input
                        type="text"
                        id="buscadorIngredientes"
                        name="filtro_ingrediente"
                        form="formBuscador"
                        value="<?= esc($filtroTextoPost) ?>"
                        class="form-control form-control-sm mt-3 rounded-pill"
                        placeholder="🔍 Buscar ingrediente rápido..."
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
                            style="background-color: #f1682d; padding: 11px; transition: 0.3s;"
                            onmouseover="this.style.backgroundColor='#d05623'"
                            onmouseout="this.style.backgroundColor='#f1682d'"
                        >
                            Actualizar búsqueda
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Columna derecha: Resultados -->
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h5 class="font-weight-bold mb-0 text-muted">Resultados de la Búsqueda</h5>
                <span id="contadorRecetas" class="badge badge-pill px-3 py-2" style="background-color: #fff3ed; color: #f1682d;">
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
                        <div class="card recipe-card shadow-sm border-0 h-100">
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
                                        <span class="d-block text-dark font-weight-bold">⏱️ <?= esc($receta['prep_time_minutes'] ?? '--') ?></span> min
                                    </div>
                                    <div class="text-center w-50" title="Dificultad">
                                        <span class="d-block text-dark font-weight-bold text-capitalize">🍳 <?= esc($receta['difficulty'] ?? 'Media') ?></span> Dificultad
                                    </div>
                                </div>

                                <p class="card-text text-muted small flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= esc($receta['preparation']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
    const sinResultados   = document.getElementById('sinResultadosBox');
    const contadorRecetas = document.getElementById('contadorRecetas');

    function obtenerIdsReceta(card) {
        const raw = (card.dataset.ingredientes || '').trim();
        if (!raw) return [];
        return raw.split(',')
            .map(v => parseInt(v, 10))
            .filter(n => Number.isInteger(n) && n > 0);
    }

    function filtrarRecetasEnVivo() {
        const seleccionados = checkboxes
            .filter(chk => chk.checked)
            .map(chk => parseInt(chk.value, 10))
            .filter(n => Number.isInteger(n) && n > 0);

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
```[cite: 35, 37]