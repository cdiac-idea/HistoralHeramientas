<?php

require_once("../configuracion/clsBD.php");
$objDatos = new clsDatos();

/*
$sql="SELECT s.estacion_sk as id, s.estacion as nombre, COUNT(f.estacion_sk) as cant, red, tipologia, municipio, ubicacion, 
latitud, longitud, altitud, propietario, inicio_funcionamiento, fin_funcionamiento, observacion, cuenca, subcuenca 
FROM fact_table f, station_dim s 
WHERE f.estacion_sk=s.estacion_sk
 GROUP BY 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 
 ORDER BY municipio, tipologia";
$datos=$objDatos->executeQuery($sql);

echo var_dump($datos);

*/

/*
$sql = "SELECT s.estacion as nombre, count(f.estacion_sk) as cantidad, min(d.fecha) as minimo, max(d.fecha) as maximo
from fact_table f, date_dim d, station_dim s
where f.estacion_sk=s.estacion_sk and f.fecha_sk=d.fecha_sk and s.visible=true
group by 1";
$datos=$objDatos->executeQuery($sql);

echo "<table border=1>";

if ($datos) {
	echo "<tr><td>id</td><td>nombre</td><td>cantidad</td><td>fecha minima</td><td>fecha maxima</td></tr>";
	foreach ($datos as $value) {
		echo "<tr><td>".$value['nombre']."</td><td>".$value['cantidad']."</td><td>".$value['minimo']."</td><td>".$value['maximo']."</td></tr>";
	}
}
echo "</table>";
*/

$sql = "UPDATE station_dim SET visible=true WHERE tipologia='Calidad del aire'";
$objDatos->operacionesCrud($sql);

$sql = "SELECT s.estacion as nombre, count(f.estacion_sk) as cantidad, min(d.fecha) as minimo, max(d.fecha) as maximo
from fact_aire f, date_dim d, station_dim s
where f.estacion_sk=s.estacion_sk and f.fecha_sk=d.fecha_sk and s.visible=true
group by 1";
$datos=$objDatos->executeQuery($sql);

echo "<table border=1>";

if ($datos) {
	echo "<tr><td>id</td><td>nombre</td><td>cantidad</td><td>fecha minima</td><td>fecha maxima</td></tr>";
	foreach ($datos as $value) {
		echo "<tr><td>".$value['nombre']."</td><td>".$value['cantidad']."</td><td>".$value['minimo']."</td><td>".$value['maximo']."</td></tr>";
	}
}
echo "</table>";

?>