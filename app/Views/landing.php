<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCheck - Bienvenidos</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

     <link rel="stylesheet" href="<?= base_url('assets/css/landing.css') ?>">
</head>
<body>

    <div class="container">
        <p class="welcome-text">Bienvenidos a</p>
        
        <div class="logo-container">
            <img src="<?= base_url('assets/imagenes/logo_blanco.png') ?>" alt="NutriCheck Logo" class="logo-img">
        </div>
        
        <div class="button-group">
            <a href="<?= base_url('login') ?>" class="btn btn-login">Iniciar sesión</a>
            <a href="<?= base_url('register') ?>" class="btn btn-register">Crear cuenta</a>
        </div>
    </div>

</body>
</html>