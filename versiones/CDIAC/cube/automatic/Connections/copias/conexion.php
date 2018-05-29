<?php
function conectarse()
{
	$servidor="172.23.177.60"; 
	$usuario="redmanweb";
	$password="consultamanizales";
	$bd="redmanizales"; 

	$conectar = new mysqli($servidor,$usuario,$password,$bd) or die("No se pudo conectar al servidor de base de datos Mysql");
	return $conectar;
	
}

$dbr = conectarse();

$cons = "SHOW COLUMNS from est_chec";
$ejecuto = mysqli_query($dbr,$cons);
echo "est_chec";
echo("<br>");
echo("<br>");

if(mysqli_num_rows($ejecuto)>0){
	while($fila = mysqli_fetch_assoc($ejecuto)){

		/*$datos = "SELECT count($fila[Field]) as cantidad from est_hospivilla where $fila[Field] != ' '";
		$e_datos = mysqli_query($dbr,$datos);
		$f_datos = mysqli_fetch_assoc($e_datos);*/


		$field=$fila['Field'];
		print_r($field);
		echo "<br>";

		$datos = "SELECT $fila[Field] from est_chec where $fila[Field] != '-' limit 10";
		$e_datos = mysqli_query($dbr,$datos);
		$f_datos = mysqli_fetch_assoc($e_datos);
		$campo = $fila['Field'];
		while($f_datos = mysqli_fetch_assoc($e_datos)){

			echo var_dump($f_datos[$campo]);
			echo "<br>";
		}


	}
}



/*
$algo = "SELECT * from est_santodomingo where fecha = '2013-10-21' and hora = '14:37:53'";
		$e_algo = mysqli_query($dbr,$algo);
		while ($f_algo = mysqli_fetch_array($e_algo)) {
	echo($f_algo['evapo_real']."  >  evapotranspiracion");
	echo "<br>";
	echo($f_algo['radiacion']."  >  radiacion");
	echo "<br>";
	echo($f_algo['precipitacion_real']."  >  precipitacion");
	echo "<br>";
	echo($f_algo['humedad']."  >  humedad");
	echo "<br>";
	echo($f_algo['presion']."  >  presion");
	echo "<br>";
	echo($f_algo['caudal']."  >  caudal");
	echo "<br>";
	echo($f_algo['direccion']."  >  direccion");
	echo "<br>";
	echo($f_algo['velocidad']."  >  velocidad");
	echo "<br>";
	echo($f_algo['temperatura']."  >  temperatura");
	echo "<br>";
	echo($f_algo['nivel']."  >  nivel");
	echo "<br>";
	echo($f_algo['hora']."  >  hora");
	echo "<br>";
	echo($f_algo['fecha']."  >  fecha");
	echo "<br>";
	echo "<br>";
	}
*/

$algo = "SELECT count(fecha) as cantidad from est_chec where fecha = '2015-07-31' and hora > '01:05:37' order by fecha, hora";
		$e_algo = mysqli_query($dbr,$algo);
		$f_algo = mysqli_fetch_array($e_algo);
$algo2 = "SELECT count(fecha) as cantidad from est_chec where fecha > '2015-07-31' order by fecha, hora";
		$e_algo2 = mysqli_query($dbr,$algo2);
		$f_algo2 = mysqli_fetch_array($e_algo2); 
		

//$algo2 = "SELECT count(fecha) as cantidad from est_santodomingo order by fecha, hora";
/*
$algo2 = "SELECT count(fecha) as cantidad from est_chec";
		$e_algo2 = mysqli_query($dbr,$algo2);
		$f_algo2 = mysqli_fetch_array($e_algo2);
		echo "<br>";echo "<br>";
		echo($f_algo['cantidad']);
		echo "::: primer dia";
		echo "<br>";
		echo($f_algo2['cantidad']); 
		echo "::: resto";
		echo "<br>";*/

		echo "uno :::";
		echo($f_algo['cantidad']);
		echo "dos:::";
		echo($f_algo2['cantidad']);
		echo "<br>";

		$total = (double)$f_algo['cantidad'] + (double)$f_algo2['cantidad'];
		echo("<br>");
		echo("total --> ".$total);



?>