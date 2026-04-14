<?php
require_once "config.php";

$token = $_GET['token'] ?? '';

if (!$token) {
    die("Token no proporcionado.");
}

$stmt = $conn->prepare("SELECT id FROM users WHERE verification_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $update = $conn->prepare(
        "UPDATE users 
         SET email_verified = 1, verification_token = NULL 
         WHERE verification_token = ?"
    );
    $update->bind_param("s", $token);
    $update->execute();

    echo "Cuenta verificada correctamente. Ya puedes iniciar sesión.";

} else {
    echo "Token inválido o ya utilizado.";
}