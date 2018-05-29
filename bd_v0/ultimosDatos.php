<?php

require_once("../configuracion/clsBD.php");
$objDatos = new clsDatos();

/*$sql = "SELECT s.estacion_sk AS id, s.estacion AS nombre, a.nombre_tabla AS tabla, count(f.estacion_sk) AS cantidad, max(d.fecha) AS fecha, max(t.tiempo) AS tiempo 
		FROM fact_table f, station_dim s, date_dim d, time_dim t, tablas a 
		WHERE f.estacion_sk=s.estacion_sk AND f.fecha_sk=d.fecha_sk AND f.tiempo_sk=t.tiempo_sk AND a.id_tabla=f.estacion_sk
		GROUP BY 1, 2, 3  
		ORDER BY 1";*/

$sql = "SELECT * FROM station_dim ORDER BY estacion_sk";
$datos=$objDatos->executeQuery($sql);

#echo var_dump($datos);
echo "<table border=1>";

#echo var_dump($datos);

if ($datos) {
	#echo "<tr><td>id</td><td>nombre</td><td>fecha</td><td>tiempo</td></tr>";
	$cadena = "<tr><td>id</td><td>nombre</td><td>red</td><td>tipologia</td><td>municipio</td><td>ubiacion</td><td>latitud</td><td>longitud</td><td>altitud</td><td>pripietario</td><td>inicio_funcionamiento</td><td>fin_funcionamiento</td><td>observacion</td><td>cuenca</td><td>subcuenca</td><td>visible</td></tr>";
	foreach ($datos as $value) {
		echo "<tr><td>".$value['estacion_sk']."</td><td>".$value['estacion']."</td><td>".$value['red']."</td><td>".$value['tipologia']."</td><td>".$value['municipio']."</td><td>".$value['ubicacion']."</td><td>".$value['latitud']."</td><td>".$value['longitud']."</td><td>".$value['propietario']."</td><td>".$value['inicio_funcionamiento']."</td><td>".$value['fin_funcionamiento']."</td><td>".$value['observacion']."</td><td>".$value['cuenca']."</td><td>".$value['subcuenca']."</td><td>".$value['visible']."</td></tr>";
		#$cadena .= $value['id'].";".$value['nombre'].";".$value['tabla'].";".$value['cantidad'].";".$value['fecha'].";".$value['tiempo'].";;";
	}
}

/*
if ($datos) {
	#echo "<tr><td>id</td><td>nombre</td><td>fecha</td><td>tiempo</td></tr>";
	$cadena = "id;nombre;nombre tabla;cantidad registros actual;fecha;tiempo;;";
	foreach ($datos as $value) {
		#echo "<tr><td>".$value['id']."</td><td>".$value['nombre']."</td><td>".$value['fecha']."</td><td>".$value['tiempo']."</td></tr>";
		$cadena .= $value['id'].";".$value['nombre'].";".$value['tabla'].";".$value['cantidad'].";".$value['fecha'].";".$value['tiempo'].";;";
	}
}*/
echo "</table>";
#echo $cadena;
?>