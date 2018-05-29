<?php
require_once("../conexion/conexion.php");

$cadena = "21:11:01";

if (strpos($cadena, 'p')) {
	$cadena = str_replace(" p,m,", "pm", $cadena);
} else if(strpos($cadena, 'a')){
			$cadena = str_replace(" a,m,", "am", $cadena);
	}


$cadena = strtotime($cadena);
$cadena = date("H:i:s", $cadena);
echo $cadena."<br />";

$mystring = '10:11:01 a,m,';




    ?>