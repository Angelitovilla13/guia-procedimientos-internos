<?php

function requireRole($roles = []) {
    if (!isset($_SESSION['user'])) {
        die("No autenticado");
    }

    if (!in_array($_SESSION['user']['role'], $roles)) {
        die("Acceso denegado");
    }
}