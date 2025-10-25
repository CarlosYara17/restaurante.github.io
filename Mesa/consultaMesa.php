<?php
include("conexion.php");

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
        <br>
        
            <h1>Gestion de Mesas</h1>
          
          
        <br><br>
        <div class="row g-4 justify-content-center">
            <?php
            // Mostrar mesas

            if ($query->num_rows > 0) {
                while ($fila = $query->fetch_assoc()) {
                    // Colores según estado
                    $color = "";
                    switch ($fila['estado']) {
                        case 'Disponible':
                            $color = "success";
                            break;
                        case 'Ocupada':
                            $color = "danger";
                            break;
                        case 'Reservada':
                            $color = "warning";
                            break;
                        default:
                            $color = "secondary";
                            break;
                    }

                    // Mostrar informacion de mesa 
                    echo '
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card border-' . $color . ' shadow-sm h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title mb-2">Mesa #' . $fila['numeroMesa'] . '</h5>
                                <p class="card-text mb-1">Sillas: ' . $fila['numeroSillas'] . '</p>

                                <div class="row">
                                  <div class="col-md-6">
                                    <h5>Estado:</h5>
                                  </div>
                                  <div class="col-md-6">
                                    <span class="badge bg-' . $color . '">' . $fila['estado'] . '</span>
                                  </div><br><br>

                                  <div class="col md-6">
                                    <button type="button" class="btn btn-warning btn-sm">Tomar Pedido</button>
                                  </div>
                                  <div class="col md-6">
                                    <button type="button" class="btn btn-secondary btn-sm">Cambiar Estado</button>
                                  </div>
                                  
                                </div>

                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p class="text-center">No hay mesas registradas aún.</p>';
            }
            ?>
        </div>
    </div>
        
    </div>

   
</body>
</html>