<?php

function conectarse()
{
	$servidor="172.23.177.60";
	$usuario="redcorpo";
	$password="consultacorpocaldas";
	$bd="redcaldas";

	$conectar = new mysqli($servidor,$usuario,$password,$bd) or die("No se pudo conectar al servidor de base de datos Mysql");
	return $conectar;
}

$dbr = conectarse();

$cons = "SHOW COLUMNS from est_marquetalia";
$ejecuto = mysqli_query($dbr,$cons);

if(mysqli_num_rows($ejecuto)>0){
	while($fila = mysqli_fetch_assoc($ejecuto)){
		echo var_dump($fila['Field']);
		echo "<br>";
	}
	echo "chec";
}




$recuperacionFecha = "SELECT fecha,hora from est_marquetalia where fecha >= '2013-10-21' and hora > '09:20:21' order by fecha,hora"; #!! Se toman las primeras 100 fechas en motivo de prueba
$e_recuperacionF = mysqli_query($dbr,$recuperacionFecha);
$n_recuperacionF = mysqli_num_rows($e_recuperacionF); #Número de fechas resultantes

echo($n_recuperacionF);
?>