<?php
require_once("../../../conexion/conexiondwh.php");
/*$central = "SELECT * from central order by registro";
$pgq = pg_query($central);

while ($f = pg_fetch_array($pgq)) {
	
	//echo($f['fecha']);
	//echo "<br>";
	//echo($f['hora']);
	//echo "<br>";
	echo($f['observaciones']);
	echo "<br>";

}*/
///$a = "UPDATE tablas set hora_actual = '10:06:59' where estacion = 'Hospital de Villamaría'";
//$e_a = pg_query($a);
//$central1 = "UPDATE variable set nombre='caudal' where nombre='Caudal'";
//$pgq1 = pg_query($central1);

//$insert = "INSERT INTO tablasxvariable (id_tabla,id_variable) values (4,167)";
//$e = pg_query($insert);

//$central = "select id_variable from tablasxvariable where id_tabla='4'";


//$borro = "DELETE from observaciones";
//$e_b = pg_query($borro);

$central = "SELECT * from central order by fecha_sk, tiempo_sk";
$pgq = pg_query($central);
if($pgq){
	echo "se logro";
}
else{
	echo "nose logro";
}
echo "probando...<br>";


while ($f = pg_fetch_array($pgq)) {
	

	echo "<br>";
	echo($f['tiempo_sk']);
	//echo "<br>";
	//echo($f['hora']);
	//echo "<br>";
	//echo "caudal";
	//echo($f['estacion_sk']);
	echo "<br>";
	//echo "nivel";
	echo($f['velocidad_viento']);
# ATENCIÓN NO SUBE nivel ni caudal, al subirse a la bodega unos datos no aparecen

}


/*$u = "UPDATE tablas set dato_actual = '2012-05-08',hora_actual = '10:06:59' where nombre_tabla = 'est_hospivilla'";
$pg = pg_query($u);

$se = "SELECT dato_actual from tablas where nombre_tabla = 'est_hospivilla'";
$e = pg_query($se);
$t = $f = pg_fetch_array($e);
//echo($t['dato_actual']);

//$preci = "UPDATE variable set nombre = 'precipitacion_real' where nombre = 'precipitacion'";
//$pgp = pg_query($preci);
*/


// Hora -> SI
// Fecha -> SI
// Precipitacion -> Si
// Temperatura -> Si
// humedad_relativa
// velocidad_viento
// direccion_viento
// presion_barometrica
// evapotranspiracion_real
// radiacion_solar
?>
