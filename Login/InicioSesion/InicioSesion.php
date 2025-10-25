<?php
require_once '../config/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['usuario'];  
    $password = $_POST['contraseña'];

    try {
      include '../config/conexion.php';

        $sql = "SELECT * FROM usuario WHERE usuario = '$username' AND contraseña = '$password'";
    $result = $conexion->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $_SESSION['idUsuario'] = $user['idUsuario'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['rol'] = $user['rol'];

            switch ($user['rol']) {
                case 'Administrador':
                    header('Location: ../Home/dashboard.php');
                    break;
                case 'Mesero':
                    header('Location: ../Home/dashboardMesero.php');
                    break;
                case 'Chef':
                    header('Location: ../Home/dashboardChef.php');
                    break;
                case 'Cajero':
                    header('Location: ../Home/dashboardCajero.php');
                    break;
                default:
                    echo 'Rol no reconocido';
                    break;
            }
            exit();
        } else {
            $error_message = 'Usuario o contraseña incorrectos';
            echo $error_message;
        }

    } catch (Throwable $th) {
        echo "Error en la conexión: " . $th->getMessage();
        exit;
    }
}

