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

            <form action="<?= base_url('perfil/actualizar') ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-0" style="border-radius: 15px;">
                            <div class="card-body text-center">
                                <?php 
                                     $avatarActual = !empty($usuario['avatar']) ? $usuario['avatar'] : 'default-avatar.png';
                                ?>
                                <input type="hidden" name="foto_actual" value="<?= esc($avatarActual) ?>">

                                <?php 
                                    $rutaAvatar = base_url('assets/avatars/' . $avatarActual) . '?t=' . time();
                                ?>
                                <img src="<?= $rutaAvatar ?>" id="imagen_preview" class="rounded-circle mb-3 shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #f79c34;" alt="Foto de Perfil">   
                                
                                <div class="form-group">
                                    <label for="foto_perfil" class="btn btn-sm btn-outline-secondary rounded-pill font-weight-bold" style="cursor:pointer;">Subir Nueva Foto</label>
                                    <input type="file" class="d-none" id="foto_perfil" name="foto_perfil" accept="image/png, image/jpeg, image/jpg">
                                    <small class="d-block text-muted mt-1">Formatos: JPG, PNG</small>
                                </div>
                                
                                <hr>
                                <div class="form-group text-left">
                                    <label class="font-weight-bold text-muted small">Correo Electrónico</label>
                                    <input type="email" class="form-control bg-light" value="<?= esc($usuario['email']) ?>" readonly>
                                </div>
                                <div class="form-group text-left">
                                    <label class="font-weight-bold text-muted small">Actualizar Contraseña</label>
                                    <input type="password" class="form-control bg-white" name="password" value="" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly');" placeholder="Dejar en blanco para mantener actual">
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
                                        <input type="date" class="form-control" name="birth_date" value="<?= old('birth_date', esc($usuario['birth_date'])) ?>">
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
                                <h6 class="font-weight-bold mt-3 text-danger">Patologías y Enfermedades</h6>
                                <div class="row px-3">
                                    <?php foreach($patologias as $patologia): ?>
                                        <div class="custom-control custom-checkbox col-md-6 mb-2">
                                            <input type="checkbox" class="custom-control-input" id="pat_<?= $patologia['id'] ?>" name="conditions[]" value="<?= $patologia['id'] ?>" <?= in_array($patologia['id'], $misCondiciones) ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="pat_<?= $patologia['id'] ?>"><?= esc($patologia['name']) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <h6 class="font-weight-bold mt-4 text-warning">Alergias e Intolerancias</h6>
                                <div class="row px-3">
                                    <?php foreach($alergias as $alergia): ?>
                                        <div class="custom-control custom-checkbox col-md-6 mb-2">
                                            <input type="checkbox" class="custom-control-input" id="ale_<?= $alergia['id'] ?>" name="conditions[]" value="<?= $alergia['id'] ?>" <?= in_array($alergia['id'], $misCondiciones) ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="ale_<?= $alergia['id'] ?>"><?= esc($alergia['name']) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block text-white font-weight-bold rounded-pill shadow-sm" style="background-color: #f1682d; padding: 14px; font-size: 1.1rem;">
                            Guardar Toda la Información
                        </button>
                    </div>
                </div>
            </form>

            <?php if(session()->get('rol') === 'admin'): ?>
            <div class="mt-5 pt-4 border-top">
                <h3 class="mb-4" style="color: #dc3545; font-weight: 700;">⚙️ Administración del Catálogo Médico</h3>
                
                <div class="row">
                    <div class="col-md-5 mb-4">
                        <div class="card shadow-sm border-0 bg-light" style="border-radius: 15px;">
                            <div class="card-body">
                                <h6 class="font-weight-bold text-dark mb-3">➕ Añadir Nueva Condición</h6>
                                
                                <form action="<?= base_url('perfil/agregar-condicion') ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Nombre de la Condición</label>
                                        <input type="text" class="form-control" name="name" placeholder="Ej: Celiaquía..." required>
                                    </div>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Clasificación</label>
                                        <select class="form-control" name="type" required>
                                            <option value="pathology">🩸 Patología / Enfermedad</option>
                                            <option value="allergy">🥜 Alergia / Intolerancia</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-block font-weight-bold shadow-sm rounded-pill">
                                        Registrar en el Sistema
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 mb-4">
                        <div class="card shadow-sm border-0" style="border-radius: 15px;">
                            <div class="card-body">
                                <h6 class="font-weight-bold text-dark mb-3">📋 Condiciones Existentes</h6>
                                
                                <div style="max-height: 250px; overflow-y: auto;" class="pr-2">
                                    <ul class="list-group list-group-flush">
                                        
                                        <?php foreach($patologias as $pat): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom-0">
                                                <div>
                                                    <span class="badge badge-danger mr-2">Patología</span>
                                                    <span class="text-dark font-weight-bold"><?= esc($pat['name']) ?></span>
                                                </div>
                                                <a href="<?= base_url('perfil/eliminar-condicion/' . $pat['id']) ?>" 
                                                   onclick="return confirm('¿Seguro que deseas eliminar <?= esc($pat['name']) ?> del sistema? Se borrará de los perfiles de los pacientes que la padezcan.')" 
                                                   class="btn btn-sm btn-outline-secondary border-0" title="Eliminar">🗑️</a>
                                            </li>
                                        <?php endforeach; ?>

                                        <?php foreach($alergias as $ale): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom-0">
                                                <div>
                                                    <span class="badge badge-warning text-white mr-2">Alergia</span>
                                                    <span class="text-dark font-weight-bold"><?= esc($ale['name']) ?></span>
                                                </div>
                                                <a href="<?= base_url('perfil/eliminar-condicion/' . $ale['id']) ?>" 
                                                   onclick="return confirm('¿Seguro que deseas eliminar <?= esc($ale['name']) ?> del sistema? Se borrará de los perfiles de los pacientes que la padezcan.')" 
                                                   class="btn btn-sm btn-outline-secondary border-0" title="Eliminar">🗑️</a>
                                            </li>
                                        <?php endforeach; ?>
                                        
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            </div>
    </div>
</div>

<script>
    // Buscamos el input oculto de la foto
    const inputFoto = document.getElementById('foto_perfil');
    // Buscamos la etiqueta img que acabamos de identificar
    const imagenPreview = document.getElementById('imagen_preview');

    // Escuchamos el evento 'change' (cuando el usuario selecciona un archivo)
    inputFoto.addEventListener('change', function(event) {
        const archivoSeleccionado = event.target.files[0];
        
        if (archivoSeleccionado) {
            // Creamos una URL temporal en la memoria del navegador
            const urlTemporal = URL.createObjectURL(archivoSeleccionado);
            // Reemplazamos la imagen actual por la previsualización
            imagenPreview.src = urlTemporal;
        }
    });
</script>

<?= view('template/piepagina') ?>