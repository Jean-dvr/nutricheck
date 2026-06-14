<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCheck - Iniciar Sesión</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; min-height: 100vh; display: flex; background-color: #ebebeb; }
        .split-container { display: flex; width: 100%; min-height: 100vh; }

        /* Columna Izquierda */
        .left-side { flex: 1; background-color: #fcd04c; display: flex; justify-content: center; align-items: center; overflow: hidden; position: relative; height: 100vh; }
        .image-placeholder { width: 100%; height: 100%; }
        .image-placeholder img { width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; }

        /* Columna Derecha */
        .right-side { flex: 1; background-color: #ebebeb; display: flex; justify-content: center; align-items: center; padding: 40px; }
        .form-box { width: 100%; max-width: 420px; }

        /* AJUSTES PARA EL LOGO Y TEXTO PEGADOS */
        .logo-form-container { text-align: center; margin-bottom: 0px; }
        .logo-form-img { width: 100%; max-width: 300px; height: auto; display: block; margin: 0 auto; }
        .page-subtitle { 
            font-size: 2.2rem; font-weight: 400; color: #f79c34; letter-spacing: 1px; 
            margin-top: 5px; /* Aquí ajustamos la mínima separación */
            margin-bottom: 25px; text-align: center; 
        }

        /* Formulario */
        .input-row { display: flex; gap: 15px; margin-bottom: 15px; }
        .input-field { width: 100%; padding: 14px 20px; border: none; border-radius: 25px; background-color: #ffffff; font-size: 1rem; color: #333333; outline: none; }
        .password-container { position: relative; display: flex; align-items: center; margin-bottom: 15px; }
        .password-container .input-field { padding-right: 60px; }
        .view-password-btn { position: absolute; right: 5px; width: 40px; height: 40px; border: none; background-color: #ffffff; border-radius: 50%; cursor: pointer; display: flex; justify-content: center; align-items: center; color: #666666; }
        .action-container { display: flex; justify-content: center; margin-top: 30px; }
        .btn-submit { display: inline-block; background-color: #8c8c8c; color: #ffffff; padding: 12px 45px; font-size: 1.1rem; text-decoration: none; border-radius: 25px; border: none; cursor: pointer; transition: background-color 0.3s; }
        .btn-submit:hover { background-color: #737373; }

        @media (max-width: 850px) {
            .split-container { flex-direction: column; }
            .left-side { min-height: 300px; }
            .right-side { padding: 30px 20px; }
        }
    </style>
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

              <form onsubmit="event.preventDefault();">
    
                <input type="email" class="input-field full-width" placeholder="Email" style="margin-bottom: 15px;" required>

                 <div class="password-container">
                    <input type="password" class="input-field" placeholder="Contraseña" required>
                    <button type="button" class="view-password-btn">👁️</button>
                </div>

                <div class="action-container">
                    <a href="#" class="btn-submit">Iniciar</a>
                </div>

            </form>
            </div>
        </div>
    </div>

</body>
</html>