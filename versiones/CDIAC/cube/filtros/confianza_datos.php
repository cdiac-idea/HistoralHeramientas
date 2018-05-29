<?php
require_once("../conexion/conexiondwh.php");

 function  calculo_entrantes(){	

 		$col= "SELECT nombre from variable where tipologia = 'Clima'";
 		$e_col = pg_query($col);

 		while ($f_col = pg_fetch_array($e_col)) {
 			$columna = $f_col['nombre'];			
 			
			$variable ="total_entrante_".$columna."";
			$calculo_entrantes ="SELECT estacion_sk,fecha_sk,count($columna) as cantidad from central where $columna != '-' and $columna != '' or $columna is null GROUP BY  estacion_sk,fecha_sk";
        	$e_calculo_entrantes = pg_query($calculo_entrantes);

        	while ($f_calculo_entrantes = pg_fetch_array($e_calculo_entrantes)) {
        		


        		$estacion_sk = (integer)$f_calculo_entrantes['estacion_sk'];
        		$fecha_sk = (integer)$f_calculo_entrantes['fecha_sk'];
        		$cantidad_entrantes = (integer)$f_calculo_entrantes['cantidad'];		
        		$existe = "SELECT estacion_sk,fecha_sk from confiabilidad where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk";
        		$e_existe = pg_query($existe);
				$f_existe = pg_fetch_array($e_existe);
				$n_exite = pg_num_rows($e_existe);
				
				if ($n_exite == 0){


						$insert = "INSERT INTO confiabilidad (estacion_sk,fecha_sk,total_entrante_".$columna.",total_buenos_".$columna.") values ($estacion_sk,$fecha_sk,$cantidad_entrantes,$cantidad_entrantes)";
						$e_insert = pg_query($insert);
			
				}
				else{


					$existe_dato = "SELECT total_entrante_".$columna." from confiabilidad where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk";
        			$e_existe_dato = pg_query($existe_dato);
					$f_existe_dato = pg_fetch_array($e_existe_dato);
					$n_existe_dato = pg_num_rows($e_existe_dato);

						
					if ($n_existe_dato == 0) {

						$entrantes = (double)$cantidad_entrantes;
						$update = "UPDATE confiabilidad set total_entrante_".$columna." = $entrantes where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk";
						$e_update = pg_query($update);
					}
					else{
						
						$variable2 = "total_entrante_".$columna."";
						$cantidad_antes = (double)$f_existe_dato[$variable2];
						$entrantes = (double)$cantidad_entrantes;
						$suma = $cantidad_antes + $entrantes;
						$update = "UPDATE confiabilidad set $variable2 = $suma where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk";
						$e_update = pg_query($update);

					}




					$existe_dato = "SELECT total_buenos_".$columna." from confiabilidad where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk";
        			$e_existe_dato = pg_query($existe_dato);
					$f_existe_dato = pg_fetch_array($e_existe_dato);
					$n_existe_dato = pg_num_rows($e_existe_dato);

						
					if ($n_existe_dato == 0) {

						$entrantes = (double)$cantidad_entrantes;
						$update = "UPDATE confiabilidad set total_buenos_".$columna." = $entrantes where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk";
						$e_update = pg_query($update);
					}
					else{
						
						$variable ="total_buenos_".$columna."";
						$cantidad_antes = (double)$f_existe_dato[$variable];
						$entrantes = (double)$cantidad_entrantes;
						$suma = $cantidad_antes + $entrantes;
						$update = "UPDATE confiabilidad set $variable = $suma where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk";
						$e_update = pg_query($update);

					}

				}
        	}
 		}

			
		
}

function insertar_errores(){

	
	$sql = "SELECT estacion_sk,fecha_sk,variable,count(valor_error) as cantidad from correcciones where variable != 'variable' and valor_corregido != ' ' GROUP BY fecha_sk, estacion_sk,variable";
	$e_sql = pg_query($sql);
	while($f_sql = pg_fetch_array($e_sql)){
		
		$estacion_sk = (integer)$f_sql['estacion_sk'];
		$fecha_sk = (integer)$f_sql['fecha_sk'];
		$variable = $f_sql['variable'];
		$cantidad = (integer)$f_sql['cantidad'];

		
	$update_correcciones = "UPDATE confiabilidad set total_buenos_".$variable." = total_buenos_".$variable." - $cantidad where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk"; 
	$e_update = pg_query($update_correcciones);


	
	}


insertar_confianza();

}


function insertar_confianza(){



$consulta = "SELECT nombre from variable where tipologia = 'Clima'";
$e_consulta = pg_query($consulta); 	

while ($f_consulta = pg_fetch_array($e_consulta)) {

$variable = $f_consulta['nombre'];
$variable_entrantes ="total_entrante_".$variable."";
$variable_buenos ="total_buenos_".$variable."";

$obtener = "SELECT estacion_sk,fecha_sk,$variable_entrantes,$variable_buenos from confiabilidad where soporte_".$variable." is null";
$e_obtener = pg_query($obtener);



while ($f_obtener = pg_fetch_array($e_obtener)) {
	$estacion_sk =$f_obtener['estacion_sk'];
	$fecha_sk =$f_obtener['fecha_sk'];
	$total_entranes =$f_obtener[$variable_entrantes];
	$total_buenos =$f_obtener[$variable_buenos];

	$medicion = "SELECT total_medicion_dia from estacion where estacion_sk = '$estacion_sk'";
	$e_medicion = pg_query($medicion);
	$f_medicion = pg_fetch_array($e_medicion);
	$medicion = $f_medicion['total_medicion_dia'];
	

	
	
	if($medicion == 0){
		$soporte = 0;
	}else{
		$soporte = $total_buenos / $medicion;
	}
	if($total_entranes == 0){
		$confianza = 0;
	}else{
		$confianza = $total_buenos / $total_entranes;
	}
	



	$update_tabla_conf = "UPDATE confiabilidad set soporte_".$variable." = $soporte, confianza_".$variable." = $confianza where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk";
	$e_update_tabla_conf = pg_query($update_tabla_conf);
	
}
	
}
}

//header("Location: ../index.php/mensaje_filtrados"); # Redirige al mensaje enhorabuena
?>