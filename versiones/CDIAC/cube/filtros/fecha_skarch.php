<?php

require_once("../conexion/conexiondwh.php"); // se incluye la conexión con el servidor local


function obtener_fecha_sk($fecha){ // se recibe una fecha por parametro

$dia = substr($fecha, 8);  // devuelve "el dia"
$mes = substr($fecha, 5, -3);  // devuelve "el mes"
$anio = substr($fecha, 0, -6);  // devuelve "el anio"

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

function obtener_fecha_skarch($fecha){ // se recibe una fecha por parametro

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
01/01/2012
    ?>