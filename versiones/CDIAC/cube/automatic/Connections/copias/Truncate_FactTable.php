<?php
require_once("../../../conexion/conexiondwh.php");


$borrof = "DELETE from fact_table";
$e_f = pg_query($borrof);

$borrof = "DELETE from fact_aire";
$e_f = pg_query($borrof);

$borroc = "DELETE from confiabilidad";
$e_c = pg_query($borroc);

$borroo = "DELETE from observaciones";
$e_o = pg_query($borroo);

$borroh = "DELETE from historial_correccion";
$e_h = pg_query($borroh);

$borroce = "DELETE from central";
$e_ce = pg_query($borroce);

$borroce = "DELETE from centralaire";
$e_ce = pg_query($borroce);


?>
