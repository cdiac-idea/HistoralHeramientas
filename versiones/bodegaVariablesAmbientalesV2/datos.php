<?php


require_once("configuracion/clsBD.php");
$objDatos = new clsDatos();



echo var_dump($objDatos->executeQuery("SELECT SUM(ppt) FROM indicador WHERE estacion=23 AND anio=2002 AND mes=6 AND dia>=1 and dia<=1"));
echo "<br><br><br><br>";

$sql = "SELECT anio, mes, dia, ppt FROM indicador WHERE estacion=23 AND anio=2002 and mes= 1 and dia>=1 and dia<=25 ORDER BY 1,2,3";# AND mes=12 AND dia>=6 AND dia<=31";

$listo = $objDatos->executeQuery($sql);
echo var_dump($listo);

echo "<center><table border = 1 ><tr class = 'cabecera'><td>anio</td><td>mes</td><td>dia</td><td>ac_25</td></tr>";

foreach ($listo as $value) {
	echo "<tr>";
	foreach ($value as $field) {
		echo "<td>$field</td>";
	}
	echo "</tr>";
}
echo "</table></center><br><br>";


echo var_dump($objDatos->executeQuery("SELECT sum(ppt) 
	from indicador 
	WHERE estacion=23 AND anio=2002 and mes= 1 and dia>=1 and dia<=25"));


?>