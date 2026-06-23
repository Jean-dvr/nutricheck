<?php
/**
 * Variables inyectadas por el Controlador RecipeSearch
 * @var array $ingredientes_disponibles
 * @var array $recetas_encontradas
 * @var bool $busqueda_realizada
 */

// Agrupamos los ingredientes por su categoría para que la vista sea más ordenada
$ingredientes_agrupados = [];
if (!empty($ingredientes_disponibles)) {
    foreach ($ingredientes_disponibles as $ing) {
        $categoria = ucfirst($ing['category']);
        $ingredientes_agrupados[$categoria][] = $ing;
    }
}
?>
<?= view('template/cabecera') ?>

<style>
    /* Estilos personalizados para darle un toque Premium */
    .pantry-container {
        max-height: 500px;
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
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
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
    
    <!-- Encabezado de la página -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 style="color: #f1682d; font-weight: 700;"><i class="fas fa-book-medical"></i> Buscador de Recetas</h2>
            <p class="text-muted mb-0">Selecciona los ingredientes que tienes en casa y verás recetas que puedes preparar.</p>
        </div>
        <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-4">
            Volver al Inicio
        </a>
    </div>

    <!-- Alertas -->
    <?php if(session()->getFlashdata('fail')): ?>
        <div class="alert alert-danger shadow-sm rounded border-0 border-left border-danger" style="border-left-width: 5px !important;">
            <strong>¡Atención!</strong> <?= session()->getFlashdata('fail') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- COLUMNA IZQUIERDA: LA DESPENSA -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px; background-color: #fcfcfc;">
                <div class="card-header bg-white border-0 pt-4 pb-2">
                    <h5 class="font-weight-bold text-dark mb-1">🛒 Mi Despensa</h5>
                    
                    <!-- Buscador en vivo interactivo -->
                    <input type="text" id="buscadorIngredientes" class="form-control form-control-sm mt-3 rounded-pill" placeholder="🔍 Buscar ingrediente rápido...">
                </div>
                
                <div class="card-body pt-2">
                    <!-- CORRECCIÓN DE RUTA AQUÍ: Volvemos a 'recetas' -->
                    <form action="<?= base_url('recetas') ?>" method="POST" id="formBuscador">
                        <?= csrf_field() ?>
                        
                        <div class="pantry-container px-2 border rounded bg-white shadow-sm mb-4 pb-3" id="listaIngredientes">
                            <?php if(empty($ingredientes_agrupados)): ?>
                                <p class="text-muted small text-center mt-4">No hay ingredientes registrados.</p>
                            <?php else: ?>
                                
                                <?php foreach($ingredientes_agrupados as $categoria => $ingredientes): ?>
                                    <div class="categoria-grupo">
                                        <div class="category-header text-uppercase small">
                                            <?= esc($categoria) ?>
                                        </div>
                                        
                                        <?php foreach($ingredientes as $ingrediente): ?>
                                            <?php 
                                                // Verificar si este ingrediente fue seleccionado previamente
                                                $estaSeleccionado = (isset($_POST['ingredientes']) && is_array($_POST['ingredientes']) && in_array($ingrediente['id'], $_POST['ingredientes'])) ? 'checked' : '';
                                            ?>
                                            <div class="custom-control custom-checkbox mb-2 ingrediente-item">
                                                <input type="checkbox" class="custom-control-input" name="ingredientes[]" value="<?= $ingrediente['id'] ?>" id="ing_<?= $ingrediente['id'] ?>" <?= $estaSeleccionado ?>>
                                                <label class="custom-control-label text-dark" for="ing_<?= $ingrediente['id'] ?>" style="cursor: pointer; width: 100%;">
                                                    <span class="nombre-ingrediente"><?= esc($ingrediente['name']) ?></span>
                                                <!--<span class="float-right text-muted small mt-1"><?= esc($ingrediente['calories_per_100g']) ?> kcal</span>
                                                </label> (Oculto para proximas actualizaciones (calorias de)) -->
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                                
                            <?php endif; ?>
                        </div>

                        <!-- MODIFICACIÓN DE BOTÓN AQUÍ -->
                        <button type="submit" class="btn btn-block text-white font-weight-bold shadow-sm rounded-pill" style="background-color: #f1682d; padding: 12px; transition: 0.3s;" onmouseover="this.style.backgroundColor='#d05623'" onmouseout="this.style.backgroundColor='#f1682d'">
                            Buscar recetas
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- COLUMNA DERECHA: RESULTADOS -->
        <div class="col-lg-8">
            <h5 class="font-weight-bold mb-3 text-muted border-bottom pb-2">Resultados de la Búsqueda</h5>
            
            <?php if(!$busqueda_realizada): ?>
                <!-- ESTADO: Aún no busca nada -->
                <div class="alert alert-light border shadow-sm text-center py-5" style="border-radius: 15px;">
                    <h1 class="mb-3" style="font-size: 4rem;">🥗</h1>
                    <h5 class="font-weight-bold text-dark">¿Qué hay para comer?</h5>
                    <p class="text-muted mb-0">Selecciona los ingredientes de tu despensa a la izquierda y presiona "Buscar recetas" para descubrir recetas seguras para ti.</p>
                </div>
                
            <?php elseif($busqueda_realizada && empty($recetas_encontradas)): ?>
                <!-- ESTADO: Buscó pero no encontró (o hace daño) -->
                <div class="alert alert-warning border-0 shadow-sm text-center py-5" style="border-radius: 15px; background-color: #fff8f3;">
                    <h1 class="mb-3" style="font-size: 4rem;">🚫</h1>
                    <h5 class="font-weight-bold text-danger">No encontramos recetas viables</h5>
                    <p class="text-muted mb-0 px-md-5">Con los ingredientes que marcaste no logramos armar un plato completo, o las opciones disponibles contienen elementos que podrían <strong>afectar tu cuadro clínico</strong>.</p>
                    <p class="small text-muted mt-3">¡Intenta agregar ingredientes básicos como sal, aceite o condimentos a tu selección!</p>
                </div>
                
            <?php else: ?>
                <!-- ESTADO: Recetas encontradas con éxito -->
                <div class="row">
                    <?php foreach($recetas_encontradas as $receta): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card recipe-card shadow-sm border-0 h-100">
                                
                                <!-- Imagen de la receta -->
                                <?php if(!empty($receta['image_url'])): ?>
                                    <img src="<?= base_url('assets/recipeimg/' . esc($receta['image_url'])) ?>" class="card-img-top recipe-img-top" alt="<?= esc($receta['title']) ?>" onerror="this.src=''">
                                <?php else: ?>
                                    <img src="" class="card-img-top recipe-img-top" alt="Receta deliciosa">
                                <?php endif; ?>
                                
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="font-weight-bold text-dark mb-0 line-clamp-2"><?= esc($receta['title']) ?></h5>
                                    </div>
                                    
                                    <!-- Badges de Tags y Seguridad -->
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

                                    <!-- Estadísticas de la receta -->
                                    <div class="d-flex justify-content-center text-muted small mb-3 p-2 rounded" style="background-color: #f8f9fa;">
                                    <!--<div class="text-center w-33" title="Calorías">
                                            <span class="d-block text-danger font-weight-bold">🔥 <?= esc($receta['total_calories']) ?></span> kcal
                                        </div>-->
                                        <div class="text-center w-50 border-right" title="Tiempo de preparación">
                                            <span class="d-block text-dark font-weight-bold">⏱️ <?= esc($receta['prep_time_minutes'] ?? '--') ?></span> min
                                        </div>
                                        <div class="text-center w-50" title="Dificultad">
                                            <span class="d-block text-dark font-weight-bold text-capitalize">🍳 <?= esc($receta['difficulty'] ?? 'Media') ?></span> Dificultad
                                        </div>
                                    </div>
                                    
                                    <p class="card-text text-muted small flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?= esc($receta['preparation']) ?>
                                    </p>
                                    
                                    <!-- Botón para ver más detalles en el futuro -->
                                    <button class="btn btn-outline-primary btn-sm rounded-pill btn-block mt-3" style="border-color: #f1682d; color: #f1682d;" onmouseover="this.style.backgroundColor='#f1682d'; this.style.color='#fff'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#f1682d'">
                                        Ver Preparación Detallada
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Script de JavaScript para la interactividad del buscador de despensa -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscadorIngredientes');
    
    if(buscador) {
        buscador.addEventListener('keyup', function() {
            let filtro = this.value.toLowerCase();
            let ingredientes = document.querySelectorAll('.ingrediente-item');
            
            // Filtrar los items individuales
            ingredientes.forEach(function(item) {
                let texto = item.querySelector('.nombre-ingrediente').textContent.toLowerCase();
                if(texto.indexOf(filtro) > -1) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
            
            // Ocultar las cabeceras de categoría si no tienen items visibles
            let categorias = document.querySelectorAll('.categoria-grupo');
            categorias.forEach(function(cat) {
                let itemsVisibles = Array.from(cat.querySelectorAll('.ingrediente-item')).filter(i => i.style.display !== 'none');
                if(itemsVisibles.length === 0) {
                    cat.querySelector('.category-header').style.display = 'none';
                } else {
                    cat.querySelector('.category-header').style.display = '';
                }
            });
        });
    }
});
</script>

<?= view('template/piepagina') ?>