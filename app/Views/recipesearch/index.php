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
    
    /* Estilo del botón naranja */
    .btn-naranja-solido {
        background-color: #f1682d !important; /* Relleno naranja fijo */
        border: 2px solid #f1682d !important; /* Borde del mismo color */
        color: #ffffff !important;            /* Letras blancas */
        border-radius: 50rem !important;      /* Forma redonda (pill) */
        transition: background-color 0.3s ease, border-color 0.3s ease;
        display: block;
        width: 100%;
        text-align: center;
        padding: 0.25rem 0.5rem;
        text-decoration: none;
    }

    .btn-naranja-solido:hover {
        background-color: #d65a25 !important; /* Un poco más oscuro al pasar el mouse */
        border-color: #d65a25 !important;
        color: #ffffff !important;
    }
</style>
    
<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 style="color: #f1682d; font-weight: 700;"><i class="fas fa-book-medical"></i> Buscador de Recetas</h2>
            <p class="text-muted mb-0">Selecciona los ingredientes que tienes en casa y verás recetas que puedes preparar.</p>
        </div>
        <div class="d-flex align-items-center">
            <?php if(session()->get('rol') === 'admin' || session()->get('rol') === 'nutricionista'): ?>
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
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px; background-color: #fcfcfc;">
                <div class="card-header bg-white border-0 pt-4 pb-2">
                    <h5 class="font-weight-bold text-dark mb-1">🛒 Mi Despensa</h5>
                    <input type="text" id="buscadorIngredientes" class="form-control form-control-sm mt-3 rounded-pill" placeholder="🔍 Buscar ingrediente rápido...">
                </div>
                
                <div class="card-body pt-2">
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
                                                $estaSeleccionado = (isset($_POST['ingredientes']) && is_array($_POST['ingredientes']) && in_array($ingrediente['id'], $_POST['ingredientes'])) ? 'checked' : '';
                                            ?>
                                            <div class="custom-control custom-checkbox mb-2 ingrediente-item">
                                                <input type="checkbox" class="custom-control-input" name="ingredientes[]" value="<?= $ingrediente['id'] ?>" id="ing_<?= $ingrediente['id'] ?>" <?= $estaSeleccionado ?>>
                                                <label class="custom-control-label text-dark" for="ing_<?= $ingrediente['id'] ?>" style="cursor: pointer; width: 100%;">
                                                    <span class="nombre-ingrediente"><?= esc($ingrediente['name']) ?></span>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                                
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-block text-white font-weight-bold shadow-sm rounded-pill" style="background-color: #f1682d; padding: 12px; transition: 0.3s;" onmouseover="this.style.backgroundColor='#d05623'" onmouseout="this.style.backgroundColor='#f1682d'">
                            Buscar recetas
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <h5 class="font-weight-bold mb-3 text-muted border-bottom pb-2">Resultados de la Búsqueda</h5>
            
            <?php if(!$busqueda_realizada): ?>
                <div class="alert alert-light border shadow-sm text-center py-5" style="border-radius: 15px;">
                    <h1 class="mb-3" style="font-size: 4rem;">🥗</h1>
                    <h5 class="font-weight-bold text-dark">¿Qué hay para comer?</h5>
                    <p class="text-muted mb-0">Selecciona los ingredientes de tu despensa a la izquierda y presiona "Buscar recetas" para descubrir recetas seguras para ti.</p>
                </div>
                
            <?php elseif($busqueda_realizada && empty($recetas_encontradas)): ?>
                <div class="alert alert-warning border-0 shadow-sm text-center py-5" style="border-radius: 15px; background-color: #fff8f3;">
                    <h1 class="mb-3" style="font-size: 4rem;">🚫</h1>
                    <h5 class="font-weight-bold text-danger">No encontramos recetas viables</h5>
                    <p class="text-muted mb-0 px-md-5">Con los ingredientes que marcaste no logramos armar un plato completo, o las opciones disponibles contienen elementos que podrían <strong>afectar tu cuadro clínico</strong>.</p>
                    <p class="small text-muted mt-3">¡Intenta agregar ingredientes básicos como sal, aceite o condimentos a tu selección!</p>
                </div>
                
            <?php else: ?>
                <div class="row">
                    <?php foreach($recetas_encontradas as $receta): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card recipe-card shadow-sm border-0 h-100">
                                
                                <?php if(!empty($receta['image_url'])): ?>
                                    <img src="<?= base_url('assets/recipeimg/' . esc($receta['image_url'])) ?>" class="card-img-top recipe-img-top" alt="<?= esc($receta['title']) ?>" onerror="this.src=''">
                                <?php else: ?>
                                    <img src="" class="card-img-top recipe-img-top" alt="Receta deliciosa">
                                <?php endif; ?>
                                
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="font-weight-bold text-dark mb-0 line-clamp-2"><?= esc($receta['title']) ?></h5>
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
                                    
                                    <button type="button" 
                                            class="btn btn-naranja-solido btn-sm mt-3" 
                                            data-toggle="modal" 
                                            data-target="#modalDetalleReceta"
                                            data-title="<?= esc($receta['title']) ?>"
                                            data-prep="<?= esc($receta['preparation']) ?>">
                                        Ver preparación detallada
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="modalDetalleReceta" tabindex="-1" role="dialog" aria-labelledby="tituloModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal" style="color: #f1682d; font-weight: bold;"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="font-weight-bold">Instrucciones de preparación:</h6>
                    <div id="cuerpoPreparacion" style="white-space: pre-line;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscadorIngredientes');
    if(buscador) {
        buscador.addEventListener('keyup', function() {
            let filtro = this.value.toLowerCase();
            let ingredientes = document.querySelectorAll('.ingrediente-item');
            
            ingredientes.forEach(function(item) {
                let texto = item.querySelector('.nombre-ingrediente').textContent.toLowerCase();
                if(texto.indexOf(filtro) > -1) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
            
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

$('#modalDetalleReceta').on('show.bs.modal', function (event) {
    // Botón que disparó el modal
    var button = $(event.relatedTarget); 
    
    // Extraer la información de los atributos data-*
    var titulo = button.data('title');
    var preparacion = button.data('prep');
    
    // Seleccionar el modal
    var modal = $(this);
    
    // Cambiar el contenido del modal
    modal.find('.modal-title').text(titulo);
    modal.find('#cuerpoPreparacion').text(preparacion);
});
</script>

<?= view('template/piepagina') ?>