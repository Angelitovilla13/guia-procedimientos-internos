<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'auth.php';
require 'config.php';

requireRole(['admin']);

$mensaje = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $role = $_POST['role'] ?? 'user';
    $puesto = $_POST['puesto'] ?? '';
    $turno = $_POST['turno'] ?? '';
    $employee_id = $_POST['employee_id'] ?? '';
    $nss = $_POST['nss'] ?? '';

    if($username && $email && $password){

        // 🔍 verificar correo duplicado
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            $mensaje = "Este correo ya está registrado";
        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
            INSERT INTO users (username, email, password, role, puesto, turno, employee_id, nss)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            if(!$stmt){
                die("Error prepare: " . $conn->error);
            }

            $stmt->bind_param(
                "ssssssss",
                $username,
                $email,
                $hash,
                $role,
                $puesto,
                $turno,
                $employee_id,
                $nss
            );

            if(!$stmt->execute()){
                die("Error execute: " . $stmt->error);
            }

            $mensaje = "Usuario creado correctamente";
        }

    } else {
        $mensaje = "Completa los campos obligatorios";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Crear usuario</title>

<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="app-wrapper form-screen">

<a href="usuarios.php" class="close-btn">✕</a>

<div class="logo">molex</div>

<h2 class="title text-center">CREAR USUARIO</h2>

<?php if($mensaje): ?>
<div class="alert alert-info text-center">
<?= htmlspecialchars($mensaje) ?>
</div>
<?php endif; ?>

<form method="POST">

<!-- Usuario -->
<div class="form-group">
<label>Usuario</label>
<input class="form-control custom-input" name="username" required>
</div>

<!-- Correo -->
<div class="form-group">
<label>Correo</label>
<input type="email" class="form-control custom-input" name="email" required>
</div>

<!-- Contraseña -->
<div class="form-group">
<label>Contraseña</label>
<input type="password" class="form-control custom-input" name="password" required>
</div>

<!-- Rol -->
<div class="form-group">
<label>Rol</label>
<select name="role" class="form-control custom-input">
    <option value="user">User</option>
    <option value="supervisor">Supervisor</option>
    <option value="admin">Admin</option>
</select>
</div>

<!-- Puesto -->
<div class="form-group">
<label>Puesto</label>
<input name="puesto" class="form-control custom-input">
</div>

<!-- Turno -->
<div class="form-group">
<label>Turno</label>
<input name="turno" class="form-control custom-input" placeholder="Ej: Matutino / Nocturno">
</div>

<!-- ID colaborador -->
<div class="form-group">
<label>ID de colaborador</label>
<input name="employee_id" class="form-control custom-input">
</div>

<!-- NSS -->
<div class="form-group">
<label>Número de Seguro Social</label>
<input name="nss" class="form-control custom-input">
</div>

<div class="text-center mt-4">
<button class="next-btn">Crear usuario</button>
</div>

</form>

</div>

</body>
</html>