<?php
include 'db/db_connect.php';
$moduloArray = array();
$response = array();

if(isset($_GET['id_modulo'])){
	$id_modulo = $_GET['id_modulo'];
	$query = "select id_docente, nombre, descripcion, creditos, duracion from modulos where id=?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$id_modulo);
		$stmt->execute();
		$stmt->bind_result($id_docente, $nombre, $descripcion, $creditos, $duracion);
		
		if($stmt->fetch()){
			$moduloArray["id_docente"] = $id_docente;
			$moduloArray["nombre"] = $nombre;
			$moduloArray["descripcion"] = $descripcion;
			$moduloArray["creditos"] = $creditos;
			$moduloArray["duracion"] = $duracion;
			$response["success"] = 1;
			$response["data"] = $moduloArray;
		}
		else{
			$response["success"] = 0;
			$response["message"] = "Modulo no encontrado";
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