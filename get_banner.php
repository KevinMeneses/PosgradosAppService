<?php
include 'db/db_connect.php';
$bannerArray = array();
$response = array();

$query = "select contenido from banner where id=1";
if($stmt = $con->prepare($query)){

	$stmt->execute();
	$stmt->bind_result($contenido);
		
	if($stmt->fetch()){
		$bannerArray["contenido"] = $contenido;
		$response["success"] = 1;
		$response["data"] = $bannerArray;
	}
	else{
		$response["success"] = 0;
		$response["message"] = "Banner no encontrado";
	}
	$stmt->close();
}
else{
	$response["success"] = 0;
	$response["message"] = mysqli_error($con);
}

echo json_encode($response);
?>