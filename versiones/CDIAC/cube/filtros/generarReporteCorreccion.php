<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
#Conexion con la base de datos y el Servidor
if ($pg_servidor = @pg_connect (" user = postgres password=%froac$ port=5432 dbname= idea_dwh_db_pruebascube host=froac.manizales.unal.edu.co")){
/*
$exporto = "COPY central delimiters ';' WITH CSV HEADER;";
	$ejecuto = pg_query($exporto);
*/
/* En los encabezados indicamos que se trata de un archivo csv
  y en el nombre de archivo le ponemos la extensión csv.            */

$esta = $_SESSION["estacion"];
header('Content-type: text/csv');
header('Content-Disposition: inline; filename=reporteCorreccion'.$esta.'.csv');
dePuntoAComa();
function generarReporte($array, $separador){

	$saltoLinea = "\n";
	$str = "";

	foreach($array as $row){
		
		foreach($row as $key => $value){
			$str .= $value;
			$str .= $separador;
		}
		//Elimina la última coma que sobra
		$str = rtrim($str, $separador);
		//Agrega el salto de línea de la fila
		$str .= $saltoLinea;
	}
	//Elimina el último salto de linea que sobra
	return rtrim($str, $saltoLinea);

} 
//Aca consulta los datos en la BD, este array es de ejemplo, 
$consulta="SELECT * from central order by registro";
$datos=pg_query($consulta);
$array = array();
//puede enviar parámetros por GET para usarlos en el where de la consulta SQL


  $array[0] = array("fecha" => "fecha", "hora" => "hora", "estacion_sk" => "estacion_sk", "fecha_sk" => "fecha_sk", "tiempo_sk" => "tiempo_sk", "precipitacion" => "precipitacion", "temperatura" => "temperatura", "temperatura_max" => "temperatura_max", "temperatura_min" => "temperatura_min", "temperatura_med" => "temperatura_med", "brillo" => "brillo", "humedad_relativa" => "humedad_relativa", "nivel" => "nivel", "caudal" => "caudal", "velocidad_viento" => "velocidad_viento", "direccion_viento" => "direccion_viento", "presion_barometrica" => "presion_barometrica", "evapotranspiracion" => "evapotranspiracion", "radiacion_solar" => "radiacion_solar", "observaciones" => "observaciones");
 
  $i++;

$i=1;
while($reg = pg_fetch_array($datos) ) {

  $array[$i] = array("fecha" => $reg['fecha'], "hora" => $reg['hora'], "estacion_sk" => $reg['estacion_sk'], "fecha_sk" => $reg['fecha_sk'], "tiempo_sk" => $reg['tiempo_sk'], "precipitacion" => $reg['precipitacion'], "temperatura" => $reg['temperatura'], "temperatura_max" => $reg['temperatura_max'], "temperatura_min" => $reg['temperatura_min'], "temperatura_med" => $reg['temperatura_med'], "brillo" => $reg['brillo'], "humedad_relativa" => $reg['humedad_relativa'], "nivel" => $reg['nivel'], "caudal" => $reg['caudal'], "velocidad_viento" => $reg['velocidad_viento'], "direccion_viento" => $reg['direccion_viento'], "presion_barometrica" => $reg['presion_barometrica'], "evapotranspiracion" => $reg['evapotranspiracion'], "radiacion_solar" => $reg['radiacion_solar'], "observaciones" => $reg['observaciones']);
 
  $i++;
}

echo generarReporte($array, ";");
}
else 
{
  header("Location: ../index.php/mensaje_error_conexion");
}

function dePuntoAComa(){
  
  $columnas = "select column_name
from information_schema.columns
where table_name = 'central'";
$e_columnas = pg_query($columnas);



while($f_columns = pg_fetch_array($e_columnas)){
  
  $reemplazo = "UPDATE central set $f_columns[column_name] = replace($f_columns[column_name], '.', ',')"; # se cambian comas por puntos para que en la tabla central se puedan ejecutar las operaciones sin problemas
  $r_reemplazo = @pg_query($reemplazo);
}
}
?>