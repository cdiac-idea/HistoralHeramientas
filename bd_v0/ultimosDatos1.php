<?php

require_once("../configuracion/clsBD.php");
$objDatos = new clsDatos();

$sql = "SELECT nombre, apellido, dependencia, cargo, nombre_usuario, MD5(contrasenia), cedula, id_rol_usu, id_usuario 
FROM usuario";
$datos = $objDatos->executeQuery($sql);

print_r($datos);

?>