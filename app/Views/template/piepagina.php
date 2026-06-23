  </div> 
  <?php 
$rolActual = session()->get('rol');

// Mostramos a Free, Nutricionista y Admin (Premium no ve esto)
if(in_array($rolActual, ['free', 'nutricionista', 'admin'])): 
    
    $bannersModel = new \App\Models\BannersModel();
    $listaBanners = $bannersModel->orderBy('created_at', 'DESC')->findAll();
    
    // TRUCO LÓGICO para la rotación
    if(empty($listaBanners)) {
        $nombresBanners = ['placeholder', 'placeholder'];
    } elseif(count($listaBanners) === 1) {
        $nombresBanners = [$listaBanners[0]['image_url'], $listaBanners[0]['image_url']];
    } else {
        $nombresBanners = array_column($listaBanners, 'image_url');
    }
?>
    <div id="freemium-ad-izq" class="d-none d-xl-block shadow" style="position: fixed; left: 20px; top: 50%; transform: translateY(-50%); width: 160px; height: 600px; background-color: #f8f9fa; border: 1px solid #ddd; z-index: 1050; border-radius: 8px; overflow: hidden; text-align: center;">
        <div style="background-color: #e9ecef; padding: 5px; font-size: 0.75rem; color: #6c757d; display: flex; justify-content: space-between; align-items: center;">
            <span class="font-weight-bold"><?= $rolActual === 'admin' ? '📊 Estadísticas' : 'Publicidad' ?></span>
            <?php if($rolActual !== 'admin'): ?>
                <button type="button" class="close" aria-label="Close" onclick="cerrarAnuncios()" style="font-size: 1rem; line-height: 1;">&times;</button>
            <?php endif; ?>
        </div>
        
        <div id="banner-img-izq" style="position: relative; width: 100%; height: calc(100% - 28px); background-size: cover; background-position: center; transition: opacity 0.4s ease;">
            
            <?php if($rolActual !== 'admin'): ?>
                <div class="badge badge-warning p-2 shadow-sm text-dark font-weight-bold ad-timer-badge" style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); width: 90%;">
                    Cambia en <span class="time-left-span">30</span>s
                </div>
            <?php endif; ?>

            <?php if($rolActual === 'admin'): ?>
                <div style="position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0,0,0,0.8); padding: 15px 10px; color: white; text-align: center;">
                    <p class="small font-weight-bold mb-1 text-warning">Anuncios Activos</p>
                    <h3 class="mb-2 text-white"><?= count($listaBanners) ?></h3>
                    <button class="btn btn-danger btn-sm btn-block font-weight-bold shadow-sm" data-toggle="modal" data-target="#modalGestionarBanners">🗑️ Gestionar</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="freemium-ad-der" class="d-none d-xl-block shadow" style="position: fixed; right: 20px; top: 50%; transform: translateY(-50%); width: 160px; height: 600px; background-color: #f8f9fa; border: 1px solid #ddd; z-index: 1050; border-radius: 8px; overflow: hidden; text-align: center;">
        <div style="background-color: #e9ecef; padding: 5px; font-size: 0.75rem; color: #6c757d; display: flex; justify-content: space-between; align-items: center;">
            <span class="font-weight-bold"><?= $rolActual === 'admin' ? '⚙️ Nuevo Anuncio' : 'Publicidad' ?></span>
            <?php if($rolActual !== 'admin'): ?>
                <button type="button" class="close" aria-label="Close" onclick="cerrarAnuncios()" style="font-size: 1rem; line-height: 1;">&times;</button>
            <?php endif; ?>
        </div>
        
        <div id="banner-img-der" style="position: relative; width: 100%; height: calc(100% - 28px); background-size: cover; background-position: center; transition: opacity 0.4s ease;">
            
            <?php if($rolActual !== 'admin'): ?>
                <div class="badge badge-warning p-2 shadow-sm text-dark font-weight-bold ad-timer-badge" style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); width: 90%;">
                    Cambia en <span class="time-left-span">30</span>s
                </div>
            <?php endif; ?>

            <?php if($rolActual === 'admin'): ?>
                <div style="position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0,0,0,0.8); padding: 15px 10px; color: white; text-align: left;">
                    <form action="<?= base_url('dashboard/actualizarAnuncio') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <label class="small font-weight-bold mb-2 text-warning">Añadir rotación (160x600px)</label>
                        <input type="file" name="nuevo_anuncio" class="form-control-file form-control-sm mb-3 text-white" accept="image/png, image/jpeg, image/jpg" required style="font-size: 0.75rem;">
                        <button type="submit" class="btn btn-success btn-sm btn-block font-weight-bold shadow-sm">➕ Subir</button>
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
                                            <a href="<?= base_url('dashboard/eliminarAnuncio/' . $banner['id']) ?>" onclick="return confirm('¿Seguro que deseas eliminar este banner de la base de datos permanentemente?')" class="btn btn-outline-danger btn-sm btn-block font-weight-bold">❌ Quitar</a>
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
        let rotacionAd;

        const bannerIzq = document.getElementById('banner-img-izq');
        const bannerDer = document.getElementById('banner-img-der');
        
        function obtenerUrl(nombre) {
            return nombre === 'placeholder' ? 'https://via.placeholder.com/160x600?text=Sube+tu+Banner' : urlBase + nombre;
        }

        bannerIzq.style.backgroundImage = "url('" + obtenerUrl(banners[indexIzq]) + "')";
        bannerDer.style.backgroundImage = "url('" + obtenerUrl(banners[indexDer]) + "')";

        <?php if($rolActual !== 'admin'): ?>
        function cerrarAnuncios() { 
            document.getElementById('freemium-ad-izq').style.display = 'none'; 
            document.getElementById('freemium-ad-der').style.display = 'none'; 
            clearInterval(rotacionAd);
        }
        
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