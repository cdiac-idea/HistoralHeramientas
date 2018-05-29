<?php

    require_once("clsBD.php");
	$objDatos = new clsDatos();

	function nombreEstacion($propietario, $prop){
		$objDatos = new clsDatos();
		$sql = "SELECT estacion, tipologia FROM station_dim WHERE propietario='".$propietario."'";
		if ($prop!=null) {
			$sql .= " OR propietario='".$prop."'";
		}
		return $objDatos->executeQuery($sql);
	}

?>