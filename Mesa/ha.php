<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Control - Administrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
    }
    .sidebar {
      height: 100vh;
      background-color: #212529;
      color: white;
      position: fixed;
      width: 250px;
    }
    .sidebar .nav-link {
      color: #ccc;
    }
    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      color: white;
      background-color: #495057;
    }
    .content {
      margin-left: 250px;
      padding: 20px;
    }
    .navbar {
      background-color: #0d6efd;
    }
  </style>
</head>
<body>

  <!-- Barra superior -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Administrador</a>
      <div class="d-flex">
        <a href="#" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
      </div>
    </div>
  </nav>

  <!-- Menú lateral -->
  <div class="sidebar pt-5">
    <div class="p-3 text-center border-bottom">
      <h5>Panel de Control</h5>
    </div>
    <ul class="nav flex-column p-2">
      <li class="nav-item">
        <a class="nav-link active" href="#">🏠 Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">🍽️ Gestión de Mesas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">👤 Gestión de Usuarios</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">📊 Reportes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">⚙️ Configuración</a>
      </li>
    </ul>
  </div>

  <!-- Contenido principal -->
  <div class="content pt-5">
    <div class="container-fluid mt-5">
      <h2>Bienvenido al Panel de Control</h2>
      <p>Desde aquí puedes administrar las mesas, usuarios y consultar reportes del restaurante.</p>
      
      <div class="row mt-4">
        <div class="col-md-4">
          <div class="card shadow-sm border-0">
            <div class="card-body text-center">
              <h5 class="card-title">Mesas Activas</h5>
              <p class="card-text display-6 text-primary">12</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm border-0">
            <div class="card-body text-center">
              <h5 class="card-title">Usuarios Registrados</h5>
              <p class="card-text display-6 text-success">8</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm border-0">
            <div class="card-body text-center">
              <h5 class="card-title">Pedidos del Día</h5>
              <p class="card-text display-6 text-warning">25</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
