<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCheck - Iniciar Sesión</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
</head>

<body>

    <div class="split-container">
        <div class="left-side">
            <div class="image-placeholder">
                <img src="<?= base_url('assets/imagenes/corazon.jpg') ?>" alt="Logo Corazón">
            </div>
        </div>

        <div class="right-side">
            <div class="form-box">
                
                <div class="logo-form-container">
                    <img src="<?= base_url('assets/imagenes/logo_naranja.png') ?>" alt="NutriCheck Logo Naranja" class="logo-form-img">
                </div>
                
                <h2 class="page-subtitle">INICIAR SESIÓN</h2>

                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if(!empty(session()->getFlashdata('fail'))) : ?>
                    <div class="alert-danger">
                        <?= session()->getFlashdata('fail') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login/ingresar') ?>" method="POST">
                    
                    <?= csrf_field() ?>

                    <input type="email" name="email" class="input-field" placeholder="Email" value="<?= set_value('email') ?>" required>
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : '' ?></span>

                    <div class="password-container">
                        <input type="password" name="password" class="input-field" placeholder="Contraseña" required>
                        <button type="button" class="view-password-btn">👁️</button>
                    </div>
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : '' ?></span>

                    <div class="action-container">
                        <button type="submit" class="btn-submit">Iniciar</button>
                        <a href="<?= base_url('register') ?>" class="register-link">¿No tienes una cuenta? Regístrate aquí</a>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Buscamos todos los botones con la clase del ojito
            const togglePasswordBtns = document.querySelectorAll('.view-password-btn');

            togglePasswordBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    // Seleccionamos el input que está en el mismo contenedor
                    const input = this.previousElementSibling;

                    // Intercambiamos el tipo de campo
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.textContent = '👁️'; // Volvemos al ojito normal
                    } else {
                        input.type = 'password';
                        this.textContent = '👁️'; // Volvemos al ojito normal
                    }
                });
            });
        });
    </script>
</body>
</html>