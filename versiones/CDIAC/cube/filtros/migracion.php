<?php
require_once("../conexion/conexion.php");

function migrar(){

	$lacon = "SELECT * from central where registro = 2";
	$e_lacon= pg_query($lacon);
	$r_lacon= pg_fetch_array($e_lacon);
	echo($r_lacon["precipitacion"]);

	$otro = Double ($r_lacon);
	echo($otro['precipitacion']);

}

function convertirParaFactTable(){
	
	$estacion_sk = "ALTER TABLE central ALTER COLUMN estacion_sk TYPE integer USING (estacion_sk::integer)";
	$e_estacion_sk = pg_query($estacion_sk);
	
	$fecha_sk = "ALTER TABLE central ALTER COLUMN fecha_sk TYPE integer USING (fecha_sk::integer)";
	$e_fecha_sk = pg_query($fecha_sk);
	
	$tiempo_sk = "ALTER TABLE central ALTER COLUMN tiempo_sk TYPE integer USING (tiempo_sk::integer)";
	$e_tiempo_sk = pg_query($tiempo_sk);
	
	$precipitacion = "ALTER TABLE central ALTER COLUMN precipitacion TYPE numeric(7,2) USING (precipitacion::numeric(7,2))";
	$e_precipitacion = pg_query($precipitacion);
	
	$temperatura = "ALTER TABLE central ALTER COLUMN temperatura TYPE numeric(5,2) USING (temperatura::numeric(5,2))";
	$e_temperatura = pg_query($temperatura);
	
	$temperatura_max = "ALTER TABLE central ALTER COLUMN temperatura_max TYPE numeric(5,2) USING (temperatura_max::numeric(5,2))";
	$e_temperatura_max = pg_query($temperatura_max);
	
	$temperatura_med = "ALTER TABLE central ALTER COLUMN temperatura_med TYPE numeric(5,2) USING (temperatura_med::numeric(5,2))";
	$e_temperatura_med = pg_query($temperatura_med);
	
	$temperatura_min = "ALTER TABLE central ALTER COLUMN temperatura_min TYPE numeric(5,2) USING (temperatura_min::numeric(5,2))";
	$e_temperatura_min = pg_query($temperatura_min);
	
	$brillo = "ALTER TABLE central ALTER COLUMN brillo TYPE numeric(5,2) USING (brillo::numeric(5,2))";
	$e_brillo = pg_query($brillo);
	
	$humedad_relativa = "ALTER TABLE central ALTER COLUMN humedad_relativa TYPE numeric(5,2) USING (humedad_relativa::numeric(5,2))";
	$e_humedad_relativa = pg_query($humedad_relativa);
	
	$nivel = "ALTER TABLE central ALTER COLUMN nivel TYPE double precision USING (nivel::double precision)";
	$e_nivel = pg_query($nivel);
	
	$caudal = "ALTER TABLE central ALTER COLUMN caudal TYPE double precision USING (caudal::double precision)";
	$e_caudal = pg_query($caudal);
	
	$velocidad_viento = "ALTER TABLE central ALTER COLUMN velocidad_viento TYPE double precision USING (velocidad_viento::double precision)";
	$e_velocidad_viento = pg_query($velocidad_viento);
	
	$direccion_viento = "ALTER TABLE central ALTER COLUMN direccion_viento TYPE integer USING (direccion_viento::integer)";
	$e_direccion_viento = pg_query($direccion_viento);
	
	$presion_barometrica = "ALTER TABLE central ALTER COLUMN presion_barometrica TYPE double precision USING (presion_barometrica::double precision)";
	$e_presion_barometrica = pg_query($presion_barometrica);
	
	$evapotranspiracion = "ALTER TABLE central ALTER COLUMN evapotranspiracion_real TYPE double precision USING (evapotranspiracion_real::double precision)";
	$e_evapotranspiracion = pg_query($evapotranspiracion);
	
	$radiacion_solar = "ALTER TABLE central ALTER COLUMN radiacion_solar TYPE double precision USING (radiacion_solar::double precision)";
	$e_radiacion_solar = pg_query($radiacion_solar);

}



function convertirParaCentral(){
	
	$estacion_sk = "ALTER TABLE central ALTER COLUMN estacion_sk TYPE character varying USING (estacion_sk::character varying)";
	$e_estacion_sk = pg_query($estacion_sk);
	
	$fecha_sk = "ALTER TABLE central ALTER COLUMN fecha_sk TYPE integer USING (fecha_sk::integer)";
	$e_fecha_sk = pg_query($fecha_sk);
	
	$tiempo_sk = "ALTER TABLE central ALTER COLUMN tiempo_sk TYPE integer USING (tiempo_sk::integer)";
	$e_tiempo_sk = pg_query($tiempo_sk);
	
	$precipitacion = "ALTER TABLE central ALTER COLUMN precipitacion TYPE integer USING (precipitacion::integer)";
	$e_precipitacion = pg_query($precipitacion);
	
	$temperatura = "ALTER TABLE central ALTER COLUMN temperatura TYPE integer USING (temperatura::integer)";
	$e_temperatura = pg_query($temperatura);
	
	$temperatura_max = "ALTER TABLE central ALTER COLUMN temperatura_max TYPE integer USING (temperatura_max::integer)";
	$e_temperatura_max = pg_query($temperatura_max);
	
	$temperatura_med = "ALTER TABLE central ALTER COLUMN temperatura_med TYPE integer USING (temperatura_med::integer)";
	$e_temperatura_med = pg_query($temperatura_med);
	
	$temperatura_min = "ALTER TABLE central ALTER COLUMN temperatura_min TYPE integer USING (temperatura_min::integer)";
	$e_temperatura_min = pg_query($temperatura_min);
	
	$brillo = "ALTER TABLE central ALTER COLUMN brillo TYPE integer USING (brillo::integer)";
	$e_brillo = pg_query($brillo);
	
	$humedad_relativa = "ALTER TABLE central ALTER COLUMN humedad_relativa TYPE integer USING (humedad_relativa::integer)";
	$e_humedad_relativa = pg_query($humedad_relativa);
	
	$nivel = "ALTER TABLE central ALTER COLUMN nivel TYPE integer USING (nivel::integer)";
	$e_nivel = pg_query($nivel);
	
	$caudal = "ALTER TABLE central ALTER COLUMN caudal TYPE integer USING (caudal::integer)";
	$e_caudal = pg_query($caudal);
	
	$velocidad_viento = "ALTER TABLE central ALTER COLUMN velocidad_viento TYPE integer USING (velocidad_viento::integer)";
	$e_velocidad_viento = pg_query($velocidad_viento);
	
	$direccion_viento = "ALTER TABLE central ALTER COLUMN direccion_viento TYPE integer USING (direccion_viento::integer)";
	$e_direccion_viento = pg_query($direccion_viento);
	
	$presion_barometrica = "ALTER TABLE central ALTER COLUMN presion_barometrica TYPE integer USING (presion_barometrica::integer)";
	$e_presion_barometrica = pg_query($presion_barometrica);
	
	$evapotranspiracion = "ALTER TABLE central ALTER COLUMN evapotranspiracion TYPE integer USING (evapotranspiracion::integer)";
	$e_evapotranspiracion = pg_query($evapotranspiracion);
	
	$radiacion_solar = "ALTER TABLE central ALTER COLUMN radiacion_solar TYPE integer USING (radiacion_solar::integer)";
	$e_radiacion_solar = pg_query($radiacion_solar);

}




?>