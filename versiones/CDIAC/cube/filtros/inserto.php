<?php
require_once("../conexion/conexion.php");

$agrego = "INSERT INTO basedatos (id_basedatos, usuario, red, nombrebasedatos, contrasenia) values (1,'redcorpo','caldas','redcaldas', 'consultacorpocaldas')";
$e_agrego = pg_query($agrego);

