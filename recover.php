<?php
session_start();
require 'config.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        $mensaje = "El campo de correo es obligatorio";
    } else {

        $email_safe = $conn->real_escape_string($email);

        /* verificar si existe el usuario */
        $sql = "SELECT id FROM users WHERE email='$email_safe'";
        $res = $conn->query($sql);

        if ($res && $res->num_rows > 0) {

            $user = $res->fetch_assoc();
            $user_id = $user['id'];

            /* generar token seguro */
            $token = bin2hex(random_bytes(32));

            /* guardar token en BD */
            $conn->query("UPDATE users SET reset_token='$token' WHERE id=$user_id");

            /* crear link */
            $link = "https://welcomeangelito.me/reset.php?token=$token";

            /* contenido del correo */
            $subject = "Recuperar contraseña";
            $message = "
Hola,

Haz clic en el siguiente enlace para restablecer tu contraseña:

$link

Si no solicitaste esto, ignora este mensaje.
";

            $headers = "From: no-reply@welcomeangelito.me";

            /* enviar correo */
            mail($email, $subject, $message, $headers);
        }

        /* mensaje siempre igual por seguridad */
        $mensaje = "Si el correo está registrado, recibirás instrucciones para restablecer tu contraseña.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar contraseña</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow-sm" style="max-width:380px;width:100%;">

  <h4 class="text-center mb-2">Recuperar contraseña</h4>
  <p class="text-muted text-center small mb-3">
    Ingresa tu correo electrónico para recibir instrucciones.
  </p>

  <?php if ($mensaje): ?>
    <div class="alert alert-info text-center py-2">
      <?= htmlspecialchars($mensaje) ?>
    </div>
  <?php endif; ?>

  <form method="POST" novalidate>

    <input
      type="email"
      name="email"
      class="form-control mb-3"
      placeholder="Correo electrónico"
      required
      maxlength="60"
      autocomplete="email"
    >

    <button class="btn btn-primary w-100 mb-2">
      Enviar instrucciones
    </button>

  </form>

  <div class="text-center">
    <a href="login.php" class="small text-decoration-none">
      Volver a iniciar sesión
    </a>
  </div>

</div>

</body>
</html>