<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCheck - Racha de Comidas</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('/assets/css/meallogs.css?v=1.0') ?>">
</head>
<body>

<!-- Cabecera Integrada -->
<header class="dash-navbar">
    <div class="logo-container">
        <!-- Retorno al Dashboard mediante clic en el Logo -->
        <a href="<?= base_url('dashboard') ?>" class="logo-wrapper">
            <img src="<?= base_url('/assets/imagenes/logo_naranja.png') ?>" alt="NutriCheck" class="dash-logo">
        </a>
    </div>

    <div class="user-menu-wrapper">
        <?php if(session()->get('rol') === 'admin'): ?>
            <a href="<?= base_url('dashboard/pagos') ?>" class="btn-top btn-admin">💳 Validar Pagos</a>
        <?php endif; ?>

        <div class="user-dropdown">
            <button type="button" class="dropdown-trigger" id="userMenuBtn">
                <?php 
                    $userId = session()->get('loggedUser');
                    $avatarFile = null;
                    if ($userId) {
                        $db = \Config\Database::connect();
                        $userQuery = $db->table('users')->select('avatar')->where('id', $userId)->get()->getRow();
                        if ($userQuery && !empty($userQuery->avatar)) {
                            $avatarFile = $userQuery->avatar;
                        }
                    }
                    $fotoPerfil = ($avatarFile && file_exists(FCPATH . 'assets/avatars/' . $avatarFile))
                        ? base_url('assets/avatars/' . $avatarFile) 
                        : base_url('assets/imagenes/iconusuario.png');
                ?>
                <img src="<?= $fotoPerfil ?>" alt="Avatar" class="user-avatar">
                <span class="user-name"><?= session()->get('name') ?? 'Usuario' ?></span>
                <span class="arrow-down">▼</span>
            </button>
            <div class="dropdown-content" id="userDropdownContent">
                <a href="<?= base_url('perfil') ?>">Configuración</a>
                <?php if(session()->get('rol') !== 'premium' && session()->get('rol') !== 'pro'): ?>
                    <a href="<?= base_url('premium/checkout') ?>" class="text-orange">NutricheckPro</a>
                <?php endif; ?>
                <hr>
                <a href="<?= base_url('logout') ?>" class="text-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</header>

<main class="meallogs-container">
    
    <!-- Título Principal de la Sección -->
    <div class="section-header">
        <img src="<?= base_url('/assets/imagenes/fuegonaranja.png') ?>" alt="Fuego" class="header-icon">
        <h1>Racha de Comidas</h1>
    </div>

    <div class="meallogs-grid">
        
        <!-- Columna Izquierda: Formulario de Registro -->
        <section class="form-card">
            <h2>Registrar Nueva Comida</h2>
            
            <form action="<?= base_url('comidas/guardar') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Fecha</label>
                        <input type="date" name="meal_date" id="meal_date" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Hora</label>
                        <input type="time" name="meal_time" value="<?= date('H:i') ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tipo de Comida</label>
                    <select name="meal_type" required>
                        <option value="" disabled selected>Selecciona el tipo...</option>
                        <option value="breakfast">☕ Desayuno</option>
                        <option value="lunch">🍲 Almuerzo</option>
                        <option value="dinner">🥗 Cena</option>
                        <option value="snack">🍎 Snack / Merienda / Antojo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>¿Qué comiste? (Descripción)</label>
                    <textarea name="description" rows="3" placeholder="Ej: 2 huevos revueltos, 1 arepa..." required></textarea>
                </div>

                <div class="form-group">
                    <label>Foto del Plato (Opcional)</label>
                    <input type="file" name="foto_comida" accept="image/png, image/jpeg, image/jpg" id="foto_comida_input">
                </div>

                <div class="image-preview-container">
                    <img id="preview_comida" src="" class="d-none">
                </div>

                <button type="submit" class="btn-submit">REGISTRAR</button>
            </form>
        </section>

        <!-- Columna Derecha: Calendario e Historial -->
        <section class="history-section">
            
            <!-- Widget Calendario Semanal Interactivo -->
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

            <h3 class="history-title">Historial Reciente</h3>
            
            <!-- Contenedor Dinámico de Comidas del Día Selección -->
            <div id="historyMealsContainer" class="history-list"></div>

        </section>
    </div>
</main>

<!-- Banner Publicitario Horizontal con Rotación y Tiempo -->
<?php if(session()->get('rol') !== 'premium' && session()->get('rol') !== 'pro'): ?>
<aside class="ad-banner-horizontal" id="adBannerHorizontal">
    <div class="ad-header">
        <span class="ad-tag">Publicidad</span>
        <div class="ad-controls">
            <span id="adTimerBadge" class="ad-timer">Cambia en 30s</span>
            <button type="button" id="closeAdBtn" class="ad-close-btn" aria-label="Cerrar publicidad">×</button>
        </div>
    </div>
    <a href="<?= base_url('premium/checkout') ?>" class="ad-link">
        <img id="adBannerImage" src="<?= base_url('/assets/imagenes/promooreo.jpg') ?>" alt="NutriCheck Pro Banner" class="ad-image">
    </a>
</aside>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Dropdown Usuario
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdownContent = document.getElementById('userDropdownContent');
    if(userMenuBtn && userDropdownContent) {
        userMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdownContent.classList.toggle('show');
        });
        window.addEventListener('click', () => {
            userDropdownContent.classList.remove('show');
        });
    }

    // Previsualización de Imagen
    const fotoInput = document.getElementById('foto_comida_input');
    const preview = document.getElementById('preview_comida');
    if(fotoInput && preview) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            } else {
                preview.src = "";
                preview.classList.add('d-none');
            }
        });
    }

    // Data de Comidas desde BD
    const comidasDB = <?= json_encode($historial_comidas ?? []) ?>;
    const baseAssetUrl = "<?= base_url('assets/meallogsimg/') ?>/";
    let currentDate = new Date(); 

    const monthYearTitle = document.getElementById('monthYearTitle');
    const calendarDaysContainer = document.getElementById('calendarDaysContainer');
    const historyMealsContainer = document.getElementById('historyMealsContainer');
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

    function formatAMPM(timeString) {
        if(!timeString) return '';
        let [hours, minutes] = timeString.split(':');
        hours = parseInt(hours, 10);
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        return `${hours}:${minutes} ${ampm}`;
    }

    function renderMealsForDate(selectedDate) {
        const dateKey = getFormattedDate(selectedDate);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const selDateObj = new Date(selectedDate);
        selDateObj.setHours(0, 0, 0, 0);
        const isPast = selDateObj < today;

        const mealsOfDay = comidasDB.filter(c => c.meal_date === dateKey);
        historyMealsContainer.innerHTML = '';

        if (mealsOfDay.length === 0) {
            historyMealsContainer.innerHTML = `
                <div class="empty-history-card">
                    <p>${isPast ? 'Sin registros para este día' : 'No has registrado ninguna comida hoy.'}</p>
                </div>
            `;
            return;
        }

        mealsOfDay.forEach(comida => {
            const dateParts = comida.meal_date.split('-');
            const formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
            const formattedTime = formatAMPM(comida.meal_time);

            let badgeClass = 'badge-snack';
            let badgeText = 'SNACK';
            
            const typeLower = (comida.meal_type || '').toLowerCase();
            if (typeLower === 'breakfast' || typeLower === 'desayuno') {
                badgeClass = 'badge-desayuno';
                badgeText = 'DESAYUNO';
            } else if (typeLower === 'lunch' || typeLower === 'almuerzo') {
                badgeClass = 'badge-almuerzo';
                badgeText = 'ALMUERZO';
            } else if (typeLower === 'dinner' || typeLower === 'cena') {
                badgeClass = 'badge-cena';
                badgeText = 'CENA';
            }

            const card = document.createElement('div');
            card.className = 'history-card';
            
            const photoBlock = comida.image_path 
                ? `<img src="${baseAssetUrl}${comida.image_path}" class="meal-photo" alt="Plato">` 
                : `<div class="no-photo"><span>Sin foto</span></div>`;

            card.innerHTML = `
                <div class="photo-container">${photoBlock}</div>
                <div class="info-container">
                    <div class="card-top-row">
                        <span class="meal-badge ${badgeClass}">${badgeText}</span>
                        <span class="meal-datetime">${formattedDate} | ${formattedTime}</span>
                    </div>
                    <p class="meal-description">${comida.description}</p>
                </div>
            `;
            historyMealsContainer.appendChild(card);
        });
    }

    function renderWeek(date) {
        calendarDaysContainer.innerHTML = '';
        const startOfWeek = new Date(date);
        startOfWeek.setDate(date.getDate() - date.getDay());

        monthYearTitle.textContent = `${months[startOfWeek.getMonth()]} ${startOfWeek.getFullYear()}`;

        for (let i = 0; i < 7; i++) {
            const day = new Date(startOfWeek);
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

        renderMealsForDate(date);
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

    // Lógica de Banner Publicitario Horizontal con Rotación
    const adBanner = document.getElementById('adBannerHorizontal');
    const closeAdBtn = document.getElementById('closeAdBtn');
    const adTimerBadge = document.getElementById('adTimerBadge');
    const adBannerImage = document.getElementById('adBannerImage');

    const baseImagesUrl = "<?= base_url('/assets/imagenes/') ?>/";
    const adImages = [
        baseImagesUrl + 'promooreo.jpg',
        baseImagesUrl + 'promopepsi.jpg'
    ];
    let currentAdIndex = 0;

    if(adBanner && closeAdBtn && adTimerBadge && adBannerImage) {
        let timeLeft = 30;
        const timerInterval = setInterval(() => {
            timeLeft--;
            if (timeLeft <= 0) {
                timeLeft = 30;
                currentAdIndex = (currentAdIndex + 1) % adImages.length;
                adBannerImage.src = adImages[currentAdIndex];
            }
            adTimerBadge.textContent = `Cambia en ${timeLeft}s`;
        }, 1000);

        closeAdBtn.addEventListener('click', () => {
            adBanner.style.display = 'none';
            clearInterval(timerInterval);
        });
    }
});
</script>

</body>
</html>