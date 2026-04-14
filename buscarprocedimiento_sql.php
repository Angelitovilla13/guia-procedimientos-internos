<?php

require '../config.php';

$area = $_POST['area'] ?? '';
$maquina = $_POST['maquina'] ?? '';
$keyword = $_POST['keyword'] ?? '';

$sql = "SELECT id, titulo, area, maquina_sector FROM addprocedimientos WHERE 1=1";

if($area != ''){
$sql .= " AND area='$area'";
}

if($maquina != ''){
$sql .= " AND maquina_sector='$maquina'";
}

if($keyword != ''){
$sql .= " AND titulo LIKE '%$keyword%'";
}

$sql .= " ORDER BY titulo";

$res = $conn->query($sql);

if($res->num_rows == 0){

echo "<p class='text-light text-center'>No se encontraron procedimientos</p>";
exit;

}

while($row = $res->fetch_assoc()){

echo "

<div class='card mb-2 p-3' style='border-radius:15px;'>

<b>".$row['titulo']."</b>

<small>
Area: ".$row['area']." |
Maquina: ".$row['maquina_sector']."
</small>

<a href='verprocedimiento.php?id=".$row['id']."' class='btn btn-sm btn-dark mt-2'>
Ver procedimiento
</a>

</div>

";

}

?>