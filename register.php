<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . "/config.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = trim($_POST['user'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['pass'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($user === '' || $email === '' || $pass === '' || $confirm === '') {
        $error = "Todos los campos son obligatorios";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Correo electrónico inválido";
    } elseif (strlen($pass) < 6) {
        $error = "La contraseña debe tener mínimo 6 caracteres";
    } elseif ($pass !== $confirm) {
        $error = "Las contraseñas no coinciden";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $user, $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {

            $error = "El usuario o el correo ya están registrados";

        } else {

            $passHash = password_hash($pass, PASSWORD_DEFAULT);
            $role = "user";
            $token = bin2hex(random_bytes(32));

            $insert = $conn->prepare(
                "INSERT INTO users (username, email, password, role, verification_token) 
                 VALUES (?, ?, ?, ?, ?)"
            );

            $insert->bind_param("sssss", $user, $email, $passHash, $role, $token);

            if ($insert->execute()) {

                require_once "mailer.php";
                enviarVerificacion($email, $token);

                $success = "Cuenta creada. Revisa tu correo para verificarla.";

            } else {
                $error = "Error al crear la cuenta";
            }

            $insert->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Crear cuenta</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">

</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow-sm login-card" style="max-width:360px;width:100%;">

<h4 class="text-center mb-3">Crear cuenta</h4>

<?php if ($error): ?>
<div class="alert alert-danger py-2 text-center">
<?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>

<?php if ($success): ?>
<div class="alert alert-success py-2 text-center">
<?= htmlspecialchars($success) ?>
</div>
<?php endif; ?>

<form method="POST" novalidate>

<input
class="form-control mb-3"
name="user"
placeholder="Usuario"
required
maxlength="40"
>

<input
class="form-control mb-3"
type="email"
name="email"
placeholder="Correo electrónico"
required
>

<input
class="form-control mb-3"
type="password"
name="pass"
placeholder="Contraseña"
required
minlength="6"
>

<input
class="form-control mb-3"
type="password"
name="confirm"
placeholder="Confirmar contraseña"
required
minlength="6"
>

<button class="btn btn-primary w-100">
Crear cuenta
</button>

</form>

<div class="text-center mt-3">
<small>
¿Ya tienes cuenta?
<a href="login.php">Inicia sesión</a>
</small>
</div>

</div>

</body>
</html>