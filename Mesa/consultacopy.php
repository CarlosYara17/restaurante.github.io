<?php
include("conexion.php");

// Procesar actualización de estado si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizarEstado'])) {
    $mesaId = $_POST['mesaId'];
    $nuevoEstado = $_POST['nuevoEstado'];
    
    if (!empty($mesaId) && !empty($nuevoEstado)) {
        $sql = "UPDATE mesa SET estado = ? WHERE idMesa = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $nuevoEstado, $mesaId);
            $actualizado = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            if ($actualizado) {
                $mensaje = "Estado actualizado correctamente";
                $tipoMensaje = "success";
            } else {
                $mensaje = "Error al actualizar el estado";
                $tipoMensaje = "danger";
            }
        } else {
            $mensaje = "Error en la consulta";
            $tipoMensaje = "danger";
        }
    } else {
        $mensaje = "Datos incompletos";
        $tipoMensaje = "warning";
    }
}

// Consulta para mostrar las mesas
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
        <h1>Gestion de Mesas</h1>
        
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-<?php echo $tipoMensaje; ?> alert-dismissible fade show mt-3" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
          
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

                                  <div class="col">
                                    <button type="button" class="btn btn-secondary btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEstado" 
                                            data-mesa-id="' . $fila['idMesa'] . '" 
                                            data-mesa-numero="' . $fila['numeroMesa'] . '" 
                                            data-mesa-estado="' . $fila['estado'] . '">
                                        Cambiar Estado
                                    </button>
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

    <!-- Modal para cambiar estado -->
    <div class="modal fade" id="modalEstado" tabindex="-1" aria-labelledby="modalEstadoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEstadoLabel">Cambiar Estado de Mesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" id="mesaId" name="mesaId">
                        <input type="hidden" name="actualizarEstado" value="1">
                        
                        <div class="mb-3">
                            <label class="form-label">Mesa:</label>
                            <input type="text" class="form-control" id="mesaNumero" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Estado Actual:</label>
                            <input type="text" class="form-control" id="estadoActual" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nuevoEstado" class="form-label">Nuevo Estado:</label>
                            <select class="form-select" id="nuevoEstado" name="nuevoEstado" required>
                                <option value="">Seleccionar estado...</option>
                                <option value="Disponible">Disponible</option>
                                <option value="Ocupada">Ocupada</option>
                                <option value="Reservada">Reservada</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Estado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript para cargar datos en el modal
        document.addEventListener('DOMContentLoaded', function() {
            const modalEstado = document.getElementById('modalEstado');
            
            modalEstado.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Botón que activó el modal
                
                // Extraer información de los atributos data-*
                const mesaId = button.getAttribute('data-mesa-id');
                const mesaNumero = button.getAttribute('data-mesa-numero');
                const mesaEstado = button.getAttribute('data-mesa-estado');
                
                // Actualizar el contenido del modal
                document.getElementById('mesaId').value = mesaId;
                document.getElementById('mesaNumero').value = 'Mesa #' + mesaNumero;
                document.getElementById('estadoActual').value = mesaEstado;
                
                // Opcional: resetear el select
                document.getElementById('nuevoEstado').value = '';
            });
            
            // Cerrar modal después de enviar el formulario si fue exitoso
            <?php if (isset($actualizado) && $actualizado): ?>
            var modal = bootstrap.Modal.getInstance(modalEstado);
            if (modal) {
                modal.hide();
            }
            <?php endif; ?>
        });
    </script>
   
</body>
</html>