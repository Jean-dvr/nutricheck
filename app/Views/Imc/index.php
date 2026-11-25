<?php
/**
 * Variables inyectadas por el Controlador Imc
 * * @var float|string $imc
 * @var string $categoria
 * @var string $claseAlerta
 * @var string $riesgoCintura
 * @var string $claseRiesgo
 * @var string $pesoGuardado
 * @var string $alturaGuardada
 * @var string $cinturaGuardada
 * @var string $sexoGuardado
 * @var object $validation
 */
?>
<?= view('template/cabecera') ?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="d-flex justify-content-end mb-3">
                <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                    Volver al Inicio
                </a>
            </div>
            
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <h2 style="color: #f1682d; font-weight: 700;">Calculadora de Evaluación Física</h2>
                    <p class="text-muted">Conoce tu IMC y tu riesgo metabólico usando la medida de tu cintura.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    <?php if(session()->getFlashdata('fail')): ?>
                        <div class="alert alert-danger" style="border-radius: 10px;">
                            <?= session()->getFlashdata('fail') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('imc/calcular') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="sexo" class="font-weight-bold">Sexo Biológico</label>
                                <select class="form-control rounded-pill" id="sexo" name="sexo">
                                    <option value="" disabled <?= !isset($sexoGuardado) ? 'selected' : '' ?>>Seleccionar...</option>
                                    <option value="M" <?= (isset($sexoGuardado) && $sexoGuardado == 'M') ? 'selected' : '' ?>>Masculino</option>
                                    <option value="F" <?= (isset($sexoGuardado) && $sexoGuardado == 'F') ? 'selected' : '' ?>>Femenino</option>
                                </select>
                                <span class="text-danger d-block mt-1" style="font-size: 0.85rem; padding-left: 15px;">
                                    <?= isset($validation) ? display_error($validation, 'sexo') : '' ?>
                                </span>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="altura" class="font-weight-bold">Altura (cm)</label>
                                <input type="number" step="0.1" class="form-control rounded-pill" id="altura" name="altura" placeholder="Ej: 175" value="<?= isset($alturaGuardada) ? $alturaGuardada : '' ?>">
                                <span class="text-danger d-block mt-1" style="font-size: 0.85rem; padding-left: 15px;">
                                    <?= isset($validation) ? display_error($validation, 'altura') : '' ?>
                                </span>
                            </div>
                        </div>

                        <div class="form-row mt-2">
                            <div class="form-group col-md-6">
                                <label for="peso" class="font-weight-bold">Peso (kg)</label>
                                <input type="number" step="0.1" class="form-control rounded-pill" id="peso" name="peso" placeholder="Ej: 70.5" value="<?= isset($pesoGuardado) ? $pesoGuardado : '' ?>">
                                <span class="text-danger d-block mt-1" style="font-size: 0.85rem; padding-left: 15px;">
                                    <?= isset($validation) ? display_error($validation, 'peso') : '' ?>
                                </span>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="cintura" class="font-weight-bold">Cintura (cm)</label>
                                <input type="number" step="0.1" class="form-control rounded-pill" id="cintura" name="cintura" placeholder="Ej: 85" value="<?= isset($cinturaGuardada) ? $cinturaGuardada : '' ?>">
                                <span class="text-danger d-block mt-1" style="font-size: 0.85rem; padding-left: 15px;">
                                    <?= isset($validation) ? display_error($validation, 'cintura') : '' ?>
                                </span>
                                <small class="text-muted d-block mt-1 pl-2">Mide justo por encima del ombligo.</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block text-white font-weight-bold rounded-pill mt-4 shadow-sm" style="background-color: #f79c34; padding: 12px; transition: 0.3s;">
                            Calcular Resultados
                        </button>
                    </form>

                    <?php if(isset($imc)): ?>
                        <hr class="mt-5 mb-4" style="border-top: 2px dashed #ebebeb;">
                        <div class="text-center">
                            <h4 class="font-weight-bold text-dark">Tu Diagnóstico</h4>
                            
                            <div class="alert <?= $claseAlerta ?> mt-3 shadow-sm" role="alert" style="border-radius: 15px; border: none;">
                                <p class="mb-0 text-muted">Tu Índice de Masa Corporal es:</p>
                                <h1 class="display-4 font-weight-bold mb-0"><?= $imc ?></h1>
                                <h5 class="mt-2 mb-0">Categoría: <strong><?= $categoria ?></strong></h5>
                            </div>

                            <div class="mt-4 p-4 shadow-sm" style="background-color: #fcfcfc; border-radius: 15px; border: 1px solid #f0f0f0;">
                                <p class="mb-2 text-muted">Evaluación de perímetro abdominal (<?= $cinturaGuardada ?> cm):</p>
                                <h5 class="<?= $claseRiesgo ?> mb-0" style="letter-spacing: 0.5px;"><?= $riesgoCintura ?></h5>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?= view('template/piepagina') ?>