<?php

require_once("../configuracion/clsBD.php");
$objDatos = new clsDatos();

$sql = "DELETE FROM estacion_indicador;
		DELETE FROM indicador;
		DELETE FROM indicador_aire;";
$objDatos->operacionesCrud($sql);

$sql = "SELECT COUNT(id_estacion) FROM estacion_indicador";
$listo = $objDatos->executeQuery($sql);

echo var_dump($listo);

?>