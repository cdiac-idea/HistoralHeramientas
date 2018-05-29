<?php
require_once("../conexion/conexiondwh.php"); // se incluye la conexión con el servidor


function obtener_tiempo_sk($tiempo){ // se recibe una hora por parametro

$longitud = strlen($tiempo);
//echo($longitud);
//echo "<br>";

if ($longitud == 8){
$hora = substr($tiempo, 0, -6);  // devuelve "la hora"
$minuto = substr($tiempo, 3, -3);  // devuelve "el minuto"
$segundo = substr($tiempo, 6);  // devuelve "el segundo"

 
$horaEntero = (double)$hora; // se convierte la hora en formato numérico
$minutoEntero = (double)$minuto; // se convierte el minuto en formato numérico
$segundoEntero = (double)$segundo; // se convierte el segundo en formato numérico

$consulta2 = "SELECT tiempo_sk from time_dim where horas = $horaEntero and minutos = $minutoEntero and segundos =$segundoEntero"; // se consulta el codigo de la hora pasada por parametro, despues de haber recuperado hora, minuto y segundo
$e_consulta2 = pg_query($consulta2);
$r_consulta2 = pg_fetch_array($e_consulta2);
$tiempo_sk = $r_consulta2["tiempo_sk"];

return $tiempo_sk; // se retorna el id de la hora

}
elseif($longitud == 5){

$hora = substr($tiempo, 0, -3);  // devuelve "la hora"
$minuto = substr($tiempo, 3);  // devuelve "el minuto"
$segundo = '00';

$horaEntero = (double)$hora; // se convierte la hora en formato numérico
$minutoEntero = (double)$minuto; // se convierte el minuto en formato numérico
$segundoEntero = (double)$segundo; // se convierte el segundo en formato numérico

$consulta2 = "SELECT tiempo_sk from time_dim where horas = $horaEntero and minutos = $minutoEntero and segundos =$segundoEntero"; // se consulta el codigo de la hora pasada por parametro, despues de haber recuperado hora, minuto y segundo
$e_consulta2 = pg_query($consulta2);
$r_consulta2 = pg_fetch_array($e_consulta2);
$tiempo_sk = $r_consulta2["tiempo_sk"];

return $tiempo_sk; // se retorna el id de la hora

}
elseif($longitud == 2 || $longitud == 1){

$hora = $tiempo;  // devuelve "la hora"
$minuto = '00';  // devuelve "el minuto"
$segundo = '00';

$horaEntero = (double)$hora; // se convierte la hora en formato numérico
$minutoEntero = (double)$minuto; // se convierte el minuto en formato numérico
$segundoEntero = (double)$segundo; // se convierte el segundo en formato numérico

$consulta2 = "SELECT tiempo_sk from time_dim where horas = $horaEntero and minutos = $minutoEntero and segundos =$segundoEntero"; // se consulta el codigo de la hora pasada por parametro, despues de haber recuperado hora, minuto y segundo
$e_consulta2 = pg_query($consulta2);
$r_consulta2 = pg_fetch_array($e_consulta2);
$tiempo_sk = $r_consulta2["tiempo_sk"];

return $tiempo_sk; // se retorna el id de la hora

}
}

// la función cambia a militar convierte las horas a formato militar de 24:00 h
function cambiarAMilitar($cadena){ // recibe una hora en formato normal

if (strpos($cadena, 'p')) { // detecta si existe en la cadena de la hora una p que indique pm
	$cadena = str_replace(" p,m,", "pm", $cadena); // si viene p,m, se reemplaza por pm
} else if(strpos($cadena, 'a')){ // detecta si existe en la cadena de la hora una a que indique am
			$cadena = str_replace(" a,m,", "am", $cadena); // si viene a,m, se reemplaza por am
	}
// convierte a militar
$cadena = strtotime($cadena);
$cadena = date("H:i:s", $cadena);

return $cadena; //se retorna la hora en formato militar

}

    ?>