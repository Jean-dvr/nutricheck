<?php
/**
 * @var array $ingredientes
 * @var array $etiquetas
 * @var array $recetas
 */
?>
<?= view('template/cabecera') ?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 style="color: #f1682d; font-weight: 700;"><i class="fas fa-tools"></i> Creador de Recetas</h2>
            <p class="text-muted mb-0">Centro de creación y gestión de contenido nutricional.</p>
        </div>
        <a href="<?= base_url('recetas') ?>" class="btn btn-outline-secondary rounded-pill px-4">Volver al Buscador</a>
    </div>

    <ul class="nav nav-tabs font-weight-bold" id="adminTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active text-dark" id="receta-tab" data-toggle="tab" href="#receta" role="tab">🍳 Armar Receta</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" id="gestionar-tab" data-toggle="tab" href="#gestionar" role="tab">📜 Gestionar Recetas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" id="ingrediente-tab" data-toggle="tab" href="#ingrediente" role="tab">🥑 Nuevo Ingrediente</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" id="etiqueta-tab" data-toggle="tab" href="#etiqueta" role="tab">🏷️ Etiquetas</a>
        </li>
    </ul>

    <div class="tab-content border border-top-0 rounded-bottom p-4 bg-white shadow-sm" id="adminTabsContent">
        
        <div class="tab-pane fade show active" id="receta" role="tabpanel">
            <form action="<?= base_url('admin/guardarReceta') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <h5 class="font-weight-bold mb-3 border-bottom pb-2">Información Básica</h5>
                <div class="row">
                    <div class="col-md-8 form-group">
                        <label>Título de la Receta</label>
                        <input type="text" name="title" class="form-control" required placeholder="Ej. Ensalada César Fit">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Foto del Plato</label>
                        <input type="file" name="imagen" id="inputImagen" class="form-control-file" accept="image/*" onchange="mostrarPrevisualizacion(event)">
                        <img id="imgPreview" src="#" alt="Previsualización" style="display:none; max-width: 120px; margin-top: 10px; border-radius: 8px; border: 1px solid #ddd;">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Tiempo (Minutos)</label>
                        <input type="number" name="prep_time" class="form-control" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Calorías Totales</label>
                        <input type="number" name="total_calories" class="form-control" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Dificultad</label>
                        <select name="difficulty" class="form-control" required>
                            <option value="facil">Fácil</option>
                            <option value="media" selected>Media</option>
                            <option value="dificil">Difícil</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Porciones</label>
                        <input type="number" name="portions" class="form-control" value="1" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Preparación (Instrucciones paso a paso)</label>
                    <textarea name="preparation" class="form-control" rows="4" required></textarea>
                </div>

                <h5 class="font-weight-bold mt-4 mb-3 border-bottom pb-2">Etiquetas (Opcional)</h5>
                <div class="mb-4">
                    <?php foreach($etiquetas as $tag): ?>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="tag_<?= $tag['id'] ?>" name="tags[]" value="<?= $tag['id'] ?>">
                            <label class="custom-control-label" for="tag_<?= $tag['id'] ?>">
                                <span class="badge" style="background-color: <?= esc($tag['color_hex']) ?>; color: white;"><?= esc($tag['name']) ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h5 class="font-weight-bold mt-4 border-bottom pb-2 d-flex justify-content-between align-items-center">
                    Ingredientes Necesarios
                    <button type="button" class="btn btn-sm btn-outline-success" onclick="agregarFilaIngrediente()">+ Añadir Ingrediente</button>
                </h5>
                
                <div id="contenedorIngredientes">
                    <div class="row align-items-end mb-2 fila-ingrediente">
                        <div class="col-md-5 form-group mb-0">
                            <label class="small text-muted mb-1">Ingrediente</label>
                            <select name="ingredient_id[]" class="form-control form-control-sm" required>
                                <option value="">Seleccione...</option>
                                <?php foreach($ingredientes as $ing): ?>
                                    <option value="<?= $ing['id'] ?>"><?= esc($ing['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 form-group mb-0">
                            <label class="small text-muted mb-1">Cantidad</label>
                            <input type="number" step="0.01" name="quantity[]" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-2 form-group mb-0">
                            <label class="small text-muted mb-1">Unidad</label>
                            <input type="text" name="unit[]" class="form-control form-control-sm" placeholder="g, ml, cda..." required>
                        </div>
                        <div class="col-md-2 form-group mb-0">
                            <label class="small text-muted mb-1">¿Es Principal?</label>
                            <select name="is_main[]" class="form-control form-control-sm">
                                <option value="1">Sí (Fuerte)</option>
                                <option value="0" selected>No (Extra)</option>
                            </select>
                        </div>
                        <div class="col-md-1 form-group mb-0 text-center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(this)"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-lg btn-block text-white font-weight-bold mt-4 shadow-sm" style="background-color: #f1682d;">
                    💾 Guardar Receta Completa
                </button>
            </form>
        </div>

        <div class="tab-pane fade" id="gestionar" role="tabpanel">
            <h5 class="font-weight-bold mb-3 border-bottom pb-2">Recetas Registradas</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>Título</th>
                            <th>Calorías</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($recetas)): ?>
                            <?php foreach($recetas as $receta): ?>
                                <tr>
                                    <td class="font-weight-bold"><?= esc($receta['title']) ?></td>
                                    <td><?= esc($receta['total_calories']) ?> kcal</td>
                                    <td>
                                        <?php if($receta['is_approved'] ?? 0): ?>
                                            <span class="badge badge-success px-2 py-1"><i class="fas fa-check"></i> Pública</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning px-2 py-1"><i class="fas fa-clock"></i> Pendiente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(session()->get('rol') === 'admin' && !($receta['is_approved'] ?? 0)): ?>
                                            <a href="<?= base_url('admin/aprobarReceta/'.$receta['id']) ?>" class="btn btn-sm btn-success text-white mb-1 shadow-sm" title="Aprobar para que todos la vean"><i class="fas fa-check-circle"></i> Aprobar</a>
                                        <?php endif; ?>
                                        
                                        <a href="<?= base_url('admin/editarReceta/'.$receta['id']) ?>" class="btn btn-sm btn-primary text-white mb-1 shadow-sm"><i class="fas fa-edit"></i> Editar</a>
                                        <a href="<?= base_url('admin/eliminarReceta/'.$receta['id']) ?>" class="btn btn-sm btn-danger text-white mb-1 shadow-sm" onclick="return confirm('¿Seguro que deseas eliminar esta receta permanentemente?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-muted">No hay recetas registradas aún.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="ingrediente" role="tabpanel">
            <form action="<?= base_url('admin/guardarIngrediente') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nombre del Ingrediente</label>
                        <input type="text" name="name" class="form-control" required placeholder="Ej. Quinoa">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Categoría</label>
                        <select name="category" class="form-control" required>
                            <option value="proteina">Proteína</option>
                            <option value="carbohidrato">Carbohidrato</option>
                            <option value="grasa">Grasa</option>
                            <option value="vegetal">Vegetal</option>
                            <option value="fruta">Fruta</option>
                            <option value="lacteo">Lácteo</option>
                            <option value="especia">Especia</option>
                            <option value="otro" selected>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Kcal por 100g</label>
                        <input type="number" step="0.01" name="calories" class="form-control" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Proteína (g)</label>
                        <input type="number" step="0.01" name="protein" class="form-control">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Carbohidratos (g)</label>
                        <input type="number" step="0.01" name="carb" class="form-control">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Grasa (g)</label>
                        <input type="number" step="0.01" name="fat" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn text-white" style="background-color: #f1682d;">Guardar Ingrediente</button>
            </form>
        </div>

        <div class="tab-pane fade" id="etiqueta" role="tabpanel">
            <form action="<?= base_url('admin/guardarEtiqueta') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nombre de la Etiqueta</label>
                        <input type="text" name="name" class="form-control" required placeholder="Ej. Bajo en Sodio">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Color (Hexadecimal)</label>
                        <input type="color" name="color_hex" class="form-control p-1" style="height: 38px;" value="#f1682d" required>
                    </div>
                </div>
                <button type="submit" class="btn text-white" style="background-color: #f1682d;">Crear Etiqueta</button>
            </form>
        </div>

    </div>
</div>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        // Seleccionamos todos los enlaces de las pestañas
        const tabLinks = document.querySelectorAll('#adminTabs a[data-toggle="tab"]');
        
        // 1. Restaurar la pestaña activa al recargar la página
        const tabGuardado = localStorage.getItem('tabActivoAdmin');
        if (tabGuardado) {
            const enlaceActivo = document.querySelector('#adminTabs a[href="' + tabGuardado + '"]');
            if (enlaceActivo) {
                enlaceActivo.click(); // Simulamos el clic para activar el tab
            }
        }

        // 2. Guardar en memoria la pestaña cada vez que el usuario hace clic en una
        tabLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                localStorage.setItem('tabActivoAdmin', this.getAttribute('href'));
            });
        });
    });

    function agregarFilaIngrediente() {
        const contenedor = document.getElementById('contenedorIngredientes');
        const filaOriginal = contenedor.querySelector('.fila-ingrediente');
        const nuevaFila = filaOriginal.cloneNode(true);
        
        nuevaFila.querySelector('select[name="ingredient_id[]"]').value = "";
        nuevaFila.querySelector('input[name="quantity[]"]').value = "";
        nuevaFila.querySelector('input[name="unit[]"]').value = "";
        nuevaFila.querySelector('select[name="is_main[]"]').value = "0";
        
        contenedor.appendChild(nuevaFila);
    }

    function eliminarFila(boton) {
        const filas = document.querySelectorAll('.fila-ingrediente');
        if (filas.length > 1) {
            boton.closest('.fila-ingrediente').remove();
        } else {
            alert('La receta debe tener al menos un ingrediente.');
        }
    }

    function mostrarPrevisualizacion(event) {
        const input = event.target;
        const preview = document.getElementById('imgPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Hacemos visible la imagen
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= view('template/piepagina') ?>