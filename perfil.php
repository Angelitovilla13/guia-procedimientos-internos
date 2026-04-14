<?php
require 'auth.php';

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Perfil</title>

<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="app-wrapper form-screen">

<a href="dashboard.php" class="close-btn">✕</a>

<div class="logo">molex</div>

<h2 class="title text-center">MI PERFIL</h2>

<div class="procedimiento-card">

<div style="text-align:center; margin-bottom:15px;">
<?php if(!empty($user['foto'])): ?>
<img src="<?= $user['foto'] ?>" style="width:100px;height:100px;border-radius:50%;">
<?php else: ?>
<div style="width:100px;height:100px;border-radius:50%;background:#ccc;line-height:100px;">
👤
</div>
<?php endif; ?>
</div>

<p><b>Nombre:</b> <?= $user['username'] ?></p>
<p><b>Email:</b> <?= $user['email'] ?></p>
<p><b>Rol:</b> <?= strtoupper($user['role']) ?></p>
<p><b>Puesto:</b> <?= $user['puesto'] ?></p>
<p><b>Turno:</b> <?= $user['turno'] ?></p>

<p><b>ID Colaborador:</b> <?= $user['employee_id'] ?></p>
<p><b>NSS:</b> <?= $user['nss'] ?></p>

</div>

</div>

</body>
</html>