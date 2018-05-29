<?php
require_once("conexiondwh.php");

$consulto = "SELECT * from usuario where nombre_usuario = 'afarroyavet' and contrasenia = '12345' and id_rol_usu = '1'";// verifica si existe un usuario con el user y el password ingresado y que sea de tipo 1
$e_consulto = pg_query($consulto);
$r_consulto = pg_num_rows($e_consulto);
$f_consulto = pg_fetch_array($e_consulto);

if ($r_consulto > 0){
	echo("si hay");
}
/*
$columna = "precipitacion";

$elimino = "SELECT estacion_sk,fecha_sk,count($columna) as cantidad from central where $columna != '-' and $columna != '' or $columna is null GROUP BY  estacion_sk,fecha_sk";
$e_elimio = pg_query($elimino);

while ($f_c = pg_fetch_array($e_elimio)) {
    

	echo($f_c['estacion_sk']);
   	echo "&nbsp;";
    echo($f_c['fecha_sk']);
    echo "&nbsp;";
   	echo($f_c['cantidad']);
    echo "<br>";


}*/
?>