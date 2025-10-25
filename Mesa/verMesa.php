<?php
include("conexion.php");

// Consultar todas las mesas
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

<body>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestión de Mesas</h1>
    <button class="btn btn-success" data-bs-target="#modalAgregarMesa" data-bs-toggle="modal">Agregar Mesa</button>
  </div>

  <div class="row g-4 justify-content-center">
    <?php
    if ($query->num_rows > 0) {
      while ($fila = $query->fetch_assoc()) {
        $color = match($fila['estado']) {
          'Disponible' => 'success',
          'Ocupada' => 'danger',
          'Reservada' => 'warning',
          default => 'secondary'
        };

        echo '
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card border-' . $color . ' shadow-sm h-100">
            <div class="card-body text-center">
              <h5 class="card-title mb-2">Mesa #' . $fila['numeroMesa'] . '</h5>
              <p class="card-text mb-1">Sillas: ' . $fila['numeroSillas'] . '</p>
              <span class="badge bg-' . $color . '">' . $fila['estado'] . '</span>
              <hr>
              <div class="d-flex justify-content-around">
                <button class="btn btn-warning btn-sm"
                  data-bs-toggle="modal"
                  data-bs-target="#modalEditarMesa"
                  data-id="' . $fila['idMesa'] . '"
                  data-numero="' . $fila['numeroMesa'] . '"
                  data-sillas="' . $fila['numeroSillas'] . '"
                  data-estado="' . $fila['estado'] . '">Editar</button>

                <button class="btn btn-danger btn-sm"
                  data-bs-toggle="modal"
                  data-bs-target="#modalEliminarMesa"
                  data-id="' . $fila['idMesa'] . '"
                  data-numero="' . $fila['numeroMesa'] . '">Eliminar</button>
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
</body>
</html>

<!-- ========== AGREGAR MESA ========== -->
<?php
if (isset($_POST['agregar'])) {
  $id = null;
  $nmesa = $_POST['num_mesa'];
  $nsilla = $_POST['num_sillas'];
  $estado = "Disponible";

  $verificar_sql = "SELECT * FROM mesa WHERE numeroMesa = '$nmesa'";
  $verificar_query = mysqli_query($conexion, $verificar_sql);

  if(mysqli_num_rows($verificar_query) > 0) {
    $mensaje = '<div class="alert alert-danger"> Error: El número de mesa '.$nmesa.' ya existe.</div>';
  } else {
    $sql = "INSERT INTO mesa VALUES('$id','$nmesa', '$nsilla', '$estado')";
    $query = mysqli_query($conexion, $sql);
    $mensaje = $query
      ? '<div class="alert alert-success">Mesa agregada con éxito.</div>'
      : '<div class="alert alert-danger"> Error al agregar la mesa.</div>';
  }

  echo '<script>
  document.addEventListener("DOMContentLoaded", function() {
    var modal = new bootstrap.Modal(document.getElementById("modalResultadoAgregar"));
    modal.show();
    document.getElementById("modalResultadoAgregar").addEventListener("hidden.bs.modal", function () {
      window.location.href = "verMesa.php";
    });
  });
  </script>';
}
?>

<!-- Modal Agregar -->
<div class="modal fade" id="modalAgregarMesa" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Mesa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Número de Mesa</label>
            <input type="number" class="form-control" name="num_mesa" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Número de Sillas</label>
            <input type="number" class="form-control" name="num_sillas" required>
          </div>
          <center><button type="submit" name="agregar" class="btn btn-success">Agregar</button></center>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Resultado Agregar -->
<div class="modal fade" id="modalResultadoAgregar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Resultado</h5></div>
      <div class="modal-body"><?php if(isset($mensaje)) echo $mensaje; ?></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- ========== EDITAR MESA ========== -->
<?php
if (isset($_POST['editar'])) {
  $id = $_POST['idMesa'];
  $sillas = $_POST['numeroSillas'];
  $estado = $_POST['estado'];

  $sql = "UPDATE mesa SET numeroSillas = '$sillas', estado = '$estado' WHERE idMesa = '$id'";
  $query = mysqli_query($conexion, $sql);

  $mensaje = $query
    ? '<div class="alert alert-success"> Mesa actualizada correctamente.</div>'
    : '<div class="alert alert-danger"> Error al actualizar la mesa.</div>';

  echo '<script>
  document.addEventListener("DOMContentLoaded", function() {
    var modal = new bootstrap.Modal(document.getElementById("modalResultadoEditar"));
    modal.show();
    document.getElementById("modalResultadoEditar").addEventListener("hidden.bs.modal", function () {
      window.location.href = "verMesa.php";
    });
  });
  </script>';
}
?>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditarMesa" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Editar Mesa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="idMesa" id="editIdMesa">

          <div class="mb-3">
            <label class="form-label">Número de Mesa</label>
            <input type="number" class="form-control" id="editNumeroMesa" name="numeroMesa" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Número de Sillas</label>
            <input type="number" class="form-control" name="numeroSillas" id="editNumeroSillas" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Estado</label>
            <select class="form-select" name="estado" id="editEstado" required>
              <option value="Disponible">Disponible</option>
              <option value="Ocupada">Ocupada</option>
              <option value="Reservada">Reservada</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="editar" class="btn btn-warning">Guardar Cambios</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Resultado Editar -->
<div class="modal fade" id="modalResultadoEditar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Resultado</h5></div>
      <div class="modal-body"><?php if(isset($mensaje)) echo $mensaje; ?></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- ========== ELIMINAR MESA ========== -->
<?php
if (isset($_POST['eliminar'])) {
  $id = $_POST['idMesaEliminar'];
  $sql = "DELETE FROM mesa WHERE idMesa = '$id'";
  $query = mysqli_query($conexion, $sql);

  $mensaje = $query
    ? '<div class="alert alert-success"> Mesa eliminada correctamente.</div>'
    : '<div class="alert alert-danger"> Error al eliminar la mesa.</div>';

  echo '<script>
  document.addEventListener("DOMContentLoaded", function() {
    var modal = new bootstrap.Modal(document.getElementById("modalResultadoEliminar"));
    modal.show();
    document.getElementById("modalResultadoEliminar").addEventListener("hidden.bs.modal", function () {
      window.location.href = "verMesa.php";
    });
  });
  </script>';
}
?>

<!-- Modal Confirmar Eliminar -->
<div class="modal fade" id="modalEliminarMesa" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Eliminar Mesa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="idMesaEliminar" id="idMesaEliminar">
          <p>¿Seguro que deseas eliminar la mesa <strong id="numeroMesaEliminar"></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" name="eliminar" class="btn btn-danger">Sí, eliminar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Resultado Eliminar -->
<div class="modal fade" id="modalResultadoEliminar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Resultado</h5></div>
      <div class="modal-body"><?php if(isset($mensaje)) echo $mensaje; ?></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- ========== SCRIPT JS PARA MODALES ========== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  var modalEditar = document.getElementById('modalEditarMesa');
  modalEditar.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    document.getElementById('editIdMesa').value = button.getAttribute('data-id');
    document.getElementById('editNumeroMesa').value = button.getAttribute('data-numero');
    document.getElementById('editNumeroSillas').value = button.getAttribute('data-sillas');
    document.getElementById('editEstado').value = button.getAttribute('data-estado');
  });

  var modalEliminar = document.getElementById('modalEliminarMesa');
  modalEliminar.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    document.getElementById('idMesaEliminar').value = button.getAttribute('data-id');
    document.getElementById('numeroMesaEliminar').textContent = button.getAttribute('data-numero');
  });
});
</script>
