<?php
include 'db/db_connect.php';
$calificacionArray = array();
$response = array();

if(isset($_GET['id_docente'])){
	$id_docente = $_GET['id_docente'];
	$query = "SELECT AVG(calificacion) as promedio FROM calificaciones WHERE id_docente = ?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$id_docente);
		$stmt->execute();
		$stmt->bind_result($promedio);
		
		if($stmt->fetch()){
			$calificacionArray["promedio"] = $promedio;
			$response["success"] = 1;
			$response["data"] = $calificacionArray;
		}
		else{
			$response["success"] = 0;
			$response["message"] = "promedio no encontrado";
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