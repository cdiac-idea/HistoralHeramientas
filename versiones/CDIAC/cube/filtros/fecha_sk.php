<?php

require_once("../conexion/conexiondwh.php");


function obtener_fecha_sk($fecha){
$anio = substr($fecha, 0, -6);  // devuelve "el dia"
$mes = substr($fecha, 5, -3);  // devuelve "el mes"
$dia = substr($fecha, 8);  // devuelve "el anio"


$diaEntero = (double)$dia; // se convierte el dia en formato numérico
$mesEntero = (double)$mes; // se convierte el mes en formato numérico
$anioEntero = (double)$anio; // se convierte el año en formato numérico

$consulta2 = "SELECT fecha_sk from date_dim where año = $anioEntero and mes = $mesEntero and dia=$diaEntero"; // se consulta el codigo de la fecha pasada por parametro, despues de haber recuperado día, mes y año
$e_consulta2 = pg_query($consulta2);
$r_consulta2 = pg_fetch_array($e_consulta2);
$cantidad = pg_num_rows($e_consulta2);
$fecha_sk = $r_consulta2["fecha_sk"];

return $fecha_sk; // se retorna el id de la fecha
}


function obtener_fecha_sk_arch($fecha){ // se recibe una fecha por parametro

$dia = substr($fecha, 0, -8);  // devuelve "el dia"
$mes = substr($fecha, 3, -5);  // devuelve "el mes"
$anio = substr($fecha, 6);  // devuelve "el anio"

$diaEntero = (double)$dia; // se convierte el dia en formato numérico
$mesEntero = (double)$mes; // se convierte el mes en formato numérico
$anioEntero = (double)$anio; // se convierte el año en formato numérico
//echo($anioEntero);
$consulta2 = "SELECT fecha_sk from date_dim where año = $anioEntero and mes = $mesEntero and dia=$diaEntero"; // se consulta el codigo de la fecha pasada por parametro, despues de haber recuperado día, mes y año
$e_consulta2 = pg_query($consulta2);
$r_consulta2 = pg_fetch_array($e_consulta2);
$fecha_sk = $r_consulta2["fecha_sk"];

return $fecha_sk; // se retorna el id de la fecha
}

function obtener_fecha_sk_aire($fecha){ // se recibe una fecha por parametro
//echo var_dump($fecha);
//secho("<br>");
$mes = substr($fecha, 0, -6);  // devuelve "el mes"
$dia = substr($fecha, 3,-3);  // devuelve "el dia"
$anio = substr($fecha, 6);  // devuelve "el anio"


$tamanoanio = strlen($anio);

if ($tamanoanio == 2){
	$restante = substr($fecha, 6);
	$anio = "20".$restante;
	$cadena = $dia."/".$mes."/".$anio;


}
elseif($tamanoanio == 4){
	$mes = substr($fecha, 0, -8);  // devuelve "el mes"
	$dia = substr($fecha, 3,-5);  // devuelve "el dia"
	$anio = substr($fecha, 6);  // devuelve "el anio"
	
	$cadena = $dia."/".$mes."/".$anio;
	
}

$diaEntero = (double)$dia; // se convierte el dia en formato numérico
$mesEntero = (double)$mes; // se convierte el mes en formato numérico
$anioEntero = (double)$anio; // se convierte el año en formato numérico

//echo($anioEntero);
$consulta2 = "SELECT fecha_sk from date_dim where año = $anioEntero and mes = $mesEntero and dia=$diaEntero"; // se consulta el codigo de la fecha pasada por parametro, despues de haber recuperado día, mes y año
$e_consulta2 = pg_query($consulta2);
$r_consulta2 = pg_fetch_array($e_consulta2);
$fecha_sk = $r_consulta2["fecha_sk"];


 if($fecha_sk != 0 or $fecha_sk != null){
 	//echo "esta dentor";
$actualizo = "UPDATE centralaire set fecha = '$cadena' where fecha = '$fecha'";
	$e_actualizo = pg_query($actualizo);

	$actualizarfecha = "UPDATE centralaire SET fecha_sk = '$fecha_sk' where fecha = '$cadena'"; # se actualiza el campo de fecha_sk de la tabla central
$e_fecha_pos = pg_query($actualizarfecha);
}

return $fecha_sk; // se retorna el id de la fecha


}

    ?>