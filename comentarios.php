<?php

if (isset($_REQUEST['correo']) && isset($_REQUEST['correoadmin']))
{      
	$correoadmin = $_REQUEST['correoadmin'];   
	$correo = $_REQUEST['correo'];   
	$asunto = $_REQUEST['asunto'];   
	$cuerpo = $_REQUEST['cuerpo'];
	mail($correoadmin, "$asunto", $cuerpo, "From:" . $correo);
	echo "Gracias por sus comentarios";   
}
else{
	echo "Faltan parametros";
}