<?php
include('conexion.php');

if (isset($_GET['idProducto'])) {
    $idProducto = $_GET['idProducto'];
    $sql = "DELETE FROM producto WHERE idProducto = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$idProducto])) {
        echo "<script>alert('Producto eliminado correctamente'); window.location='verProducto.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el producto'); window.location='verProducto.php';</script>";
    }
} else {
    echo "<script>alert('ID de producto no recibido'); window.location='verProducto.php';</script>";
}
?>





