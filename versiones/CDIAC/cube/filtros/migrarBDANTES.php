<?php
require_once("../conexion/conexion.php");

function migrar_inicial($estacion_sk){
subida_llaves();

// consulta para optener las variables que tiene cada estacion


$consulta = "SELECT nombre from variable where id_variable in (select id_variable from tablasxvariable where id_tabla='$estacion_sk')";
$e_consulta = pg_query($consulta);  

$cantidad_maxima = pg_num_rows($e_consulta);


while($r_consulta = pg_fetch_array($e_consulta)){
   
	convertirParaFactTable($r_consulta['nombre']);
	$variable = $r_consulta['nombre'];
	echo($r_consulta['nombre']);
	echo ("<br>");

   $consulta_central = "SELECT estacion_sk, fecha_sk, tiempo_sk, $variable FROM central";
   $e_consulta_central = pg_query($consulta_central);

   while ($f_consulta_central = pg_fetch_array($e_consulta_central)){
   	echo($f_consulta_central[$variable]);
   	$consul = "UPDATE fact_table set $variable = {$f_consulta_central[$variable]} where estacion_sk = $f_consulta_central[estacion_sk] and fecha_sk = $f_consulta_central[fecha_sk] and tiempo_sk = $f_consulta_central[tiempo_sk]";
 	$ejecuto_consul = pg_query($consul);

}


}

observaciones(); 
}


############################### funciones ###############################



//consulta para pasar las llaves a la fack_table

function subida_llaves(){

$estacion_sk = "ALTER TABLE central ALTER COLUMN estacion_sk TYPE integer USING (estacion_sk::integer)";
	$e_estacion_sk = pg_query($estacion_sk);
	
	$fecha_sk = "ALTER TABLE central ALTER COLUMN fecha_sk TYPE integer USING (fecha_sk::integer)";
	$e_fecha_sk = pg_query($fecha_sk);
	
	$tiempo_sk = "ALTER TABLE central ALTER COLUMN tiempo_sk TYPE integer USING (tiempo_sk::integer)";
	$e_tiempo_sk = pg_query($tiempo_sk);


	 $consul = "INSERT INTO fact_table SELECT estacion_sk ,fecha_sk ,tiempo_sk FROM central ";
 	  $ejecuto_consul = pg_query($consul);

}



function convertirParaFactTable($columna){

	if ($columna == 'precipitacion') {

		cambiar_a_puntos('precipitacion');

		$precipitacion = "ALTER TABLE central ALTER COLUMN precipitacion TYPE numeric(7,2) USING (precipitacion::numeric(7,2))";
		$e_precipitacion = pg_query($precipitacion);
	}
	elseif($columna == 'temperatura'){

		cambiar_a_puntos('temperatura');

		$temperatura = "ALTER TABLE central ALTER COLUMN temperatura TYPE numeric(5,2) USING (temperatura::numeric(5,2))";
		$e_temperatura = pg_query($temperatura);
	}
	elseif($columna == 'brillo'){

		cambiar_a_puntos('brillo');

		$brillo = "ALTER TABLE central ALTER COLUMN brillo TYPE numeric(5,2) USING (brillo::numeric(5,2))";
		$e_brillo = pg_query($brillo);
	}
	elseif($columna == 'humedad_relativa'){
	
		$humedad_relativa = "ALTER TABLE central ALTER COLUMN humedad_relativa TYPE numeric(5,2) USING (humedad_relativa::numeric(5,2))";
		$e_humedad_relativa = pg_query($humedad_relativa);
	}
	elseif($columna == 'nivel'){

		cambiar_a_puntos('nivel');

		$nivel = "ALTER TABLE central ALTER COLUMN nivel TYPE double precision USING (nivel::double precision)";
		$e_nivel = pg_query($nivel);
	}
	elseif($columna == 'caudal'){

		cambiar_a_puntos('caudal');	

		$caudal = "ALTER TABLE central ALTER COLUMN caudal TYPE double precision USING (caudal::double precision)";
		$e_caudal = pg_query($caudal);
	}
	elseif($columna == 'velocidad_viento'){

		cambiar_a_puntos('velocidad_viento');

		$velocidad_viento = "ALTER TABLE central ALTER COLUMN velocidad_viento TYPE double precision USING (velocidad_viento::double precision)";
		$e_velocidad_viento = pg_query($velocidad_viento);
	}
	elseif($columna == 'direccion_viento'){

		$direccion_viento = "ALTER TABLE central ALTER COLUMN direccion_viento TYPE integer USING (direccion_viento::integer)";
		$e_direccion_viento = pg_query($direccion_viento);
	}
	elseif($columna == 'presion_barometrica'){

		cambiar_a_puntos('presion_barometrica');

		$presion_barometrica = "ALTER TABLE central ALTER COLUMN presion_barometrica TYPE double precision USING (presion_barometrica::double precision)";
		$e_presion_barometrica = pg_query($presion_barometrica);
	}
	elseif($columna == 'evapotranspiracion'){

		cambiar_a_puntos('evapotranspiracion');

		$evapotranspiracion = "ALTER TABLE central ALTER COLUMN evapotranspiracion_real TYPE double precision USING (evapotranspiracion_real::double precision)";
		$e_evapotranspiracion = pg_query($evapotranspiracion);
	}
	elseif($columna == 'radiacion_solar'){

	cambiar_a_puntos('radiacion_solar');
	
	$radiacion_solar = "ALTER TABLE central ALTER COLUMN radiacion_solar TYPE double precision USING (radiacion_solar::double precision)";
	$e_radiacion_solar = pg_query($radiacion_solar);
	}
	
}



function cambiar_a_puntos($columna){
		$cambio ="UPDATE central set $columna = replace($columna, ',', '.')";
        $e_cambio = pg_query($cambio);
}

function observaciones(){

    $consul = "INSERT INTO observaciones SELECT estacion_sk,fecha_sk,tiempo_sk,observaciones FROM central  WHERE observaciones = 'Ppt acumulada'";
    $ejecuto_consul = pg_query($consul);
}

?>