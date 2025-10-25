<?php
// Parámetros de conexión
$host = "localhost";      // Servidor de base de datos (localhost si está en tu equipo)
$usuario = "root";        // Usuario de MySQL
$contrasena = "";         // Contraseña de MySQL
$base_datos = "restaurantedb"; // Nombre de tu base de datos

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    // Opcional: mensaje de éxito
    // echo "Conexión exitosa a la base de datos.";
}
?>
