<?php

require_once("../conexion/conexiondwh.php");

$act = "SELECT * from users";
$e_act = pg_query($act);
while ($f_act = pg_fetch_array($e_act)) {
	echo($f_act['usuario']);
}
?>