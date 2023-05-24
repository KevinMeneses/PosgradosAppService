<?php
include 'db/db_connect.php';
$horarioArray = array();
$response = array();
$result = array();

if(isset($_GET['id_posgrado']) && isset($_GET['semestre'])){
	$id_posgrado = $_GET['id_posgrado'];
	$semestre = $_GET['semestre'];
	$query = "select id_modulo, dia, hora, sede, direccion, salon from horarios where id_posgrado=? and semestre=?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("ss",$id_posgrado,$semestre);
		$stmt->execute();
		$stmt->bind_result($id_modulo, $dia, $hora, $sede, $direccion, $salon);
		
		while($stmt->fetch()){
			$horarioArray["id_modulo"] = $id_modulo;
			$horarioArray["dia"] = $dia;
			$horarioArray["hora"] = $hora;
			$horarioArray["sede"] = $sede;
			$horarioArray["direccion"] = $direccion;
			$horarioArray["salon"] = $salon;
			$result[] = $horarioArray;
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