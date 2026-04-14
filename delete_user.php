<?php
require 'auth.php';
require 'config.php';
requireRole(['admin']);

if($_SESSION['user']['rol'] != 'admin'){
    die("Acceso denegado");
}

$id = intval($_POST['id']);

/* evitar que te borres a ti mismo */
if($id == $_SESSION['user']['id']){
    die("No puedes eliminarte a ti mismo");
}

$conn->query("DELETE FROM users WHERE id=$id");

header("Location: usuarios.php");