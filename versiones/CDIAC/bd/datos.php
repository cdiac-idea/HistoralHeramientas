<?php


require_once("../configuracion/clsBD.php");
$objDatos = new clsDatos();

$sql = "SELECT  max_vv, med_vv, n_dia_nocturno, nno_dia_nocturno, no_dia_nocturno, ono_dia_nocturno, 
						o_dia_nocturno, oso_dia_nocturno, so_dia_nocturno, sso_dia_nocturno, 
						s_dia_nocturno, sse_dia_nocturno, se_dia_nocturno, ese_dia_nocturno, 
						e_dia_nocturno, ene_dia_nocturno, ne_dia_nocturno, nne_dia_nocturno
						from indicador
						where estacion=29 and anio=2004 and mes=10 and dia=0";

$listo = $objDatos->executeQuery($sql);

echo var_dump($listo);




?>