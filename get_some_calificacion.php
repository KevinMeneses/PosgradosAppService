<?php
include 'db/db_connect.php';
$calificacionArray = array();
$response = array();

if(isset($_GET['id_docente'])&&isset($_GET['id_usuario'])){
	$id_docente = $_GET['id_docente'];
	$id_usuario = $_GET['id_usuario'];

	$query = "SELECT calificacion FROM calificaciones WHERE id_docente=? and id_usuario=?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("ss",$id_docente,$id_usuario);
		$stmt->execute();
		$stmt->bind_result($calificacion);
		
		if($stmt->fetch()){
			$calificacionArray["calificacion"] = $calificacion;
			$response["success"] = 1;
			$response["data"] = $calificacionArray;
		}
		else{
			$response["success"] = 0;
			$response["message"] = "Calificacion no encontrada";
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