<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Login/css/styles.css">
    <title>Login</title>
</head>

<body>
    <div class="wrapper">
        <div class="title">Inicia sesion</div>
        <form action="Login/InicioSesion/InicioSesion.php" method="POST">
            <div class="field">
                <input type="text" required name="usuario">
                <label>Nombre de usuario</label>
            </div>
            <div class="field">
                <input type="password" required name="contraseña">
                <label>Contraseña</label>
            </div>
            
            <div class="field">
                <input type="submit" value="Ingresar">
            </div>
        </form>
    </div>
</body>

</html>
