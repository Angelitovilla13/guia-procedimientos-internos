<?php
require 'auth.php';
require 'config.php';
requireRole(['admin','supervisor']);

$sql = "
SELECT r.*, u.username, u.employee_id, u.puesto
FROM reportes_procedimientos r
JOIN users u ON r.usuario_id = u.id
ORDER BY r.fecha DESC
";

$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reportes</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="app-wrapper">

<a href="dashboard.php" class="close-btn">✕</a>

<h2 class="title text-center">REPORTES</h2>

<?php while($r = $res->fetch_assoc()): ?>

<div class="procedimiento-card">

<b><?= strtoupper($r['tipo']) ?></b><br>

<small>
<?= $r['username'] ?> |
ID: <?= $r['employee_id'] ?> |
<?= $r['puesto'] ?>
</small>

<p><?= $r['detalle'] ?></p>

<a href="procedures/verprocedimiento.php?id=<?= $r['procedimiento_id'] ?>" class="app-button">
Ver procedimiento
</a>

</div>

<?php endwhile; ?>

</div>

</body>
</html>