<?php
require 'auth.php';
require 'config.php'; 

$user = $_SESSION['user'];
$isAdmin = ($user['role'] === 'admin');

// contar reportes
$countRes = $conn->query("SELECT COUNT(*) as total FROM reportes_procedimientos");
$count = $countRes->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel principal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="app-wrapper">

  <!-- Header -->
  <div class="header text-center" style="position:relative;">

    <!-- 🔔 NOTIFICACIONES -->
    <?php if($user['role'] == 'admin' || $user['role'] == 'supervisor'): ?>
    <a href="reportes.php" style="position:absolute; top:10px; right:10px; text-decoration:none;">

      <span style="font-size:20px;">🔔</span>

      <?php if($count > 0): ?>
      <span style="
      position:absolute;
      top:-5px;
      right:-10px;
      background:red;
      color:white;
      border-radius:50%;
      padding:2px 7px;
      font-size:12px;
      ">
      <?= $count ?>
      </span>
      <?php endif; ?>

    </a>
    <?php endif; ?>

    <h3 class="fw-bold">
      BIENVENIDO <?= htmlspecialchars($user['username']) ?>
    </h3>

    <p class="role">
      <?= !empty($user['puesto']) 
          ? strtoupper($user['puesto']) 
          : ($isAdmin ? 'ADMINISTRADOR' : 'SIN PUESTO') ?>
    </p>

    <?php if(!empty($user['turno'])): ?>
      <small><?= strtoupper($user['turno']) ?></small>
    <?php endif; ?>

  </div>

  <!-- Título -->
  <div class="section-title text-center">
    Procedimientos Internos
  </div>

  <!-- Botones -->
  <div class="buttons">

    <a href="procedures/buscarprocedimiento.php" class="app-button">
      Ver procedimientos
    </a>

    <?php if($user['role'] == 'admin' || $user['role'] == 'supervisor'): ?>
    <a href="procedures/agregarprocedimiento1.php" class="app-button">
      Agregar Procedimiento
    </a>
    <?php endif; ?>

    <?php if($user['role'] == 'admin'): ?>
    <a href="usuarios.php" class="app-button">
      Usuarios
    </a>
    <?php endif; ?>

    <a href="perfil.php" class="app-button">
      Mi Perfil
    </a>

    <a href="logout.php" class="app-button logout">
      Cerrar sesión
    </a>

  </div>

</div>

</body>
</html>