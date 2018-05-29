<?php

require_once("../configuracion/clsBD.php");
$objDatos = new clsDatos();

$sql = "DELETE FROM estacion_indicador; DELETE FROM indicador_aire;  DELETE FROM indicador";
$datos=$objDatos->executeQuery($sql);

$sql = "Alter table indicador add column min_pb number(10,1); Alter table indicador add column max_pb number(10,1);";
$datos=$objDatos->executeQuery($sql);


?>