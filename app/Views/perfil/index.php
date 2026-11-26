<?php
/**
 * Variables inyectadas por el Controlador Profile
 * @var array $usuario
 * @var array $perfil
 * @var array $patologias
 * @var array $alergias
 * @var array $misCondiciones
 */

$misCondicionesInt = array_map('intval', $misCondiciones ?? []);
$avatarActual = trim((string) ($usuario['avatar'] ?? ''));
$rutaAvatar = ($avatarActual !== '' && file_exists(FCPATH . 'assets/avatars/' . $avatarActual))
    ? base_url('assets/avatars/' . $avatarActual) . '?t=' . time()
    : base_url('assets/imagenes/iconusuario.png');
?>
<?= view('template/cabecera') ?>

<style>
    .perfil-config-wrap {
        color: #3f4652;
    }
    .perfil-titulo {
        color: #6b7280;
        font-weight: 700;
        letter-spacing: -0.3px;
    }
    .perfil-card {
        background-color: #ffffff;
        border: 1px solid #eceff4;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    }
    .perfil-seccion-titulo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #374151;
    }
    .perfil-icono-sec {
        width: 24px;
        height: 24px;
        object-fit: contain;
        flex-shrink: 0;
    }
    .perfil-icono-sub {
        width: 16px;
        height: 16px;
        object-fit: contain;
        flex-shrink: 0;
    }
    .perfil-icono-btn {
        width: 15px;
        height: 15px;
        object-fit: contain;
        flex-shrink: 0;
    }
    .perfil-icono-borrar {
        width: 20px;
        height: 20px;
        object-fit: contain;
    }
    .perfil-subtitulo-patologias {
        color: #d94848;
        font-weight: 700;
    }
    .perfil-subtitulo-alergias {
        color: #f39c12;
        font-weight: 700;
    }
    .perfil-btn-guardar {
        background: linear-gradient(90deg, #f59e0b 0%, #f7b529 100%);
        border: none;
        color: #ffffff;
        font-weight: 700;
        border-radius: 999px;
        padding: 13px 24px;
        font-size: 1.08rem;
        box-shadow: 0 6px 16px rgba(245, 158, 11, 0.28);
    }
    .perfil-btn-guardar:hover,
    .perfil-btn-guardar:focus {
        background: linear-gradient(90deg, #e58e06 0%, #f2a916 100%);
        color: #ffffff;
    }
    .perfil-admin-titulo {
        color: #6b7280;
        font-weight: 700;
    }
    .perfil-btn-registrar {
        background-color: #e04856;
        border-color: #e04856;
        color: #ffffff;
        font-weight: 700;
    }
    .perfil-btn-registrar:hover,
    .perfil-btn-registrar:focus {
        background-color: #c93846;
        border-color: #c93846;
        color: #ffffff;
    }
    .perfil-badge-patologia {
        background-color: #e04856;
        color: #ffffff;
        font-weight: 700;
        border-radius: 6px;
        padding: 4px 8px;
        font-size: 0.75rem;
    }
    .perfil-badge-alergia {
        background-color: #f6b221;
        color: #ffffff;
        font-weight: 700;
        border-radius: 6px;
        padding: 4px 8px;
        font-size: 0.75rem;
    }
    .perfil-form-control {
        border-color: #dfe4ec;
        border-radius: 8px;
    }
    .perfil-form-control:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 0.15rem rgba(245, 158, 11, 0.2);
    }
</style>

<div class="container perfil-config-wrap mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4">
                <h2 class="perfil-titulo mb-2 mb-sm-0">Configuración</h2>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm text-nowrap flex-shrink-0">
                    Volver al Inicio
                </a>
            </div>

            <form action="<?= base_url('perfil/actualizar') ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card perfil-card">
                            <div class="card-body text-center">
                                <input type="hidden" name="foto_actual" value="<?= esc($avatarActual) ?>">

                                <img src="<?= esc($rutaAvatar) ?>" id="imagen_preview" class="rounded-circle mb-3 shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #f79c34;" alt="Foto de Perfil">   
                                
                                <div class="form-group">
                                    <label for="foto_perfil" class="btn btn-sm btn-outline-secondary rounded-pill font-weight-bold" style="cursor:pointer;">Subir Nueva Foto</label>
                                    <input type="file" class="d-none" id="foto_perfil" name="foto_perfil" accept="image/png, image/jpeg, image/jpg">
                                    <small class="d-block text-muted mt-1">Formatos: JPG, PNG</small>
                                </div>
                                
                                <hr>
                                <div class="form-group text-left">
                                    <label class="font-weight-bold text-muted small">Correo Electrónico</label>
                                    <input type="email" class="form-control perfil-form-control bg-light" value="<?= esc($usuario['email'] ?? '') ?>" readonly>
                                </div>
                                <div class="form-group text-left">
                                    <label class="font-weight-bold text-muted small">Actualizar Contraseña</label>
                                    <input type="password" class="form-control perfil-form-control bg-white" name="password" value="" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly');" placeholder="Dejar en blanco para mantener actual">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        
                        <div class="card perfil-card mb-4">
                            <div class="card-header bg-white border-0 pt-4 pb-0">
                                <div class="perfil-seccion-titulo">
                                    <img src="<?= base_url('assets/imagenes/datospersonales.png') ?>" alt="" class="perfil-icono-sec">
                                    <span>Datos Personales</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label class="font-weight-bold">Nombre y Apellido</label>
                                        <input type="text" class="form-control perfil-form-control" name="name" value="<?= esc(old('name', (string) ($usuario['name'] ?? ''))) ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="font-weight-bold">Sexo Biológico</label>
                                        <select class="form-control perfil-form-control" name="sex">
                                            <option value="" disabled <?= empty($usuario['sex']) ? 'selected' : '' ?>>Seleccione...</option>
                                            <option value="male" <?= (($usuario['sex'] ?? '') == 'male') ? 'selected' : '' ?>>Masculino</option>
                                            <option value="female" <?= (($usuario['sex'] ?? '') == 'female') ? 'selected' : '' ?>>Femenino</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="font-weight-bold">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control perfil-form-control" name="birth_date" value="<?= esc(old('birth_date', (string) ($usuario['birth_date'] ?? ''))) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card perfil-card mb-4">
                            <div class="card-header bg-white border-0 pt-4 pb-0">
                                <div class="perfil-seccion-titulo">
                                    <img src="<?= base_url('assets/imagenes/metricasyobjetivos.png') ?>" alt="" class="perfil-icono-sec">
                                    <span>Métricas y Objetivos</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label class="font-weight-bold">Peso (kg)</label>
                                        <input type="number" step="0.01" min="20" max="300" class="form-control perfil-form-control" name="weight_kg" value="<?= esc(old('weight_kg', (string) ($perfil['weight_kg'] ?? ''))) ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="font-weight-bold">Altura (cm)</label>
                                        <input type="number" min="50" max="250" class="form-control perfil-form-control" name="height_cm" value="<?= esc(old('height_cm', (string) ($perfil['height_cm'] ?? ''))) ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="font-weight-bold">Tu Objetivo</label>
                                        <select class="form-control perfil-form-control" name="goal">
                                            <option value="" disabled <?= empty($perfil['goal']) ? 'selected' : '' ?>>Seleccione...</option>
                                            <option value="lose_fat" <?= (isset($perfil['goal']) && $perfil['goal'] == 'lose_fat') ? 'selected' : '' ?>>Bajar Grasa</option>
                                            <option value="gain_muscle" <?= (isset($perfil['goal']) && $perfil['goal'] == 'gain_muscle') ? 'selected' : '' ?>>Aumentar Masa</option>
                                            <option value="maintenance" <?= (isset($perfil['goal']) && $perfil['goal'] == 'maintenance') ? 'selected' : '' ?>>Mantener Peso</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card perfil-card mb-4">
                            <div class="card-header bg-white border-0 pt-4 pb-0">
                                <div class="perfil-seccion-titulo">
                                    <img src="<?= base_url('assets/imagenes/cuadroclinico.png') ?>" alt="" class="perfil-icono-sec">
                                    <span>Cuadro Clínico</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="actualizar_condiciones" value="1">

                                <h6 class="perfil-subtitulo-patologias mt-3">Patologías y Enfermedades</h6>
                                <div class="row px-3">
                                    <?php foreach($patologias as $patologia): ?>
                                        <div class="custom-control custom-checkbox col-md-6 mb-2">
                                            <input type="checkbox" class="custom-control-input" id="pat_<?= (int) $patologia['id'] ?>" name="conditions[]" value="<?= (int) $patologia['id'] ?>" <?= in_array((int) $patologia['id'], $misCondicionesInt, true) ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="pat_<?= (int) $patologia['id'] ?>"><?= esc($patologia['name']) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <h6 class="perfil-subtitulo-alergias mt-4">Alergias e Intolerancias</h6>
                                <div class="row px-3">
                                    <?php foreach($alergias as $alergia): ?>
                                        <div class="custom-control custom-checkbox col-md-6 mb-2">
                                            <input type="checkbox" class="custom-control-input" id="ale_<?= (int) $alergia['id'] ?>" name="conditions[]" value="<?= (int) $alergia['id'] ?>" <?= in_array((int) $alergia['id'], $misCondicionesInt, true) ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="ale_<?= (int) $alergia['id'] ?>"><?= esc($alergia['name']) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block perfil-btn-guardar">
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>

            <?php if(session()->get('rol') === 'admin'): ?>
            <div class="mt-5 pt-4 border-top">
                <div class="d-flex align-items-center mb-4" style="gap: 10px;">
                    <img src="<?= base_url('assets/imagenes/administracion.png') ?>" alt="" class="perfil-icono-sec">
                    <h3 class="perfil-admin-titulo mb-0">Parámetros clínicos y alimentario</h3>
                </div>
                
                <div class="row">
                    <div class="col-md-5 mb-4">
                        <div class="card perfil-card bg-light">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3" style="gap: 8px;">
                                    <img src="<?= base_url('assets/imagenes/agregarpublicacion.png') ?>" alt="" class="perfil-icono-sub">
                                    <h6 class="font-weight-bold text-dark mb-0">Añadir Nueva Condición</h6>
                                </div>
                                
                                <form action="<?= base_url('perfil/agregar-condicion') ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Nombre de la Condición</label>
                                        <input type="text" class="form-control perfil-form-control bg-white" name="name" placeholder="Ej: Celiaquía..." required>
                                    </div>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Clasificación</label>
                                        <select class="form-control perfil-form-control bg-white" name="type" required>
                                            <option value="pathology">Patología / Enfermedad</option>
                                            <option value="allergy">Alergia / Intolerancia</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn perfil-btn-registrar btn-block shadow-sm rounded-pill d-inline-flex align-items-center justify-content-center" style="gap: 6px;">
                                        <img src="<?= base_url('assets/imagenes/agregarpublicacion.png') ?>" alt="" class="perfil-icono-btn">
                                        <span>Registrar en el Sistema</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 mb-4">
                        <div class="card perfil-card">
                            <div class="card-body">
                                <h6 class="font-weight-bold text-dark mb-3">Condiciones Existentes</h6>
                                
                                <div style="max-height: 250px; overflow-y: auto;" class="pr-2">
                                    <ul class="list-group list-group-flush">
                                        
                                        <?php foreach($patologias as $pat): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom-0">
                                                <div class="d-flex align-items-center">
                                                    <span class="perfil-badge-patologia mr-2">Patología</span>
                                                    <span class="text-dark font-weight-bold"><?= esc($pat['name']) ?></span>
                                                </div>
                                                <a href="<?= base_url('perfil/eliminar-condicion/' . $pat['id']) ?>" 
                                                   onclick="return confirm('¿Seguro que deseas eliminar <?= esc($pat['name']) ?> del sistema? Se borrará de los perfiles de los pacientes que la padezcan.')" 
                                                   class="btn btn-sm btn-link p-1" title="Eliminar">
                                                    <img src="<?= base_url('assets/imagenes/borrar.png') ?>" alt="Eliminar" class="perfil-icono-borrar">
                                                </a>
                                            </li>
                                        <?php endforeach; ?>

                                        <?php foreach($alergias as $ale): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom-0">
                                                <div class="d-flex align-items-center">
                                                    <span class="perfil-badge-alergia mr-2">Alergia</span>
                                                    <span class="text-dark font-weight-bold"><?= esc($ale['name']) ?></span>
                                                </div>
                                                <a href="<?= base_url('perfil/eliminar-condicion/' . $ale['id']) ?>" 
                                                   onclick="return confirm('¿Seguro que deseas eliminar <?= esc($ale['name']) ?> del sistema? Se borrará de los perfiles de los pacientes que la padezcan.')" 
                                                   class="btn btn-sm btn-link p-1" title="Eliminar">
                                                    <img src="<?= base_url('assets/imagenes/borrar.png') ?>" alt="Eliminar" class="perfil-icono-borrar">
                                                </a>
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