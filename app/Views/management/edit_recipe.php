<?php
/**
 * @var array $receta
 */
?>
<?= view('template/cabecera') ?>

<style>
    .edit-recipe-card {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
    }
    .edit-recipe-title {
        color: #6b6b6b;
        font-weight: 800;
        word-wrap: break-word;
    }
    .edit-recipe-title i {
        color: #F8B133;
    }
    .edit-recipe-form label {
        font-size: 0.84rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 6px;
    }
    .edit-recipe-form .form-control {
        border-radius: 10px;
        border: 1px solid #dce1e7;
        font-size: 0.92rem;
        color: #2d3436;
    }
    .edit-recipe-form .form-control:focus {
        border-color: #F8B133;
        box-shadow: 0 0 0 0.18rem rgba(248, 177, 51, 0.2);
    }
    .edit-file-box {
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px dashed #cfd6de;
        background-color: #fafbfc;
        border-radius: 10px;
        padding: 7px 12px;
        cursor: pointer;
        margin-bottom: 0;
        min-height: 38px;
        transition: border-color 0.2s ease, background-color 0.2s ease;
    }
    .edit-file-box:hover {
        border-color: #F8B133;
        background-color: #fffaf0;
    }
    .edit-file-btn {
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
    .edit-file-name {
        font-size: 0.82rem;
        color: #6c757d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
    }
    .edit-btn-save {
        background-color: #F8B133;
        border: none;
        color: #ffffff;
        font-weight: 700;
        transition: background-color 0.2s ease;
    }
    .edit-btn-save:hover,
    .edit-btn-save:focus {
        background-color: #e39a1c;
        color: #ffffff;
    }
    .edit-recipe-actions {
        gap: 10px;
    }
    @media (max-width: 576px) {
        .edit-recipe-title {
            font-size: 1.2rem;
            line-height: 1.35;
        }
        .edit-recipe-actions .btn {
            width: 100%;
        }
    }
</style>

<div class="container mt-4 mb-5">
    <div class="card shadow-sm edit-recipe-card">
        <div class="card-header bg-white border-bottom pt-4 pb-3 px-3 px-md-4">
            <h4 class="mb-0 edit-recipe-title">
                <i class="fas fa-pen mr-2"></i>Editando Receta: <?= esc($receta['title']) ?>
            </h4>
        </div>
        
        <div class="card-body p-3 p-md-4">
            <form action="<?= base_url('admin/actualizarReceta') ?>" method="POST" enctype="multipart/form-data" class="edit-recipe-form">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= esc($receta['id']) ?>">

                <div class="row">
                    <div class="col-md-8 form-group">
                        <label for="editTitle">Título de la Receta</label>
                        <input type="text" id="editTitle" name="title" class="form-control" value="<?= esc($receta['title']) ?>" required>
                    </div>
                    
                    <div class="col-md-4 form-group">
                        <label for="editImagen">Sustituir Foto (Opcional)</label>
                        <label for="editImagen" class="edit-file-box">
                            <span class="edit-file-btn"><i class="fas fa-upload mr-1"></i>Subir</span>
                            <span class="edit-file-name" id="editFotoNombre">Mantener foto actual</span>
                        </label>
                        <input type="file" id="editImagen" name="imagen" class="d-none" accept="image/*" onchange="actualizarNombreFotoEdit(event)">
                        <small class="text-muted d-block mt-1">Si no seleccionas una imagen, se conservará la actual.</small>
                    </div>
                    
                    <div class="col-6 col-md-3 form-group">
                        <label for="editTime">Tiempo (Minutos)</label>
                        <input type="number" id="editTime" name="prep_time" class="form-control" value="<?= esc($receta['prep_time_minutes']) ?>" required>
                    </div>
                    
                    <div class="col-6 col-md-3 form-group">
                        <label for="editCalories">Calorías Totales</label>
                        <input type="number" id="editCalories" name="total_calories" class="form-control" value="<?= esc($receta['total_calories']) ?>" required>
                    </div>
                    
                    <div class="col-6 col-md-3 form-group">
                        <label for="editDifficulty">Dificultad</label>
                        <select id="editDifficulty" name="difficulty" class="form-control" required>
                            <option value="facil" <?= ($receta['difficulty'] == 'facil') ? 'selected' : '' ?>>Fácil</option>
                            <option value="media" <?= ($receta['difficulty'] == 'media') ? 'selected' : '' ?>>Media</option>
                            <option value="dificil" <?= ($receta['difficulty'] == 'dificil') ? 'selected' : '' ?>>Difícil</option>
                        </select>
                    </div>
                    
                    <div class="col-6 col-md-3 form-group">
                        <label for="editPortions">Porciones</label>
                        <input type="number" id="editPortions" name="portions" class="form-control" value="<?= esc($receta['portions']) ?>" required>
                    </div>
                </div>

                <div class="form-group mt-2">
                    <label for="editPrep">Preparación (Instrucciones paso a paso)</label>
                    <textarea id="editPrep" name="preparation" class="form-control" rows="6" required><?= esc($receta['preparation']) ?></textarea>
                </div>

                <div class="d-flex flex-column-reverse flex-sm-row justify-content-between align-items-stretch align-items-sm-center mt-4 edit-recipe-actions">
                    <a href="<?= base_url('admin') ?>" class="btn btn-outline-secondary rounded-pill px-4">Cancelar y Volver</a>
                    <button type="submit" class="btn edit-btn-save rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function actualizarNombreFotoEdit(event) {
        const input = event.target;
        const labelNombre = document.getElementById('editFotoNombre');
        if (labelNombre) {
            labelNombre.textContent = (input.files && input.files[0])
                ? input.files[0].name
                : 'Mantener foto actual';
        }
    }
</script>

<?= view('template/piepagina') ?>