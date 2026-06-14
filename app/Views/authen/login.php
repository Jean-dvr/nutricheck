<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Test - NutriCheck</title>
</head>
<body>


    <h2>Login de Prueba</h2>

<?php if(session()->getFlashdata('success')): ?>
    <div style="color: green; font-weight: bold; margin-bottom: 15px;">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('login/ingresar') ?>" method="POST">
    <?= csrf_field() ?>

        <?php if(!empty(session()->getFlashdata('fail'))) : ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('fail') ?>
            </div>
        <?php endif; ?>
        
        <label for="email">Correo Electrónico:</label><br>
        <input type="email" id="email" name="email"  placeholder="Ingresa tu correo electrónico" value="<?= set_value('email') ?>">
        <br>
        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : '' ?></span>
        <br>

        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password"  placeholder="Ingresa tu contraseña">
        <br>
        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : '' ?></span>
        <br>

        <button type="submit">Iniciar Sesión</button>
        
        <a href="<?= base_url('register') ?>">¿No tienes una cuenta? Regístrate aquí</a>
    </form>

</body>
</html>