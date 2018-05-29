<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
#Conexion con la base de datos y el Servidor
if ($pg_servidor = @pg_connect (" user = postgres password=%froac$ port=5432 dbname= idea_dwh_db_pruebascube host=froac.manizales.unal.edu.co")){

/* En los encabezados indicamos que se trata de un archivo csv
  y en el nombre de archivo le ponemos la extensión csv.            */
 $esta = $_SESSION["estacion"];
header('Content-type: text/csv');
header('Content-Disposition: inline; filename=reporteErrores'.$esta.'.csv');

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
$consulta="SELECT * from correcciones order by id_correccion";
$datos=pg_query($consulta);
$array = array();
//puede enviar parámetros por GET para usarlos en el where de la consulta SQL
$i=0;
while($reg = pg_fetch_array($datos) ) {
  
  $array[$i] = array("fecha" => $reg['fecha'], "hora" => $reg['hora'], "estacion" => utf8_decode($reg['estacion']), "posicion" => $reg['posicion'], "variable" => $reg['variable'], "valor_error" => $reg['valor_error'], "observacion_error" => $reg['observacion_error'], "valor_corregido" => $reg['valor_corregido'], "tipo_correccion_aplicado" => $reg['tipo_correccion_aplicado']);
 
  $i++;
}

echo generarReporte($array, ";");
}
else 
{
  header("Location: ../index.php/mensaje_error_conexion");
}
?>