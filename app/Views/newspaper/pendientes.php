<?php
/**
 * @var array $posts
 */
?>
<?= view('template/cabecera') ?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 style="color: #dc3545; font-weight: 800;">🛡️ Sala de Moderación</h2>
            <p class="text-muted mb-0">Revisa las publicaciones de los Nutricionistas antes de aprobarlas.</p>
        </div>
        <a href="<?= base_url('newspaper') ?>" class="btn btn-outline-secondary rounded-pill">Volver al Periódico</a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success shadow-sm rounded"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('fail')): ?>
        <div class="alert alert-danger shadow-sm rounded"><?= session()->getFlashdata('fail') ?></div>
    <?php endif; ?>

    <?php if(empty($posts)): ?>
        <div class="alert alert-info border-0 shadow-sm text-center py-5" style="border-radius: 15px;">
            <h3 class="mb-3">✅</h3>
            <h5 class="font-weight-bold">¡Todo al día!</h5>
            <p class="mb-0">No hay publicaciones pendientes de revisión en este momento.</p>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach($posts as $post): ?>
                <div class="col-md-12 mb-4">
                    <div class="card shadow-sm border-0" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('assets/avatars/' . $post['autor_avatar']) ?>" class="rounded-circle mr-3 shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <h5 class="font-weight-bold mb-0"><?= esc($post['title']) ?></h5>
                                        <small class="text-muted">Por <?= esc($post['autor_nombre']) ?> | Categoría: <span class="badge badge-warning text-uppercase"><?= esc($post['category']) ?></span></small>
                                    </div>
                                </div>
                                <span class="badge badge-secondary px-3 py-2">Pendiente</span>
                            </div>
                            
                            <div class="bg-light p-3 rounded mb-3" style="max-height: 150px; overflow-y: auto;">
                                <p class="mb-0 text-dark"><?= nl2br(esc($post['contents'])) ?></p>
                            </div>

                            <?php if(!empty($post['image_url'])): ?>
                                <p class="small text-muted mb-2">📸 <strong>Imagen adjunta:</strong></p>
                                <img src="<?= base_url('assets/postsimg/' . $post['image_url']) ?>" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 150px; object-fit: cover;">
                            <?php endif; ?>

                            <div class="d-flex justify-content-end border-top pt-3">
                                <a href="<?= base_url('newspaper/rechazar/' . $post['id']) ?>" onclick="return confirm('¿Seguro que deseas rechazar y eliminar esta publicación?')" class="btn btn-outline-danger font-weight-bold rounded-pill px-4 mr-2">❌ Rechazar</a>
                                
                                <a href="<?= base_url('newspaper/aprobar/' . $post['id']) ?>" class="btn btn-success font-weight-bold rounded-pill px-4 shadow-sm">✅ Aprobar Publicación</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= view('template/piepagina') ?>