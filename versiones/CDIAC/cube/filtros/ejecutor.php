<?php

require_once("filtro_optimo1_13.php"); // Se incluye el archivo de filtro
require_once("../conexion/conexiondwh.php"); //Se incluye la conexión con la bodega
require_once("migrarBD.php"); // Se incluyen las funciones de migración
require_once("confianza_datos.php");

$estacion = "Alcaldía de Marquetalia";
$parcial = 1;
inicial($estacion); // se llama la funcion inicial del archivo filtro_optimo que lo que hace es el proceso de filtrado
//migrar_inicial($parcial);
//calculo_entrantes();
//insertar_errores();	

echo "Termine";

?>
