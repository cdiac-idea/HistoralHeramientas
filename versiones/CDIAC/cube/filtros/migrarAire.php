<?php


function migrar_inicial($estacion_sk){
	require_once("../conexion/conexiondwh.php");


	### consulta para identificar las variables que contiene cada estacion en cada estacion ####
	
	$consulta = "SELECT nombre from variable where tipologia = 'Aire'";
	$e_consulta = pg_query($consulta); 

	$cantidad_maxima = pg_num_rows($e_consulta);

	
	while($r_consulta = pg_fetch_array($e_consulta)){
	   
		$variable = $r_consulta['nombre'];


		################ funcion para cambiar de comas a puntos los datos de central #########

		cambiar_a_puntos($variable);



	}

		################ consulta para contar la cantidad de registros en central ######

	$contar="SELECT estacion_sk from centralaire";
	$e_contar = pg_query($contar);
	$n_contar = pg_num_rows($e_contar);


######################################################################################################################
	### consulta para identificar las columnas existentes en central ####

	$columas_central= "SELECT column_name from information_schema.columns where table_name = 'centralaire';";
	$e_columas_central = pg_query($columas_central);



	$arreglo = "";


			$lugar = 0;

			while ($f_columas_central = pg_fetch_assoc($e_columas_central)) {
				
				$var =(String)$f_columas_central['column_name'];

				if ($var == 'fecha' or $var == 'hora' or $var == 'registro' or $var == 'observaciones') {

					 // no se hace nada :P
				}else{

					$arreglo .= "$var,";
					$array[$lugar] = $var;
					


				echo($lugar);
				echo ":::";
				echo($array[$lugar]);
				echo "<br>";
					$lugar = $lugar + 1;
				}

				
	
			}
			$arreglo[strlen($arreglo)-1] = ' ';

			## .................................................. ###

			$consulta = "SELECT $arreglo from centralaire"; 
			$e_consulta = pg_query($consulta);
			$n_consuta = pg_num_rows($e_consulta);
			$bandera = 0;
			while ($f_consulta = pg_fetch_assoc($e_consulta)) { // es muy importante ejecutar con assoc y no con array

				
				$arreglo_variables = '';
				
				$arreglo_valores = '';

			    reset($f_consulta);

			    while(list($name,$value) = each($f_consulta)) {  

			    $variable_arreglo = (string)$array[$bandera];
	
			    if (is_null($value) or $value == ' ' or $value == '') {
					
				}else{
					$arreglo_variables .= "$variable_arreglo,";
					$valor = (double)$value;
					$arreglo_valores .= "$valor,";

				}	
		       		$bandera = $bandera + 1;     
			    }
			    $bandera = 0;
				
				$str = "insert into fact_aire (".$arreglo_variables ;

			    $str[strlen($str)-1] = ')';
			    $str .= " values (".$arreglo_valores;

			    $str[strlen($str)-1] = ')';
			    $str .= ";"    ;	

			    $ejecuto = pg_query($str);
				}

			
##################################################################################################################

	historial_correccion();
}

function historial_correccion(){
	$consul = "INSERT INTO historial_correccion (estacion_sk,fecha_sk,tiempo_sk,posicion,variable,valor_error,observacion_error,valor_corregido,tipo_correccion_aplicado) (SELECT estacion_sk,fecha_sk,tiempo_sk,posicion,variable,valor_error,observacion_error,valor_corregido,tipo_correccion_aplicado from correcciones where estacion != 'estacion');";
    $ejecuto_consul = @pg_query($consul);
}

