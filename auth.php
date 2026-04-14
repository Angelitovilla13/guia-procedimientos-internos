<?php
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

/* 🔐 FUNCIÓN DE ROLES */
function requireRole($roles){
    if(!in_array($_SESSION['user']['role'], $roles)){
        die("No tienes permisos para acceder a esta sección");
    }
}


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: /login.php");
    exit;
}