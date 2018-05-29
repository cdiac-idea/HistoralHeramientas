<?php
/* En los encabezados indicamos que se trata de un archivo csv
  y en el nombre de archivo le ponemos la extensión csv.            */
header('Content-type: text/csv');
header('Content-Disposition: inline; filename=reporte.csv');


function generarReporte($arrayDatos, $separador, $cabeza, $cabezaAnio, $cabezaMes, 
	$cabezaDia, $nombreEstacion, $origen, $arrayAnio, $arrayMes, $arrayDia, $saltoLinea, 
	$arrayPromRang, $nombrePromRang, $anioMenor, $anioMayor){

	$str = "";
	if ($origen == "consulta" || $origen == "indicadorAire") {
		if ($cabeza != null) {
			$str = $str.$cabeza.$saltoLinea;
		}
		foreach($arrayDatos as $row){
			if ($nombreEstacion != null) {
				$str .= $nombreEstacion.$separador;
			}
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
		$str = rtrim($str, $saltoLinea);
		//return $str
	}elseif ($origen == "indicador") {
		if ($nombrePromRang != null) {
			$str = $str.$nombrePromRang.$saltoLinea;
			#foreach($arrayPromRang as $row){
				if ($nombreEstacion != null) {
					$str .= $nombreEstacion.$separador;
					$str .= $anioMenor." - ".$anioMayor.$separador;
				}
				$tam=count($arrayPromRang);
				#foreach($row as $key => $value){
				for ($i=0; $i < $tam; $i++) { 
					$str .= $arrayPromRang[$i];
					$str .= $separador;
				}
				//Elimina la última coma que sobra
				$str = rtrim($str, $separador);
				//Agrega el salto de línea de la fila
				$str .= $saltoLinea;
			#}
			//Elimina el último salto de linea que sobra
			//$str = rtrim($str, $saltoLinea);
		}

		if ($cabezaAnio != null) {
			$str = $str.$cabezaAnio.$saltoLinea;
			foreach($arrayAnio as $row){
				if ($nombreEstacion != null) {
					$str .= $nombreEstacion.$separador;
				}
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
			//$str = rtrim($str, $saltoLinea);
		}

		if ($cabezaMes != null) {
			$str = $str.$cabezaMes.$saltoLinea;
			foreach($arrayMes as $row){
				if ($nombreEstacion != null) {
					$str .= $nombreEstacion.$separador;
				}
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
			//$str = rtrim($str, $saltoLinea);
		}

		if ($cabezaDia != null) {
			$str = $str.$cabezaDia.$saltoLinea;
			foreach($arrayDia as $row){
				if ($nombreEstacion != null) {
					$str .= $nombreEstacion.$separador;
				}
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
			//$str = rtrim($str, $saltoLinea);
		}
	}/*elseif ($origen == "indicadorAire") {
		if ($) {
			# code...
		}
	}*/
	return $str;

} 

if($_POST){
	$string_array = array_key_exists('datos', $_POST) ? $_POST["datos"] : null;
	$cabeza = array_key_exists('titulos', $_POST) ? $_POST["titulos"] : null;
	$string_array_anio = array_key_exists('anio', $_POST) ? $_POST["anio"] : null;
	$cabezaAnio = array_key_exists('titulosAnio', $_POST) ? $_POST["titulosAnio"] : null;
	$string_array_mes = array_key_exists('mes', $_POST) ? $_POST["mes"] : null;
	$cabezaMes = array_key_exists('titulosMes', $_POST) ? $_POST["titulosMes"] : null;
	$string_array_dia = array_key_exists('dia', $_POST) ? $_POST["dia"] : null;
	$cabezaDia = array_key_exists('titulosDia', $_POST) ? $_POST["titulosDia"] : null;
	$origen = array_key_exists('origen', $_POST) ? $_POST["origen"] : null; 
	$nombreEstacion = array_key_exists('nombEsta', $_POST) ? $_POST["nombEsta"] : null;
	$promRang = array_key_exists('promRango', $_POST) ? $_POST["promRango"] : null; 
	$nombrePromRang = array_key_exists('titProm', $_POST) ? $_POST["titProm"] : null;
	$anioMenor = array_key_exists('anioMenor', $_POST) ? $_POST["anioMenor"] : null; 
	$anioMayor = array_key_exists('anioMayor', $_POST) ? $_POST["anioMayor"] : null;

	//volver a convertir el string json en el array
	$tmp = stripslashes($string_array); 
    $tmp = urldecode($tmp); 
    $arrayDatos = unserialize($tmp); 

    $tmp = stripslashes($promRang); 
    $tmp = urldecode($tmp); 
    $arrayPromRang = unserialize($tmp); 

	$tmp = stripslashes($string_array_anio); 
    $tmp = urldecode($tmp); 
    $arrayAnio = unserialize($tmp); 
    
    $tmp = stripslashes($string_array_mes); 
    $tmp = urldecode($tmp); 
    $arrayMes = unserialize($tmp); 
    
    $tmp = stripslashes($string_array_dia); 
    $tmp = urldecode($tmp); 
    $arrayDia = unserialize($tmp); 
    
    #echo var_dump($arrayDatos);
    echo generarReporte($arrayDatos, ";", $cabeza, $cabezaAnio, $cabezaMes, 
    	$cabezaDia, $nombreEstacion, $origen, $arrayAnio, $arrayMes, $arrayDia, 
    	"\n", $arrayPromRang, $nombrePromRang, $anioMenor, $anioMayor);
}

?>