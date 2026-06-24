<?php
/**
 * Variables inyectadas por el Controlador MealLogs
 * @var array $historial_comidas
 */
?>
<?= view('template/cabecera') ?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #f1682d; font-weight: 700;">🥗 Mi Diario de Comidas</h2>
        <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary btn-sm">Volver al Inicio</a>
    </div>


    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px; background-color: #fcfcfc;">
                <div class="card-body">
                    <h5 class="font-weight-bold mb-3">Registrar Nueva Comida</h5>
                    
                    <form action="<?= base_url('comidas/guardar') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small text-muted">Fecha</label>
                                <input type="date" class="form-control" name="meal_date" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small text-muted">Hora</label>
                                <input type="time" class="form-control" name="meal_time" value="<?= date('H:i') ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small text-muted">Tipo de Comida</label>
                            <select class="form-control" name="meal_type" required>
                                <option value="" disabled selected>Selecciona el tipo...</option>
                                <option value="desayuno">☕ Desayuno</option>
                                <option value="media_manana">🍎 Media Mañana</option>
                                <option value="almuerzo">🍲 Almuerzo</option>
                                <option value="merienda">🥪 Merienda</option>
                                <option value="cena">🥗 Cena</option>
                                <option value="antojo">🍪 Antojo Nocturno</option>
                                <option value="bebida">🥤 Bebida / Hidratación</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small text-muted">¿Qué comiste? (Descripción)</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Ej: 2 huevos revueltos, 1 arepa..." required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small text-muted">Foto del Plato (Opcional)</label>
                            <input type="file" class="form-control-file border p-1 rounded bg-white" name="foto_comida" accept="image/png, image/jpeg, image/jpg" id="foto_comida_input">
                        </div>

                        <div class="text-center mt-2 mb-3">
                            <img id="preview_comida" src="" class="img-fluid rounded shadow-sm d-none" style="max-height: 150px; object-fit: cover;">
                        </div>

                        <button type="submit" class="btn btn-block text-white font-weight-bold shadow-sm" style="background-color: #28a745; border-radius: 10px; padding: 12px;">
                            ➕ Añadir al Diario
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <h5 class="font-weight-bold mb-3 text-muted">Historial Reciente</h5>
            
            <?php if(empty($historial_comidas)): ?>
                <div class="alert alert-info text-center border-0 shadow-sm" style="border-radius: 15px;">
                    Aún no has registrado ninguna comida. ¡Empieza tu diario hoy mismo!
                </div>
            <?php else: ?>
                <?php foreach($historial_comidas as $comida): ?>
                    <div class="card shadow-sm border-0 mb-3" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <?php if(!empty($comida['image_path'])): ?>
                                        <img src="<?= base_url('assets/meallogsimg/' . $comida['image_path']) ?>" class="img-fluid rounded shadow-sm" style="height: 120px; width: 100%; object-fit: cover;" alt="Foto de comida">
                                    <?php else: ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted shadow-sm" style="height: 120px; width: 100%;">
                                            <small>🚫 Sin foto</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between align-items-center mb-2 mt-2 mt-md-0">
                                        <span class="badge badge-warning text-uppercase px-3 py-1"><?= str_replace('_', ' ', $comida['meal_type']) ?></span>
                                        <small class="text-muted font-weight-bold">
                                            📅 <?= date('d/m/Y', strtotime($comida['meal_date'])) ?> | 🕒 <?= date('h:i A', strtotime($comida['meal_time'])) ?>
                                        </small>
                                    </div>
                                    <p class="mb-0 text-dark"><?= nl2br(esc($comida['description'])) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.getElementById('foto_comida_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview_comida');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        } else {
            preview.src = "";
            preview.classList.add('d-none');
        }
    });
</script>

<?= view('template/piepagina') ?>