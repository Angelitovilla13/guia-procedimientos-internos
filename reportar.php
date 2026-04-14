<?php
require 'auth.php';
require 'config.php';

$user = $_SESSION['user'];

$proc_id = intval($_GET['id'] ?? 0);

$mensaje = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $tipo = $_POST['tipo'];
    $detalle = $_POST['detalle'];

    $stmt = $conn->prepare("
    INSERT INTO reportes_procedimientos (procedimiento_id, usuario_id, tipo, detalle)
    VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("iiss", $proc_id, $user['id'], $tipo, $detalle);
    $stmt->execute();

    $mensaje = "Reporte enviado correctamente";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reportar</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="app-wrapper form-screen">

<a href="javascript:history.back()" class="close-btn">✕</a>

<div class="logo">molex</div>

<h2 class="title text-center">REPORTAR</h2>

<?php if($mensaje): ?>
<div class="alert alert-success"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST">

<div class="form-group">
<label>Tipo</label>
<select name="tipo" class="form-control custom-input">
<option value="error">Error</option>
<option value="mejora">Mejora</option>
</select>
</div>

<div class="form-group">
<label>Detalle</label>
<textarea name="detalle" class="form-control custom-input" rows="4"></textarea>
</div>

<div class="text-center mt-4">
<button class="next-btn">Enviar</button>
</div>

</form>

</div>

</body>
</html>