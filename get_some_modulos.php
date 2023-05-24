<?php
include 'db/db_connect.php';
$moduloArray = array();
$response = array();
$result = array();

if(isset($_GET['id_posgrado']) && isset($_GET['semestre'])){
	$id_posgrado = $_GET['id_posgrado'];
	$semestre = $_GET['semestre'];
	$query = "select id, id_docente, nombre, descripcion, creditos, duracion from modulos where id_posgrado=? and semestre=?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("si",$id_posgrado,$semestre);
		$stmt->execute();
		$stmt->bind_result($id, $id_docente, $nombre, $descripcion, $creditos, $duracion);
		
		while($stmt->fetch()){
			$moduloArray["id"] = $id;
			$moduloArray["id_docente"] = $id_docente;
			$moduloArray["nombre"] = $nombre;
			$moduloArray["descripcion"] = $descripcion;
			$moduloArray["creditos"] = $creditos;
			$moduloArray["duracion"] = $duracion;
			$result[] = $moduloArray;
		}
		$stmt->close();
		$response["success"] = 1;
		$response["data"] = $result;
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