<?php
require '../auth.php';
require '../config.php';

if(!isset($_GET['id'])){
    die("Procedimiento no encontrado");
}

$id = intval($_GET['id']);

/* traer procedimiento */
$sql = "SELECT * FROM addprocedimientos WHERE id = $id";
$res = $conn->query($sql);

if($res->num_rows == 0){
    die("Procedimiento no encontrado");
}

$proc = $res->fetch_assoc();

/* traer pasos */
$sqlPasos = "SELECT * FROM procedimiento_pasos 
WHERE procedure_id = $id 
ORDER BY numero_paso ASC";

$resPasos = $conn->query($sqlPasos);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php echo $proc['titulo']; ?></title>

<link rel="stylesheet" href="../style.css">

<style>

/* Tarjeta principal */
.procedimiento-card{
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    padding: 20px;
    border-radius: 20px;
    margin-top: 20px;
}

/* Paso */
.paso{
    margin-top: 25px;
    background: rgba(255,255,255,0.08);
    padding: 15px;
    border-radius: 15px;
}

/* Imagen */
.paso img{
    width: 100%;
    border-radius: 12px;
    margin-top: 10px;
}

/* Botón back */
.back-btn{
    position:absolute;
    top:20px;
    left:20px;
    background:white;
    width:35px;
    height:35px;
    border-radius:50%;
    text-align:center;
    line-height:35px;
    font-weight:bold;
    text-decoration:none;
    color:#333;
    box-shadow:0 5px 15px rgba(0,0,0,.3);
}

</style>

</head>

<body>

<div class="app-wrapper form-screen">

<!-- BOTÓN REGRESAR -->
<a href="buscarprocedimiento.php" class="back-btn">‹</a>

<div class="logo">molex</div>

<h2 class="title text-center">PROCEDIMIENTO</h2>

<!-- INFO PRINCIPAL -->
<div class="procedimiento-card">

<h3><?php echo $proc['titulo']; ?></h3>

<p><b>AREA:</b> <?php echo $proc['area']; ?></p>

<p><b>MAQUINA:</b> <?php echo $proc['maquina_sector']; ?></p>

<p><b>Objetivo:</b><br>
<?php echo $proc['objetivo']; ?>
</p>

</div>

<!-- PASOS -->
<?php while($paso = $resPasos->fetch_assoc()): ?>

<div class="paso">

<b>Paso <?php echo $paso['numero_paso']; ?>:</b>

<p><?php echo $paso['descripcion']; ?></p>

<?php
$idPaso = $paso['id'];

$sqlImg = "SELECT * FROM paso_imagenes WHERE paso_id = $idPaso";
$resImg = $conn->query($sqlImg);

while($img = $resImg->fetch_assoc()):
?>

<img src="<?php echo $img['ruta_imagen']; ?>">

<?php endwhile; ?>

</div>

<?php endwhile; ?>

<!-- 🔥 BOTÓN ÚNICO AL FINAL -->
<div class="text-center mt-4">
<a href="../reportar.php?id=<?php echo $id; ?>" class="app-button" style="background:#ffdddd; color:#900;">
⚠ Reportar / Sugerir mejora
</a>
</div>

</div>

</body>
</html>