<?php
require_once("conexiondwh.php");

echo ":::::: TABLA VARIABLES :::::::::";
echo "<br>";
echo "est_manzanares";
echo("<br>");
echo("<br>");
$consulto = "SELECT distinct (variables) from variables where estacion_sk = 17";
$e_consulto = pg_query($consulto); 

while($f_consulto = pg_fetch_array($e_consulto)){
	echo($f_consulto['variables']);
	echo "<br>";
}


?>