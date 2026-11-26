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

    .tabla-pagos thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 700;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-top: none;
        border-bottom: 1px solid #e9ecef;
    }

    .tabla-pagos tbody td {
        border-top: 1px solid #f1f3f5;
        vertical-align: middle;
    }

    .tabla-pagos tbody tr:hover {
        background-color: #fcfcfd;
    }

    .badge-metodo-zelle {
        background-color: #f3e8ff;
        color: #6b21a8;
        border: 1px solid #e9d5ff;
        font-weight: 600;
    }

    .badge-metodo-movil {
        background-color: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
        font-weight: 600;
    }

    .empty-state-img {
        width: 72px;
        height: 72px;
        object-fit: contain;
    }
</style>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-11">

            <!-- Bloque superior: encabezado con validarpagos.png -->
            <div class="panel-bloque-blanco p-4 mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div class="mb-2 mb-md-0 mr-md-3">
                        <div class="d-flex align-items-center mb-1">
                            <img src="<?= base_url('assets/imagenes/validarpagos.png') ?>" alt="Validar pagos" class="icono-titulo-pagos mr-2">
                            <h2 class="titulo-seccion-pagos mb-0">Validación de Pagos Premium</h2>
                        </div>
                        <p class="text-muted small mb-0">Verifica las transferencias reportadas por los usuarios para activar suscripciones.</p>
                    </div>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-4 text-nowrap flex-shrink-0 mt-2 mt-md-0">
                        Volver al Inicio
                    </a>
                </div>
            </div>

            <?php if(empty($pagos)): ?>
                <!-- Bloque blanco: estado vacío con sinnoticias.png -->
                <div class="panel-bloque-blanco text-center py-5 px-4">
                    <img src="<?= base_url('assets/imagenes/sinnoticias.png') ?>" alt="Sin pagos pendientes" class="empty-state-img mb-3">
                    <h5 class="text-dark font-weight-bold mb-1">¡Al día! No hay pagos pendientes por verificar.</h5>
                    <p class="text-muted small mb-0">Cuando se registren nuevas transferencias, aparecerán aquí para su revisión.</p>
                </div>
            <?php else: ?>
                <!-- Bloque blanco: tabla de pagos -->
                <div class="panel-bloque-blanco overflow-hidden">
                    <div class="table-responsive">
                        <table class="table tabla-pagos mb-0 text-left">
                            <thead class="text-nowrap">
                                <tr>
                                    <th class="py-3 pl-4">Usuario</th>
                                    <th class="py-3">Método</th>
                                    <th class="py-3">Monto</th>
                                    <th class="py-3">Referencia</th>
                                    <th class="py-3">Fecha y Hora</th>
                                    <th class="py-3">Comprobante</th>
                                    <th class="py-3 text-center pr-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 0.9rem;">
                                <?php foreach($pagos as $pago): ?>
                                    <tr>
                                        <td class="py-3 pl-4">
                                            <span class="d-block font-weight-bold text-dark"><?= esc($pago['user_name']) ?></span>
                                            <small class="text-muted"><?= esc($pago['user_email']) ?></small>
                                        </td>
                                        <td class="py-3 text-nowrap">
                                            <?php if($pago['payment_method'] === 'zelle'): ?>
                                                <span class="badge badge-pill badge-metodo-zelle px-3 py-2">Zelle</span>
                                            <?php else: ?>
                                                <span class="badge badge-pill badge-metodo-movil px-3 py-2">Pago Móvil</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3 font-weight-bold text-success text-nowrap">
                                            <?= $pago['payment_method'] === 'zelle' ? '$' : 'Bs ' ?><?= number_format($pago['amount'], 2) ?>
                                        </td>
                                        <td class="py-3 font-family-monospace text-secondary font-weight-bold text-nowrap">
                                            #<?= esc($pago['reference_number']) ?>
                                        </td>
                                        <td class="py-3 text-muted small font-weight-bold text-nowrap">
                                            <span class="d-block text-dark"><?= date('d/m/Y', strtotime($pago['created_at'])) ?></span>
                                            <span><?= date('h:i A', strtotime($pago['created_at'])) ?></span>
                                        </td>
                                        <td class="py-3 text-nowrap">
                                            <?php if(!empty($pago['receipt_image'])): ?>
                                                <a href="<?= base_url('assets/receipts/' . $pago['receipt_image']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary font-weight-bold px-3">
                                                    Ver Recibo
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">Sin captura</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3 text-center pr-4 text-nowrap">
                                            <div class="d-inline-flex align-items-center">
                                                <a href="<?= base_url('dashboard/pagos/aprobar/' . $pago['id']) ?>"
                                                   onclick="return confirm('¿Confirmas que validaste los fondos y deseas activar el estatus Premium de este usuario?')"
                                                   class="btn btn-sm btn-success font-weight-bold px-3 mr-2 rounded">
                                                    Aprobar
                                                </a>
                                                <a href="<?= base_url('dashboard/pagos/rechazar/' . $pago['id']) ?>"
                                                   onclick="return confirm('¿Deseas rechazar este reporte de pago? El usuario recibirá una alerta.')"
                                                   class="btn btn-sm btn-outline-danger font-weight-bold px-3 rounded">
                                                    Rechazar
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