<?= view('template/cabecera') ?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div class="mb-2 mb-md-0 mr-md-3">
                    <h2 class="font-weight-bold text-dark" style="font-family: sans-serif;">🛡️ Validación de Pagos Premium</h2>
                    <p class="text-muted small mb-0">Verifica las transferencias reportadas por los usuarios para activar suscripciones.</p>
                </div>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm text-nowrap flex-shrink-0 mt-2 mt-md-0">Volver al Inicio</a>
            </div>

            <?php if(empty($pagos)): ?>
                <div class="card border-0 shadow-sm text-center py-5 px-3" style="border-radius: 15px;">
                    <h1 class="text-muted mb-2">☕</h1>
                    <h5 class="text-muted font-weight-bold mb-0">¡Al día! No hay pagos pendientes por verificar.</h5>
                </div>
            <?php else: ?>
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-left">
                            <thead class="bg-dark text-white text-nowrap" style="font-size: 0.85rem;">
                                <tr>
                                    <th class="py-3 pl-4">Usuario</th>
                                    <th class="py-3">Método</th>
                                    <th class="py-3">Monto</th>
                                    <th class="py-3">Referencia</th>
                                    <!-- NUEVA COLUMNA: FECHA -->
                                    <th class="py-3">Fecha y Hora</th>
                                    <th class="py-3">Comprobante</th>
                                    <th class="py-3 text-center pr-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 0.9rem;">
                                <?php foreach($pagos as $pago): ?>
                                    <tr class="align-middle">
                                        <td class="py-3 pl-4">
                                            <span class="d-block font-weight-bold text-dark"><?= esc($pago['user_name']) ?></span>
                                            <small class="text-muted"><?= esc($pago['user_email']) ?></small>
                                        </td>
                                        <td class="py-3 align-middle text-nowrap">
                                            <span class="badge badge-pill <?= $pago['payment_method'] === 'zelle' ? 'badge-purple text-white' : 'badge-info' ?> px-3 py-2" style="<?= $pago['payment_method'] === 'zelle' ? 'background-color: #7414ca;' : '' ?>">
                                                <?= $pago['payment_method'] === 'zelle' ? '💸 Zelle' : '📱 Pago Móvil' ?>
                                            </span>
                                        </td>
                                        <td class="py-3 align-middle font-weight-bold text-success text-nowrap">
                                            <?= $pago['payment_method'] === 'zelle' ? '$' : 'Bs ' ?><?= number_format($pago['amount'], 2) ?>
                                        </td>
                                        <td class="py-3 align-middle font-family-monospace text-secondary font-weight-bold text-nowrap">
                                            #<?= esc($pago['reference_number']) ?>
                                        </td>
                                        
                                        <!-- NUEVA CELDA: FECHA FORMATEADA -->
                                        <td class="py-3 align-middle text-muted small font-weight-bold text-nowrap">
                                            📅 <?= date('d/m/Y', strtotime($pago['created_at'])) ?><br>
                                            🕒 <?= date('h:i A', strtotime($pago['created_at'])) ?>
                                        </td>

                                        <td class="py-3 align-middle text-nowrap">
                                            <?php if(!empty($pago['receipt_image'])): ?>
                                                <a href="<?= base_url('assets/receipts/' . $pago['receipt_image']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary font-weight-bold">
                                                    👁️ Ver Recibo
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">Sin captura</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3 align-middle text-center pr-4 text-nowrap">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('dashboard/pagos/aprobar/' . $pago['id']) ?>" 
                                                   onclick="return confirm('¿Confirmas que validaste los fondos y deseas activar el estatus Premium de este usuario?')" 
                                                   class="btn btn-sm btn-success font-weight-bold px-3 mr-2 rounded shadow-sm">
                                                    ✅ Aprobar
                                                </a>
                                                <a href="<?= base_url('dashboard/pagos/rechazar/' . $pago['id']) ?>" 
                                                   onclick="return confirm('¿Deseas rechazar este reporte de pago? El usuario recibirá una alerta.')" 
                                                   class="btn btn-sm btn-danger font-weight-bold px-3 rounded shadow-sm">
                                                    ❌ Rechazar
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?= view('template/piepagina') ?>