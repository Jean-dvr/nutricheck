</div> 
  <?php 
$rolActual = session()->get('rol');

// Mostramos a Free y Admin (Premium y Nutricionista no ven esto)
if(in_array($rolActual, ['free', 'admin'])): 
    
    $bannersModel = new \App\Models\BannersModel();
    $dbBanners = \Config\Database::connect();
    if ($dbBanners->fieldExists('orientation', 'banners')) {
        $listaBanners = $bannersModel->where('orientation', 'vertical')->orderBy('created_at', 'DESC')->findAll();
    } else {
        $listaBanners = $bannersModel->orderBy('created_at', 'DESC')->findAll();
    }
    
    // TRUCO LÓGICO para la rotación
    if(empty($listaBanners)) {
        $nombresBanners = ['placeholder', 'placeholder'];
    } elseif(count($listaBanners) === 1) {
        $nombresBanners = [$listaBanners[0]['image_url'], $listaBanners[0]['image_url']];
    } else {
        $nombresBanners = array_column($listaBanners, 'image_url');
    }
?>
    <style>
        /* Estética suave para los banners publicitarios laterales */
        .nc-side-ad {
            position: fixed;
            top: calc(50% + 32px);
            transform: translateY(-50%);
            width: 170px;
            height: min(540px, calc(100vh - 125px));
            background-color: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 20px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
            padding: 8px;
            z-index: 1050;
            text-align: center;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        /* Evita que los laterales tapen el contenido al hacer zoom o en resoluciones intermedias */
        @media (max-width: 1499.98px) {
            .nc-side-ad {
                display: none !important;
            }
        }
        .nc-side-ad:hover {
            box-shadow: 0 16px 38px rgba(0, 0, 0, 0.12);
        }
        .nc-side-ad-header {
            height: 26px;
            padding: 0 6px 6px 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nc-side-ad-header.nc-centered {
            justify-content: center;
        }
        .nc-side-ad-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: #8c939a;
        }
        .nc-side-ad-close {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: none;
            background-color: #f1f3f5;
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .nc-side-ad-close:hover {
            background-color: #ffe3e3;
            color: #dc3545;
        }
        .nc-side-ad-canvas {
            position: relative;
            width: 100%;
            height: calc(100% - 26px);
            border-radius: 14px;
            overflow: hidden;
            background-color: #f4f6f9;
            background-size: cover;
            background-position: center;
            transition: opacity 0.4s ease;
        }
        .nc-side-ad-link {
            position: absolute;
            inset: 0;
            z-index: 1;
            display: block;
        }
        .nc-side-ad-overlay {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 26px 8px 10px 8px;
            background: linear-gradient(to top, rgba(20, 20, 24, 0.72) 0%, rgba(20, 20, 24, 0) 100%);
            z-index: 2;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }
        .nc-side-ad-pill {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50rem;
            background: rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.2px;
        }
        .nc-side-ad-pro-link {
            pointer-events: auto;
            display: inline-block;
            padding: 4px 10px;
            border-radius: 50rem;
            background: rgba(248, 177, 51, 0.92);
            color: #212529 !important;
            font-size: 0.68rem;
            font-weight: 700;
            text-decoration: none !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.16);
            transition: transform 0.18s ease, background-color 0.18s ease;
        }
        .nc-side-ad-pro-link:hover {
            background: #ff9f1c;
            transform: translateY(-1px);
        }
        .nc-side-ad-admin-panel {
            position: absolute;
            left: 8px;
            right: 8px;
            bottom: 8px;
            background: rgba(24, 24, 28, 0.82);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 12px 10px;
            color: #ffffff;
            z-index: 3;
        }
        .nc-side-ad-file {
            width: 100%;
            font-size: 0.68rem;
            color: #e9ecef;
            margin-bottom: 10px;
        }
    </style>

    <div id="freemium-ad-izq" class="d-none d-xl-block nc-side-ad" style="left: 18px;">
        <div class="nc-side-ad-header <?= $rolActual !== 'admin' ? 'nc-centered' : '' ?>">
            <span class="nc-side-ad-label"><?= $rolActual === 'admin' ? '📊 Estadísticas' : 'Publicidad' ?></span>
            <?php if($rolActual === 'admin'): ?>
                <button type="button" class="nc-side-ad-close" aria-label="Cerrar anuncios" title="Ocultar anuncios temporalmente" onclick="cerrarAnuncios()">&times;</button>
            <?php endif; ?>
        </div>
        
        <div id="banner-img-izq" class="nc-side-ad-canvas">
            
            <?php if($rolActual !== 'admin'): ?>
                <a href="<?= base_url('premium/checkout') ?>" class="nc-side-ad-link" aria-label="Mejorar a NutriCheckPro"></a>
                <div class="nc-side-ad-overlay">
                    <span class="nc-side-ad-pill ad-timer-badge">Cambia en <span class="time-left-span">30</span>s</span>
                    <a href="<?= base_url('premium/checkout') ?>" class="nc-side-ad-pro-link">✨ Quitar anuncios</a>
                </div>
            <?php endif; ?>

            <?php if($rolActual === 'admin'): ?>
                <div class="nc-side-ad-admin-panel text-center">
                    <p class="small font-weight-bold mb-1 text-warning" style="font-size: 0.72rem;">Anuncios Activos</p>
                    <h3 class="mb-2 text-white font-weight-bold"><?= count($listaBanners) ?></h3>
                    <button class="btn btn-danger btn-sm btn-block font-weight-bold rounded-pill shadow-sm" data-toggle="modal" data-target="#modalGestionarBanners">🗑️ Gestionar</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="freemium-ad-der" class="d-none d-xl-block nc-side-ad" style="right: 18px;">
        <div class="nc-side-ad-header <?= $rolActual !== 'admin' ? 'nc-centered' : '' ?>">
            <span class="nc-side-ad-label"><?= $rolActual === 'admin' ? '⚙️ Nuevo Anuncio' : 'Publicidad' ?></span>
            <?php if($rolActual === 'admin'): ?>
                <button type="button" class="nc-side-ad-close" aria-label="Cerrar anuncios" title="Ocultar anuncios temporalmente" onclick="cerrarAnuncios()">&times;</button>
            <?php endif; ?>
        </div>
        
        <div id="banner-img-der" class="nc-side-ad-canvas">
            
            <?php if($rolActual !== 'admin'): ?>
                <a href="<?= base_url('premium/checkout') ?>" class="nc-side-ad-link" aria-label="Mejorar a NutriCheckPro"></a>
                <div class="nc-side-ad-overlay">
                    <span class="nc-side-ad-pill ad-timer-badge">Cambia en <span class="time-left-span">30</span>s</span>
                    <a href="<?= base_url('premium/checkout') ?>" class="nc-side-ad-pro-link">✨ Quitar anuncios</a>
                </div>
            <?php endif; ?>

            <?php if($rolActual === 'admin'): ?>
                <div class="nc-side-ad-admin-panel text-left">
                    <form action="<?= base_url('dashboard/actualizarAnuncio') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="orientation" value="vertical">
                        <label class="small font-weight-bold mb-2 text-warning d-block" style="font-size: 0.72rem;">Añadir rotación (160x600px)</label>
                        <input type="file" name="nuevo_anuncio" class="nc-side-ad-file" accept="image/png, image/jpeg, image/jpg" required>
                        <button type="submit" class="btn btn-success btn-sm btn-block font-weight-bold rounded-pill shadow-sm">➕ Subir</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if($rolActual === 'admin'): ?>
    <div class="modal fade text-left" id="modalGestionarBanners" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header bg-white">
                    <h5 class="modal-title font-weight-bold text-dark">⚙️ Gestionar Banners en Rotación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <?php if(empty($listaBanners)): ?>
                        <div class="text-center py-5">
                            <h3 class="text-muted">📭</h3>
                            <p class="text-muted font-weight-bold">No hay banners subidos en el sistema actualmente.</p>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach($listaBanners as $banner): ?>
                                <div class="col-6 col-md-3 mb-4">
                                    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 10px;">
                                        <img src="<?= base_url('assets/ads/' . $banner['image_url']) ?>" class="card-img-top bg-dark" style="height: 250px; object-fit: contain;" alt="Banner">
                                        <div class="card-body p-2">
                                            <a href="<?= base_url('dashboard/eliminarAnuncio/' . $banner['id']) ?>" onclick="return confirm('¿Seguro que deseas eliminar este banner de la base de datos permanentemente?')" class="btn btn-outline-danger btn-sm btn-block font-weight-bold rounded-pill">❌ Quitar</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        const banners = <?= json_encode($nombresBanners) ?>;
        const urlBase = "<?= base_url('assets/ads/') ?>/";
        
        let indexIzq = 0;
        let indexDer = 1;
        let rotacionAd = null;

        const bannerIzq = document.getElementById('banner-img-izq');
        const bannerDer = document.getElementById('banner-img-der');
        
        function obtenerUrl(nombre) {
            return nombre === 'placeholder' ? 'https://via.placeholder.com/160x600?text=Sube+tu+Banner' : urlBase + nombre;
        }

        bannerIzq.style.backgroundImage = "url('" + obtenerUrl(banners[indexIzq]) + "')";
        bannerDer.style.backgroundImage = "url('" + obtenerUrl(banners[indexDer]) + "')";

        <?php if($rolActual === 'admin'): ?>
        function cerrarAnuncios() { 
            document.getElementById('freemium-ad-izq').style.display = 'none'; 
            document.getElementById('freemium-ad-der').style.display = 'none'; 
            if (rotacionAd) clearInterval(rotacionAd);
        }
        <?php else: ?>
        let segundosFaltantes = 30;
        const contadores = document.querySelectorAll('.time-left-span');

        rotacionAd = setInterval(() => {
            segundosFaltantes--;
            contadores.forEach(c => c.textContent = segundosFaltantes);
            
            if (segundosFaltantes <= 0) {
                indexIzq = (indexIzq + 1) % banners.length;
                indexDer = (indexDer + 1) % banners.length;
                
                bannerIzq.style.opacity = "0";
                bannerDer.style.opacity = "0";
                
                setTimeout(() => { 
                    bannerIzq.style.backgroundImage = "url('" + obtenerUrl(banners[indexIzq]) + "')";
                    bannerDer.style.backgroundImage = "url('" + obtenerUrl(banners[indexDer]) + "')";
                    bannerIzq.style.opacity = "1";
                    bannerDer.style.opacity = "1";
                }, 400);

                segundosFaltantes = 30;
                contadores.forEach(c => c.textContent = segundosFaltantes);
            }
        }, 1000);
        <?php endif; ?>
    </script>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>