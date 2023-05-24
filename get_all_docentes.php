<?php
include 'db/db_connect.php';
$iddocenteArray = array();
$docenteArray = array();
$response = array();
$result = array();

if(isset($_GET['id_posgrado'])){
	$id_posgrado = $_GET['id_posgrado'];
  	$query1 = "select id_docente from docente_posgrado where id_posgrado=?"
    $query = "select nombre, apellido, profesion, descripcion, imagen from docentes where id=?";
    if($stmt1 = $con->prepare($query1)){
		$stmt1->bind_param("s",$id_posgrado);
		$stmt1->execute();
		$stmt1->bind_result($id_docente);
      	while($stmt1->fetch()){
          	$iddocenteArray[]=$id_docente; 
        }
      	$stmt1->close();
      	
    	foreach($iddocenteArray as $id){		
			if($stmt = $con->prepare($query)){
				$stmt->bind_param("s",$id);
				$stmt->execute();
				$stmt->bind_result($nombre,$apellido,$profesion,$descripcion,$imagen);
		
				if($stmt->fetch()){
					$docenteArray["nombre"]=$nombre;
					$docenteArray["apellido"]=$apellido;
					$docenteArray["profesion"]=$profesion;
					$docenteArray["descripcion"]=$descripcion;
					$docenteArray["imagen"]=$imagen;
					$result[] = $docenteArray;
              		$stmt->close();
					$response["success"] = 1;
					$response["data"] = $result;
				}else{
					$response["success"] = 0;
					$response["message"] = mysqli_error($con);
          		}
			}else{
				$response["success"] = 0;
				$response["message"] = mysqli_error($con);	
			}
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