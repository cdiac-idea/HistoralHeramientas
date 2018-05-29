<?php
require_once("conexiondwh.php");



######################################################################################################################
	### consulta para identificar las columnas existentes en central ####

	$columas_central= "SELECT column_name from information_schema.columns where table_name = 'fact_table';";
	$e_columas_central = pg_query($columas_central);



	$arreglo = "";


			$lugar = 0;

			while ($f_columas_central = pg_fetch_assoc($e_columas_central)) {
				
				$var =(String)$f_columas_central['column_name'];

					$arreglo .= "$var,";
					$array[$lugar] = $var;
					$lugar = $lugar + 1;
				}

			$arreglo[strlen($arreglo)-1] = ' ';

			## .................................................. ###

			$consulta = "SELECT $arreglo from fact_table where estacion_sk = 63"; 
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
				
				$str = "insert into fact_table (".$arreglo_variables ;

			    $str[strlen($str)-1] = ')';
			    $str .= " values (".$arreglo_valores;

			    $str[strlen($str)-1] = ')';
			    $str .= ";"    ;	


/// AKI IRIA LA OTRA CONECCION........
			    require_once("../../../conexion/conexionyarumos.php");
			    $ejecuto = pg_query($str);
				}

			
##################################################################################################################


?>