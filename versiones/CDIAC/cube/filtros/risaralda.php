<?php
session_start();
require_once("filtro_optimo1_13.php");
require_once("../conexion/conexion.php");
require_once("migrar.php");

$red = $_POST["red"];
$estacion = $_POST["estacion"];
$_SESSION["red"] = $red;
$_SESSION["estacion"] = $estacion;

$archivo = $_FILES["archivo"]["name"];
$_SESSION["archivo"] = $archivo;


$delete_table = "DROP TABLE central";
$rdelete_table = @pg_query($delete_table);
$delete_correcciones = "delete from correcciones";
$e_de_correcciones = pg_query($delete_correcciones);
$encabezado = "INSERT into correcciones (fecha,hora,estacion,posicion,variable,valor_error,observacion_error, valor_corregido, tipo_correccion_aplicado) values ('fecha','hora','estacion','posicion_en_el_archivo','variable','valor_error','Obervacion Error', 'valor_corregido', 'tipo_correccion_aplicado')";
$r_encabezado = pg_query($encabezado);

upload_file("datos",".csv"); # Se carga el archivo llamando la funcion upload_file

$fp = fopen ( "../backups/datos.csv" , "r" ); 
$data = fgetcsv ( $fp , 1000 , ";" );
$numero = count($data);

$posicion = "SELECT estacion_sk from station_dim where estacion = '$estacion'";
$r_posicion = pg_query($posicion);
$v_posicion = pg_fetch_array($r_posicion);

$parcial = $v_posicion['estacion_sk']; 

crear_central($data,$numero,$estacion);
inicial($estacion);
migrar_inicial($parcial);

fclose ( $fp ); 
header("Location: filtro_optimo1_13.php");

function crear_central($arreglo,$numero,$estacion){

$i=0;

while ($i < $numero ) {

	$variables = "SELECT distinct (variables) from variables ";
	$e_variables = pg_query($variables);

	//$variable_excel = "SELECT distinct (variable_excel) from variables where variables != 'temperatura' and variables != 'direccion_viento'";
	$variable_excel = "SELECT distinct (variable_excel) from variables";
	$e_variables_excel = pg_query($variable_excel);
	$Temperatura = substr($arreglo[$i], 1, -5);
	$Direccion = substr($arreglo[$i], 1, -4);

	$bandera = 0;	


if($arreglo[$i] == 'fecha' || $arreglo[$i] == 'hora' || $arreglo[$i] == 'estacion_sk' || $arreglo[$i] == 'fecha_sk' || $arreglo[$i] == 'tiempo_sk' || $arreglo[$i] == 'temperatura_max' || $arreglo[$i] == 'temperatura_min' || $arreglo[$i] == 'temperatura_med' || $arreglo[$i] == 'brillo'){
	

		if ($i == 0){
			$pg_tabla = "CREATE TABLE central
    	(
    		{$arreglo[$i]} character varying
    	)";
		$resultado_tabla = pg_query($pg_tabla);
		}
	
		else
		{
			$add_registro = "ALTER TABLE central ADD COLUMN {$arreglo[$i]} character varying";
			$resultado_add_registro = pg_query($add_registro);
		}
		$bandera = 1;
	}
if($arreglo[$i] == 'evapotranspiración_real' || $arreglo[$i] == 'evapotranspiracion_real' || $arreglo[$i] == 'evapo_real' || $arreglo[$i] == ' Evapotranspiracion(mm) '){

	if ($i == 0){
			$pg_tabla = "CREATE TABLE central
    	(
    		evapotranspiracion_real character varying
    	)";
		$resultado_tabla = pg_query($pg_tabla);
		}
	
		else
		{
			$add_registro = "ALTER TABLE central ADD COLUMN evapotranspiracion_real character varying";
			$resultado_add_registro = pg_query($add_registro);
		}
		$bandera = 1;
}

if ($bandera == 0) {
		if ($Temperatura == 'Temperatura'){

		if ($i == 0){
			$pg_tabla = "CREATE TABLE central
    	(
    		temperatura character varying
    	)";
		$resultado_tabla = pg_query($pg_tabla);
		}
	
		else
		{
			$add_registro = "ALTER TABLE central ADD COLUMN temperatura character varying";
			$resultado_add_registro = pg_query($add_registro);
		}
		$bandera = 1;
		}
	}

if ($bandera == 0) {
		if ($Direccion == 'Direccion'){

		if ($i == 0){
			$pg_tabla = "CREATE TABLE central
    	(
    		direccion_viento character varying
    	)";
		$resultado_tabla = pg_query($pg_tabla);
		}
	
		else
		{
			$add_registro = "ALTER TABLE central ADD COLUMN direccion_viento character varying";
			$resultado_add_registro = pg_query($add_registro);
		}
		$bandera = 1;
		}
	}


if ($bandera == 0){
	while ($f_variables  = pg_fetch_array($e_variables)) {
	# pregunto si son iguales
		if ($f_variables['variables'] == $arreglo[$i]){
	
		if ($i == 0){
			$pg_tabla = "CREATE TABLE central
    		(
    		{$arreglo[$i]} character varying
    		)";
			$resultado_tabla = pg_query($pg_tabla);
		}
	
		else
			{
				$add_registro = "ALTER TABLE central ADD COLUMN {$arreglo[$i]} character varying";
				$resultado_add_registro = pg_query($add_registro);
			}
			$bandera = 1;	
		}
			
	}
}
echo("<br>");

if ($bandera == 0){
	while ($f_variable_excel  = pg_fetch_array($e_variables_excel)) {

		if (($f_variable_excel['variable_excel']) == $arreglo[$i]){
	

			$variableDexcel = "SELECT variables from variables where variable_excel = '{$arreglo[$i]}'";
  			$e_variableDexcel = pg_query(($variableDexcel));
  			$fco = pg_fetch_array($e_variableDexcel);
  			
  			if ($i == 0){
			$pg_tabla = "CREATE TABLE central
    		(
    			{$fco['variables']} character varying
    		)";
			$resultado_tabla = pg_query($pg_tabla);
			}
	
			else
			{
				$add_registro = "ALTER TABLE central ADD COLUMN {$fco['variables']} character varying";
				$resultado_add_registro = pg_query(($add_registro));
			}
			$bandera = 1;
		}
		else{

		}

	}
}

		$i++;
	
}
subir_datos();
	agregar_columnas($arreglo,$estacion);

}
		



function subir_datos(){
elimino_fila();
$pg_carga_datos = "COPY central from 'C:\wamp\www\cube\backups\datos.csv' DELIMITERS ';'";

$resultado_carga_datos = pg_query(($pg_carga_datos));
if($resultado_carga_datos == false){
	header("Location: ../index.php/mensaje_error_carga");
}


$borro_vacio = "DELETE from central where fecha is null;";
$r_borro_vacio = pg_query($borro_vacio);
$borro_vacio = "DELETE from central where fecha = '';";
$r_borro_vacio = pg_query($borro_vacio);

}

 function upload_file($nombre, $extension){
  $archi = $_FILES["archivo"]["tmp_name"];


  //$nombre = "datos";
  //$extension = ".csv";
  $destino = "../backups/".$nombre.$extension;
  $_SESSION["archivo"] = $archi;

  move_uploaded_file($archi,$destino);  # mueve el archivo al destino destro de la carpeta backups
}


function agregar_columnas($data,$estacion){
 if (!in_array("fecha_sk", $data)) {
	$add_registro = "ALTER TABLE central ADD COLUMN fecha_sk character varying";
			$resultado_add_registro = pg_query($add_registro);
}
if (!in_array("tiempo_sk", $data)) {
	$add_registro = "ALTER TABLE central ADD COLUMN tiempo_sk character varying";
			$resultado_add_registro = pg_query($add_registro);
}
if (!in_array("estacion_sk", $data)) {
	$add_registro = "ALTER TABLE central ADD COLUMN estacion_sk character varying";
			$resultado_add_registro = pg_query($add_registro);
}
$add_registro = "ALTER TABLE central ADD COLUMN registro serial";
$resultado_add_registro = pg_query($add_registro);

$add_observaciones = "ALTER TABLE central ADD COLUMN observaciones character varying";
$resultado_add_registro = pg_query($add_observaciones);



}


function elimino_fila(){
	$archivo = '../backups/datos.csv';  
    if(file_exists($archivo)) {  
        $file = fopen($archivo,'r');  
        while(!feof($file)) {   
            $name = fgets($file);  
            $lineas[] = $name;  
        }  
        fclose($file);  

        // Todas las lineas quedan almacenadas en $lineas  
        // Ahora eliminas la fila 15 por ejemplo, en el array sería la posicion 14 (empezamos por la 0)  
        unset($lineas[0]);  
        $lineas = array_values($lineas);  
        //print_r($lineas);
        //echo "<br>";
        // GUARDAMOS  
        $file = fopen($archivo, "w");  
        foreach( $lineas as $linea ) {  
            fwrite( $file, $linea );  
        }   
        fclose( $file ); 
    } 
}



############
 


?>