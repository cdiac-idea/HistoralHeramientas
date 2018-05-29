<?php


function migrar_inicial($estacion_sk){
	require_once("../conexion/conexiondwh.php");


	### consulta para identificar las variables que contiene cada estacion en cada estacion ####
	
	$consulta = "SELECT nombre from variable where tipologia = 'Clima'";
	$e_consulta = pg_query($consulta); 

	$cantidad_maxima = pg_num_rows($e_consulta);

	
	while($r_consulta = pg_fetch_array($e_consulta)){
	   
		$variable = $r_consulta['nombre'];


		################ funcion para cambiar de comas a puntos los datos de central #########

		cambiar_a_puntos($variable);

		################ funcion para cambiar el tipo de campos de la tabla central #########

		//convertirParaFactTable($variable);

	}

		################ consulta para contar la cantidad de registros en central ######

	$contar="SELECT estacion_sk from central";
	$e_contar = pg_query($contar);
	$n_contar = pg_num_rows($e_contar);


######################################################################################################################
	### consulta para identificar las columnas existentes en central ####

	$columas_central= "SELECT column_name from information_schema.columns where table_name = 'central';";
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

			$consulta = "SELECT $arreglo from central"; 
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

			    $ejecuto = pg_query($str);
				}

			
##################################################################################################################
		

	observaciones();
	historial_correccion();
}

function historial_correccion(){
	$consul = "INSERT INTO historial_correccion (estacion_sk,fecha_sk,tiempo_sk,posicion,variable,valor_error,observacion_error,valor_corregido,tipo_correccion_aplicado) (SELECT estacion_sk,fecha_sk,tiempo_sk,posicion,variable,valor_error,observacion_error,valor_corregido,tipo_correccion_aplicado from correcciones where estacion != 'estacion');";
    $ejecuto_consul = @pg_query($consul);
}

function observaciones(){
	 $consul = "INSERT INTO observaciones SELECT cast(estacion_sk as integer),cast(fecha_sk as integer),cast(tiempo_sk as integer),observaciones FROM central  WHERE observaciones = 'Ppt acumulada'";
    $ejecuto_consul = @pg_query($consul);
}




### funcion para subir el campo recuperado a la fact_table ###
function update_especific($columna,$estacion_sk,$fecha_sk,$tiempo_sk,$i){

	


	if ($columna == 'precipitacion') {
		$valor = "SELECT precipitacion from central limit 1 offset $i";
		$e_valor = pg_query($valor);
		$f_valor = pg_fetch_array($e_valor);

		if (!is_null($f_valor['precipitacion'] ) or $f_valor['precipitacion'] != "") {
		
		$valor = (float)$f_valor['precipitacion'];

		$precipitacion = "UPDATE fact_table set precipitacion = $valor where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk and tiempo_sk = $tiempo_sk";
		$e_precipitacion = pg_query($precipitacion);

		}
	}
	elseif($columna == 'temperatura'){
		
		

		$valor = "SELECT temperatura from central limit 1 offset $i";
		$e_valor = pg_query($valor);
		$f_valor = pg_fetch_array($e_valor);

		if (!is_null($f_valor['temperatura'] ) or $f_valor['temperatura'] != "") {

		$valor = (float)$f_valor['temperatura'];

		$temperatura = "UPDATE fact_table set temperatura = $valor where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk and tiempo_sk = $tiempo_sk";
		$e_temperatura = pg_query($temperatura);
	}
		
	}
	elseif($columna == 'brillo'){

		$valor = "SELECT brillo from central limit 1 offset $i";
		$e_valor = pg_query($valor);
		$f_valor = pg_fetch_array($e_valor);
		
		if (!is_null($f_valor['brillo'] ) or $f_valor['brillo'] != "") {
		$valor = (float)$f_valor['brillo'];

		$brillo = "UPDATE fact_table set brillo = $valor where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk and tiempo_sk = $tiempo_sk";
		$e_brillo = pg_query($brillo);
	}
	}
	elseif($columna == 'humedad_relativa'){
	

		$valor = "SELECT humedad_relativa from central limit 1 offset $i";
		$e_valor = pg_query($valor);
		$f_valor = pg_fetch_array($e_valor);

		if (!is_null($f_valor['humedad_relativa'] ) or $f_valor['humedad_relativa'] != "") {
		$valor = (float)$f_valor['humedad_relativa'];

		$humedad_relativa = "UPDATE fact_table set humedad_relativa = $valor where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk and tiempo_sk = $tiempo_sk";
		$e_humedad_relativa = pg_query($humedad_relativa);
	}
	}
	elseif($columna == 'nivel'){

		$valor = "SELECT nivel from central limit 1 offset $i";
		$e_valor = pg_query($valor);
		$f_valor = pg_fetch_array($e_valor);

		if (!is_null($f_valor['nivel'] ) or $f_valor['nivel'] != "") {
		$valor = (float)$f_valor['nivel'];

		$nivel = "UPDATE fact_table set nivel = $valor where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk and tiempo_sk = $tiempo_sk";
		$e_nivel = pg_query($nivel);
	}
	}
	elseif($columna == 'caudal'){

		$valor = "SELECT caudal from central limit 1 offset $i";
		$e_valor = pg_query($valor);
		$f_valor = pg_fetch_array($e_valor);

		if (!is_null($f_valor['caudal'] ) or $f_valor['caudal'] != "") {
		$valor = (float)$f_valor['caudal'];

		$caudal = "UPDATE fact_table set caudal = $valor where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk and tiempo_sk = $tiempo_sk";
		$e_caudal = pg_query($caudal);
	}
	}
	elseif($columna == 'velocidad_viento'){

		$valor = "SELECT velocidad_viento from central limit 1 offset $i";
		$e_valor = pg_query($valor);
		$f_valor = pg_fetch_array($e_valor);

		if (!is_null($f_valor['velocidad_viento'] ) or $f_valor['velocidad_viento'] != "") {
		$valor = (float)$f_valor['velocidad_viento'];

		$velocidad_viento = "UPDATE fact_table set velocidad_viento = $valor where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk and tiempo_sk = $tiempo_sk";
		$e_velocidad_viento = pg_query($velocidad_viento);
	}
	}

	elseif($columna == 'direccion_viento'){

		$valor = "SELECT direccion_viento from central limit 1 offset $i";
		$e_valor = pg_query($valor);
		$f_valor = pg_fetch_array($e_valor);

		if (!is_null($f_valor['direccion_viento'] ) or $f_valor['direccion_viento'] != "") {
		$valor = (float)$f_valor['direccion_viento'];

		$direccion_viento = "UPDATE fact_table set direccion_viento = $valor where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk and tiempo_sk = $tiempo_sk";
		$e_direccion_viento = pg_query($direccion_viento);
	}
}
	elseif($columna == 'presion_barometrica'){

		$valor = "SELECT presion_barometrica from central limit 1 offset $i";
		$e_valor = pg_query($valor);
		$f_valor = pg_fetch_array($e_valor);

		if (!is_null($f_valor['presion_barometrica'] ) or $f_valor['presion_barometrica'] != "") {
		$valor = (float)$f_valor['presion_barometrica'];

		$presion_barometrica = "UPDATE fact_table set presion_barometrica = $valor where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk and tiempo_sk = $tiempo_sk";
		$e_presion_barometrica = pg_query($presion_barometrica);
	}
}
	elseif($columna == 'evapotranspiracion'){

		$valor = "SELECT evapotranspiracion from central limit 1 offset $i";
		$e_valor = pg_query($valor);
		$f_valor = pg_fetch_array($e_valor);


		if (!is_null($f_valor['evapotranspiracion'] ) or $f_valor['evapotranspiracion'] != "") {
		$valor = (float)$f_valor['evapotranspiracion'];

		$evapotranspiracion = "UPDATE fact_table set evapotranspiracion = $valor where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk and tiempo_sk = $tiempo_sk";
		$e_evapotranspiracion = pg_query($evapotranspiracion);
	}
}
	elseif($columna == 'radiacion_solar'){

	
		$valor = "SELECT radiacion_solar from central limit 1 offset $i";
		$e_valor = pg_query($valor);
		$f_valor = pg_fetch_array($e_valor);

		if (!is_null($f_valor['radiacion_solar'] ) or $f_valor['radiacion_solar'] != "") {
		$valor = (float)$f_valor['radiacion_solar'];

		$radiacion_solar = "UPDATE fact_table set radiacion_solar = $valor where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk and tiempo_sk = $tiempo_sk";
		$e_radiacion_solar = pg_query($radiacion_solar);;
	}
}
	
}

### funcion para para cambiar las comas en central por puntos ###
 function  cambiar_a_puntos($columna){	
			
			$cambio ="UPDATE central set $columna = replace($columna, ',', '.')";
        	$e_cambio = @pg_query($cambio);

        	$actualiza = "UPDATE central set $columna = null where $columna = '-' and $columna = ''";
			$ejecuto_actualiza = @pg_query($actualiza);
		
}
### funcion para para cambiar el tipo de dato de las columnas ###
function convertirParaFactTable($columna){

	if ($columna == 'precipitacion_real') {



		$precipitacion = "ALTER TABLE central ALTER COLUMN precipitacion TYPE numeric(7,2) USING (precipitacion_real::numeric(7,2))";
		$e_precipitacion = pg_query($precipitacion);
	}
	elseif($columna == 'temperatura'){

	
		$temperatura = "ALTER TABLE central ALTER COLUMN temperatura TYPE numeric(5,2) USING (temperatura::numeric(5,2))";
		$e_temperatura = pg_query($temperatura);
	}
	elseif($columna == 'brillo'){

		

		$brillo = "ALTER TABLE central ALTER COLUMN brillo TYPE numeric(5,2) USING (brillo::numeric(5,2))";
		$e_brillo = pg_query($brillo);
	}
	elseif($columna == 'humedad_relativa'){
	
		$humedad_relativa = "ALTER TABLE central ALTER COLUMN humedad_relativa TYPE numeric(5,2) USING (humedad_relativa::numeric(5,2))";
		$e_humedad_relativa = pg_query($humedad_relativa);
	}
	elseif($columna == 'nivel'){

		

		$nivel = "ALTER TABLE central ALTER COLUMN nivel TYPE double precision USING (nivel::double precision)";
		$e_nivel = pg_query($nivel);
	}
	elseif($columna == 'caudal'){

		

		$caudal = "ALTER TABLE central ALTER COLUMN caudal TYPE double precision USING (caudal::double precision)";
		$e_caudal = pg_query($caudal);
	}
	elseif($columna == 'velocidad_viento'){

		

		$velocidad_viento = "ALTER TABLE central ALTER COLUMN velocidad_viento TYPE double precision USING (velocidad_viento::double precision)";
		$e_velocidad_viento = pg_query($velocidad_viento);
	}
	elseif($columna == 'direccion_viento'){

		$direccion_viento = "ALTER TABLE central ALTER COLUMN direccion_viento TYPE double precision USING (direccion_viento::double precision)";
		$e_direccion_viento = pg_query($direccion_viento);
	}
	elseif($columna == 'presion_barometrica'){

		

		$presion_barometrica = "ALTER TABLE central ALTER COLUMN presion_barometrica TYPE double precision USING (presion_barometrica::double precision)";
		$e_presion_barometrica = pg_query($presion_barometrica);
	}
	elseif($columna == 'evapotranspiracion_real'){

		

		$evapotranspiracion = "ALTER TABLE central ALTER COLUMN evapotranspiracion_real TYPE double precision USING (evapotranspiracion_real::double precision)";
		$e_evapotranspiracion = pg_query($evapotranspiracion);
	}
	elseif($columna == 'radiacion_solar'){

	
	
	$radiacion_solar = "ALTER TABLE central ALTER COLUMN radiacion_solar TYPE double precision USING (radiacion_solar::double precision)";
	$e_radiacion_solar = pg_query($radiacion_solar);
	}
	
}
?>