<?php
include 'db/db_connect.php';
$response = array();

if(isset($_REQUEST['id_usuario'])&&isset($_REQUEST['id_docente'])&&isset($_REQUEST['calificacion'])){
	$id_usuario = $_REQUEST['id_usuario'];
	$id_docente = $_REQUEST['id_docente'];
	$calificacion = $_REQUEST['calificacion'];

	$query = "UPDATE calificaciones SET calificacion=? WHERE id_usuario=? and id_docente=?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("dss", $calificacion, $id_usuario, $id_docente);
		$stmt->execute();
		
		if($stmt->affected_rows == 1){
			$response["success"] = 1;			
			$response["message"] = "Calificacion modificada";				
		}else{
			$response["success"] = 0;
			$response["message"] = "error al modificar";
		}					
	}else{
		$response["success"] = 0;
		$response["message"] = mysqli_error($con);
	}

}else{
	$response["success"] = 0;
	$response["message"] = "faltan parametros";
}
echo json_encode($response);
?>