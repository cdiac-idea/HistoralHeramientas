<?php
require_once("conexion2.php");

/*

$ultima_fecha_filtrada = "SELECT dato_actual from tablas where nombre_tabla = 'est_marquetalia'";  #|
        $e_ultima_fecha_filtrada = pg_query($ultima_fecha_filtrada);                                                   #|
        $f_ultima_fecha_filtrada = pg_fetch_array($e_ultima_fecha_filtrada);                                           #|
        $fecha = $f_ultima_fecha_filtrada['dato_actual']; #en $fecha se almacena la última fecha filtrada              #|
        
echo($fecha);

$ultima_hora_filtrada = "SELECT hora_actual from tablas where nombre_tabla = 'est_marquetalia'";  #|
        $e_ultima_hora_filtrada = pg_query($ultima_hora_filtrada);                                                   #|
        $f_ultima_hora_filtrada = pg_fetch_array($e_ultima_hora_filtrada);                                           #|
        $hora = $f_ultima_hora_filtrada['hora_actual']; #en $fecha se almacena la última fecha filtrada              #|
echo "<br>";
echo($hora);


					$consul = "
					CREATE TABLE confiabilidad_aire
					(
					  estacion_sk integer,
					  fecha_sk integer,
					  total_entrante_so2 integer,
					  total_buenos_so2 integer,
					  soporte_so2 double precision,
					  confianza_so2 double precision,
					  total_entrante_co integer,
					  total_buenos_co integer,
					  soporte_co double precision,
					  confianza_co double precision,
					  total_entrante_o3 integer,
					  total_buenos_03 integer,
					  soporte_o3 double precision,
					  confianza_o3 double precision,
					  total_entrante_pm10 integer,
					  total_buenos_pm10 integer,
					  soporte_pm10 double precision,
					  confianza_pm10 double precision,
					  total_entrante_pm2_5 integer,
					  total_buenos_pm2_5 integer,
					  confianza_pm2_5 double precision,
					  soporte_pm2_5 double precision
					)
					WITH (
					  OIDS=FALSE
					);";

		$e_consul = pg_query($consul);

		*/


		$consulta = "SELECT * from historial_correccion where tiempo_sk = '' order by id_correccion";
		$e_consulta = pg_query($consulta);


		 while ($f_consulta = pg_fetch_array($e_consulta)) {

		 	$variable = $f_consulta['variable'];
		 	$estacion = $f_consulta['estacion_sk'];
		 	$fecha = $f_consulta['fecha_sk'];
			$valor = $f_consulta['valor_corregido'];
			$id = $f_consulta['id_correccion'];




				
			if ($valor != null and $estacion != null) {
				

					$consulta2 = "SELECT tiempo_sk,$variable from fact_table where estacion_sk = $estacion and fecha_sk = $fecha and $variable = $valor limit 1";
				 	$e_consulta2 = pg_query($consulta2);
				 	$f_consulta2 = pg_fetch_array($e_consulta2);
				 	$valor_actual = $f_consulta2['tiempo_sk'];

				 	echo var_dump($valor_actual);
				 	echo("<br>");

				 	//$consulta4 = "UPDATE historial_correccion set tiempo_sk = $valor_actual where id_correccion = $id";
				 	//$e_consulta4 = pg_query($consulta4);
			}
	}



?>