<?php

include("conexion.php");

$sql = "SELECT * FROM mesa ORDER BY numeroMesa ASC";
$query = mysqli_query($conexion, $sql);


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/bootstrap/css/bootstrap.min.css">
    <script src="estilos/bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>verMesa</title>

    <div id="cabecera"></div>
    </div>
    <script>
    // Cargar tabla desde un archivo externo
    fetch("header/header.html")
      .then(response => response.text())
      .then(data => {
        document.getElementById("cabecera").innerHTML = data;
      });
    </script>

</head>
<body>
    <div class="container">
        <br>
        <div class="row">
          <div class="col-md-10">
            <h1>Gestion de Mesas</h1>
          </div>
          <div class="col -md-2">
          <button class="btn btn-success" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Agregar Mesa</button>
          </div>
        </div>
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

                                  <div class="col-md-6">
                                    <button type="button" class="btn btn-warning btn-sm">Editar</button>
                                  </div>
                                  <div class="col-md-6">
                                    <button type="button" class="btn btn-danger btn-sm" width="1000px">Eliminar</button>
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

<!-- Ventana Agregar-->
<?php

if (isset($_POST['agregar'])) {
    $id = null;
    $nmesa = $_POST['num_mesa'];
    $nsilla = $_POST['num_sillas'];
    $estado = "Disponible";

    // Primero verificamos si la mesa ya existe
    $verificar_sql = "SELECT * FROM mesa WHERE numeroMesa = '$nmesa'";
    $verificar_query = mysqli_query($conexion, $verificar_sql);
    
    if(mysqli_num_rows($verificar_query) > 0) {
        $mensaje = '
        <div class="alert alert-danger" role="alert">
         Error: El número de mesa '.$nmesa.' ya existe. No se pudo agregar!
        </div>
        ';
        $mostrarModal = 'exampleModalToggle2';
    } else {
        // La mesa no existe, procedemos a insertar
        $sql = "INSERT INTO mesa VALUES('$id','$nmesa', '$nsilla', '$estado')";
        $query = mysqli_query($conexion, $sql);

        if($query){
            $mensaje = '
            <div class="alert alert-success" role="alert">
             La mesa se agrego con exito!
            </div>
            ';
            $mostrarModal = 'exampleModalToggle2';
            
            // Agregar script para recargar la página cuando se cierre el modal
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = new bootstrap.Modal(document.getElementById("exampleModalToggle2"));
                modal.show();
                
                // Cuando se cierre el modal, recargar la página
                document.getElementById("exampleModalToggle2").addEventListener("hidden.bs.modal", function () {
                    window.location.href = "verMesaCopia.php";
                });
            });
            </script>';
        }
        else{
            $mensaje = '
            <div class="alert alert-danger" role="alert">
             La mesa no se pudo agregar!
            </div>
            ';
            $mostrarModal = 'exampleModalToggle2';
        }
    }
}
?>

<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Modal 1</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
            <div class="mb-3">
            <label class="form-label">Ingresa numero de la Mesa</label>
            <input type="number" class="form-control" name="num_mesa" required><br>
            </div>
            <div class="mb-3">
            <label class="form-label" >Ingrese numero de sillas de la mesa </label >
            <input type="number" class="form-control"  name="num_sillas" required><br>
            </div>
            <center>
             <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
            </center>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Modal 2</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php if(isset($mensaje)) echo $mensaje; ?>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Agregar otra Mesa</button>
         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if(isset($_POST['agregar']) && isset($mostrarModal)): ?>
    // Mostrar el modal correspondiente después del envío del formulario
    var modal = new bootstrap.Modal(document.getElementById('<?php echo $mostrarModal; ?>'));
    modal.show();
    <?php endif; ?>
});
</script>

<!--Ventana Editar -->
<div class="modal fade" id="VentanaEditar" aria-hidden="true" aria-labelledby="VentEditar" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ventEditar"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
            <div class="mb-3">
            <label class="form-label">Ingresa numero de la Mesa</label>
            <input type="number" class="form-control" name="num_mesa" required><br>
            </div>
            <div class="mb-3">
            <label class="form-label" >Ingrese numero de sillas de la mesa </label >
            <input type="number" class="form-control"  name="num_sillas" required><br>
            </div>
            <center>
             <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
            </center>
        </form>
      </div>
    </div>
  </div>
</div>