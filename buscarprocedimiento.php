<?php
require '../auth.php';
require '../config.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Buscar Procedimiento</title>

<link rel="stylesheet" href="../style.css?v=1.1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="app-wrapper form-screen">

<a href="../dashboard.php" class="close-btn">✕</a>

<div class="logo">molex</div>

<h3 class="title text-center">BUSQUEDA</h3>

<p class="text-center text-light mb-4">Buscar procedimiento</p>

<!-- AREA -->

<div class="form-group">

<label>1.- BUSCAR POR AREA</label>

<select id="area" class="form-control custom-input">
<option value="">Seleccionar</option>

<?php

$res = $conn->query("SELECT DISTINCT area FROM addprocedimientos ORDER BY area");

while($row = $res->fetch_assoc()){
echo "<option>".$row['area']."</option>";
}

?>

</select>

</div>

<!-- MAQUINA -->

<div class="form-group mt-3">

<label>2.- BUSCAR POR MAQUINA / SECTOR</label>

<select id="maquina" class="form-control custom-input">
<option value="">Seleccionar</option>

<?php

$res = $conn->query("SELECT DISTINCT maquina_sector FROM addprocedimientos ORDER BY maquina_sector");

while($row = $res->fetch_assoc()){
echo "<option>".$row['maquina_sector']."</option>";
}

?>

</select>

</div>

<!-- PALABRA CLAVE -->

<div class="form-group mt-3">

<label>3.- BUSCAR POR PALABRA</label>

<input
type="text"
id="keyword"
class="form-control custom-input"
placeholder="Ej: calibracion, sensor..."
>

</div>

<div class="text-center mt-4">

<button class="next-btn" onclick="buscar()">Buscar</button>

</div>

<hr class="text-light">

<div id="resultados" class="mt-3"></div>

</div>

<script>

function buscar(){

let area = document.getElementById("area").value;
let maquina = document.getElementById("maquina").value;
let keyword = document.getElementById("keyword").value;

fetch("buscarprocedimiento_sql.php",{

method:"POST",
headers:{'Content-Type':'application/x-www-form-urlencoded'},

body:
"area="+area+
"&maquina="+maquina+
"&keyword="+keyword

})

.then(res=>res.text())
.then(data=>{

document.getElementById("resultados").innerHTML=data;

});

}

</script>

</body>
</html>