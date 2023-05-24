<?php
include 'db/db_connect.php';
$horarioArray = array();
$response = array();

if(isset($_GET['id_modulo'])){
	$id_modulo = $_GET['id_modulo'];
	$query = "select dia, hora, sede, direccion, salon from horarios where id_modulo=?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$id_modulo);
		$stmt->execute();
		$stmt->bind_result($dia, $hora, $sede, $direccion, $salon);
		
		if($stmt->fetch()){
			$horarioArray["dia"] = $dia;
			$horarioArray["hora"] = $hora;
			$horarioArray["sede"] = $sede;
			$horarioArray["direccion"] = $direccion;
			$horarioArray["salon"] = $salon;
			$response["success"] = 1;
			$response["data"] = $horarioArray;
		}
		else{
			$response["success"] = 0;
			$response["message"] = "Horario no encontrado";
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