<?php
/**
 * Variables inyectadas por el Controlador Payments
 * @var array|null  $pagoPendiente
 * @var bool        $esPremium
 * @var string|null $fechaVencimiento
 * @var int|null    $diasRestantes
 */
?>
<?= view('template/cabecera') ?>

<style>
    .panel-bloque-blanco {
        background-color: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
    }

    .titulo-seccion-pagos {
        font-family: inherit;
        font-weight: 800;
        color: #6b6b6b;
        letter-spacing: -0.02em;
        line-height: 1.1;
    }

    .icono-titulo-pagos {
        width: 36px;
        height: 36px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .subtitulo-seccion-pagos {
        color: #7c7c7c;
        font-size: 0.9rem;
    }

    .bloque-estado-activo {
        background-color: #fff9e6;
        border: 1px solid #f5e2a8;
        border-left: 5px solid #ffc107 !important;
    }

    .bloque-metodo-pago {
        background-color: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
    }

    .alerta-revision-pago {
        background-color: #fff9e6;
        border: 2px dashed #ffc107;
        border-radius: 12px;
    }
</style>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Bloque superior: encabezado con validarpagos.png -->
            <div class="panel-bloque-blanco p-4 mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div class="mb-2 mb-md-0 mr-md-3">
                        <?php if(!empty($esPremium)): ?>
                            <div class="d-flex align-items-center mb-1">
                                <img src="<?= base_url('assets/imagenes/validarpagos.png') ?>" alt="Suscripción Premium" class="icono-titulo-pagos mr-2">
                                <h2 class="titulo-seccion-pagos mb-0">Tu Suscripción NutriCheckPro</h2>
                            </div>
                            <p class="subtitulo-seccion-pagos mb-0">Consulta la vigencia de tu plan actual o prolonga tu suscripción por <strong>1 mes adicional ($5.00)</strong>.</p>
                        <?php else: ?>
                            <div class="d-flex align-items-center mb-1">
                                <img src="<?= base_url('assets/imagenes/validarpagos.png') ?>" alt="Conviértete en Premium" class="icono-titulo-pagos mr-2">
                                <h2 class="titulo-seccion-pagos mb-0">Conviértete en Premium</h2>
                            </div>
                            <p class="subtitulo-seccion-pagos mb-0">Desbloquea el acceso ilimitado a NutriCheck y elimina la publicidad por solo <strong>$5.00 al mes</strong>.</p>
                        <?php endif; ?>
                    </div>

                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-4 text-nowrap flex-shrink-0 mt-2 mt-md-0">
                        Volver al Inicio
                    </a>
                </div>
            </div>

            <?php if(!empty($esPremium)): ?>
                <!-- Bloque: estado de suscripción activa -->
                <div class="panel-bloque-blanco bloque-estado-activo p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mr-md-3">
                            <h5 class="font-weight-bold text-dark mb-1">Plan Premium Activo</h5>
                            <?php if(!empty($fechaVencimiento)): ?>
                                <p class="text-muted mb-0 small">
                                    Tu suscripción vence el <strong><?= date('d/m/Y', strtotime($fechaVencimiento)) ?></strong>.
                                </p>
                            <?php else: ?>
                                <p class="text-muted mb-0 small">
                                    Tu cuenta cuenta con beneficios Premium activos. Al reportar una renovación se asignará un nuevo periodo mensual.
                                </p>
                            <?php endif; ?>
                        </div>
                        <?php if($diasRestantes !== null): ?>
                            <div class="mt-2 mt-md-0">
                                <span class="badge badge-warning px-3 py-2 text-dark shadow-sm" style="font-size: 0.95rem;">
                                    <?= esc((string) $diasRestantes) ?> <?= ($diasRestantes === 1) ? 'día restante' : 'días restantes' ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Bloques blancos: métodos de pago -->
            <div class="row mb-2">
                <div class="col-md-6 mb-3">
                    <div class="bloque-metodo-pago h-100 p-4 text-center">
                        <h5 class="font-weight-bold text-dark mb-3">Pago Móvil</h5>
                        <ul class="list-unstyled text-left small text-muted mb-0">
                            <li class="mb-1"><strong>Banco:</strong> Banesco (0134)</li>
                            <li class="mb-1"><strong>Teléfono:</strong> 0414-1234567</li>
                            <li class="mb-1"><strong>Cédula:</strong> V-28.000.000</li>
                            <li class="mt-3 text-center text-success font-weight-bold">Monto: 195,00 Bs</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="bloque-metodo-pago h-100 p-4 text-center">
                        <h5 class="font-weight-bold text-dark mb-3">Zelle</h5>
                        <ul class="list-unstyled text-left small text-muted mb-0">
                            <li class="mb-1"><strong>Correo:</strong> pagos@nutricheck.com</li>
                            <li class="mb-1"><strong>Titular:</strong> NutriCheck LLC</li>
                            <li class="mt-3 text-center text-success font-weight-bold">Monto: $5.00</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Bloque blanco: reporte o estado de revisión -->
            <div class="panel-bloque-blanco p-4">
                <h5 class="font-weight-bold text-dark mb-3">
                    <?= !empty($esPremium) ? 'Prolongar Suscripción (+1 Mes)' : 'Reportar Transferencia' ?>
                </h5>

                <?php if(!empty($pagoPendiente)): ?>

                    <div class="alerta-revision-pago p-4 text-center">
                        <h5 class="font-weight-bold text-dark mb-2">Tu pago está en revisión</h5>
                        <p class="mb-0 text-dark small">Ya hemos recibido un reporte tuyo y nuestro equipo lo está validando. Si todo es correcto, tu suscripción Premium se actualizará en breve.</p>
                    </div>

                <?php else: ?>

                    <form action="<?= base_url('premium/reportar') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="small font-weight-bold text-muted">Método utilizado</label>
                                <select class="form-control" name="payment_method" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="pago_movil">Pago Móvil</option>
                                    <option value="zelle">Zelle</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small font-weight-bold text-muted">Monto Enviado</label>
                                <input type="number" step="0.01" class="form-control" name="amount" placeholder="Ej: 5.00 o 195.00" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small font-weight-bold text-muted">Número de Referencia</label>
                            <input type="text" class="form-control" name="reference_number" placeholder="Últimos 4 o 6 dígitos" required>
                        </div>

                        <div class="form-group">
                            <label class="small font-weight-bold text-muted">Comprobante (Captura de pantalla)</label>
                            <input type="file" class="form-control-file border p-2 rounded bg-light" name="receipt_image" accept="image/png, image/jpeg, image/jpg" required>
                        </div>

                        <button type="submit" class="btn btn-warning btn-block font-weight-bold shadow-sm rounded-pill mt-4 text-dark" style="padding: 12px;">
                            <?= !empty($esPremium) ? 'Enviar Reporte para Prolongar Plan' : 'Enviar Reporte de Pago' ?>
                        </button>
                    </form>

                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?= view('template/piepagina') ?>