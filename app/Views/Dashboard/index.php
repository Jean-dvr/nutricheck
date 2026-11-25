<?= view('Dashboard/cabecera') ?>

<link rel="stylesheet" href="<?= base_url('/assets/css/meallogs.css?v=2.0') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/css/dashboard.css?v=2.0') ?>">

<main class="dashboard-layout">
    
    <!-- Panel Izquierdo: Herramientas -->
    <section class="tools-grid">
        <div class="dash-card">
            <div class="card-info">
                <img src="<?= base_url('/assets/imagenes/iconcalculadoranaranja.png') ?>" alt="IMC" class="card-icon">
                <div class="text-group">
                    <h2>Calculadora IMC</h2>
                    <p>Calcula tu Índice de Masa Corporal y conoce tu estado actual.</p>
                </div>
            </div>
            <a href="<?= base_url('imc') ?>" class="btn-probar">PROBAR</a>
        </div>

        <div class="dash-card">
            <div class="card-info">
                <img src="<?= base_url('/assets/imagenes/iconlupanaranja.png') ?>" alt="Recetas" class="card-icon">
                <div class="text-group">
                    <h2>Recetas</h2>
                    <p>Encuentra recetas filtradas según tu perfil clínico y patologías.</p>
                </div>
            </div>
            <a href="<?= base_url('recetas') ?>" class="btn-probar">PROBAR</a>
        </div>

        <div class="dash-card">
            <div class="card-info">
                <img src="<?= base_url('/assets/imagenes/megafononaranja.png') ?>" alt="Noticias" class="card-icon">
                <div class="text-group">
                    <h2>Noticias</h2>
                    <p>Mantente al día con artículos médicos, jornadas y consejos nutricionales.</p>
                </div>
            </div>
            <?php if(!in_array(session()->get('rol'), ['premium', 'pro', 'nutricionista', 'admin'])): ?>
                <a href="<?= base_url('premium/checkout') ?>" class="btn-probar btn-locked">PROBAR</a>
            <?php else: ?>
                <a href="<?= base_url('newspaper') ?>" class="btn-probar">PROBAR</a>
            <?php endif; ?>
        </div>

        <div class="dash-card">
            <div class="card-info">
                <img src="<?= base_url('/assets/imagenes/fuegonaranja.png') ?>" alt="Diario" class="card-icon">
                <div class="text-group">
                    <h2>Racha de Comidas</h2>
                    <p>Registra y monitorea tus alimentos consumidos día a día.</p>
                </div>
            </div>
            <a href="<?= base_url('comidas') ?>" class="btn-probar">PROBAR</a>
        </div>
    </section>

    <!-- Panel Derecho: Calendario y Comidas -->
    <aside class="sidebar-panel">
        <div class="calendar-widget">
            <div class="calendar-header">
                <span class="month-title" id="monthYearTitle"></span>
                <div class="calendar-nav">
                    <button type="button" id="prevWeekBtn">‹</button>
                    <button type="button" id="nextWeekBtn">›</button>
                </div>
            </div>
            <div class="calendar-days" id="calendarDaysContainer"></div>
        </div>

        <!-- Comidas del Día Dinámicas -->
        <div class="daily-meals">
            <h3>Comidas del día</h3>
            <div id="mealsContainer"></div>
        </div>
    </aside>

</main>

<!-- Banner Publicitario Horizontal con Tiempo e Interacción Pro -->
<?php
$rolAnuncioH = session()->get('rol');
$urlsBannersH = [];
$listaBannersH = [];

if (in_array($rolAnuncioH, ['free', 'admin'], true)):
    $bannersModelH = new \App\Models\BannersModel();
    $dbBannersH = \Config\Database::connect();
    if ($dbBannersH->fieldExists('orientation', 'banners')) {
        $listaBannersH = $bannersModelH->where('orientation', 'horizontal')->orderBy('created_at', 'DESC')->findAll();
    }

    if (!empty($listaBannersH)) {
        foreach ($listaBannersH as $bItem) {
            $urlsBannersH[] = base_url('assets/ads/' . $bItem['image_url']);
        }
    } else {
        $promoOreo = file_exists(FCPATH . 'assets/imagenes/promooreo.jpg')
            ? base_url('/assets/imagenes/promooreo.jpg')
            : base_url('/assets/ads/promooreo.jpg');
        $promoPepsi = file_exists(FCPATH . 'assets/imagenes/promopepsi.jpg')
            ? base_url('/assets/imagenes/promopepsi.jpg')
            : base_url('/assets/ads/promopepsi.jpg');
        $urlsBannersH = [$promoOreo, $promoPepsi];
    }
?>
<aside class="ad-banner-horizontal" id="adBannerHorizontal">
    <div class="ad-header">
        <span class="ad-tag"><?= $rolAnuncioH === 'admin' ? '⚙️ Publicidad Horizontal (1160x70px)' : 'Publicidad' ?></span>
        <div class="ad-controls">
            <?php if($rolAnuncioH === 'admin'): ?>
                <span class="ad-admin-count">📊 Activos: <?= count($listaBannersH) ?></span>
                <button type="button" id="btnAbrirModalBannersH" class="ad-admin-btn ad-btn-manage">🗑️ Gestionar</button>
                <form action="<?= base_url('dashboard/actualizarAnuncio') ?>" method="POST" enctype="multipart/form-data" class="ad-admin-form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="orientation" value="horizontal">
                    <input type="file" name="nuevo_anuncio" class="ad-admin-file" accept="image/png, image/jpeg, image/jpg" required>
                    <button type="submit" class="ad-admin-btn ad-btn-upload">➕ Subir</button>
                </form>
                <button type="button" id="closeAdBtn" class="ad-close-btn" aria-label="Cerrar publicidad" title="Ocultar barra temporalmente">×</button>
            <?php else: ?>
                <span id="adTimerBadge" class="ad-timer">Cambia en 30s</span>
            <?php endif; ?>
        </div>
    </div>

    <?php if($rolAnuncioH === 'admin' && empty($listaBannersH)): ?>
        <div class="ad-placeholder-box">Sube un banner horizontal (JPG/PNG) para personalizar la rotación de esta barra</div>
    <?php else: ?>
        <a href="<?= $rolAnuncioH === 'admin' ? 'javascript:void(0)' : base_url('premium/checkout') ?>" class="ad-link">
            <img id="adBannerImage" src="<?= esc($urlsBannersH[0]) ?>" alt="NutriCheck Pro Banner" class="ad-image">
        </a>
    <?php endif; ?>
</aside>

<?php if($rolAnuncioH === 'admin'): ?>
<div class="ad-modal-backdrop" id="modalGestionarBannersH" aria-hidden="true">
    <div class="ad-modal-card">
        <div class="ad-modal-header">
            <h3>⚙️ Gestionar Banners Horizontales en Rotación</h3>
            <button type="button" class="ad-modal-close" id="cerrarModalBannersH" aria-label="Cerrar">&times;</button>
        </div>
        <div class="ad-modal-body">
            <?php if(empty($listaBannersH)): ?>
                <div class="ad-modal-empty">📭 No hay banners horizontales subidos actualmente.</div>
            <?php else: ?>
                <div class="ad-modal-grid">
                    <?php foreach($listaBannersH as $bannerH): ?>
                        <div class="ad-modal-item">
                            <img src="<?= base_url('assets/ads/' . $bannerH['image_url']) ?>" alt="Banner Horizontal">
                            <div class="ad-modal-item-footer">
                                <a href="<?= base_url('dashboard/eliminarAnuncio/' . $bannerH['id']) ?>" onclick="return confirm('¿Seguro que deseas eliminar este banner horizontal permanentemente?')" class="ad-modal-delete">❌ Quitar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Dropdown del usuario
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdownContent = document.getElementById('userDropdownContent');

    if(userMenuBtn && userDropdownContent) {
        userMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdownContent.classList.toggle('show');
        });

        window.addEventListener('click', () => {
            if (userDropdownContent.classList.contains('show')) {
                userDropdownContent.classList.remove('show');
            }
        });
    }

    const baseAssetsUrl = "<?= base_url('/assets/imagenes/') ?>/";

    // Arreglo con la data real traída de meal_logs
    const comidasDB = <?= json_encode($comidas ?? []) ?>;

    let currentDate = new window.Date(); 

    const monthYearTitle = document.getElementById('monthYearTitle');
    const calendarDaysContainer = document.getElementById('calendarDaysContainer');
    const mealsContainer = document.getElementById('mealsContainer');
    const prevBtn = document.getElementById('prevWeekBtn');
    const nextBtn = document.getElementById('nextWeekBtn');

    const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const dayNames = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];

    function getFormattedDate(date) {
        const yyyy = date.getFullYear();
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const dd = String(date.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }

    function renderMeals(selectedDate) {
        const dateKey = getFormattedDate(selectedDate);

        const today = new window.Date();
        today.setHours(0, 0, 0, 0);

        const selDateObj = new window.Date(selectedDate);
        selDateObj.setHours(0, 0, 0, 0);

        const isPast = selDateObj < today;

        // Comidas registradas en este día específico
        const mealsOfDay = comidasDB.filter(c => {
            let fechaComida = c.meal_date || c.fecha || c.date || (c.created_at ? c.created_at.substring(0, 10) : '');
            return fechaComida === dateKey;
        });

        mealsContainer.innerHTML = '';

        // CASO 1: Es un día pasado Y NO SE REGISTRÓ ABSOLUTAMENTE NADA
        if (isPast && mealsOfDay.length === 0) {
            mealsContainer.innerHTML = `
                <div class="meal-item">
                    <img src="${baseAssetsUrl}iconno.jpg" alt="Sin registro" class="status-icon">
                    <div class="meal-details">
                        <h4>Sin registro</h4>
                        <p>Día completo</p>
                    </div>
                </div>
            `;
            return;
        }

        // Estructura base de las 3 comidas reconociendo los IDs numéricos (1, 2, 3, 4) y los nombres en texto
        const tresComidasBase = [
            { ids: ['1', 'breakfast', 'desayuno'], nombre: 'Desayuno' },
            { ids: ['2', 'lunch', 'almuerzo'], nombre: 'Almuerzo' },
            { ids: ['3', '4', 'dinner', 'snack', 'cena', 'merienda'], nombre: 'Cena' }
        ];

        tresComidasBase.forEach(base => {
            // Buscamos si existe registro coincidente en meal_type
            const registrada = mealsOfDay.find(m => {
                const tipo = String(m.meal_type || m.tipo || '').toLowerCase();
                return base.ids.includes(tipo);
            });

            let iconName = 'iconpendiente.jpg';
            let titulo = base.nombre;
            let subtexto = 'Por registrar';
            let mostrarAcciones = false;

            if (registrada) {
                // Se registró la comida
                iconName = 'iconlisto.jpg';
                titulo = registrada.description || registrada.nombre || base.nombre;
                subtexto = base.nombre;
                mostrarAcciones = true;
            } else if (isPast) {
                // Día pasado donde faltó registrar esta comida específica
                iconName = 'iconno.jpg';
                subtexto = 'No registrado';
            }

            const mealDiv = document.createElement('div');
            mealDiv.className = 'meal-item';
            mealDiv.innerHTML = `
                <img src="${baseAssetsUrl}${iconName}" alt="${subtexto}" class="status-icon">
                <div class="meal-details">
                    <h4>${titulo}</h4>
                    <p>${subtexto}</p>
                </div>
                ${mostrarAcciones ? `
                    <div class="meal-actions">
                        <a href="<?= base_url('comidas') ?>" class="btn-action">Editar</a>
                        <a href="<?= base_url('comidas') ?>" class="btn-action">Eliminar</a>
                    </div>
                ` : ''}
            `;
            mealsContainer.appendChild(mealDiv);
        });
    }

    function renderWeek(date) {
        calendarDaysContainer.innerHTML = '';
        const startOfWeek = new window.Date(date);
        startOfWeek.setDate(date.getDate() - date.getDay());

        monthYearTitle.textContent = `${months[startOfWeek.getMonth()]} ${startOfWeek.getFullYear()}`;

        for (let i = 0; i < 7; i++) {
            const day = new window.Date(startOfWeek);
            day.setDate(startOfWeek.getDate() + i);
            
            const isSelected = day.toDateString() === date.toDateString();

            const dayDiv = document.createElement('div');
            dayDiv.className = `day-col ${isSelected ? 'current-day' : ''}`;
            dayDiv.innerHTML = `
                <span class="day-name">${dayNames[day.getDay()]}</span>
                <span class="day-num">${day.getDate()}</span>
                ${isSelected ? '<span class="active-dot"></span>' : ''}
            `;
            
            dayDiv.addEventListener('click', () => {
                currentDate = day;
                renderWeek(currentDate);
            });

            calendarDaysContainer.appendChild(dayDiv);
        }

        renderMeals(date);
    }

    if(prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            currentDate.setDate(currentDate.getDate() - 7);
            renderWeek(currentDate);
        });

        nextBtn.addEventListener('click', () => {
            currentDate.setDate(currentDate.getDate() + 7);
            renderWeek(currentDate);
        });
    }

    renderWeek(currentDate);

    // Lógica de Banner Publicitario Horizontal con rotación dinámica
    const adBanner = document.getElementById('adBannerHorizontal');
    const closeAdBtn = document.getElementById('closeAdBtn');
    const adTimerBadge = document.getElementById('adTimerBadge');
    const adBannerImage = document.getElementById('adBannerImage');

    const adImages = <?= json_encode($urlsBannersH) ?>;
    let currentAdIndex = 0;
    let timerInterval = null;

    if(adBanner && adTimerBadge && adBannerImage && adImages.length > 0) {
        let timeLeft = 30;
        timerInterval = setInterval(() => {
            timeLeft--;
            if (timeLeft <= 0) {
                timeLeft = 30;
                currentAdIndex = (currentAdIndex + 1) % adImages.length;
                adBannerImage.src = adImages[currentAdIndex];
            }
            adTimerBadge.textContent = `Cambia en ${timeLeft}s`;
        }, 1000);
    }

    if(adBanner && closeAdBtn) {
        closeAdBtn.addEventListener('click', () => {
            adBanner.style.display = 'none';
            if (timerInterval) clearInterval(timerInterval);
        });
    }

    // Modal de gestión de banners horizontales (Admin)
    const btnAbrirModalH = document.getElementById('btnAbrirModalBannersH');
    const modalBannersH = document.getElementById('modalGestionarBannersH');
    const cerrarModalH = document.getElementById('cerrarModalBannersH');

    if (btnAbrirModalH && modalBannersH) {
        btnAbrirModalH.addEventListener('click', () => {
            modalBannersH.classList.add('active');
        });
        if (cerrarModalH) {
            cerrarModalH.addEventListener('click', () => {
                modalBannersH.classList.remove('active');
            });
        }
        modalBannersH.addEventListener('click', (e) => {
            if (e.target === modalBannersH) {
                modalBannersH.classList.remove('active');
            }
        });
    }
});
</script>

<?php 
if(file_exists(APPPATH . 'Views/Dashboard/piepagina.php')) {
    echo view('Dashboard/piepagina');
}
?>