<?php
include("conexion.php");

if (isset($_GET['idProducto'])) {
    $idProducto = $_GET['idProducto'];
    $stmt = $pdo->prepare("SELECT * FROM producto WHERE idProducto = ?");
    $stmt->execute([$idProducto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        echo "<script>alert('Producto no encontrado'); window.location='verProducto.php';</script>";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idProducto = $_POST['idProducto'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];

    $sql = "UPDATE producto SET nombre=?, precio=?, descripcion=?, categoria=? WHERE idProducto=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $precio, $descripcion, $categoria, $idProducto]);

    echo "<script>alert('Producto actualizado correctamente'); window.location='verProducto.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <style>
        body { font-family: Poppins, sans-serif; background: linear-gradient(135deg,#f8f9fa,#e3f2fd); padding:40px; }
        .formulario { max-width:450px; margin:auto; background:white; padding:25px 30px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align:center; color:#007bff; }
        label { font-weight:bold; margin-top:10px; display:block; }
        input, textarea { width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-top:5px; font-size:15px; }
        button { width:100%; padding:12px; background-color:#ffc107; border:none; color:black; font-weight:bold; border-radius:6px; margin-top:15px; cursor:pointer; }
        button:hover { background-color:#e0a800; }
        a { display:block; text-align:center; margin-top:15px; text-decoration:none; color:#007bff; }
    </style>
</head>
<body>
<div class="formulario">
    <h2>Editar Producto</h2>
    <form method="POST">
        <input type="hidden" name="idProducto" value="<?php echo $producto['idProducto']; ?>">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>

        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required>

        <label>Descripción:</label>
        <textarea name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>

        <label>Categoría:</label>
        <input type="text" name="categoria" value="<?php echo htmlspecialchars($producto['categoria']); ?>" required>

        <button type="submit">Guardar Cambios</button>
        <a href="consultar.php">← Volver</a>
    </form>
</div>
</body>
</html>





