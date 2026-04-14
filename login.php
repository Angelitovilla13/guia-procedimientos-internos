<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . "/config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = trim($_POST['user'] ?? '');
    $pass = $_POST['pass'] ?? '';

    if ($user === '' || $pass === '') {
        $error = "Todos los campos son obligatorios";
    } else {

        $sql = $conn->prepare("
        SELECT id, username, email, password, role, email_verified, puesto, turno, employee_id, nss, foto
        FROM users
        WHERE username = ?
        ");

        if (!$sql) {
            die("Error en prepare: " . $conn->error);
        }

        $sql->bind_param("s", $user);

        if (!$sql->execute()) {
            die("Error en execute: " . $sql->error);
        }

        $sql->store_result();

        if ($sql->num_rows === 1) {

            $sql->bind_result(
            $id, $username, $email, $password, $role, $email_verified, 
            $puesto, $turno, $employee_id, $nss, $foto
            );
            $sql->fetch();

            if (password_verify($pass, $password)) {

                if ($email_verified == 0) {

                    $error = "Debes verificar tu correo antes de iniciar sesión.";

                } else {

                    session_regenerate_id(true);

                    $_SESSION['user'] = [
                        'id' => $id,
                        'username' => $username,
                        'email' => $email,
                        'role' => $role,
                        'puesto' => $puesto,
                        'turno' => $turno,
                        'employee_id' => $employee_id,
                        'nss' => $nss,
                        'foto' => $foto
                    ];

                    header("Location: dashboard.php");
                    exit;
                }

            } else {
                $error = "Usuario o contraseña incorrectos";
            }

        } else {
            $error = "Usuario o contraseña incorrectos";
        }

        $sql->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Iniciar sesión</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<style>

/* CONTENEDOR LOGIN */
.login-card{
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    padding: 25px;
    box-shadow: 0 20px 40px rgba(0,0,0,.3);
    animation: fadeIn .6s ease;
}

/* INPUT ICON STYLE */
.input-group-text{
    background: white;
    border-radius: 12px 0 0 12px;
}

/* INPUT */
.form-control{
    border-radius: 0 12px 12px 0 !important;
}

/* TITULO */
.login-title{
    font-weight: 800;
    text-align: center;
    margin-bottom: 10px;
}

/* SUB */
.login-sub{
    text-align: center;
    font-size: 1rem;
    opacity: .9;
    margin-bottom: 20px;
    color: rgba(255,255,255,0.85);
}

/* BOTON */
.btn-login{
    border-radius: 20px;
    padding: 12px;
    font-weight: 600;
    background: white;
    color: #333;
    border: none;
    transition: .2s;
}

.login-title-big{
    font-size: 2.5rem;
    font-weight: 900;
    text-align: center;
    color: white;
    text-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.btn-login:hover{
    transform: scale(1.05);
}

</style>

</head>

<body>

<div class="app-wrapper d-flex justify-content-center align-items-center">

<div class="login-card w-100" style="max-width:350px;">

<div class="login-title-big">Bienvenido</div>
<div class="login-sub">Inicia sesión para continuar</div>

<?php if ($error): ?>
<div class="alert alert-danger py-2 text-center">
<?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>

<form method="POST">

<!-- USER -->
<div class="input-group mb-3">
<span class="input-group-text">👤</span>
<input 
class="form-control"
name="user"
placeholder="Usuario"
required
>
</div>

<!-- PASSWORD -->
<div class="input-group mb-2">
<span class="input-group-text">🔒</span>
<input 
type="password"
class="form-control"
name="pass"
placeholder="Contraseña"
required
>
</div>

<div class="text-end mb-2">
<a href="recover.php" class="small text-white text-decoration-none">
¿Olvidaste tu contraseña?
</a>
</div>

<div class="text-end mb-3">
<a href="register.php" class="small text-white text-decoration-none">
Crear cuenta
</a>
</div>

<button class="btn btn-login w-100">
Entrar
</button>

</form>

</div>

</div>

</body>
</html>