<?php
include 'db/db_connect.php';
$escuelaArray = array();
$response = array();

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$query = "select director, descripcion, correo, direccion, coordenada1, coordenada2 from escuela where id=?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$id);
		$stmt->execute();
		$stmt->bind_result($director,$descripcion,$correo,$direccion,$coordenada1,$coordenada2);
		
		if($stmt->fetch()){
			$escuelaArray["director"] = $director;
			$escuelaArray["descripcion"] = $descripcion;
			$escuelaArray["correo"] = $correo;
			$escuelaArray["direccion"] = $direccion;
			$escuelaArray["coordenada1"] = $coordenada1;
			$escuelaArray["coordenada2"] = $coordenada2;
			$response["success"] = 1;
			$response["data"] = $escuelaArray;
		}
		else{
			$response["success"] = 0;
			$response["message"] = "Datos no encontrados";
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