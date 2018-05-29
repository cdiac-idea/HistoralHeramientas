<?php
/*$usuario = $f_consulta_bases['usuario'];  // GUARDA EN $usuario EL USUARIO DE CADA BASE DE DATOS
	$password = $f_consulta_bases['contrasenia']; // GUARDA EN $password LA CONTRASEÑA DE CADA BASE DE DATOS
	$bd = $f_consulta_bases['nombrebasedatos']; // GUARDA EN $bd EL NOMBRE DE LA BASE DE DATOS DE CADA BASE DE DATOS

	$dbr = conectarse($usuario,$password,$bd); # establece conexión con el servidor de adquisición de datos

require_once("../conexion/conexionyarumos.php");
$borrar1 = "DELETE from fact_table where estacion_sk = '1' and fecha_sk = 26958 and tiempo_sk > 33621";
$r = pg_query($borrar1);

$borrar = "DELETE from fact_table where estacion_sk = '1' and fecha_sk > 26958";
pg_query($borrar);

require_once("../conexion/conexiondwh.php");
$dbr = conectarse1();


$consulta = "SELECT * from fact_table where estacion_sk = 1";
$e_consulta = pg_query($consulta);


$array = array("estacion_sk","fecha_sk","tiempo_sk","precipitacion","temperatura","temperatura_max","temperatura_min","temperatura_med","brillo","humedad_relativa","nivel","caudal","velocidad_viento","direccion_viento","presion_barometrica","evapotranspiracion","radiacion_solar");


require_once("../conexion/conexionyarumos.php");
$dbr2 = conectarse2();

while($n_consulta = pg_fetch_array($e_consulta)){

if (is_numeric($n_consulta['estacion_sk']) and is_numeric($n_consulta['fecha_sk']) and is_numeric($n_consulta['tiempo_sk'])){
$inserto_en_fact_oficial = "INSERT INTO fact_table (estacion_sk,fecha_sk,tiempo_sk) values($n_consulta[estacion_sk],$n_consulta[fecha_sk],$n_consulta[tiempo_sk])";
$e_inserto_en_fact_oficial = pg_query($inserto_en_fact_oficial);
}

}



while ($f_consulta = pg_fetch_array($e_consulta)){


	$estacion_sk = $f_consulta['estacion_sk'];
	$fecha_sk = $f_consulta['fecha_sk'];
	$tiempo_sk = $f_consulta['tiempo_sk'];
	$precipitacion = $f_consulta['precipitacion'];
	$temperatura = $f_consulta['temperatura'];
	$temperatura_max = $f_consulta['temperatura_max'];
	$temperatura_min = $f_consulta['temperatura_min'];
	$temperatura_med = $f_consulta['temperatura_med'];
	$brillo = $f_consulta['brillo'];
	$humedad_relativa = $f_consulta['humedad_relativa'];
	$nivel = $f_consulta['nivel'];
	$caudal = $f_consulta['caudal'];
	$velocidad_viento = $f_consulta['velocidad_viento'];
	$direccion_viento = $f_consulta['direccion_viento'];
	$presion_barometrica = $f_consulta['presion_barometrica'];
	$evapotranspiracion = $f_consulta['evapotranspiracion'];
	$radiacion_solar = $f_consulta['radiacion_solar'];


$inserto_en_fact_oficial = "INSERT INTO fact_table values($estacion_sk,$fecha_sk,$tiempo_sk,$precipitacion,$temperatura,null,null,null,null,$humedad_relativa,$nivel,$caudal,$velocidad_viento,$direccion_viento,$presion_barometrica,$evapotranspiracion,$radiacion_solar)";
$e_inserto_en_fact_oficial = pg_query($inserto_en_fact_oficial);
}

/*
$consulta2 = "SELECT count(estacion_sk) AS cantidad FROM fact_table where estacion_sk = 1";
$e_consulta2 = pg_query($consulta2);
$f_consulta2 = pg_fetch_array($e_consulta2);

echo($f_consulta2['cantidad']);




/*
$consulta2 = "SELECT count(precipitacion) AS cantidad FROM fact_table";
$e_consulta2 = pg_query($consulta2);
$f_consulta2 = pg_fetch_array($e_consulta2);

//$o = "SELECT ($dbr.idea_dwh_db_pruebascube.fact_table.precipitacion) AS FACT1 FROM $dbr.idea_dwh_db_pruebascube.fact_table";

echo($f_consulta['cantidad']);
echo "<br>";

/*
$consulta = "SELECT fecha_sk,tiempo_sk from fact_table where estacion_sk = 1 and fecha_sk = 26958 and tiempo_sk > 33622";
$e_consulta = pg_query($consulta);

$consulta2 = "SELECT fecha_sk,tiempo_sk from fact_table where estacion_sk = 1 and fecha_sk > 26958";
$e_consulta2 = pg_query($consulta2);


echo(pg_num_rows($e_consulta));
echo "<br>";
echo(pg_num_rows($e_consulta2));
echo "<br>";
echo(pg_num_rows($e_consulta) + pg_num_rows($e_consulta2));

echo "<br>";
while ($f_consulta = pg_fetch_array($e_consulta)) {
	//$borrar = "DELETE from fact_table where estacion_sk = 4 and fecha_sk = $f_consulta[fecha_sk] and tiempo_sk = $f_consulta[tiempo_sk]";
	//pg_query($borrar);
	
	echo($f_consulta['fecha_sk']);
	echo "<br>";
	echo($f_consulta['tiempo_sk']);
	echo "<br>";
}



echo "<br>";
while ($f_consulta2 = pg_fetch_array($e_consulta2)) {

	//$borrar = "DELETE from fact_table where estacion_sk = 4 and fecha_sk = $f_consulta2[fecha_sk] and tiempo_sk = $f_consulta2[tiempo_sk]";
	//pg_query($borrar);

	echo($f_consulta2['fecha_sk']);
	echo "<br>";
	echo($f_consulta2['tiempo_sk']);
	echo "<br>";
}

*/
require_once("../conexion/conexionyarumos.php");
$FACT = "SELECT fecha_sk,tiempo_sk from fact_table where estacion_sk = 21 group by fecha_sk,tiempo_sk order by (fecha_sk,tiempo_sk) desc";
$e_FACT = pg_query($FACT);
$r = pg_num_rows($e_FACT);
echo($r);
echo "<br>";
while ($f_FACT = pg_fetch_array($e_FACT)){
echo($f_FACT['fecha_sk']." :: ".$f_FACT['tiempo_sk']);
echo "<br>";
} 
echo "<br>";/*
$FACT2 = "SELECT count (estacion_sk) as cantidad from fact_table";
$e_FACT2 = pg_query($FACT2);
while ($f_FACT2 = pg_fetch_array($e_FACT2)){
echo($f_FACT2['cantidad']);
}
/*
$recuperacionFecha = "SELECT fecha,hora from est_marquetalia where fecha >= '$fecha_actual' and hora > '$hora_actual' order by fecha,hora limit 7000"; #!! Se toman las primeras 100 fechas en motivo de prueba
$e_recuperacionF = mysqli_query($dbr,$recuperacionFecha);
$n_recuperacionF = mysqli_num_rows($e_recuperacionF); #Número de fechas resultantes

function conectarse($usuario,$password,$bd)
{
	$servidor="172.23.177.60";

	$conectar = new mysqli($servidor,$usuario,$password,$bd) or die("No se pudo conectar al servidor de base de datos Mysql");
	return $conectar;
}*/
?>