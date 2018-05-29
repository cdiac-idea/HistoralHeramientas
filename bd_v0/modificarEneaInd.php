<?php

require_once("../configuracion/clsBD.php");
$objDatos = new clsDatos();


$sql = "DELETE FROM estacion_indicador WHERE id_estacion=24 and anio=2015;  
DELETE FROM indicador WHERE estacion=24 and anio=2015; ";
$datos=$objDatos->executeQuery($sql);


?>