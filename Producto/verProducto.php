<?php
include("conexion.php");

$busqueda = "";
if (isset($_GET['buscar'])) {
    $busqueda = $_GET['buscar'];
    $stmt = $pdo->prepare("SELECT * FROM producto WHERE nombre LIKE ?");
    $stmt->execute(["%$busqueda%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM producto");
}
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="/Restaurante/Estilos/bootstrap/css/bootstrap.min.css">
    <script src="/Restaurante/Estilos/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div id="cabecera"></div>
    </div>
    <script>
    // Cargar tabla desde un archivo externo
    fetch("/Restaurante/header/headerAdmin.html")
      .then(response => response.text())
      .then(data => {
        document.getElementById("cabecera").innerHTML = data;
      });
    </script>
 <style>
        
        
       
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            border-radius: 5px 0 0 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }
        button:hover { background-color: #0056b3; }
        .btn-agregar {
            display: flex;
             display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
            margin-bottom: 20px;
        }
        .btn-agregar:hover { background-color: #218838; }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            border-radius: 8px;
            overflow: hidden;
        }
        th {
            background-color: #007bff;
            color: white;
            padding: 12px;
        }
        td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
        }
        tr:nth-child(even) { background-color: #f2f2f2; }
        a.editar {
            background-color: #ffc107;
            color: black;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
        }
        a.eliminar {
            background-color: #dc3545;
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
        }
        a:hover { opacity: 0.85; }
    </style>
</head>
<body>

<br>
    


<div class="container">
<h1>Gestión de Productos</h1>
    <form method="get" action="">
        <input type="text" name="buscar" placeholder="Buscar producto..." value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit">Buscar</button>
    </form>

    <a href="insertar.php" class="btn-agregar">+ Agregar nuevo producto</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
        <?php if (count($productos) > 0): ?>
            <?php foreach ($productos as $fila): ?>
                <tr>
                    <td><?php echo $fila['idProducto']; ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                    <td>$<?php echo number_format($fila['precio'], 2); ?></td>
                    <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($fila['categoria']); ?></td>
                    <td>
                        <a href="modificar.php?idProducto=<?php echo $fila['idProducto']; ?>" class="editar">Editar</a>
                        <a href="eliminar.php?idProducto=<?php echo $fila['idProducto']; ?>" class="eliminar" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No hay productos registrados</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>


