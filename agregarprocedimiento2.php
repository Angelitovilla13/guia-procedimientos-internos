<?php

require '../auth.php';
require '../config.php';

if($_SESSION['user']['role'] != 'admin' && $_SESSION['user']['role'] != 'supervisor'){
    die("No tienes permisos para crear procedimientos");
    }
 requireRole(['admin','supervisor']);

$user = $_SESSION['user'];

# CREAR PROCEDIMIENTO
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['titulo'])) {

    $titulo = $_POST['titulo'];
    $area = $_POST['area'];
    $maquina_sector = $_POST['maquina_sector'];
    $objetivo = $_POST['objetivo'];
    $creado_por = $user['id'];

    $stmt = $conn->prepare("INSERT INTO addprocedimientos (titulo, area, maquina_sector, objetivo, creado_por) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $titulo, $area, $maquina_sector, $objetivo, $creado_por);
    $stmt->execute();

    $_SESSION['procedure_id'] = $stmt->insert_id;
}

$procedure_id = $_SESSION['procedure_id'] ?? null;


# GUARDAR PASOS
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['paso_texto'])) {

    $procedure_id = $_POST['procedure_id'];

    foreach($_POST['paso_texto'] as $index => $texto){

        $numero_paso = $index + 1;

        $stmt = $conn->prepare("INSERT INTO procedimiento_pasos (procedure_id, numero_paso, descripcion) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $procedure_id, $numero_paso, $texto);
        $stmt->execute();

        $paso_id = $stmt->insert_id;

        # subir imágenes
        if(isset($_FILES['paso_imagen']['name'][$index])){

            $total = count($_FILES['paso_imagen']['name'][$index]);

            for($i=0; $i<$total; $i++){

                $nombre = $_FILES['paso_imagen']['name'][$index][$i];
                $tmp = $_FILES['paso_imagen']['tmp_name'][$index][$i];

                if($nombre != ""){

                    $ruta = "../uploads/".$nombre;
                    move_uploaded_file($tmp,$ruta);

                    $stmt2 = $conn->prepare("INSERT INTO paso_imagenes (paso_id, ruta_imagen) VALUES (?, ?)");
                    $stmt2->bind_param("is",$paso_id,$ruta);
                    $stmt2->execute();

                }
            }
        }
    }

    echo "<script>alert('Procedimiento guardado correctamente'); window.location='../dashboard.php';</script>";
    exit;

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Agregar Procedimiento</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css?v=1.2">

</head>

<body>

<div class="app-wrapper form-screen">

<a href="../dashboard.php" class="close-btn">‹</a>

<div class="logo">molex</div>

<h3 class="title text-center">AGREGAR<br>PROCEDIMIENTO</h3>

<form method="POST" enctype="multipart/form-data">

<input type="hidden" name="procedure_id" value="<?php echo $procedure_id ?>">

<div id="pasos-container">

<div class="form-group paso">

<label>PASO 1:</label>

<input
type="text"
name="paso_texto[]"
class="form-control custom-input"
placeholder="Describe el paso"
required
>

<button type="button" class="app-button mt-2 btn-img">
+ Agregar Imagen
</button>

<input
type="file"
name="paso_imagen[0][]"
class="d-none file-input"
multiple
>

<span class="img-count small text-light ms-2"></span>

</div>

</div>

<div class="text-center mt-4">

<button type="submit" class="next-btn">✔ Hecho</button>

</div>

</form>

<button id="addStepBtn" class="close-btn" style="bottom:30px; top:auto;">+</button>

</div>

<script>

let numeroPaso = 1;

document.getElementById("addStepBtn").addEventListener("click", function(){

numeroPaso++;

let container = document.getElementById("pasos-container");

let div = document.createElement("div");

div.classList.add("form-group","paso");

div.innerHTML = `
<label>PASO ${numeroPaso}:</label>

<input
type="text"
name="paso_texto[]"
class="form-control custom-input"
placeholder="Describe el paso"
required
>

<button type="button" class="app-button mt-2 btn-img">
+ Agregar Imagen
</button>

<input
type="file"
name="paso_imagen[${numeroPaso-1}][]"
class="d-none file-input"
multiple
>

<span class="img-count small text-light ms-2"></span>
`;

container.appendChild(div);

});



document.addEventListener("click", function(e){

if(e.target.classList.contains("btn-img")){

let input = e.target.nextElementSibling;

input.click();

}

});


document.addEventListener("change", function(e){

if(e.target.classList.contains("file-input")){

let count = e.target.files.length;

let label = e.target.nextElementSibling;

if(count == 1){
label.innerHTML = "1 imagen seleccionada";
}else{
label.innerHTML = count + " imágenes seleccionadas";
}

}

});

</script>

</body>
</html>