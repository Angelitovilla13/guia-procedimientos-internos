<?php
require 'auth.php';
require 'config.php';

requireRole(['admin']);

/* obtener datos */
$id = intval($_POST['id']);
$role = $_POST['role'];
$puesto = $conn->real_escape_string($_POST['puesto']);
$turno = $conn->real_escape_string($_POST['turno']);

/* evitar que admin se cambie a sí mismo */
if($id == $_SESSION['user']['id']){
    die("No puedes modificar tu propio usuario");
}

/* actualizar */
$conn->query("
UPDATE users 
SET role='$role', puesto='$puesto', turno='$turno'
WHERE id=$id
");

/* volver */
header("Location: usuarios.php");
exit;