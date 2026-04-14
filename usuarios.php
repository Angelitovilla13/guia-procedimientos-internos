<?php
require 'auth.php';
require 'config.php';

requireRole(['admin']);

$res = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Usuarios</title>

<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

.user-card{
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(12px);
    padding: 18px;
    border-radius: 18px;
    margin-bottom: 15px;
}

.user-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.user-name{
    font-weight:700;
    font-size:1.1rem;
}

.user-info{
    font-size:0.85rem;
    opacity:.85;
}

.hidden{
    display:none;
}

</style>

<script>
function toggleEdit(id){
    document.getElementById("view-"+id).classList.toggle("hidden");
    document.getElementById("edit-"+id).classList.toggle("hidden");
}
</script>

</head>

<body>

<div class="app-wrapper">

<a href="dashboard.php" class="close-btn">✕</a>

<div class="logo">molex</div>
<h2 class="title">USUARIOS</h2>

<a href="crear_usuario.php" class="app-button mb-3">
➕ Crear usuario
</a>

<?php while($u = $res->fetch_assoc()): ?>

<div class="user-card">

    <!-- VISTA NORMAL -->
    <div id="view-<?= $u['id'] ?>">

        <div class="user-header">
            <div>
                <div class="user-name">
                    <?= htmlspecialchars($u['name']) ?>
                </div>
                <div class="user-info">
                    ID: <?= $u['employee_id'] ?> • <?= htmlspecialchars($u['email']) ?>
                </div>
            </div>

            <button onclick="toggleEdit(<?= $u['id'] ?>)" class="btn btn-light btn-sm">
                Editar
            </button>
        </div>

        <div class="mt-2">
            <b>Rol:</b> <?= strtoupper($u['role']) ?><br>
            <b>Puesto:</b> <?= $u['puesto'] ?: 'No asignado' ?><br>
            <b>Turno:</b> <?= $u['turno'] ?: 'No asignado' ?>
        </div>

    </div>

    <!-- VISTA EDITAR -->
    <div id="edit-<?= $u['id'] ?>" class="hidden">

        <form method="POST" action="update_user.php">

            <input type="hidden" name="id" value="<?= $u['id'] ?>">

            <label>Rol</label>
            <select name="role" class="form-control custom-input mb-2">
                <option value="user" <?= $u['role']=='user'?'selected':'' ?>>User</option>
                <option value="supervisor" <?= $u['role']=='supervisor'?'selected':'' ?>>Supervisor</option>
                <option value="admin" <?= $u['role']=='admin'?'selected':'' ?>>Admin</option>
            </select>

            <label>Puesto</label>
            <input type="text" name="puesto" value="<?= $u['puesto'] ?>" class="form-control custom-input mb-2">

            <label>Turno</label>
            <input type="text" name="turno" value="<?= $u['turno'] ?>" class="form-control custom-input mb-2">

            <div class="d-flex gap-2 mt-2">

                <button class="btn btn-success w-50">
                    Guardar
                </button>

        </form>

        <form method="POST" action="delete_user.php" 
        onsubmit="return confirm('¿Eliminar usuario?');" class="w-50">

            <input type="hidden" name="id" value="<?= $u['id'] ?>">

            <button class="btn btn-danger w-100">
                Eliminar
            </button>

        </form>

            </div>

        <button onclick="toggleEdit(<?= $u['id'] ?>)" 
        class="btn btn-secondary w-100 mt-2">
            Cancelar
        </button>

    </div>

</div>

<?php endwhile; ?>

</div>

</body>
</html>