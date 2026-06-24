<<?= view('template/cabecera') ?>

<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="font-weight-bold text-dark">Bienvenido, <?= session()->get('name') ?> 👋</h1>
            <p class="text-muted">¿Qué deseas gestionar hoy en NutriCheck?</p>
        </div>
        <div class="d-flex align-items-center">
            
            <!--  Botón de Auditoría de Pagos (Exclusivo para la cuenta Admin) -->
            <?php if(session()->get('rol') === 'admin'): ?>
                <a href="<?= base_url('dashboard/pagos') ?>" class="btn btn-danger shadow-sm font-weight-bold text-white mr-3">
                    💳 Validar Pagos
                </a>
            <?php endif; ?>

            <!-- Botón Superior de Premium (Solo para usuarios Free) -->
            <?php if(session()->get('rol') === 'free'): ?>
                <a href="<?= base_url('premium/checkout') ?>" class="btn btn-warning shadow-sm font-weight-bold text-dark mr-3" style="border: 1px solid #e0a800;">
                    ⭐ Hazte Premium
                </a>
            <?php endif; ?>

            <a href="<?= base_url('perfil') ?>" class="btn btn-outline-secondary shadow-sm">
                ⚙️ Configuración de Perfil
            </a>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center mt-3">
                    <h1 class="mb-3">⚖️</h1>
                    <h5 class="card-title font-weight-bold">Calculadora IMC</h5>
                    <p class="card-text text-muted">Calcula tu Índice de Masa Corporal y conoce tu estado actual.</p>
                </div>
                <div class="card-footer bg-white border-0 text-center mb-3">
                    <a href="<?= base_url('imc') ?>" class="btn btn-primary btn-block rounded-pill">Calcular IMC</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center mt-3">
                    <h1 class="mb-3">🥗</h1>
                    <h5 class="card-title font-weight-bold">Diario de Comidas</h5>
                    <p class="card-text text-muted">Registra y monitorea tus alimentos consumidos día a día.</p>
                </div>
                <div class="card-footer bg-white border-0 text-center mb-3">
                    <a href="<?= base_url('comidas') ?>" class="btn btn-success btn-block rounded-pill">Registrar Comida</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center mt-3">
                    <h1 class="mb-3">📖</h1>
                    <h5 class="card-title font-weight-bold">Buscador de Recetas</h5>
                    <p class="card-text text-muted">Encuentra recetas filtradas según tu perfil clínico y patologías.</p>
                </div>
                <div class="card-footer bg-white border-0 text-center mb-3">
                    <a href="<?= base_url('recetas') ?>" class="btn btn-warning btn-block rounded-pill text-white">Buscar Recetas</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center mt-3">
                    <h1 class="mb-3">📰</h1>
                    <h5 class="card-title font-weight-bold">NutriCheck News</h5>
                    <p class="card-text text-muted">Mantente al día con artículos médicos, jornadas y consejos nutricionales.</p>
                </div>
                <div class="card-footer bg-white border-0 text-center mb-3">
                    
                    <?php if(session()->get('rol') === 'free'): ?>
                        <a href="<?= base_url('newspaper') ?>" class="btn btn-secondary btn-block rounded-pill text-white">
                            🔒 Exclusivo Premium
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('newspaper') ?>" class="btn btn-info btn-block rounded-pill text-white">
                            Leer Artículos
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <?php if(session()->get('rol') === 'free'): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0" style="background: linear-gradient(145deg, #fffcf5, #fff8e1); border: 1px solid #ffeeba !important;">
                <div class="card-body text-center mt-3">
                    <h1 class="mb-3">⭐</h1>
                    <h5 class="card-title font-weight-bold text-warning" style="text-shadow: 0px 0px 1px #ffc107;">Desbloquea Premium</h5>
                    <p class="card-text text-muted">Elimina la publicidad y accede a todo el contenido exclusivo de salud.</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center mb-3">
                    <a href="<?= base_url('premium/checkout') ?>" class="btn btn-warning btn-block rounded-pill font-weight-bold text-dark shadow-sm">
                        Ver Planes de Pago
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?= view('template/piepagina') ?>