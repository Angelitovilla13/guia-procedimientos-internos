<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Error 404 | Página no encontrada</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f4f6f8;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .error-box {
      background: white;
      padding: 40px;
      border-radius: 18px;
      box-shadow: 0 15px 30px rgba(0,0,0,.08);
      text-align: center;
      max-width: 420px;
    }
    h1 {
      font-size: 4rem;
    }
  </style>
</head>
<body>

  <div class="error-box">
    <h1 class="fw-bold text-danger">404</h1>
    <h5 class="mb-3">Página no encontrada</h5>
    <p class="text-muted mb-4">
      La dirección que intentas acceder no existe o no está disponible.
    </p>
    <a href="dashboard.php" class="btn btn-primary">
      Volver al inicio
    </a>
  </div>

</body>
</html>
