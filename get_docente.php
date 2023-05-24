<?php
include 'db/db_connect.php';
$docenteArray = array();
$response = array();

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$query = "select nombre, apellido, profesion, descripcion, imagen from docentes where id=?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$id);
		$stmt->execute();
		$stmt->bind_result($nombre,$apellido,$profesion,$descripcion,$imagen);
		
		if($stmt->fetch()){
			$docenteArray["nombre"] = $nombre;
			$docenteArray["apellido"] = $apellido;
			$docenteArray["profesion"] = $profesion;
			$docenteArray["descripcion"] = $descripcion;
			$docenteArray["imagen"] = $imagen;
			$response["success"] = 1;
			$response["data"] = $docenteArray;
		}
		else{
			$response["success"] = 0;
			$response["message"] = "Docente no encontrado";
		}
		$stmt->close();
	}
	else{
		$response["success"] = 0;
		$response["message"] = mysqli_error($con);
	}
}
else{
	$response["success"] = 0;
	$response["message"] = "faltan parametros";
}

echo json_encode($response);
?>