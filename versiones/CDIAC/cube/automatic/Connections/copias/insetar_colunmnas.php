<?php

require_once("conexiondwh.php");

/*
$columns = "ALTER TABLE tablas ADD  column activa integer";

$e_columns = pg_query($columns);

$columns = "ALTER TABLE tablas ADD  column filtrada integer";

$e_columns = pg_query($columns);
*/

 $actualizoAcero = "UPDATE tablas set filtrada = 1 where id_tabla = 1 ";
 pg_query($actualizoAcero);

/*$c = "SELECT * from central limit 1";
$e_c = pg_query($c);
while($f = pg_fetch_array($e_c)){
  echo ($f['precipitacion_real']);
}*/
?>