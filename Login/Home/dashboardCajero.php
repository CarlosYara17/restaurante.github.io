<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header('Location: /Restaurante/index.php');
    exit;
}

if ($_SESSION['rol'] !== 'Cajero') {
    echo "Acceso denegado";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <div class="sidebar">
        <h2>Cajero</h2>
        <a href="#">Inicio</a>
        <a href="#">Precios</a>
        <a href="#">Informes</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>
</body>
</html>

