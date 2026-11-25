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

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="text-center mb-4">
                <?php if(!empty($esPremium)): ?>
                    <h2 style="color: #ffc107; font-weight: 800;">⭐ Tu Suscripción NutriCheckPro</h2>
                    <p class="text-muted">Consulta la vigencia de tu plan actual o prolonga tu suscripción por <strong>1 mes adicional ($5.00)</strong>.</p>
                <?php else: ?>
                    <h2 style="color: #ffc107; font-weight: 800;">⭐ Conviértete en Premium</h2>
                    <p class="text-muted">Desbloquea el acceso ilimitado a NutriCheck y elimina la publicidad por solo <strong>$5.00 al mes</strong>.</p>
                <?php endif; ?>
            </div>

            <?php if(!empty($esPremium)): ?>
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; background-color: #fff9e6; border-left: 5px solid #ffc107 !important;">
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h5 class="font-weight-bold text-dark mb-1">✅ Plan Premium Activo</h5>
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
                                    ⏳ <?= esc((string) $diasRestantes) ?> <?= ($diasRestantes === 1) ? 'día restante' : 'días restantes' ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; background-color: #f8f9fa;">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold text-dark mb-3">📱 Pago Móvil</h5>
                            <ul class="list-unstyled text-left small text-muted">
                                <li><strong>Banco:</strong> Banesco (0134)</li>
                                <li><strong>Teléfono:</strong> 0414-1234567</li>
                                <li><strong>Cédula:</strong> V-28.000.000</li>
                                <li class="mt-2 text-center text-success font-weight-bold">Monto: 195,00 Bs</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; background-color: #f8f9fa;">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold text-dark mb-3">💸 Zelle</h5>
                            <ul class="list-unstyled text-left small text-muted">
                                <li><strong>Correo:</strong> pagos@nutricheck.com</li>
                                <li><strong>Titular:</strong> NutriCheck LLC</li>
                                <li class="mt-2 text-center text-success font-weight-bold">Monto: $5.00</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="font-weight-bold">
                        <?= !empty($esPremium) ? '🔄 Prolongar Suscripción (+1 Mes)' : '📋 Reportar Transferencia' ?>
                    </h5>
                </div>
                <div class="card-body p-4">
                    
                    <?php if(!empty($pagoPendiente)): ?>
                        
                        <div class="alert alert-warning text-center rounded" style="border: 2px dashed #ffc107;">
                            <h4 class="mb-2">⏳</h4>
                            <h5 class="font-weight-bold text-dark">Tu pago está en revisión</h5>
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
</div>

<?= view('template/piepagina') ?>