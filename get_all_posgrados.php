<?php
include 'db/db_connect.php';

$query = "SELECT * FROM posgrados";
$result = array();
$posgradoArray = array();
$response = array();

if($stmt = $con->prepare($query)){
	$stmt->execute();
	$stmt->bind_result($id,$cod_snies,$nombre,$duracion,$totalcreditos,$descripcion,$valorsemestre);
			
	while($stmt->fetch()){
		$posgradoArray["id"] = $id;
		$posgradoArray["cod_snies"] = $cod_snies;
		$posgradoArray["nombre"] = $nombre;
		$posgradoArray["duracion"] = $duracion;
		$posgradoArray["totalcreditos"] = $totalcreditos;
		$posgradoArray["descripcion"] = $descripcion;
		$posgradoArray["valorsemestre"] = $valorsemestre;
		$result[] = $posgradoArray;
	}
	$stmt->close();
	$response["success"] = 1;
	$response["data"] = $result;

}else{
	$response["success"] = 0;
	$response["message"] = mysqli_error($con);	
}

echo json_encode($response);
?>