<?php
include 'db/db_connect.php';
$posgradoArray = array();
$response = array();

if(isset($_GET['id_posgrado'])){
	$id_posgrado = $_GET['id_posgrado'];
	$query = "select nombre from posgrados where id=?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s", $id_posgrado);
		$stmt->execute();
		$stmt->bind_result($nombre);
		
		if($stmt->fetch()){
			$posgradoArray["nombre"] = $nombre;
			$response["success"] = 1;
			$response["data"] = $posgradoArray;
		}
		else{
			$response["success"] = 0;
			$response["message"] = "Posgrado no encontrado";
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
	$response["message"] = "faltan parametro";
}

echo json_encode($response);
?>