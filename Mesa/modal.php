<link rel="stylesheet" href="estilos/bootstrap/css/bootstrap.min.css">
<script src="estilos/bootstrap/js/bootstrap.bundle.min.js"></script>

<?php
include("conexion.php");

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
        <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Back to first</button>
      </div>
    </div>
  </div>
</div>

<button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Open first modal</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if(isset($_POST['agregar']) && isset($mostrarModal)): ?>
    // Mostrar el modal correspondiente después del envío del formulario
    var modal = new bootstrap.Modal(document.getElementById('<?php echo $mostrarModal; ?>'));
    modal.show();
    <?php endif; ?>
});
</script>