<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['nombre'])) {
    header('Location: /Restaurante/index.php');
    exit;
}

if ($_SESSION['rol'] !== 'Mesero') {
    echo "Acceso denegado";
    exit;
}

// Consulta para mostrar las mesas
$sql = "SELECT * FROM mesa ORDER BY numeroMesa ASC";
$query = mysqli_query($conexion, $sql);

?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Restaurante/Estilos/bootstrap/css/bootstrap.min.css">
    <script src="/Restaurante/Estilos/bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>verMesa</title>

    <div id="cabecera"></div>
    </div>
    <script>
    // Cargar tabla desde un archivo externo
    fetch("/Restaurante/header/headerMesero.html")
      .then(response => response.text())
      .then(data => {
        document.getElementById("cabecera").innerHTML = data;
      });
    </script>

</head>
<body>
    <div class="container">
        <br><center>
        <h1>Bienvenido Mesero</h1>
        </center>
         <div class="row">
        <div class="col-md-4">
          <div class="card shadow-sm border-0">
            <div class="card-body text-center">
              <h5 class="card-title">Mesas Activas</h5>
              <img src="/restaurante/imagen/mesa.png " width="200px">
              <p class="card-text display-6 text-primary">12</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm border-0">
            <div class="card-body text-center">
              <h5 class="card-title">Pedidos en curso</h5>
              <img src="/restaurante/imagen/pedido.png " width="200px">
              <p class="card-text display-6 text-success">8</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm border-0">
            <div class="card-body text-center">
              <h5 class="card-title">Menu</h5>
              <img src="/restaurante/imagen/menu.png " width="200px">
              <p class="card-text display-6 text-warning">Ver Menu</p>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>

