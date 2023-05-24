<?php
include 'db/db_connect.php';
$usuarioArray = array();
$response = array();

if(isset($_GET['correo']) && isset($_GET['contrasena'])){
	$correo = $_GET['correo'];
	$contrasena = $_GET['contrasena'];
	$query = "select codigo, nombre, apellido, id_posgrado, semestre from usuarios where correo=? and contrasena=?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("ss",$correo,$contrasena);
		$stmt->execute();
		$stmt->bind_result($codigo,$nombre,$apellido,$id_posgrado,$semestre);
		
		if($stmt->fetch()){
			$usuarioArray["codigo"] = $codigo;
			$usuarioArray["nombre"] = $nombre;
			$usuarioArray["apellido"] = $apellido;
			$usuarioArray["correo"] = $correo;
			$usuarioArray["id_posgrado"] = $id_posgrado;
			$usuarioArray["semestre"] = $semestre;
			$response["success"] = 1;
			$response["data"] = $usuarioArray;
		}
		else{
			$response["success"] = 0;
			$response["message"] = "Usuario no encontrado";
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
	$response["message"] = "falta el correo o la contrasena";
}

echo json_encode($response);
?>