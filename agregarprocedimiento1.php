<?php
require '../auth.php';
/* permitir admin y supervisor */
requireRole(['admin','supervisor']);

$user = $_SESSION['user'];
$isAdmin = ($user['role'] === 'admin');

requireRole(['admin','supervisor']);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Agregar Procedimiento</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css?v=1.1">
</head>

<body>

<div class="app-wrapper form-screen">

    <!-- Botón salida -->
    <a href="../dashboard.php" class="close-btn">✕</a>

    <div class="logo">molex</div>

    <h3 class="title text-center">AGREGAR<br>PROCEDIMIENTO</h3>

    <form action="agregarprocedimiento2.php" method="POST">

        <!-- Título -->
        <div class="form-group">
            <label>TITULO:</label>
            <input type="text" name="titulo" class="form-control custom-input" required>
        </div>

        <!-- Área -->
        <div class="form-group">
            <label>AREA:</label>
            <select name="area" class="form-control custom-input" required>
                <option value="">Seleccionar área</option>
                <option value="MEDICAL">MEDICAL</option>
                <option value="CORTE">CORTE</option>
                <option value="RF">RF</option>
                <option value="DESPOJE">DESPOJE</option>
            </select>
        </div>
        
         <!-- Maquina o sector -->
        <div class="form-group">
            <label>Maquina o sector:</label>
            <input type="text" name="maquina_sector" class="form-control custom-input" required>
        </div>


        <!-- Objetivo -->
        <div class="form-group">
            <label>OBJETIVO:</label>
            <textarea name="objetivo" rows="4" class="form-control custom-input" required></textarea>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="next-btn">SIGUIENTE</button>
        </div>

    </form>

</div>

</body>
</html>