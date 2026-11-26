<?php
/**
 * Variables inyectadas por el Controlador Imc
 * @var float|string $imc
 * @var float        $imcPosicion
 * @var string       $categoria
 * @var string       $claseAlerta
 * @var float        $pesoMinSaludable
 * @var float        $pesoMaxSaludable
 * @var string       $textoPesoRef
 * @var string       $riesgoCintura
 * @var string       $referenciaCintura
 * @var string       $claseRiesgo
 * @var float        $ice
 * @var string       $estadoIce
 * @var string       $claseIce
 * @var array        $recomendaciones
 * @var string       $errorCoherencia
 * @var array        $erroresValidacion
 * @var bool         $recienCalculado
 * @var string       $pesoGuardado
 * @var string       $alturaGuardada
 * @var string       $cinturaGuardada
 * @var string       $sexoGuardado
 */

$erroresCampo = is_array($erroresValidacion ?? null) ? $erroresValidacion : [];
?>
<?= view('template/cabecera') ?>

<style>
    .imc-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        padding-bottom: 16px;
        margin-bottom: 22px;
        border-bottom: 1px solid #e6e6e6;
    }
    .imc-page-title {
        color: #6b6b6b;
        font-weight: 800;
        font-size: 1.85rem;
        margin-bottom: 4px;
        letter-spacing: -0.3px;
    }
    .imc-page-title i {
        color: #F8B133;
    }
    .imc-page-subtitle {
        color: #7c7c7c;
        font-size: 0.92rem;
        margin: 0;
    }

    .imc-main-card {
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        background-color: #ffffff;
    }
    .imc-form label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #495057;
        margin-bottom: 6px;
    }
    .imc-form .form-control {
        border-radius: 10px;
        border: 1px solid #dce1e7;
        font-size: 0.94rem;
        color: #2d3436;
        height: 44px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .imc-form .form-control:focus {
        border-color: #F8B133;
        box-shadow: 0 0 0 0.18rem rgba(248, 177, 51, 0.2);
    }
    .imc-btn-calc {
        background-color: #F8B133;
        border: none;
        color: #ffffff;
        font-weight: 700;
        font-size: 1rem;
        padding: 13px 24px;
        border-radius: 12px;
        transition: background-color 0.2s ease;
    }
    .imc-btn-calc:hover,
    .imc-btn-calc:focus {
        background-color: #e39a1c;
        color: #ffffff;
    }

    /* Separador y títulos de sección */
    .imc-divider {
        border-top: 1px solid #eceff2;
        margin: 2rem 0 1.75rem 0;
    }
    .imc-result-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
    }
    .imc-section-heading {
        font-size: 1.1rem;
        font-weight: 800;
        color: #4a4a4a;
        margin-bottom: 14px;
    }
    .imc-result-header .imc-section-heading {
        margin-bottom: 0;
    }
    .imc-section-heading i {
        color: #F8B133;
    }
    .imc-btn-clear {
        font-size: 0.82rem;
        font-weight: 600;
        color: #6b6b6b;
        border: 1px solid #d5dbe1;
        background-color: #ffffff;
        border-radius: 50rem;
        padding: 6px 14px;
        text-decoration: none !important;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .imc-btn-clear:hover {
        background-color: #f4f6f8;
        border-color: #adb5bd;
        color: #343a40;
    }

    /* Bloque principal de resultado IMC */
    .imc-hero-box {
        border-radius: 14px;
        padding: 22px 24px;
        border: 1px solid transparent;
    }
    .imc-tone-success {
        background-color: #eef9f2;
        border-color: #c5ebd3;
        color: #1b6535;
    }
    .imc-tone-warning {
        background-color: #fff8e6;
        border-color: #f6df9f;
        color: #8a5b00;
    }
    .imc-tone-danger {
        background-color: #fdf0f0;
        border-color: #f5c6cb;
        color: #9b1c26;
    }
    .imc-score-number {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -1px;
    }
    .imc-category-pill {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 50rem;
        background-color: rgba(255, 255, 255, 0.78);
        font-size: 0.9rem;
        font-weight: 700;
    }

    /* Barra visual de tramos IMC */
    .imc-scale-wrapper {
        margin-top: 18px;
    }
    .imc-scale-bar {
        position: relative;
        display: flex;
        height: 11px;
        border-radius: 999px;
        overflow: visible;
        background-color: #e9ecef;
    }
    .imc-scale-seg {
        height: 100%;
    }
    .imc-seg-under {
        width: 20%;
        background-color: #60a5fa;
        border-radius: 999px 0 0 999px;
    }
    .imc-seg-normal {
        width: 30%;
        background-color: #2ecc71;
    }
    .imc-seg-over {
        width: 25%;
        background-color: #F8B133;
    }
    .imc-seg-obese {
        width: 25%;
        background-color: #e74c3c;
        border-radius: 0 999px 999px 0;
    }
    .imc-scale-marker {
        position: absolute;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background-color: #2d3436;
        border: 3px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.28);
    }
    .imc-scale-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.72rem;
        font-weight: 600;
        color: #5c6670;
        margin-top: 8px;
        gap: 6px;
    }

    .imc-weight-ref-bar {
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        font-size: 0.88rem;
    }

    /* Tarjetas de métricas secundarias (Cintura e ICE) */
    .imc-metric-card {
        background-color: #fafbfc;
        border: 1px solid #e9edf1;
        border-radius: 14px;
        padding: 18px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .imc-metric-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6c757d;
        margin-bottom: 6px;
    }
    .imc-metric-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: #2d3436;
        line-height: 1.15;
        margin-bottom: 8px;
    }
    .imc-metric-ref {
        font-size: 0.78rem;
        color: #6c757d;
        margin-top: auto;
        padding-top: 10px;
    }

    /* Insignias de estado */
    .imc-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 50rem;
        font-size: 0.8rem;
        font-weight: 700;
        width: fit-content;
    }
    .imc-badge-success {
        background-color: #e6f6ec;
        color: #1c6e3a;
    }
    .imc-badge-warning {
        background-color: #fff4d6;
        color: #9a6500;
    }
    .imc-badge-danger {
        background-color: #fde8e8;
        color: #b4232c;
    }
    .imc-badge-info {
        background-color: #e8f3fe;
        color: #1c5ea8;
    }

    /* Bloque de recomendaciones */
    .imc-summary-box {
        background-color: #fffaf0;
        border: 1px solid #fae2b2;
        border-left: 4px solid #F8B133;
        border-radius: 12px;
        padding: 15px 18px;
        color: #495057;
        font-size: 0.92rem;
        line-height: 1.55;
        margin-bottom: 18px;
    }
    .imc-rec-card {
        background-color: #ffffff;
        border: 1px solid #e9edf1;
        border-radius: 14px;
        padding: 16px 18px;
        height: 100%;
    }
    .imc-rec-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 8px;
    }
    .imc-rec-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.92rem;
        font-weight: 700;
        color: #2d3436;
        margin: 0;
    }
    .imc-rec-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background-color: #fff6e3;
        color: #d98e14;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .imc-rec-text {
        font-size: 0.86rem;
        color: #5c6670;
        line-height: 1.55;
        margin: 0;
    }

    .imc-actions-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-top: 22px;
    }
    .imc-disclaimer {
        margin-top: 20px;
        padding: 12px 16px;
        background-color: #f8f9fa;
        border-radius: 10px;
        font-size: 0.78rem;
        color: #6c757d;
        line-height: 1.5;
    }

    @media (max-width: 767.98px) {
        .imc-page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .imc-page-title {
            font-size: 1.5rem;
        }
        .imc-score-number {
            font-size: 2.4rem;
        }
        .imc-hero-box {
            padding: 18px 16px;
        }
        .imc-actions-bar .btn {
            width: 100%;
        }
    }
</style>

<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">

            <!-- Encabezado -->
            <div class="imc-page-header">
                <div>
                    <h2 class="imc-page-title">
                        <i class="fas fa-heartbeat mr-2"></i>Calculadora de Evaluación Física
                    </h2>
                    <p class="imc-page-subtitle">Evalúa tu IMC, tu rango de peso saludable y tu riesgo metabólico según tu cintura y estatura.</p>
                </div>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm text-nowrap flex-shrink-0">
                    Volver al Inicio
                </a>
            </div>

            <div class="card shadow-sm imc-main-card">
                <div class="card-body p-3 p-md-4">

                    <?php if (session()->getFlashdata('fail')): ?>
                        <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 10px;">
                            <?= esc((string) session()->getFlashdata('fail')) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario -->
                    <form action="<?= base_url('imc/calcular') ?>" method="POST" class="imc-form">
                        <?= csrf_field() ?>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="sexo">Sexo Biológico</label>
                                <select class="form-control" id="sexo" name="sexo" required>
                                    <option value="" disabled <?= empty($sexoGuardado) ? 'selected' : '' ?>>Seleccionar...</option>
                                    <option value="M" <?= (isset($sexoGuardado) && $sexoGuardado === 'M') ? 'selected' : '' ?>>Masculino</option>
                                    <option value="F" <?= (isset($sexoGuardado) && $sexoGuardado === 'F') ? 'selected' : '' ?>>Femenino</option>
                                </select>
                                <?php if (!empty($erroresCampo['sexo'])): ?>
                                    <span class="text-danger d-block mt-1 small"><?= esc($erroresCampo['sexo']) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="altura">Altura (cm)</label>
                                <input
                                    type="number"
                                    step="0.1"
                                    min="120"
                                    max="230"
                                    class="form-control"
                                    id="altura"
                                    name="altura"
                                    placeholder="Ej: 170"
                                    value="<?= isset($alturaGuardada) ? esc((string) $alturaGuardada) : '' ?>"
                                    required
                                >
                                <?php if (!empty($erroresCampo['altura'])): ?>
                                    <span class="text-danger d-block mt-1 small"><?= esc($erroresCampo['altura']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row mt-1">
                            <div class="form-group col-md-6">
                                <label for="peso">Peso (kg)</label>
                                <input
                                    type="number"
                                    step="0.1"
                                    min="30"
                                    max="250"
                                    class="form-control"
                                    id="peso"
                                    name="peso"
                                    placeholder="Ej: 70.5"
                                    value="<?= isset($pesoGuardado) ? esc((string) $pesoGuardado) : '' ?>"
                                    required
                                >
                                <?php if (!empty($erroresCampo['peso'])): ?>
                                    <span class="text-danger d-block mt-1 small"><?= esc($erroresCampo['peso']) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="cintura">Cintura (cm)</label>
                                <input
                                    type="number"
                                    step="0.1"
                                    min="45"
                                    max="180"
                                    class="form-control"
                                    id="cintura"
                                    name="cintura"
                                    placeholder="Ej: 85"
                                    value="<?= isset($cinturaGuardada) ? esc((string) $cinturaGuardada) : '' ?>"
                                    required
                                >
                                <?php if (!empty($erroresCampo['cintura'])): ?>
                                    <span class="text-danger d-block mt-1 small"><?= esc($erroresCampo['cintura']) ?></span>
                                <?php endif; ?>
                                <small class="text-muted d-block mt-1">Mide con cinta métrica justo por encima del ombligo, sin presionar el abdomen.</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block imc-btn-calc mt-3 shadow-sm">
                            <i class="fas fa-calculator mr-2"></i>Calcular Evaluación
                        </button>
                    </form>

                    <!-- Aviso si las medidas son anatómicamente incoherentes -->
                    <?php if (!empty($errorCoherencia)): ?>
                        <div class="imc-divider"></div>
                        <div id="resultadosImc" class="alert alert-warning border-0 shadow-sm p-4 mb-0" style="border-radius: 14px; background-color: #fff8e6; color: #7a5200;">
                            <div class="d-flex align-items-start" style="gap: 12px;">
                                <i class="fas fa-exclamation-triangle mt-1" style="font-size: 1.25rem; color: #d98e14;"></i>
                                <div>
                                    <h6 class="font-weight-bold mb-1">Revisa las medidas ingresadas</h6>
                                    <p class="mb-0 small"><?= esc($errorCoherencia) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Resultados Completos -->
                    <?php if (isset($imc)): ?>
                        <div class="imc-divider"></div>

                        <div id="resultadosImc">
                            <div class="imc-result-header">
                                <h5 class="imc-section-heading">
                                    <i class="fas fa-chart-bar mr-2"></i>Resultado de tu Evaluación
                                </h5>
                                <a href="<?= base_url('imc/limpiar') ?>" class="imc-btn-clear">
                                    <i class="fas fa-eraser mr-1"></i>Limpiar evaluación
                                </a>
                            </div>

                            <!-- 1. Tarjeta Principal: IMC + Barra Visual + Peso Saludable -->
                            <div class="imc-hero-box <?= esc($claseAlerta) ?> mb-4">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center" style="gap: 12px;">
                                    <div>
                                        <span class="d-block small font-weight-bold text-uppercase" style="opacity: 0.8;">Índice de Masa Corporal (IMC)</span>
                                        <div class="imc-score-number mt-1"><?= esc(number_format((float) $imc, 2)) ?></div>
                                    </div>
                                    <div class="text-sm-right">
                                        <span class="imc-category-pill"><?= esc($categoria) ?></span>
                                        <small class="d-block mt-1" style="opacity: 0.85;">Referencia saludable: 18.5 – 24.9</small>
                                    </div>
                                </div>

                                <!-- Barra Visual por Tramos -->
                                <div class="imc-scale-wrapper">
                                    <div class="imc-scale-bar" aria-label="Escala visual de IMC">
                                        <div class="imc-scale-seg imc-seg-under" title="Bajo peso (< 18.5)"></div>
                                        <div class="imc-scale-seg imc-seg-normal" title="Normal (18.5 – 24.9)"></div>
                                        <div class="imc-scale-seg imc-seg-over" title="Sobrepeso (25.0 – 29.9)"></div>
                                        <div class="imc-scale-seg imc-seg-obese" title="Obesidad (≥ 30.0)"></div>
                                        <div class="imc-scale-marker" style="left: <?= esc((string) $imcPosicion) ?>%;" title="Tu IMC: <?= esc((string) $imc) ?>"></div>
                                    </div>
                                    <div class="imc-scale-labels">
                                        <span>Bajo (&lt;18.5)</span>
                                        <span>Normal (18.5–24.9)</span>
                                        <span>Sobrepeso (25–29.9)</span>
                                        <span>Obesidad (≥30)</span>
                                    </div>
                                </div>

                                <!-- Rango de Peso Saludable -->
                                <div class="imc-weight-ref-bar">
                                    <strong>Peso saludable estimado para <?= esc((string) $alturaGuardada) ?> cm:</strong>
                                    <?= esc(number_format((float) $pesoMinSaludable, 1)) ?> kg – <?= esc(number_format((float) $pesoMaxSaludable, 1)) ?> kg.
                                    <span class="d-block mt-1" style="opacity: 0.9;"><?= esc($textoPesoRef) ?></span>
                                </div>
                            </div>

                            <!-- 2. Métricas de Grasa Abdominal: Perímetro + ICE -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="imc-metric-card">
                                        <span class="imc-metric-label">Perímetro Abdominal</span>
                                        <div class="imc-metric-value"><?= esc((string) $cinturaGuardada) ?> cm</div>
                                        <span class="imc-status-badge <?= esc($claseRiesgo) ?>">
                                            <i class="fas fa-ruler-horizontal"></i><?= esc($riesgoCintura) ?>
                                        </span>
                                        <div class="imc-metric-ref"><?= esc($referenciaCintura) ?></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="imc-metric-card">
                                        <span class="imc-metric-label">Índice Cintura-Estatura (ICE)</span>
                                        <div class="imc-metric-value"><?= esc(number_format((float) $ice, 2)) ?></div>
                                        <span class="imc-status-badge <?= esc($claseIce) ?>">
                                            <i class="fas fa-balance-scale"></i><?= esc($estadoIce) ?>
                                        </span>
                                        <div class="imc-metric-ref">Saludable: 0.40 – 0.49 | Lo ideal es mantener la cintura por debajo de la mitad de tu estatura.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Orientación y Recomendaciones Personalizadas -->
                            <?php if (!empty($recomendaciones)): ?>
                                <h5 class="imc-section-heading">
                                    <i class="fas fa-clipboard-list mr-2"></i>Orientación y Próximos Pasos
                                </h5>

                                <div class="imc-summary-box">
                                    <strong>Interpretación combinada:</strong> <?= esc($recomendaciones['resumen']) ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="imc-rec-card">
                                            <div class="imc-rec-header">
                                                <h6 class="imc-rec-title">
                                                    <span class="imc-rec-icon"><i class="fas fa-bullseye"></i></span>
                                                    <span>Objetivo: <?= esc($recomendaciones['objetivo_titulo']) ?></span>
                                                </h6>
                                            </div>
                                            <p class="imc-rec-text"><?= esc($recomendaciones['objetivo_texto']) ?></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="imc-rec-card">
                                            <div class="imc-rec-header">
                                                <h6 class="imc-rec-title">
                                                    <span class="imc-rec-icon"><i class="fas fa-utensils"></i></span>
                                                    <span>Alimentación</span>
                                                </h6>
                                            </div>
                                            <p class="imc-rec-text"><?= esc($recomendaciones['alimentacion']) ?></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="imc-rec-card">
                                            <div class="imc-rec-header">
                                                <h6 class="imc-rec-title">
                                                    <span class="imc-rec-icon"><i class="fas fa-running"></i></span>
                                                    <span>Actividad Física</span>
                                                </h6>
                                            </div>
                                            <p class="imc-rec-text"><?= esc($recomendaciones['actividad']) ?></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="imc-rec-card">
                                            <div class="imc-rec-header flex-wrap">
                                                <h6 class="imc-rec-title">
                                                    <span class="imc-rec-icon"><i class="fas fa-user-md"></i></span>
                                                    <span>Seguimiento Profesional</span>
                                                </h6>
                                                <span class="imc-status-badge <?= esc($recomendaciones['prioridad_clase']) ?>" style="font-size: 0.72rem; padding: 3px 10px;">
                                                    <?= esc($recomendaciones['prioridad_texto']) ?>
                                                </span>
                                            </div>
                                            <p class="imc-rec-text"><?= esc($recomendaciones['profesional']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Accesos rápidos a herramientas de NutriCheck -->
                            <div class="imc-actions-bar">
                                <a href="<?= base_url('recetas') ?>" class="btn btn-outline-secondary rounded-pill px-4 font-weight-bold">
                                    <i class="fas fa-book-open mr-2"></i>Explorar Recetas Saludables
                                </a>
                                <a href="<?= base_url('comidas') ?>" class="btn btn-outline-secondary rounded-pill px-4 font-weight-bold">
                                    <i class="fas fa-fire mr-2"></i>Ir a Racha de Comidas
                                </a>
                            </div>

                            <!-- Nota clínica orientativa -->
                            <div class="imc-disclaimer">
                                <i class="fas fa-info-circle mr-1"></i>
                                <strong>Nota informativa:</strong> Esta evaluación utiliza referencias estándar (OMS y guías NICE) diseñadas para adultos mayores de 18 años. Los resultados son orientativos y no sustituyen una consulta médica ni una valoración nutricional presencial. No aplica para menores de edad, personas embarazadas o deportistas de alto rendimiento con elevada masa muscular.
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php if (!empty($recienCalculado) && (isset($imc) || !empty($errorCoherencia))): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const resultados = document.getElementById('resultadosImc');
    if (resultados) {
        resultados.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
});
</script>
<?php endif; ?>

<?= view('template/piepagina') ?>