<?php
/*
/* En los encabezados indicamos que se trata de un archivo csv
  y en el nombre de archivo le ponemos la extensión csv.  */          
  $pg_servidor = @pg_connect (" user = postgres password=administrador port=5432 dbname= datawarehouse_idea host=localhost");
header('Content-type: text/csv');
header('Content-Disposition: inline; filename=reporte.csv');

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
$consulta="SELECT * from correcciones ";
$datos=pg_query($consulta);
$array = array();
//puede enviar parámetros por GET para usarlos en el where de la consulta SQL
//$array[0] = array("id" => $_GET["id"], "nombre" => "juan", "apellido" => "perez");

//$array[0] = array("fecha" => "fecha", "hora" => "horas", "estacion_sk" => 'estacion_s', "pos" => 'posicion', "var" => 'variable', "error" => 'valor_error', "observacion" => 'observacion_error', "valor_cor" => 'valor_corregido', "tipo_correccion_apli" => 'tipo_correccion_aplicado');
//$array[1] = array("nombre" => "Angela", "apellido" => "perez");
//$array[0] = array("fecha" => "fecha", "hora" => "horas", "estacion_sk" => 'estacion_s', "pos" => 'posicion', "var" => 'variable', "error" => 'valor_error', "observacion" => 'observacion_error', "valor_cor" => 'valor_corregido', "tipo_correccion_apli" => 'tipo_correccion_aplicado');
//echo generarReporte($array, ";");
$i=0;
while($reg = pg_fetch_array($datos) ) {
  
  $array[$i] = array("fecha" => $reg['fecha'], "hora" => $reg['hora'], "estacion_sk" => $reg['estacion_sk'], "posicion" => $reg['posicion'], "variable" => $reg['variable'], "valor_error" => $reg['valor_error'], "observacion_error" => $reg['observacion_error'], "valor_corregido" => $reg['valor_corregido'], "tipo_correccion_aplicado" => $reg['tipo_correccion_aplicado']);

  $i++;
}
echo generarReporte($array, ";");


/* En los encabezados indicamos que se trata de un archivo csv
  y en el nombre de archivo le ponemos la extensi?n csv.            
header('Content-type: text/csv');
header('Content-Disposition: inline; filename=reporte.csv');

function generarReporte($array, $separador){

	$saltoLinea = "\n";
	$str = "";

	foreach($array as $row){
		
		foreach($row as $key => $value){
			$str .= $value;
			$str .= $separador;
		}
		//Elimina la ?ltima coma que sobra
		$str = rtrim($str, $separador);
		//Agrega el salto de l?nea de la fila
		$str .= $saltoLinea;
	}
	//Elimina el ?ltimo salto de linea que sobra
	return rtrim($str, $saltoLinea);

} 
//Aca consulta los datos en la BD, este array es de ejemplo, 
//puede enviar par?metros por GET para usarlos en el where de la consulta SQL
$array = array();
$array[0] = array("fecha" => "fecha", "hora" => "hora");
$array[1] = array("nombre" => "Angela", "apellido" => "perez");

echo generarReporte($array, ";");*/
?>