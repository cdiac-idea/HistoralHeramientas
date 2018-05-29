<?php
session_start();

foreach ($_FILES["archivo"] as $key => $value) {
	# code...
	echo "Propiedad: $key --- Clave: $value<br>";
}

if ($_FILES["archivo"]["type"]=="application/vnd.ms-excel"){
	echo "ES CSV";
}
else{
	echo "No es CSV";
}
?>
