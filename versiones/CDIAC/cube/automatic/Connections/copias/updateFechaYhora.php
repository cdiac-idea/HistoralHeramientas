<?php

require_once("conexiondwh.php");
//$up = "INSERT into tablas (id_tabla,estacion,nombre_tabla,dato_actual,id_basedatos,hora_actual) values (76,'liceo',)";
//$e_up = pg_query($up);

$up = "UPDATE tablas set dato_actual = '2015-07-31', hora_actual = '01:05:37' where id_tabla = 21";
$e_up = pg_query($up);

//2013-10-21  10:15:16
$columns = "SELECT * from tablas where id_tabla = 21";

$e_columns = pg_query($columns);

while($f_columns = pg_fetch_array($e_columns)){  
	echo($f_columns['dato_actual']);
	echo "<br>";
	echo($f_columns['hora_actual']);
	echo "<br>";
}

/*$columns = "SELECT * from usuario where nombre_usuario = 'afarroyavet' and contrasenia = '12345' and id_rol_usu = '1'";

$e_columns = pg_query($columns);

while($f_columns = pg_fetch_array($e_columns)){
	echo($f_columns['id_rol_usu']);
	echo "<br>";
}



/*$c = "SELECT * from central limit 1";
$e_c = pg_query($c);
while($f = pg_fetch_array($e_c)){
	echo ($f['precipitacion_real']);
}*/
?>
