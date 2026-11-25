<?php
/**
 * Variables inyectadas por el Controlador Newspaper
 * @var array $posts
 * @var string $categoria_actual
 * @var string $rol_usuario
 */
?>
<?= view('template/cabecera') ?>

<div class="container mt-4 mb-5">

    <div class="row align-items-center mb-4 border-bottom pb-3">
        <div class="col-lg-5 mb-3 mb-lg-0 text-center text-lg-left">
            <h2 style="color: #f1682d; font-weight: 800; font-family: serif; margin-bottom: 0;">📰 NutriCheck News</h2>
            <p class="text-muted small mb-0">Lo último en salud, jornadas médicas y nutrición.</p>
        </div>
        
        <div class="col-lg-7 text-center text-lg-right">
            
            <?php if($rol_usuario === 'admin'): ?>
                <a href="<?= base_url('newspaper/pendientes') ?>" class="btn font-weight-bold text-white shadow-sm rounded-pill mr-md-2 mb-2" style="background-color: #dc3545;">
                    🛡️ Revisar Pendientes 
                    <?php if(isset($pendientes_count) && $pendientes_count > 0): ?>
                        <span class="badge badge-light text-danger ml-1"><?= $pendientes_count ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

            <?php if(in_array($rol_usuario, ['admin', 'nutricionista'])): ?>
                <a href="<?= base_url('newspaper/crear') ?>" class="btn font-weight-bold text-white shadow-sm rounded-pill mr-md-2 mb-2" style="background-color: #28a745;">
                    ✍️ Nueva Publicación
                </a>
            <?php endif; ?>

            <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm mb-2">
                Volver al Inicio
            </a>

        </div>
    </div> 
    
    <div class="d-flex justify-content-center mb-5">
        <ul class="nav nav-pills font-weight-bold flex-wrap justify-content-center">
            <li class="nav-item mx-2 mb-2">
                <a class="nav-link px-4 rounded-pill <?= $categoria_actual == 'general' ? 'active shadow-sm text-white' : 'bg-light text-dark' ?>" 
                   href="<?= base_url('newspaper?cat=general') ?>" 
                   <?= $categoria_actual == 'general' ? 'style="background-color: #f1682d;"' : '' ?>>🌐 General</a>
            </li>
            <li class="nav-item mx-2 mb-2">
                <a class="nav-link px-4 rounded-pill <?= $categoria_actual == 'eventos' ? 'active shadow-sm text-white' : 'bg-light text-dark' ?>" 
                   href="<?= base_url('newspaper?cat=eventos') ?>"
                   <?= $categoria_actual == 'eventos' ? 'style="background-color: #f1682d;"' : '' ?>>📅 Eventos y Jornadas</a>
            </li>
            <li class="nav-item mx-2 mb-2">
                <a class="nav-link px-4 rounded-pill <?= $categoria_actual == 'recetas' ? 'active shadow-sm text-white' : 'bg-light text-dark' ?>" 
                   href="<?= base_url('newspaper?cat=recetas') ?>"
                   <?= $categoria_actual == 'recetas' ? 'style="background-color: #f1682d;"' : '' ?>>🍲 Recetas Especiales</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <?php if(empty($posts)): ?>
            <div class="col-12 text-center py-5">
                <h1 class="text-muted mb-3">📭</h1>
                <h5 class="text-muted font-weight-bold">Aún no hay publicaciones en esta sección.</h5>
            </div>
        <?php else: ?>
            <?php foreach($posts as $post): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 position-relative" style="border-radius: 15px; overflow: hidden;">
                        
                        <div class="position-absolute" style="top: 15px; right: 15px; z-index: 10;">
                            <?php if($post['category'] === 'eventos'): ?>
                                <span class="badge badge-info shadow-sm px-3 py-2" style="font-size: 0.8rem;">📅 Evento/Jornada</span>
                            <?php elseif($post['category'] === 'recetas'): ?>
                                <span class="badge badge-warning text-white shadow-sm px-3 py-2" style="font-size: 0.8rem;">🍲 Receta</span>
                            <?php elseif($post['category'] === 'general'): ?>
                                <span class="badge shadow-sm px-3 py-2 text-white" style="background-color: #f1682d; font-size: 0.8rem;">🌐 Noticia</span>
                            <?php endif; ?>
                        </div>

                        <?php if(!empty($post['image_url'])): ?>
                            <img src="<?= base_url('assets/postsimg/' . $post['image_url']) ?>" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Imagen del artículo">
                        <?php endif; ?>
                        
                        <div class="card-body <?= empty($post['image_url']) ? 'mt-4' : '' ?>">
                            <h4 class="font-weight-bold text-dark mb-3"><?= esc($post['title']) ?></h4>
                            <p class="text-muted" style="display: -webkit-box; -webkit-line-clamp: 4; line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= nl2br(esc($post['contents'])) ?>
                            </p>
                        </div>
                        
                       
                        
                        
                        <div class="card-footer bg-white border-top-0 pt-0 pb-3 d-flex justify-content-between align-items-center">
                            
                            <!-- Datos del Autor -->
                            <div class="d-flex align-items-center">
                                <img src="<?= base_url('assets/avatars/' . $post['autor_avatar']) ?>" class="rounded-circle mr-2 shadow-sm" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #f1682d;">
                                <div>
                                    <small class="d-block font-weight-bold text-dark mb-0" style="line-height: 1.2;"><?= esc($post['autor_nombre']) ?></small>
                                    <small class="text-muted" style="font-size: 0.75rem;">📅 <?= date('d/m/Y h:i A', strtotime($post['created_at'])) ?></small>
                                </div>
                            </div>

                            <!-- Botón de Eliminar (Exclusivo para el Admin) -->
                            <?php if($rol_usuario === 'admin'): ?>
                                <a href="<?= base_url('newspaper/eliminar/' . $post['id']) ?>" 
                                   onclick="return confirm('¿Estás seguro de que deseas eliminar esta publicación permanentemente?')" 
                                   class="btn btn-sm btn-outline-danger shadow-sm rounded-circle" 
                                   style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"
                                   title="Eliminar Publicación">
                                    🗑️
                                </a>
                            <?php endif; ?>

                        </div>
                       

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?= view('template/piepagina') ?>