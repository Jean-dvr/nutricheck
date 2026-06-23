<?= view('template/cabecera') ?>

<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="font-weight-bold text-dark">Bienvenido, <?= session()->get('name') ?> 👋</h1>
            <p class="text-muted">¿Qué deseas gestionar hoy en NutriCheck?</p>
        </div>
        <div>
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

    </div>
</div>

<?= view('template/piepagina') ?>