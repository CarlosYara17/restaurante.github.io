<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header('Location: /Restaurante/index.php');
    exit;
}

if ($_SESSION['rol'] !== 'Administrador') {
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
    <link rel="stylesheet" href="/Restaurante/Mesa/estilos/bootstrap/css/bootstrap.min.css">
  <script src="/Restaurante/Mesa/estilos/bootstrap/js/bootstrap.bundle.min.js"></script>
  <title>Gestión de Mesas</title>

  <div id="cabecera"></div>
  <script>
  fetch("/Restaurante/header/headerAdmin.html")
    .then(response => response.text())
    .then(data => {
      document.getElementById("cabecera").innerHTML = data;
    });
  </script>
</head>
</head>
<body>
    <div class="container">
        <br><center>
        <h1>Panel de control del Restaurante</h1>
        </center>
         <div class="row">
        <div class="col-md-4">
          <div class="card shadow-sm border-0">
            <div class="card-body text-center">
              <h5 class="card-title">Mesas Activas</h5>
              <p class="card-text display-6 text-primary">12</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm border-0">
            <div class="card-body text-center">
              <h5 class="card-title">Pedidos en curso</h5>
              <p class="card-text display-6 text-success">8</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm border-0">
            <div class="card-body text-center">
              <h5 class="card-title">Pedidos del Día</h5>
              <p class="card-text display-6 text-warning">25</p>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>

