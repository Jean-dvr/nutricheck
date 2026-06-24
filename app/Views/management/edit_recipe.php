<?php
/**
 * @var array $receta
 */
?>
<?= view('template/cabecera') ?>

<div class="container mt-4 mb-5">
    <div class="card shadow-sm border-0 rounded">
        <div class="card-header bg-white border-bottom pt-4 pb-3">
            <h4 class="font-weight-bold" style="color: #f1682d;"><i class="fas fa-edit"></i> Editando Receta: <?= esc($receta['title']) ?></h4>
        </div>
        
        <div class="card-body p-4">
            <form action="<?= base_url('admin/actualizarReceta') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= esc($receta['id']) ?>">

                <div class="row">
                    <div class="col-md-8 form-group">
                        <label class="font-weight-bold">Título de la Receta</label>
                        <input type="text" name="title" class="form-control" value="<?= esc($receta['title']) ?>" required>
                    </div>
                    
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Sustituir Foto (Opcional)</label>
                        <input type="file" name="imagen" class="form-control-file" accept="image/*">
                        <small class="text-muted">Si no subes nada, se mantendrá la foto actual.</small>
                    </div>
                    
                    <div class="col-md-3 form-group">
                        <label class="font-weight-bold">Tiempo (Minutos)</label>
                        <input type="number" name="prep_time" class="form-control" value="<?= esc($receta['prep_time_minutes']) ?>" required>
                    </div>
                    
                    <div class="col-md-3 form-group">
                        <label class="font-weight-bold">Calorías Totales</label>
                        <input type="number" name="total_calories" class="form-control" value="<?= esc($receta['total_calories']) ?>" required>
                    </div>
                    
                    <div class="col-md-3 form-group">
                        <label class="font-weight-bold">Dificultad</label>
                        <select name="difficulty" class="form-control" required>
                            <option value="facil" <?= ($receta['difficulty'] == 'facil') ? 'selected' : '' ?>>Fácil</option>
                            <option value="media" <?= ($receta['difficulty'] == 'media') ? 'selected' : '' ?>>Media</option>
                            <option value="dificil" <?= ($receta['difficulty'] == 'dificil') ? 'selected' : '' ?>>Difícil</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 form-group">
                        <label class="font-weight-bold">Porciones</label>
                        <input type="number" name="portions" class="form-control" value="<?= esc($receta['portions']) ?>" required>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="font-weight-bold">Preparación (Instrucciones paso a paso)</label>
                    <textarea name="preparation" class="form-control" rows="6" required><?= esc($receta['preparation']) ?></textarea>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="<?= base_url('admin') ?>" class="btn btn-outline-secondary">Cancelar y Volver</a>
                    <button type="submit" class="btn text-white font-weight-bold" style="background-color: #f1682d;">💾 Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= view('template/piepagina') ?>