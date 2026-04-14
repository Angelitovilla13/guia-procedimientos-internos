<?php
require 'config.php';

$mensaje = "";
$valido = false;

/* verificar token */
if(isset($_GET['token'])){
    $token = $conn->real_escape_string($_GET['token']);

    $sql = "SELECT id FROM users WHERE reset_token='$token'";
    $res = $conn->query($sql);

    if($res && $res->num_rows > 0){
        $user = $res->fetch_assoc();
        $user_id = $user['id'];
        $valido = true;
    } else {
        $mensaje = "Token inválido o expirado";
    }
} else {
    $mensaje = "Token no proporcionado";
}

/* cambiar contraseña */
if($valido && $_SERVER["REQUEST_METHOD"] === "POST"){

    $pass = $_POST['password'] ?? '';
    $pass2 = $_POST['confirm_password'] ?? '';

    if($pass === '' || $pass2 === ''){
        $mensaje = "Completa todos los campos";
    } elseif($pass !== $pass2){
        $mensaje = "Las contraseñas no coinciden";
    } elseif(strlen($pass) < 6){
        $mensaje = "La contraseña debe tener al menos 6 caracteres";
    } else {

        /* encriptar contraseña */
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        /* actualizar contraseña y borrar token */
        $conn->query("
            UPDATE users 
            SET password='$hash', reset_token=NULL 
            WHERE id=$user_id
        ");

        $mensaje = "Contraseña actualizada correctamente";
        $valido = false;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Restablecer contraseña</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow-sm" style="max-width:380px;width:100%;">

<h4 class="text-center mb-3">Nueva contraseña</h4>

<?php if($mensaje): ?>
<div class="alert alert-info text-center py-2">
<?= htmlspecialchars($mensaje) ?>
</div>
<?php endif; ?>

<?php if($valido): ?>

<form method="POST">

<input
type="password"
name="password"
class="form-control mb-3"
placeholder="Nueva contraseña"
required
>

<input
type="password"
name="confirm_password"
class="form-control mb-3"
placeholder="Confirmar contraseña"
required
>

<button class="btn btn-primary w-100">
Guardar contraseña
</button>

</form>

<?php else: ?>

<div class="text-center">
<a href="login.php" class="btn btn-dark mt-2">
Ir a iniciar sesión
</a>
</div>

<?php endif; ?>

</div>

</body>
</html>