<?php
/**
 * Variables inyectadas por el Controlador Profile
 * @var array $usuario
 * @var array $perfil
 * @var array $patologias
 * @var array $alergias
 * @var array $misCondiciones
 */
?>
<?= view('template/cabecera') ?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4" style="color: #f1682d; font-weight: 700;">Configuración de Perfil</h2>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success shadow-sm rounded"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('fail')): ?>
                <div class="alert alert-danger shadow-sm rounded"><?= session()->getFlashdata('fail') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('perfil/actualizar') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-0" style="border-radius: 15px;">
                            <div class="card-body text-center">
                                <?php 
                                    /* COMENTADO HASTA ACTUALIZAR LA BD
                                    // Evaluar ruta de la imagen
                                    $avatar = $usuario['avatar'];
                                    $rutaAvatar = ($avatar && $avatar != 'default-avatar.png') 
                                                ? base_url('assets/imagenes/avatars/' . $avatar) 
                                                : base_url('assets/imagenes/default-avatar.png');
                                    */
                                ?>
                                
                                <img src="<?= base_url('assets/imagenes/default-avatar.png') ?>" class="rounded-circle mb-3 shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #f79c34;" alt="Foto de Perfil Temporal">
                                
                                <hr>
                                <div class="form-group text-left">
                                    <label class="font-weight-bold text-muted small">Correo Electrónico (No modificable)</label>
                                    <input type="email" class="form-control bg-light" name="email" value="<?= esc($usuario['email']) ?>" readonly>
                                </div>
                                <div class="form-group text-left">
                                    <label class="font-weight-bold text-muted small">Actualizar Contraseña</label>
                                    <input type="password" class="form-control" name="password" placeholder="Dejar en blanco para mantener actual">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                            <div class="card-header bg-white font-weight-bold border-0 pt-4">👤 Datos Personales</div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label class="font-weight-bold">Nombre y Apellido</label>
                                        <input type="text" class="form-control" name="name" value="<?= old('name', esc($usuario['name'])) ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="font-weight-bold">Sexo Biológico</label>
                                        <select class="form-control" name="sex">
                                            <option value="" disabled <?= empty($usuario['sex']) ? 'selected' : '' ?>>Seleccione...</option>
                                            <option value="male" <?= ($usuario['sex'] == 'male') ? 'selected' : '' ?>>Masculino</option>
                                            <option value="female" <?= ($usuario['sex'] == 'female') ? 'selected' : '' ?>>Femenino</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="font-weight-bold">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control" name="birth_date" value="<?= esc($usuario['birth_date']) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                            <div class="card-header bg-white font-weight-bold border-0 pt-4">⚖️ Métricas y Objetivos</div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                            <label class="font-weight-bold">Peso (kg)</label>
                                            <input type="number" step="0.1" min="1" max="300" class="form-control" name="weight_kg" value="<?= old('weight_kg', esc($perfil['weight_kg'] ?? '')) ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="font-weight-bold">Altura (cm)</label>
                                            <input type="number" min="50" max="250" class="form-control" name="height_cm" value="<?= old('height_cm', esc($perfil['height_cm'] ?? '')) ?>">
                                        </div>
                                    <div class="form-group col-md-4">
                                        <label class="font-weight-bold">Tu Objetivo</label>
                                        <select class="form-control" name="goal">
                                            <option value="" disabled <?= empty($perfil['goal']) ? 'selected' : '' ?>>Seleccione...</option>
                                            <option value="lose_fat" <?= (isset($perfil['goal']) && $perfil['goal'] == 'lose_fat') ? 'selected' : '' ?>>Bajar Grasa</option>
                                            <option value="gain_muscle" <?= (isset($perfil['goal']) && $perfil['goal'] == 'gain_muscle') ? 'selected' : '' ?>>Aumentar Masa</option>
                                            <option value="maintenance" <?= (isset($perfil['goal']) && $perfil['goal'] == 'maintenance') ? 'selected' : '' ?>>Mantener Peso</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                            <div class="card-header bg-white font-weight-bold border-0 pt-4">⚕️ Cuadro Clínico</div>
                            <div class="card-body">
                                <p class="text-muted small">Marca las opciones correspondientes para que NutriCheck filtre tus recetas seguras.</p>
                                
                                <h6 class="font-weight-bold mt-3 text-danger">Patologías Diagnosticadas</h6>
                                <div class="row px-3">
                                    <?php foreach($patologias as $patologia): ?>
                                        <div class="custom-control custom-checkbox col-md-6 mb-2">
                                            <input type="checkbox" class="custom-control-input" id="cond_<?= $patologia['id'] ?>" name="conditions[]" value="<?= $patologia['id'] ?>" <?= in_array($patologia['id'], $misCondiciones) ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="cond_<?= $patologia['id'] ?>"><?= esc($patologia['name']) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <h6 class="font-weight-bold mt-4 text-warning">Alergias Alimentarias</h6>
                                <div class="row px-3">
                                    <?php foreach($alergias as $alergia): ?>
                                        <div class="custom-control custom-checkbox col-md-6 mb-2">
                                            <input type="checkbox" class="custom-control-input" id="cond_<?= $alergia['id'] ?>" name="conditions[]" value="<?= $alergia['id'] ?>" <?= in_array($alergia['id'], $misCondiciones) ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="cond_<?= $alergia['id'] ?>"><?= esc($alergia['name']) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block text-white font-weight-bold rounded-pill shadow-sm" style="background-color: #f1682d; padding: 14px; font-size: 1.1rem; transition: 0.3s;">
                            Guardar Toda la Información
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= view('template/piepagina') ?>