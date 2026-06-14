<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCheck - Bienvenidos</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Montserrat', sans-serif; min-height: 100vh; display: flex; 
            justify-content: center; align-items: center; 
            background: linear-gradient(135deg, #fcd04c 0%, #f79c34 50%, #f1682d 100%); 
            color: #ffffff; text-align: center; padding: 20px; 
        }
        .container { max-width: 600px; width: 100%; }
        .welcome-text { font-size: 1.8rem; text-transform: uppercase; letter-spacing: 2px; font-weight: 400; margin-bottom: 25px; opacity: 0.9; }
        .logo-container { margin-bottom: 50px; display: flex; justify-content: center; align-items: center; }
        .logo-img { width: 100%; max-width: 520px; height: auto; display: block; margin: -60px auto -60px auto; }
        .button-group { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; }
        
        .btn { display: inline-block; padding: 12px 40px; font-size: 1.1rem; font-weight: 400; text-decoration: none; border-radius: 25px; transition: all 0.3s ease; min-width: 180px; }
        
        .btn-login { background-color: rgba(90, 90, 95, 0.8); color: #ffffff; }
        .btn-login:hover { background-color: rgba(70, 70, 75, 1); transform: translateY(-2px); }
        
        .btn-register { background-color: rgba(240, 240, 245, 0.9); color: #5a5a5f; }
        .btn-register:hover { background-color: rgba(255, 255, 255, 1); transform: translateY(-2px); }

        @media (max-width: 480px) {
            .welcome-text { font-size: 1.3rem; margin-bottom: 15px; }
            .logo-img { max-width: 320px; }
            .button-group { flex-direction: column; align-items: center; gap: 15px; }
            .btn { width: 100%; }
        }
    </style>
</head>
<body>

    <div class="container">
        <p class="welcome-text">Bienvenidos a</p>
        
        <div class="logo-container">
            <img src="<?= base_url('assets/imagenes/logo_blanco.png') ?>" alt="NutriCheck Logo" class="logo-img">
        </div>
        
        <div class="button-group">
            <a href="<?= base_url('home/iniciar_sesion') ?>" class="btn btn-login">Iniciar sesión</a>
            <a href="<?= base_url('home/registro') ?>" class="btn btn-register">Crear cuenta</a>
        </div>
    </div>

</body>
</html>