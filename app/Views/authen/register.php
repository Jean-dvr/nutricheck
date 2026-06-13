<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Test - NutriCheck</title>
</head>
<body>

    <h2>Registro de Prueba</h2>

    <form action="<?= base_url('/register/guardar') ?>" method="POST">
        <?= csrf_field() ?>

        <?php if(!empty(session()->getFlashdata('fail'))) : ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('fail') ?>
            </div>
        <?php endif; ?>
        
       
            
        <label for="nombre">Nombre de Usuario:</label><br>
        <input type="text" id="nombre" name="nombre"  placeholder="Ingresa tu nombre de usuario"
        value="<?= set_value('nombre') ?>">
        
        <br>
            
        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'nombre') : '' ?></span>

        <br>

        <label for="correo">Correo Electrónico:</label><br>
        <input type="email" id="correo" name="correo"  placeholder="Ingresa tu correo electrónico" 
        value="<?= set_value('correo') ?>">
        <br>
        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'correo') : '' ?></span>
        <br>
        

        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password"  placeholder="Ingresa tu contraseña"
        value="">
        <br>
        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : '' ?></span>
        <br>
     

        <label for="cpassword">Confirmar Contraseña:</label><br>
        <input type="password" id="cpassword" name="cpassword"  placeholder="Ingresa tu contraseña nuevamente"
        value="">
        <br>
        
        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'cpassword') : '' ?></span>
        <br>
  

        <button type="submit">Registrarse</button>
        
        <a href="<?= base_url('login') ?>" >¿Ya tienes una cuenta? Inicia sesión aquí</a>
    </form>

</body>
</html>