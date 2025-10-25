<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];

    $sql = "INSERT INTO producto (nombre, precio, descripcion, categoria) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $precio, $descripcion, $categoria]);

    echo "<script>alert('Producto agregado correctamente'); window.location='verProducto.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #f8f9fa, #e3f2fd);
            padding: 40px;
        }
        .formulario {
            max-width: 450px;
            margin: auto;
            background: white;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 5px;
            font-size: 15px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            margin-top: 15px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="formulario">
    <h2>Agregar Nuevo Producto</h2>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" required>

        <label>Descripción:</label>
        <textarea name="descripcion" required></textarea>

        <label>Categoría:</label>
        <input type="text" name="categoria" required>

        <button type="submit">Guardar Producto</button>
        <a href="verProducto.php.php">← Volver a la lista</a>
    </form>
</div>

</body>
</html>



