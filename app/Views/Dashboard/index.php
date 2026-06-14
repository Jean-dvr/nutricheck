<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - NutriCheck</title>
</head>
<body>

    <h1>Bienvenido a NutriCheck, <?= session()->get('name') ?></h1>
    <p>Este es tu panel de control privado.</p>


    <a href="<?= base_url('logout') ?>" style="color: red; text-decoration: none; font-weight: bold;">
        Cerrar Sesión
    </a>

</body>
</html>