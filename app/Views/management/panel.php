<?php
/**
 * @var array $ingredientes
 * @var array $etiquetas
 * @var array $recetas
 */
?>
<?= view('template/cabecera') ?>

<style>
    .mgmt-header-actions {
        gap: 8px;
    }
    .mgmt-title {
        color: #6b6b6b;
        font-weight: 800;
        letter-spacing: -0.3px;
    }
    .mgmt-title-icon {
        color: #F8B133;
    }
    .mgmt-subtitle {
        color: #7c7c7c;
        font-size: 0.92rem;
    }

    /* Pestañas limpias */
    #adminTabs {
        border-bottom: 1px solid #e5e7eb;
        gap: 4px;
    }
    #adminTabs .nav-link {
        color: #555e68;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 11px 18px;
        border: 1px solid transparent;
        border-radius: 10px 10px 0 0;
        transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
    }
    #adminTabs .nav-link:hover {
        color: #d98e14;
        background-color: #fffaf0;
        border-color: #fce8c3 #fce8c3 #e5e7eb;
    }
    #adminTabs .nav-link.active {
        color: #d98e14;
        background-color: #ffffff;
        border-color: #e5e7eb #e5e7eb #ffffff;
    }
    #adminTabs .nav-link i {
        font-size: 0.85rem;
        opacity: 0.85;
    }

    .mgmt-tabs-content {
        border: 1px solid #e5e7eb;
        border-top: 0;
        border-radius: 0 0 14px 14px;
        background-color: #ffffff;
    }

    /* Secciones y campos del formulario */
    .mgmt-section-title {
        font-size: 1.02rem;
        font-weight: 700;
        color: #2d3436;
        border-bottom: 1px solid #edf0f2;
        padding-bottom: 10px;
        margin-bottom: 18px;
    }
    .mgmt-form label {
        font-size: 0.84rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 6px;
    }
    .mgmt-form .form-control {
        border-radius: 10px;
        border: 1px solid #dce1e7;
        font-size: 0.92rem;
        color: #2d3436;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .mgmt-form .form-control:focus {
        border-color: #F8B133;
        box-shadow: 0 0 0 0.18rem rgba(248, 177, 51, 0.2);
    }

    /* Selector de archivo personalizado */
    .mgmt-file-box {
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px dashed #cfd6de;
        background-color: #fafbfc;
        border-radius: 10px;
        padding: 7px 12px;
        cursor: pointer;
        transition: border-color 0.2s ease, background-color 0.2s ease;
        margin-bottom: 0;
        min-height: 38px;
    }
    .mgmt-file-box:hover {
        border-color: #F8B133;
        background-color: #fffaf0;
    }
    .mgmt-file-btn {
        background-color: #ffffff;
        border: 1px solid #dce1e7;
        border-radius: 8px;
        padding: 3px 10px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #495057;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .mgmt-file-name {
        font-size: 0.82rem;
        color: #6c757d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
    }
    .mgmt-img-preview {
        display: none;
        width: 88px;
        height: 64px;
        object-fit: cover;
        margin-top: 10px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
    }

    /* Etiquetas */
    .mgmt-tag-pill {
        padding: 5px 11px;
        border-radius: 50rem;
        font-size: 0.78rem;
        font-weight: 600;
        color: #ffffff;
    }

    /* Filas dinámicas de ingredientes */
    .mgmt-ing-header {
        gap: 10px;
    }
    .fila-ingrediente {
        background-color: #f9fafb;
        border: 1px solid #edf0f2;
        border-radius: 12px;
        padding: 12px 6px;
        margin-left: 0;
        margin-right: 0;
        margin-bottom: 10px !important;
    }

    /* Botón principal (Naranja logo NutriCheck) */
    .mgmt-btn-primary {
        background-color: #F8B133;
        border: none;
        color: #ffffff;
        font-weight: 700;
        border-radius: 12px;
        padding: 12px 24px;
        transition: background-color 0.2s ease, transform 0.15s ease;
    }
    .mgmt-btn-primary:hover,
    .mgmt-btn-primary:focus {
        background-color: #e39a1c;
        color: #ffffff;
    }

    /* Tabla de gestión */
    .mgmt-table thead th {
        background-color: #f8f9fa;
        border-top: 0;
        border-bottom: 1px solid #e5e7eb;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6c757d;
        padding: 12px 14px;
    }
    .mgmt-table tbody td {
        padding: 13px 14px;
        border-top: 1px solid #f0f2f5;
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .mgmt-table-title {
        min-width: 190px;
        color: #2d3436;
    }
    .mgmt-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 11px;
        border-radius: 50rem;
        font-size: 0.76rem;
        font-weight: 600;
    }
    .mgmt-status-public {
        background-color: #e8f7ee;
        color: #1e7e45;
    }
    .mgmt-status-pending {
        background-color: #fff4e0;
        color: #b76e00;
    }

    @media (max-width: 767.98px) {
        .mgmt-header-title {
            font-size: 1.55rem;
        }
        .mgmt-header-actions .btn {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
            font-size: 0.85rem;
        }

        /* Pestañas ordenadas en cuadrícula 2x2 en móviles */
        #adminTabs {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            border-bottom: none;
            margin-bottom: 12px;
        }
        #adminTabs .nav-item {
            margin-bottom: 0;
        }
        #adminTabs .nav-link {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 10px 8px;
            font-size: 0.82rem;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background-color: #ffffff;
        }
        #adminTabs .nav-link.active {
            background-color: #fff8ea;
            border-color: #F8B133;
            color: #d98e14 !important;
        }
        .mgmt-tabs-content {
            border-top: 1px solid #e5e7eb !important;
            border-radius: 14px;
        }
    }
</style>

<div class="container mt-4 mb-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 border-bottom pb-3">
        <div class="mb-3 mb-md-0 mr-md-3">
            <h2 class="mgmt-header-title mgmt-title mb-1">
                <i class="fas fa-sliders-h mr-2 mgmt-title-icon"></i>Creador de Recetas
            </h2>
            <p class="mgmt-subtitle mb-0">Centro de creación y gestión de contenido nutricional.</p>
        </div>
        <div class="d-flex flex-wrap align-items-center mgmt-header-actions flex-shrink-0">
            <a href="<?= base_url('recetas') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm text-nowrap flex-shrink-0">Volver al Buscador</a>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm text-nowrap flex-shrink-0">Volver al Inicio</a>
        </div>
    </div>

    <ul class="nav nav-tabs" id="adminTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="receta-tab" data-toggle="tab" href="#receta" role="tab">
                <i class="fas fa-utensils mr-2"></i>Armar Receta
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="gestionar-tab" data-toggle="tab" href="#gestionar" role="tab">
                <i class="fas fa-list-ul mr-2"></i>Gestionar Recetas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="ingrediente-tab" data-toggle="tab" href="#ingrediente" role="tab">
                <i class="fas fa-leaf mr-2"></i>Nuevo Ingrediente
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="etiqueta-tab" data-toggle="tab" href="#etiqueta" role="tab">
                <i class="fas fa-tags mr-2"></i>Etiquetas
            </a>
        </li>
    </ul>

    <div class="tab-content p-3 p-md-4 shadow-sm mgmt-tabs-content" id="adminTabsContent">
        
        <div class="tab-pane fade show active" id="receta" role="tabpanel">
            <form action="<?= base_url('admin/guardarReceta') ?>" method="POST" enctype="multipart/form-data" class="mgmt-form">
                <?= csrf_field() ?>
                
                <h5 class="mgmt-section-title">Información Básica</h5>
                <div class="row">
                    <div class="col-md-8 form-group">
                        <label for="recipeTitle">Título de la Receta</label>
                        <input type="text" id="recipeTitle" name="title" class="form-control" required placeholder="Ej. Ensalada César Fit">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="inputImagen">Foto del Plato</label>
                        <label for="inputImagen" class="mgmt-file-box">
                            <span class="mgmt-file-btn"><i class="fas fa-upload mr-1"></i>Subir</span>
                            <span class="mgmt-file-name" id="nombreArchivoReceta">Ningún archivo seleccionado</span>
                        </label>
                        <input type="file" name="imagen" id="inputImagen" class="d-none" accept="image/*" onchange="mostrarPrevisualizacion(event)">
                        <img id="imgPreview" src="#" alt="Previsualización" class="mgmt-img-preview">
                    </div>
                    <div class="col-6 col-md-3 form-group">
                        <label for="recipeTime">Tiempo (Minutos)</label>
                        <input type="number" id="recipeTime" name="prep_time" class="form-control" placeholder="Ej. 20" required>
                    </div>
                    <div class="col-6 col-md-3 form-group">
                        <label for="recipeCalories">Calorías Totales</label>
                        <input type="number" id="recipeCalories" name="total_calories" class="form-control" placeholder="Ej. 350" required>
                    </div>
                    <div class="col-6 col-md-3 form-group">
                        <label for="recipeDifficulty">Dificultad</label>
                        <select id="recipeDifficulty" name="difficulty" class="form-control" required>
                            <option value="facil">Fácil</option>
                            <option value="media" selected>Media</option>
                            <option value="dificil">Difícil</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3 form-group">
                        <label for="recipePortions">Porciones</label>
                        <input type="number" id="recipePortions" name="portions" class="form-control" value="1" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="recipePrep">Preparación (Instrucciones paso a paso)</label>
                    <textarea id="recipePrep" name="preparation" class="form-control" rows="4" placeholder="Describe los pasos de preparación de forma clara..." required></textarea>
                </div>

                <h5 class="mgmt-section-title mt-4">Etiquetas (Opcional)</h5>
                <div class="mb-4">
                    <?php foreach($etiquetas as $tag): ?>
                        <div class="custom-control custom-checkbox custom-control-inline mb-2 mr-3">
                            <input type="checkbox" class="custom-control-input" id="tag_<?= $tag['id'] ?>" name="tags[]" value="<?= $tag['id'] ?>">
                            <label class="custom-control-label" for="tag_<?= $tag['id'] ?>" style="cursor: pointer;">
                                <span class="badge mgmt-tag-pill" style="background-color: <?= esc($tag['color_hex']) ?>;"><?= esc($tag['name']) ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mgmt-section-title mt-4 d-flex flex-wrap justify-content-between align-items-center mgmt-ing-header">
                    <span>Ingredientes Necesarios</span>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 font-weight-bold text-nowrap" onclick="agregarFilaIngrediente()">
                        <i class="fas fa-plus mr-1"></i>Añadir Ingrediente
                    </button>
                </div>
                
                <div id="contenedorIngredientes">
                    <div class="row align-items-end fila-ingrediente">
                        <div class="col-12 col-md-5 form-group mb-2 mb-md-0">
                            <label class="small text-muted mb-1">Ingrediente</label>
                            <select name="ingredient_id[]" class="form-control form-control-sm" required>
                                <option value="">Seleccione...</option>
                                <?php foreach($ingredientes as $ing): ?>
                                    <option value="<?= $ing['id'] ?>"><?= esc($ing['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 col-md-2 form-group mb-2 mb-md-0">
                            <label class="small text-muted mb-1">Cantidad</label>
                            <input type="number" step="0.01" name="quantity[]" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-6 col-md-2 form-group mb-2 mb-md-0">
                            <label class="small text-muted mb-1">Unidad</label>
                            <input type="text" name="unit[]" class="form-control form-control-sm" placeholder="g, ml, cda..." required>
                        </div>
                        <div class="col-9 col-md-2 form-group mb-0">
                            <label class="small text-muted mb-1">¿Es Principal?</label>
                            <select name="is_main[]" class="form-control form-control-sm">
                                <option value="1">Sí (Fuerte)</option>
                                <option value="0" selected>No (Extra)</option>
                            </select>
                        </div>
                        <div class="col-3 col-md-1 form-group mb-0 text-right text-md-center">
                            <button type="button" class="btn btn-sm btn-outline-danger rounded" onclick="eliminarFila(this)" title="Quitar ingrediente">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-block mgmt-btn-primary mt-4 shadow-sm">
                    <i class="fas fa-save mr-2"></i>Guardar Receta Completa
                </button>
            </form>
        </div>

        <div class="tab-pane fade" id="gestionar" role="tabpanel">
            <h5 class="mgmt-section-title">Recetas Registradas</h5>
            <div class="table-responsive">
                <table class="table table-hover mb-0 mgmt-table">
                    <thead class="text-nowrap">
                        <tr>
                            <th>Título</th>
                            <th>Calorías</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($recetas)): ?>
                            <?php foreach($recetas as $receta): ?>
                                <tr>
                                    <td class="font-weight-bold mgmt-table-title"><?= esc($receta['title']) ?></td>
                                    <td class="text-nowrap text-muted font-weight-bold"><?= esc($receta['total_calories']) ?> kcal</td>
                                    <td class="text-nowrap">
                                        <?php if($receta['is_approved'] ?? 0): ?>
                                            <span class="mgmt-status-badge mgmt-status-public">
                                                <i class="fas fa-check-circle"></i>Pública
                                            </span>
                                        <?php else: ?>
                                            <span class="mgmt-status-badge mgmt-status-pending">
                                                <i class="fas fa-clock"></i>Pendiente
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right text-nowrap">
                                        <?php if(session()->get('rol') === 'admin' && !($receta['is_approved'] ?? 0)): ?>
                                            <a href="<?= base_url('admin/aprobarReceta/'.$receta['id']) ?>" class="btn btn-sm btn-success rounded-pill px-3 mb-1 shadow-sm" title="Aprobar para que todos la vean">
                                                <i class="fas fa-check mr-1"></i>Aprobar
                                            </a>
                                        <?php endif; ?>
                                        
                                        <a href="<?= base_url('admin/editarReceta/'.$receta['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 mb-1">
                                            <i class="fas fa-pen mr-1"></i>Editar
                                        </a>
                                        <a href="<?= base_url('admin/eliminarReceta/'.$receta['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 mb-1" onclick="return confirm('¿Seguro que deseas eliminar esta receta permanentemente?');" title="Eliminar receta">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">No hay recetas registradas aún.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="ingrediente" role="tabpanel">
            <h5 class="mgmt-section-title">Registrar Nuevo Ingrediente</h5>
            <form action="<?= base_url('admin/guardarIngrediente') ?>" method="POST" class="mgmt-form">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="ingName">Nombre del Ingrediente</label>
                        <input type="text" id="ingName" name="name" class="form-control" required placeholder="Ej. Quinoa">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="ingCategory">Categoría</label>
                        <select id="ingCategory" name="category" class="form-control" required>
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
                    <div class="col-6 col-md-3 form-group">
                        <label for="ingCal">Kcal por 100g</label>
                        <input type="number" id="ingCal" step="0.01" name="calories" class="form-control" required>
                    </div>
                    <div class="col-6 col-md-3 form-group">
                        <label for="ingProt">Proteína (g)</label>
                        <input type="number" id="ingProt" step="0.01" name="protein" class="form-control">
                    </div>
                    <div class="col-6 col-md-3 form-group">
                        <label for="ingCarb">Carbohidratos (g)</label>
                        <input type="number" id="ingCarb" step="0.01" name="carb" class="form-control">
                    </div>
                    <div class="col-6 col-md-3 form-group">
                        <label for="ingFat">Grasa (g)</label>
                        <input type="number" id="ingFat" step="0.01" name="fat" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn mgmt-btn-primary mt-2 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Guardar Ingrediente
                </button>
            </form>
        </div>

        <div class="tab-pane fade" id="etiqueta" role="tabpanel">
            <h5 class="mgmt-section-title">Crear Nueva Etiqueta</h5>
            <form action="<?= base_url('admin/guardarEtiqueta') ?>" method="POST" class="mgmt-form">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="tagName">Nombre de la Etiqueta</label>
                        <input type="text" id="tagName" name="name" class="form-control" required placeholder="Ej. Bajo en Sodio">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="tagColor">Color (Hexadecimal)</label>
                        <input type="color" id="tagColor" name="color_hex" class="form-control p-1" style="height: 38px;" value="#F8B133" required>
                    </div>
                </div>
                <button type="submit" class="btn mgmt-btn-primary mt-2 shadow-sm">
                    <i class="fas fa-tag mr-2"></i>Crear Etiqueta
                </button>
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
                enlaceActivo.click();
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
        const nombreArchivo = document.getElementById('nombreArchivoReceta');

        if (input.files && input.files[0]) {
            if (nombreArchivo) {
                nombreArchivo.textContent = input.files[0].name;
            }
            const reader = new window.FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            if (nombreArchivo) {
                nombreArchivo.textContent = 'Ningún archivo seleccionado';
            }
            preview.style.display = 'none';
        }
    }
</script>

<?= view('template/piepagina') ?>