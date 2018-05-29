<?php
require_once("../configuracion/clsBD.php");
$objDatos = new clsDatos();
#error_reporting(0);

	function getFechaAire($variable, $estacion, $menor, $mayor){
		$objDatos = new clsDatos();
		if ($variable=="pm10") {
			$sql = "SELECT mes, anio, dia, hora_fin
					FROM indicador_aire 
					WHERE anio>=$menor AND anio<=$mayor AND estacion=$estacion  
					ORDER BY 1, 2, 3, 4";
		}elseif ($variable=="pm2_5") {
			$sql = "SELECT mes, anio, dia, hora_fin
					FROM indicador_aire 
					WHERE anio>=$menor AND anio<=$mayor AND estacion=$estacion  
					ORDER BY 1, 2, 3, 4";
		}elseif ($variable=="co_local_ppt") {
			$sql = "SELECT mes, anio, dia, hora_fin
					FROM indicador_aire 
					WHERE anio>=$menor AND anio<=$mayor AND estacion=$estacion  
					ORDER BY 1, 2, 3, 4";
		}elseif ($variable=="o3_local_ppt") {
			$sql = "SELECT mes, anio, dia, hora_fin
					FROM indicador_aire 
					WHERE anio>=$menor AND anio<=$mayor AND estacion=$estacion  
					ORDER BY 1, 2, 3, 4";
		}elseif ($variable=="so2_local_ppt") {
			$sql = "SELECT mes, anio, dia, hora_fin
					FROM indicador_aire 
					WHERE anio>=$menor AND anio<=$mayor AND estacion=$estacion 
					ORDER BY 1, 2, 3, 4";
		}
		return $objDatos->executeQuery($sql);
	}

	function getDatoAire($variable, $estacion, $menor, $mayor, $clasificacion){
		$objDatos = new clsDatos();
		if ($variable=="pm10") {
			$sql = "SELECT mes, anio, dia, hora_fin, ica_pm10 AS dato
					FROM indicador_aire 
					WHERE anio>=$menor AND anio<=$mayor AND estacion=$estacion AND 
						calificacion_pm10='".$clasificacion."'
					ORDER BY 1, 2, 3, 4";
		}elseif ($variable=="pm2_5") {
			$sql = "SELECT mes, anio, dia, hora_fin, ica_pm25 AS dato
					FROM indicador_aire 
					WHERE anio>=$menor AND anio<=$mayor AND estacion=$estacion AND 
						calificacion_pm25='".$clasificacion."'
					ORDER BY 1, 2, 3, 4";
		}elseif ($variable=="co_local_ppt") {
			$sql = "SELECT mes, anio, dia, hora_fin, ica_co_8h AS dato
					FROM indicador_aire 
					WHERE anio>=$menor AND anio<=$mayor AND estacion=$estacion AND 
						calificacion_co_8h='".$clasificacion."'
					ORDER BY 1, 2, 3, 4";
		}elseif ($variable=="o3_local_ppt") {
			$sql = "SELECT mes, anio, dia, hora_fin, ica_o3_8h AS dato
					FROM indicador_aire 
					WHERE anio>=$menor AND anio<=$mayor AND estacion=$estacion AND 
						calificacion_o3_8h='".$clasificacion."'
					ORDER BY 1, 2, 3, 4";
		}elseif ($variable=="so2_local_ppt") {
			$sql = "SELECT mes, anio, dia, hora_fin, ica_so2_24h AS dato
					FROM indicador_aire 
					WHERE anio>=$menor AND anio<=$mayor AND estacion=$estacion AND 
						calificacion_so2_24h='".$clasificacion."'
					ORDER BY 1, 2, 3, 4";
		}
		return $objDatos->executeQuery($sql);
	}

	function getCantDatoAire($variable, $estacion, $menor, $mayor){
		$objDatos = new clsDatos();
		$sql = "SELECT COUNT(ica_pm10) AS dato
				FROM indicador_aire 
				WHERE anio>=$menor AND anio<=$mayor AND estacion=$estacion ";
		return $objDatos->executeQuery($sql);
	}

	function datRosaVientsDiur($idEstacion, $anio, $anio2, $mes, $dia){
		$objDatos = new clsDatos();
		$sql= "SELECT n_dia_diurno, nno_dia_diurno, no_dia_diurno, ono_dia_diurno, 
						o_dia_diurno, oso_dia_diurno, so_dia_diurno, sso_dia_diurno, 
						s_dia_diurno, sse_dia_diurno, se_dia_diurno, ese_dia_diurno,  
						e_dia_diurno, ene_dia_diurno, ne_dia_diurno, nne_dia_diurno
						FROM indicador 
						WHERE estacion=".$idEstacion;
		if ($anio2!=null) {
			$sql .= " AND anio>=".$anio." AND anio<=".$anio2;
		}else{
			$sql .= " AND anio=".$anio;
		}
			$sql .= " AND mes=".$mes." AND dia=".$dia;
		return $objDatos->executeQuery($sql);
	}

	function datRosaVientsDiurMes($idEstacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql= "SELECT n_dia_diurno, nno_dia_diurno, no_dia_diurno, ono_dia_diurno, 
						o_dia_diurno, oso_dia_diurno, so_dia_diurno, sso_dia_diurno, 
						s_dia_diurno, sse_dia_diurno, se_dia_diurno, ese_dia_diurno,  
						e_dia_diurno, ene_dia_diurno, ne_dia_diurno, nne_dia_diurno
						FROM indicador 
						WHERE estacion=".$idEstacion;
		if ($anio2!=null) {
			$sql .= " AND anio>=".$anio." AND anio<=".$anio2;
		}else{
			$sql .= " AND anio=".$anio;
		}
			$sql .= " AND mes>0 AND dia>0";
		return $objDatos->executeQuery($sql);
	}

	function datRosaVientsDiurRangAnual($idEstacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql= "SELECT MAX(n_dia_diurno) AS n, MAX(nno_dia_diurno) AS nno, MAX(no_dia_diurno) AS no, 
					MAX(ono_dia_diurno) AS ono, MAX(o_dia_diurno) AS o, MAX(oso_dia_diurno) AS oso, 
					MAX(so_dia_diurno) AS so, MAX(sso_dia_diurno) AS sso, MAX(s_dia_diurno) AS s, 
					MAX(sse_dia_diurno) AS sse, MAX(se_dia_diurno) AS se, MAX(ese_dia_diurno) AS ese, 
					MAX(e_dia_diurno) AS e, MAX(ene_dia_diurno) AS ene, MAX(ne_dia_diurno) AS ne, 
					MAX(nne_dia_diurno) AS nne
						FROM indicador 
						WHERE estacion=".$idEstacion." AND anio>=".$anio." AND anio<=".$anio2.
						" AND mes>0 AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	function datRosaVientsNocRangAnual($idEstacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql= "SELECT MAX(n_dia_nocturno) AS n, MAX(nno_dia_nocturno) AS nno, MAX(no_dia_nocturno) AS no, 
					MAX(ono_dia_nocturno) AS ono, MAX(o_dia_nocturno) AS o, MAX(oso_dia_nocturno) AS oso, 
					MAX(so_dia_nocturno) AS so, MAX(sso_dia_nocturno) AS sso, MAX(s_dia_nocturno) AS s, 
					MAX(sse_dia_nocturno) AS sse, MAX(se_dia_nocturno) AS se, MAX(ese_dia_nocturno) AS ese, 
					MAX(e_dia_nocturno) AS e, MAX(ene_dia_nocturno) AS ene, MAX(ne_dia_nocturno) AS ne, 
					MAX(nne_dia_nocturno) AS nne
						FROM indicador 
						WHERE estacion=".$idEstacion." AND anio>=".$anio." AND anio<=".$anio2." 
						AND mes>0 AND dia=0 ";
		return $objDatos->executeQuery($sql);
	}

function datRosaVientsDiurRangMes($idEstacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql= "SELECT MAX(n_dia_diurno) AS n, MAX(nno_dia_diurno) AS nno, MAX(no_dia_diurno) AS no, 
					MAX(ono_dia_diurno) AS ono, MAX(o_dia_diurno) AS o, MAX(oso_dia_diurno) AS oso, 
					MAX(so_dia_diurno) AS so, MAX(sso_dia_diurno) AS sso, MAX(s_dia_diurno) AS s, 
					MAX(sse_dia_diurno) AS sse, MAX(se_dia_diurno) AS se, MAX(ese_dia_diurno) AS ese, 
					MAX(e_dia_diurno) AS e, MAX(ene_dia_diurno) AS ene, MAX(ne_dia_diurno) AS ne, 
					MAX(nne_dia_diurno) AS nne
						FROM indicador 
						WHERE estacion=".$idEstacion." AND anio>=".$anio." AND anio<=".$anio2.
						" AND mes>0 AND dia>0";
		return $objDatos->executeQuery($sql);
	}

	function datRosaVientsNocRangMes($idEstacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql= "SELECT MAX(n_dia_nocturno) AS n, MAX(nno_dia_nocturno) AS nno, MAX(no_dia_nocturno) AS no, 
					MAX(ono_dia_nocturno) AS ono, MAX(o_dia_nocturno) AS o, MAX(oso_dia_nocturno) AS oso, 
					MAX(so_dia_nocturno) AS so, MAX(sso_dia_nocturno) AS sso, MAX(s_dia_nocturno) AS s, 
					MAX(sse_dia_nocturno) AS sse, MAX(se_dia_nocturno) AS se, MAX(ese_dia_nocturno) AS ese, 
					MAX(e_dia_nocturno) AS e, MAX(ene_dia_nocturno) AS ene, MAX(ne_dia_nocturno) AS ne, 
					MAX(nne_dia_nocturno) AS nne
						FROM indicador 
						WHERE estacion=".$idEstacion." AND anio>=".$anio." AND anio<=".$anio2." 
						AND mes>0 AND dia>0 ";
		return $objDatos->executeQuery($sql);
	}

	function datRosaVientsDiurDia($idEstacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql= "SELECT n_dia_diurno, nno_dia_diurno, no_dia_diurno, ono_dia_diurno, 
						o_dia_diurno, oso_dia_diurno, so_dia_diurno, sso_dia_diurno, 
						s_dia_diurno, sse_dia_diurno, se_dia_diurno, ese_dia_diurno,  
						e_dia_diurno, ene_dia_diurno, ne_dia_diurno, nne_dia_diurno
						FROM indicador 
						WHERE estacion=".$idEstacion;
		if ($anio2!=null) {
			$sql .= " AND anio>=".$anio." AND anio<=".$anio2;
		}else{
			$sql .= " AND anio=".$anio;
		}
			$sql .= " AND mes>0 AND dia>0 ORDER BY mes, dia";
		return $objDatos->executeQuery($sql);
	}

	function datIntLluv($idEstacion, $anio, $mes, $dia){
		$objDatos = new clsDatos();
		$sql= "SELECT int_lluvia_uno_cinco, int_lluvia_uno_diez, int_lluvia_uno_quince, 
						int_lluvia_uno_veinte, int_lluvia_uno_veintecinco, int_lluvia_uno_trenta, 
						int_lluvia_uno_trentacinco, int_lluvia_uno_cuarenta, 
						int_lluvia_uno_cuarentacinco, int_lluvia_uno_cincuenta, 
						int_lluvia_uno_cincuentacinco, int_lluvia_uno_sesenta, int_lluvia_dos_cinco, 
						int_lluvia_dos_diez, int_lluvia_dos_quince, int_lluvia_dos_veinte, 
						int_lluvia_dos_veintecinco, int_lluvia_dos_trenta, int_lluvia_dos_trentacinco, 
						int_lluvia_dos_cuarenta, int_lluvia_dos_cuarentacinco, int_lluvia_dos_cincuenta, 
						int_lluvia_dos_cincuentacinco, int_lluvia_dos_sesenta, int_lluvia_tres_cinco, 
						int_lluvia_tres_diez, int_lluvia_tres_quince, int_lluvia_tres_veinte, 
						int_lluvia_tres_veintecinco, int_lluvia_tres_trenta, int_lluvia_tres_trentacinco, 
						int_lluvia_tres_cuarenta, int_lluvia_tres_cuarentacinco, int_lluvia_tres_cincuenta, 
						int_lluvia_tres_cincuentacinco, int_lluvia_tres_sesenta
						FROM indicador 
						WHERE estacion=".$idEstacion." AND anio=".$anio."
						 AND mes=".$mes." AND dia=".$dia;
		return $objDatos->executeQuery($sql);
	}

	function datRosaVientsNoc($idEstacion, $anio, $anio2, $mes, $dia){
		$objDatos = new clsDatos();
		$sql= "SELECT n_dia_nocturno, nno_dia_nocturno, no_dia_nocturno, ono_dia_nocturno, 
						o_dia_nocturno, oso_dia_nocturno, so_dia_nocturno, sso_dia_nocturno, 
						s_dia_nocturno, sse_dia_nocturno, se_dia_nocturno, ese_dia_nocturno,  
						e_dia_nocturno, ene_dia_nocturno, ne_dia_nocturno, nne_dia_nocturno
						FROM indicador 
						WHERE estacion=".$idEstacion;
		if ($anio2!=null) {
			$sql .= " AND anio>=".$anio." AND anio<=".$anio2;
		}else{
			$sql .= " AND anio=".$anio;
		}
			$sql .= "AND mes=".$mes." AND dia=".$dia;
		return $objDatos->executeQuery($sql);
	}

	function datRosaVientsNocMes($idEstacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql= "SELECT n_dia_nocturno, nno_dia_nocturno, no_dia_nocturno, ono_dia_nocturno, 
						o_dia_nocturno, oso_dia_nocturno, so_dia_nocturno, sso_dia_nocturno, 
						s_dia_nocturno, sse_dia_nocturno, se_dia_nocturno, ese_dia_nocturno,  
						e_dia_nocturno, ene_dia_nocturno, ne_dia_nocturno, nne_dia_nocturno
						FROM indicador 
						WHERE estacion=".$idEstacion;
		if ($anio2!=null) {
			$sql .= " AND anio>=".$anio." AND anio<=".$anio2;
		}else{
			$sql .= " AND anio=".$anio;
		}
			$sql .= "AND mes>0 AND dia>0 ORDER BY mes, dia";
		return $objDatos->executeQuery($sql);
	}

	function datRosaVientsNocDia($idEstacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql= "SELECT n_dia_nocturno, nno_dia_nocturno, no_dia_nocturno, ono_dia_nocturno, 
						o_dia_nocturno, oso_dia_nocturno, so_dia_nocturno, sso_dia_nocturno, 
						s_dia_nocturno, sse_dia_nocturno, se_dia_nocturno, ese_dia_nocturno,  
						e_dia_nocturno, ene_dia_nocturno, ne_dia_nocturno, nne_dia_nocturno
						FROM indicador 
						WHERE estacion=".$idEstacion;
		if ($anio2!=null) {
			$sql .= " AND anio>=".$anio." AND anio<=".$anio2;
		}else{
			$sql .= " AND anio=".$anio;
		}
			$sql .= " AND mes>0 AND dia>0 ORDER BY mes, dia";
		return $objDatos->executeQuery($sql);
	}

	/*******************************************************************************************************
	 *  CAPTURA DE DATOS PARA ELECCION DEL USUARIO
	 ******************************************************************************************************/
	function countRegistros($visible){
		$objDatos = new clsDatos();
		$sql = "SELECT COUNT(f.estacion_sk) AS dato 
				FROM fact_table f, station_dim s 
				WHERE f.estacion_sk=s.estacion_sk";
		if ($visible=='true') {
			$sql .=" AND s.visible='".$visible."'";
		}
		return $objDatos->executeQuery($sql);
	}
	
	function countRegistrosAire($visible){
		$objDatos = new clsDatos();
		$sql = "SELECT COUNT(f.estacion_sk) AS dato 
				FROM fact_aire f, station_dim s 
				WHERE f.estacion_sk=s.estacion_sk";
		if ($visible=='true') {
			$sql .=" AND s.visible='".$visible."'";
		}
		return $objDatos->executeQuery($sql);
	}

	function getEstacionClima($visible){
		$objDatos = new clsDatos();
		$sql = "SELECT DISTINCT estacion_sk as id, estacion as nombre, municipio as municipio 
				FROM station_dim s
				WHERE tipologia!='CA' "; # AND s.visible='".$visible."'";/*";
		if ($visible=='true') {
			$sql .=" AND s.visible='".$visible."'";
		}
		$sql .= "ORDER BY nombre";
		return $objDatos->executeQuery($sql);
	}

	function getEstacionOrderId($visible){
		$objDatos = new clsDatos();
		$sql = "SELECT s.estacion_sk as id, s.estacion as nombre, COUNT(f.estacion_sk) as cant,
					red, tipologia, municipio, ubicacion, latitud, longitud, altitud, propietario, inicio_funcionamiento, 
					fin_funcionamiento, observacion, cuenca, subcuenca
				FROM fact_table f, station_dim s
				WHERE f.estacion_sk=s.estacion_sk";
		if ($visible=='true') {
			$sql .=" AND s.visible='".$visible."'";
		}
		$sql .= " GROUP BY 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 "
                        . "ORDER BY municipio, tipologia ";
		#echo $sql;
		$resultado = $objDatos->executeQuery($sql);
		$sql = "SELECT s.estacion_sk as id, s.estacion as nombre, COUNT(f.estacion_sk) as cant,
					red, tipologia, municipio, ubicacion, latitud, longitud, altitud, propietario, inicio_funcionamiento, 
					fin_funcionamiento, observacion, cuenca, subcuenca
				FROM fact_aire f, station_dim s
				WHERE f.estacion_sk=s.estacion_sk";
		if ($visible=='true') {
			$sql .=" AND s.visible='".$visible."'";
		}
		$sql .= " GROUP BY 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 ORDER BY municipio, tipologia ";
		#echo $sql;
		$datos=$objDatos->executeQuery($sql);
		foreach ($datos as $key) {
			# code...
			array_push($resultado,$key);
		}
		#echo var_dump($resultado);
		return $resultado;
	}

	function getEstacion(){
		$objDatos = new clsDatos();
		$sql = "SELECT DISTINCT estacion_sk as id, estacion as nombre 
				FROM station_dim 
				ORDER BY nombre";
		return $objDatos->executeQuery($sql);
	}

	/*function getEstacionVar(){
		$objDatos = new clsDatos();
		$sql = "SELECT DISTINCT id_variable as id, nombre as nombre 
				FROM variable 
				WHERE tipologia='Aire'
				ORDER BY nombre";
		return $objDatos->executeQuery($sql);
	}*/
        
        
	function getEstacionVar(){
		$objDatos = new clsDatos();
		$sql = "SELECT DISTINCT id_variable as id, nombre as nombre 
				FROM variable 
				WHERE tipologia='Aire' AND nombre<>'co'
				ORDER BY nombre";
		return $objDatos->executeQuery($sql);
	}

	function getVarAire($idVariable){
		$objDatos = new clsDatos();
		$sql = "SELECT nombre as nombre, variable_fact as variable 
				FROM variable 
				WHERE id_variable=$idVariable";
		return $objDatos->executeQuery($sql);
	}

	function getEstacionAire(){
		$objDatos = new clsDatos();
		$sql = "SELECT DISTINCT estacion_sk as id, estacion as nombre 
				FROM station_dim 
				WHERE tipologia!='CA'
				ORDER BY nombre";
		return $objDatos->executeQuery($sql);
	}

	function getEstacionVarAire($variable){
		$objDatos = new clsDatos();
		$sql = "SELECT variable_fact FROM variable WHERE id_variable=".$variable;
		$variable = $objDatos->executeQuery($sql);
		$variable = $variable[0]['variable_fact'];
		$sql = "SELECT DISTINCT station_dim.estacion_sk as id, estacion as nombre, municipio as municipio  
				FROM station_dim, fact_aire 
				WHERE station_dim.tipologia='CA' AND fact_aire.$variable IS NOT NULL 
					AND station_dim.estacion_sk=fact_aire.estacion_sk
				ORDER BY nombre";
		return $objDatos->executeQuery($sql);
	}

	function getTiempoDato($var, $estacion, $anio, $anio2, $mes, $dia){
		$objDatos = new clsDatos();
		$sql = "SELECT ";
		if ($dia==null && $mes!=null) {
			$sql .= "dia AS dia";
		}elseif ($dia!=null && $mes!=null) {
			$sql .= "tiempo AS dia";
		}else{
			$sql .= "mes AS dia";
		}
		if ($anio2!=null) {
			if ($dia!=null) {
				$sql .= ", d.año AS año";
			}else{
				$sql .= ", anio AS año";
			}
		}
		if ($var==1) {
			if ($dia!=null && $mes!=null) {
				$sql .=', temperatura ';
			}else{
				$sql .=', tmax AS maximo, tmin AS minimo, tmed ';
			}
	    }elseif ($var==2) {
			if ($dia!=null && $mes!=null) {
				$sql .=', temperatura ';
			}else{
				$sql .=', trango';
			}
	    }elseif ($var==3) {
			if ($dia!=null && $mes!=null) {
				$sql .=', precipitacion ';
			}else{
				$sql .=', ppt';
			}
	    }elseif ($var==4) {
			if ($dia!=null && $mes!=null) {
				$sql .=', precipitacion ';
			}else{
				$sql .=', ac_25';
			}
	    }elseif ($var==5) {
			if ($dia!=null && $mes!=null) {
				$sql .=', velocidad_viento AS velocidad, direccion_viento ';
			}else{
				$sql .=', max_vv AS maxima, med_vv AS media, frec_dv_diurno AS diurna, frec_dv_nocturno ';
			}
	    }elseif ($var==6) {
			if ($dia!=null ) {#&& $mes!=null) {
				$sql .=', humedad_relativa ';
			}else{
				$sql .=', max_hr AS maximo, min_hr AS minimo, med_hr';
			}
	    }elseif ($var==7) {
			if ($dia!=null && $mes!=null) {
				$sql .=', radiacion_solar ';//calcular minimo ya tiene el maximo
			}else{
				$sql .=', max_rs AS maximo, med_rs ';
			}
	    }elseif ($var==8) {
			if ($dia!=null && $mes!=null) {
				$sql .=', presion_barometrica ';//calcular maximo, minimo
			}else{
				$sql .=', max_pb AS maximo, min_pb AS minimo, med_pb';
			}
	    }elseif ($var==9) {
			if ($dia!=null && $mes!=null) {
				$sql .=', presion_barometrica ';
			}else{
				$sql .=', ci';
			}
	    }elseif ($var==10) {
			if ($dia!=null && $mes!=null) {
				$sql .=', precipitacion ';
			}else{
				$sql .=', isp';
			}
	    }elseif ($var==11) {
			if ($dia!=null && $mes!=null) {
				$sql .=', presion_barometrica ';
			}else{
				$sql .=', indice_martonne';
			}
	    }
		$sql .= " AS dato ";
		if ($dia==null && $mes!=null) {
			$sql .= "FROM indicador ";
			if ($anio!=null){
				if ($anio2!=null) {
					$sql .= "WHERE anio>=".$anio." AND anio<=".$anio2;
				}else{
					$sql .= "WHERE anio=".$anio;
				}
			}elseif ($anio2!=null) {
				$sql .= "WHERE anio=".$anio2;
			}
			$sql .=" AND estacion=".$estacion." AND dia>0 AND mes=".$mes;
		}elseif ($dia!=null && $mes!=null) {
			$sql .= "FROM fact_table f, time_dim t, date_dim d ";
			$sql .=	"WHERE f.tiempo_sk=t.tiempo_sk AND f.fecha_sk=d.fecha_sk AND ";
			if ($anio!=null){
				if ($anio2!=null) {
					$sql .= "d.año>=".$anio." AND d.año<=".$anio2;
				}else{
					$sql .= "d.año=".$anio;
				}
			}elseif ($anio2!=null) {
				$sql .= "d.año=".$anio2;
			}
			$sql .= " AND f.estacion_sk=".$estacion." AND dia=".$dia." AND mes=".$mes;
		}else{
			$sql .= "FROM indicador ";
			if ($anio!=null){
				if ($anio2!=null) {
					$sql .= "WHERE anio>=".$anio." AND anio<=".$anio2;
				}else{
					$sql .= "WHERE anio=".$anio;
				}
			}elseif ($anio2!=null) {
				$sql .= "WHERE anio=".$anio2;
			}
			$sql .= " AND estacion=".$estacion." AND dia=".$dia." AND mes>".$mes;
		}
		$sql .= " ORDER BY ";
		if ($anio2!=null) {
			$sql .= "2, 1";
		}else{
			$sql .= "1";
		}

		#echo $sql;
		return $objDatos->executeQuery($sql);
	}

	function velVientoRangoAnual($var, $estacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql = "SELECT anio AS año, mes AS mes, max_vv AS maxima, med_vv AS media 
				FROM indicador 
				WHERE anio>=".$anio." AND anio<=".$anio2."
				AND estacion=".$estacion." AND dia=0 AND mes>0 
				ORDER BY 1, 2";
		return $objDatos->executeQuery($sql);
	}

	function velVientoRangoMes($var, $estacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql = "SELECT anio AS año, mes AS mes, dia AS dia, max_vv AS maxima, med_vv AS media 
				FROM indicador 
				WHERE anio>=".$anio." AND anio<=".$anio2."
				AND estacion=".$estacion." AND dia>0 AND mes>0 
				ORDER BY 1, 2, 3";
		return $objDatos->executeQuery($sql);
	}

	function getTiempoDatoMes($var, $estacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql = "SELECT dia AS dia, mes AS mes, anio AS año";
		if ($var==1) {
			$sql .=', tmax AS maximo, tmin AS minimo, tmed ';
	    }elseif ($var==2) {
			$sql .=', trango';
	    }elseif ($var==3) {
			$sql .=', ppt';
	    }elseif ($var==4) {
			$sql .=', ac_25';
	    }elseif ($var==5) {
			$sql .=', max_vv AS maxima, med_vv AS media, frec_dv_diurno AS diurna, frec_dv_nocturno ';
	    }elseif ($var==6) {
			$sql .=', max_hr AS maximo, min_hr AS minimo, med_hr';
	    }elseif ($var==7) {
			$sql .=', max_rs AS maximo, med_rs ';
	    }elseif ($var==8) {
			$sql .=', max_pb AS maximo, min_pb AS minimo, med_pb';
	    }elseif ($var==9) {
			$sql .=', ci';
	    }elseif ($var==10) {
			$sql .=', isp';
	    }elseif ($var==11) {
			$sql .=', indice_martonne';
	    }
		$sql .= " AS dato FROM indicador ";
		if ($anio!=null){
			if ($anio2!=null) {
				$sql .= "WHERE anio>=".$anio." AND anio<=".$anio2;
			}else{
				$sql .= "WHERE anio=".$anio;
			}
		}elseif ($anio2!=null) {
			$sql .= "WHERE anio=".$anio2;
		}
		$sql .=" AND estacion=".$estacion." AND mes>0 AND dia>0 ORDER BY 1, 2, 3 ";
		return $objDatos->executeQuery($sql);
	}

	function getTiempoDatoRangoMes($var, $estacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql = "SELECT dia AS dia, mes AS mes, anio AS año";
		if ($var==1) {
			$sql .=', tmax AS maximo, tmin AS minimo, tmed ';
	    }elseif ($var==2) {
			$sql .=', trango';
	    }elseif ($var==3) {
			$sql .=', ppt';
	    }elseif ($var==4) {
			$sql .=', ac_25';
	    }elseif ($var==5) {
			$sql .=', max_vv AS maxima, med_vv AS media, frec_dv_diurno AS diurna, frec_dv_nocturno ';
	    }elseif ($var==6) {
			$sql .=', max_hr AS maximo, min_hr AS minimo, med_hr';
	    }elseif ($var==7) {
			$sql .=', max_rs AS maximo, med_rs ';
	    }elseif ($var==8) {
			$sql .=', max_pb AS maximo, min_pb AS minimo, med_pb';
	    }elseif ($var==9) {
			$sql .=', ci';
	    }elseif ($var==10) {
			$sql .=', isp';
	    }elseif ($var==11) {
			$sql .=', indice_martonne';
	    }
		$sql .= " AS dato FROM indicador WHERE anio>=".$anio." AND anio<=".$anio2." 
				AND estacion=".$estacion." AND mes>0 AND dia>0 
				ORDER BY 3, 2, 1 ";
		return $objDatos->executeQuery($sql);
	}

	function getTiempoDatoDia($var, $estacion, $anio, $anio2){
		$objDatos = new clsDatos();
		$sql = "SELECT d.dia AS dia, d.mes AS mes, d.año AS año, t.tiempo AS tiempo";
		if ($var==1 || $var==2) {
			$sql .=', temperatura ';
	    }elseif ($var==3 || $var==4) {
			$sql .=', precipitacion ';
	    }elseif ($var==5) {
			$sql .=', velocidad_viento ';
	    }elseif ($var==6) {
			$sql .=', humedad_relativa ';
	    }elseif ($var==7) {
	    	$sql .=', radiacion_solar ';//calcular minimo ya tiene el maximo
	    }elseif ($var==8 || $var==9 || $var==11) {
				$sql .=', presion_barometrica ';//calcular maximo, minimo
		}elseif ($var==10) {
			$sql .=', precipitacion ';
		}
		$sql .= " AS dato 
					FROM fact_table f, time_dim t, date_dim d 
					WHERE f.tiempo_sk=t.tiempo_sk AND f.fecha_sk=d.fecha_sk AND 
							d.año>=".$anio." AND d.año<=".$anio2.
							" AND f.estacion_sk=".$estacion.
					" ORDER BY 1, 2, 3, 4";
		return $objDatos->executeQuery($sql);
	}

	function getCant($estacion){
		$objDatos = new clsDatos();
		$sql = "SELECT COUNT(estacion_sk) AS dato FROM fact_table 
				WHERE fact_table.estacion_sk='".$estacion."'";
		return $objDatos->executeQuery($sql);
	}

	function getFechaMin($estacion){
		$objDatos = new clsDatos();
		$sql = "SELECT MIN(fecha) AS dato FROM fact_table, date_dim 
				WHERE fact_table.fecha_sk=date_dim.fecha_sk 
				AND fact_table.estacion_sk=". $estacion;
		return $objDatos->executeQuery($sql);
	}

	function getFechaMax($estacion){
		$objDatos = new clsDatos();
		$sql = "SELECT MAX(fecha) AS dato FROM fact_table, date_dim 
				WHERE fact_table.fecha_sk=date_dim.fecha_sk 
				AND fact_table.estacion_sk=".$estacion;
		return $objDatos->executeQuery($sql);
	}

	/**************************************************************************************
	utilizado por consultarDataStation.php
	****************************************************************************************/
	function getEstacionVariable($estacion){
		$objDatos = new clsDatos();
		$sql = "SELECT DISTINCT v.estacion_sk as id, s.nombre_estacion as nombre
				FROM esta_var v, estacion s
				WHERE v.estacion_sk=s.estacion_sk and v.id_variable=".$estacion." ORDER BY nombre";
		return $objDatos->executeQuery($sql);
	}

	/**************************************************************************************
	utilizado por consultarDataDim.php
	****************************************************************************************/
	function getAno($estacion){
		$objDatos = new clsDatos();
		$sql = "SELECT DISTINCT año as nombre 
				FROM date_dim, fact_table 
				WHERE fact_table.fecha_sk = date_dim.fecha_sk  
					AND fact_table.estacion_sk =".$estacion." ORDER BY nombre";
		return $objDatos->executeQuery($sql);
		//return $sql;
	}

	function getAnoAire($estacion, $variable){
		$objDatos = new clsDatos();
		$sql = "SELECT variable_fact FROM variable WHERE id_variable=".$variable;
		$variable = $objDatos->executeQuery($sql);
		$variable = $variable[0]['variable_fact'];
		$sql = "SELECT DISTINCT año as nombre 
				FROM date_dim, fact_aire 
				WHERE fact_aire.fecha_sk = date_dim.fecha_sk  
					AND fact_aire.estacion_sk =".$estacion." AND $variable IS NOT NULL ORDER BY nombre";
		#print_r($sql);
		return $objDatos->executeQuery($sql);
	}

	function nombreVarAire($estacion, $variable){
		$objDatos = new clsDatos();
		$sql = "SELECT variable_fact FROM variable WHERE id_variable=".$variable;
		$variable = $objDatos->executeQuery($sql);
		$variable = $variable[0]['variable_fact'];
		return $variable;
	}

	/**************************************************************************************
	utilizado por consultarFactTable.php  y consultarVariablesIndicador.php
	****************************************************************************************/
	function countVariable($estacion, $anio1, $anio2, $mes1, $mes2, $dia1, $dia2) {
		$objDatos = new clsDatos();
		$sql = "SELECT COUNT(precipitacion) AS precipitacion, COUNT(temperatura) AS temperatura,
				COUNT(temperatura_max) AS temperatura_max, COUNT(temperatura_min) AS temperatura_min,
				COUNT(temperatura_med) AS temperatura_med, COUNT(brillo) AS brillo, 
				COUNT(humedad_relativa) AS humedad_relativa, COUNT(nivel) AS nivel,
				COUNT(caudal) AS caudal, COUNT(velocidad_viento) AS velocidad_viento,
				COUNT(direccion_viento) AS direccion_viento, COUNT(presion_barometrica) AS presion_barometrica,
				COUNT(evapotranspiracion) AS evapotranspiracion, COUNT(radiacion_solar) AS radiacion_solar
				FROM fact_table, date_dim
				WHERE fact_table.estacion_sk='" . $estacion . "' 
					AND (fact_table.precipitacion IS NOT NULL or fact_table.temperatura IS NOT NULL 
						or fact_table.temperatura_max IS NOT NULL or fact_table.temperatura_min IS NOT NULL 
						or fact_table.temperatura_med IS NOT NULL or fact_table.brillo IS NOT NULL
						or fact_table.humedad_relativa IS NOT NULL or fact_table.nivel IS NOT NULL
						or fact_table.caudal IS NOT NULL or fact_table.velocidad_viento IS NOT NULL
						or fact_table.direccion_viento IS NOT NULL or fact_table.presion_barometrica IS NOT NULL
						or fact_table.evapotranspiracion IS NOT NULL or fact_table.radiacion_solar IS NOT NULL)
					AND fact_table.fecha_sk = date_dim.fecha_sk ";
			/*******************************************************************************
			hacer un pre procesamiento antes para identificar la fecha_sk que esta consultando
			y disminuir el producto carteciano
			***********************************************************************/
		if($anio1 != null){
			if ($anio2 != null){
				$menor = $anio1;
				$mayor = $anio2;
				if ($menor > $anio2) {
					$menor = $anio2;
					$mayor = $anio1;
				}
				$sql = $sql." AND date_dim.año >= '$menor' AND date_dim.año <= '$mayor'";
			}else{
				$sql = $sql." AND date_dim.año='$anio1'";
			}
		}elseif ($anio2 != null){
			$sql = $sql." AND date_dim.año='$anio2'";
		}
		if (($anio1 == null && $anio2 != null) || ($anio1 != null && $anio2 == null)) {
			$banderaAño = "true";
		}else{
			$banderaAño = "false";
		}
		if($mes1 != null && $banderaAño  == "true" && ($dia1 == null || $dia2 == null)){
			if ($mes2 != null && $banderaAño  == "true" && ($dia1 == null || $dia2 == null)){
				$menor = $mes1;
				$mayor = $mes2;
				if ($menor > $mes2) {
					$menor = $mes2;
					$mayor = $mes1;
				}
				$sql = $sql." AND date_dim.mes >= '$menor' AND date_dim.mes <= '$mayor'";
			}elseif ($mes2 != null && $banderaAño == "false") {
				$menor = $anio1;
				$mayor = $anio2;
				if ($menor > $anio2) {
					$menor = $anio2;
					$mayor = $anio1;
				}
				$fechaMenor = $menor."-".$mes1."-01";
				$mes3 = $mes2+1;
				$fechaMayor = $mayor."-".$mes3."-01";
				$sql = $sql." AND date_dim.fecha >= '$fechaMenor' AND date_dim.fecha <= '$fechaMayor'";
			}else{
				$sql = $sql." AND date_dim.mes='$mes1'";
			}
		}elseif ($mes2 != null && $banderaAño == "true" && ($dia1 == null || $dia2 == null)) {
			$sql = $sql." AND date_dim.mes='$mes2'";
		}
		if (($mes1 == null && $mes2 != null) || ($mes1 != null && $mes2 == null)) {
			$banderaMes = "true";
		}else{
			$banderaMes = "false";
		}
		if ($dia1 != null) {
			if ($dia2 != null && $banderaAño  == "true" && $banderaMes == "true") {
				$menor = $dia1;
				$mayor = $dia2;
				if ($menor > $dia2) {
					$menor = $dia2;
					$mayor = $dia1;
				}
				$sql .= " AND date_dim.dia >='$menor' AND date_dim.dia <='$mayor'";
			}elseif ($dia2 != null && $banderaAño  == "false") {
				$menor = $anio1;
				$mayor = $anio2;
				if ($menor > $anio2) {
					$menor = $anio2;
					$mayor = $anio1;
				}
				$fechaMenor = $menor."-".$mes1."-".$dia1;
				$fechaMayor = $mayor."-".$mes2."-".$dia2;
				$sql = $sql." AND date_dim.fecha >= '$fechaMenor' AND date_dim.fecha <= '$fechaMayor'";
			}else{
				$sql .= " AND date_dim.dia='$dia1'";
			}
		}elseif ($dia2 != null && $banderaAño == "true" && $banderaMes = "true") {
			$sql .= " AND date_dim.dia='$dia2'";
		}
		return $objDatos->executeQuery($sql);
	}

	/**************************************************************************************
	utilizado por consultarDataDimMes.php
	****************************************************************************************/
	function getMes($estacion, $anio1, $anio2){	
		$objDatos = new clsDatos();
		$sql = "SELECT DISTINCT mes AS num, nombremes AS nombre 
				FROM date_dim, fact_table 
				WHERE fact_table.fecha_sk = date_dim.fecha_sk 
					AND fact_table.estacion_sk = '".$estacion."'";
		if($anio1 != null){
			if ($anio2 != null){
				$menor = $anio1;
				$mayor = $anio2;
				if ($menor > $anio2) {
					$menor = $anio2;
					$mayor = $anio1;
				}
				$sql = $sql." AND date_dim.año >= '$menor' AND date_dim.año <= '$mayor'";
			}else{
				$sql = $sql." AND date_dim.año='$anio1'";
			}
		}elseif ($anio2 != null){
        	$sql = $sql." AND date_dim.año='$anio2'";
		}
		$sql = $sql." ORDER BY num";
		return $objDatos->executeQuery($sql);
	}

	function getMesAire($estacion, $anio1, $anio2, $variable){	
		$objDatos = new clsDatos();
		$sql = "SELECT variable_fact FROM variable WHERE id_variable=".$variable;
		$variable = $objDatos->executeQuery($sql);
		$variable = $variable[0]['variable_fact'];

		$sql = "SELECT DISTINCT mes AS num, nombremes AS nombre 
				FROM date_dim, fact_aire 
				WHERE fact_aire.fecha_sk = date_dim.fecha_sk 
					AND fact_aire.estacion_sk = '".$estacion."'";
		$sql = $sql." ORDER BY num";
		return $objDatos->executeQuery($sql);
	}

	/**************************************************************************************
	utilizado por consultarDataDimDia.php
	****************************************************************************************/
	function getDia($estacion, $anio1, $anio2, $mes1, $mes2){
		$objDatos = new clsDatos();	
		$sql = "SELECT DISTINCT dia AS nombre 
				FROM date_dim, fact_table 
				WHERE fact_table.fecha_sk = date_dim.fecha_sk 
				AND fact_table.estacion_sk = '".$estacion."'";
		if($anio1 != null){
			if ($anio2 != null){
				$menor = $anio1;
				$mayor = $anio2;
				if ($menor > $anio2) {
					$menor = $anio2;
					$mayor = $anio1;
				}
				$sql = $sql." AND date_dim.año >= '$menor' AND date_dim.año <= '$mayor'";
			}else{
				$sql = $sql." AND date_dim.año='$anio1'";
			}
		}elseif ($anio2 != null){
			$sql = $sql." AND date_dim.año='$anio2'";
		}
		if (($anio1 == null && $anio2 != null) || ($anio1 != null && $anio2 == null)) {
			$banderaAño = "true";
		}else{
			$banderaAño = "false";
		}
		if($mes1 != null && $banderaAño  == "true" && ($dia1 == null || $dia2 == null)){
			if ($mes2 != null && $banderaAño  == "true" && ($dia1 == null || $dia2 == null)){
				$menor = $mes1;
				$mayor = $mes2;
				if ($menor > $mes2) {
					$menor = $mes2;
					$mayor = $mes1;
				}
				$sql = $sql." AND date_dim.mes >= '$menor' AND date_dim.mes <= '$mayor'";
			}elseif ($mes2 != null && $banderaAño == "false") {
				$menor = $anio1;
				$mayor = $anio2;
				if ($menor > $anio2) {
					$menor = $anio2;
					$mayor = $anio1;
				}
				$fechaMenor = $menor."-".$mes1."-01";
				$mes3 = $mes2+1;
				$fechaMayor = $mayor."-".$mes3."-01";
				$sql = $sql." AND date_dim.fecha >= '$fechaMenor' AND date_dim.fecha <= '$fechaMayor'";
			}else{
				$sql = $sql." AND date_dim.mes='$mes1'";
			}
		}elseif ($mes2 != null && $banderaAño == "true" && ($dia1 == null || $dia2 == null)) {
			$sql = $sql." AND date_dim.mes='$mes2'";
		}
		$sql = $sql." ORDER BY nombre";
		return $objDatos->executeQuery($sql);
	}

	function getDiaAire($estacion, $anio1, $anio2, $mes1, $mes2, $variable){
		$objDatos = new clsDatos();	
		$sql = "SELECT variable_fact FROM variable WHERE id_variable=".$variable;
		$variable = $objDatos->executeQuery($sql);
		$variable = $variable[0]['variable_fact'];
		$sql = "SELECT DISTINCT dia AS nombre 
				FROM date_dim, fact_aire 
				WHERE fact_aire.fecha_sk = date_dim.fecha_sk  AND fact_aire.$variable IS NOT NULL 
				AND fact_aire.estacion_sk = '".$estacion."'";
		if($anio1 != null){
			if ($anio2 != null){
				$menor = $anio1;
				$mayor = $anio2;
				if ($menor > $anio2) {
					$menor = $anio2;
					$mayor = $anio1;
				}
				$sql = $sql." AND date_dim.año >= '$menor' AND date_dim.año <= '$mayor'";
			}else{
				$sql = $sql." AND date_dim.año='$anio1'";
			}
		}elseif ($anio2 != null){$sql = $sql." AND date_dim.año='$anio2'";}
		if (($anio1 == null && $anio2 != null) || ($anio1 != null && $anio2 == null)) {
			$banderaAño = "true";
		}else{
			$banderaAño = "false";
		}
		if($mes1 != null && $banderaAño  == "true" && ($dia1 == null || $dia2 == null)){
			if ($mes2 != null && $banderaAño  == "true" && ($dia1 == null || $dia2 == null)){
				$menor = $mes1;
				$mayor = $mes2;
				if ($menor > $mes2) {
					$menor = $mes2;
					$mayor = $mes1;
				}
				$sql = $sql." AND date_dim.mes >= '$menor' AND date_dim.mes <= '$mayor'";
			}elseif ($mes2 != null && $banderaAño == "false") {
				$menor = $anio1;
				$mayor = $anio2;
				if ($menor > $anio2) {
					$menor = $anio2;
					$mayor = $anio1;
				}
				$fechaMenor = $menor."-".$mes1."-01";
				$mes3 = $mes2+1;
				$fechaMayor = $mayor."-".$mes3."-01";
				$sql = $sql." AND date_dim.fecha >= '$fechaMenor' AND date_dim.fecha <= '$fechaMayor'";
			}else{
				$sql = $sql." AND date_dim.mes='$mes1'";
			}
		}elseif ($mes2 != null && $banderaAño == "true" && ($dia1 == null || $dia2 == null)) {
			$sql = $sql." AND date_dim.mes='$mes2'";
		}
		$sql = $sql." ORDER BY nombre";
		return $objDatos->executeQuery($sql);
	}

	/**************************************************************************************
	utilizado por generarIndicador.php
	****************************************************************************************/

	//Verificar existencio o generar datos POR DIA de tmax, tmin y tmed en tabla indicador
	function garantizarTempsDiaIndicador($idEstacion, $idAno, $variable){
		//Capturando la cantidad de los datos que existen en la tabla indicadores
		$arreglo_temp_indicador = cantDatosTemps($idEstacion, $idAno);
		if ($arreglo_temp_indicador) {
			foreach ($arreglo_temp_indicador as $value) {
				$tamMax = $value['maxi']; $tamMin = $value['mini']; $tamMed = $value['promedio'];
			}
		}
		//si no existe
		if ($tamMax < 1 && $tamMin < 1 && $tamMed < 1) {
			//obtiene el mes mas alto que existe se obtienen de la fact_table y date_dim
			$limtMes = mesMaximoFact($idEstacion, $idAno);
			for ($mes=1; $mes <= $limtMes; $mes++) { 
				//verificando si ya existen los datos por dia en la tabla fact_table
				$arreglo_temp = cantTempsFact($idEstacion, $idAno, $mes);
				if ($arreglo_temp) {
					foreach ($arreglo_temp as $value) {
						$tamMaxDia = $value['max']; $tamMinDia = $value['min']; $tamMedDia = $value['med'];
					}
				}
				//Si los datos ya existen en la fact_table, solo se copian en la tabla indicador (si no se calculan)
				if ($tamMaxDia > 0 && $tamMinDia > 0 && $tamMedDia > 0) {
					//obtiene el dia mas alto que existe se obtienen de la fact_table y date_dim
					$limtDia = diaMaximoFact($idEstacion, $idAno, $mes);
					for ($dia=1; $dia <= $limtDia; $dia++) { 
						//si ya esta generado entonces se carga en la tabla indicadores
						$arreglo_tempMaxDia = extraTempsFact($idEstacion, $idAno, $mes, $dia);
						//generar el insert y copiar el dato de la fact_table a la tabla indicador
						#if ($arreglo_tempMaxDia) {
							copyTempFactIndicador($arreglo_tempMaxDia, $idEstacion, $variable, $idAno, $mes);
						#}
					}
				}else{
					//Si no existan ya en la fact_table, se calculan -- llamar todos los del dia, 
					//obtiene el dia mas alto que existe se obtienen de la fact_table y date_dim
					$limtDia = diaMaximoFact($idEstacion, $idAno, $mes);
					for ($dia=1; $dia <= $limtDia; $dia++) { 
						//obtener calculos de temperatudara del dia
						$arreglo_calc_temp = calculoTempsDiaFact($idEstacion, $idAno, $mes, $dia);
						//insertar datos calculados en la tabla indicador
						if ($arreglo_calc_temp) {
							foreach ($arreglo_calc_temp as $value) {
								$cantTempe = $value['cant'];
							}
						}
						if ($cantTempe > 0) {
							if ( yaExisteEstacion($idEstacion, $idAno, $mes, $dia) ) {
								updateIndicador($arreglo_calc_temp, $idEstacion, $variable, $idAno, $mes, $dia);
							}else{
								insertIndicador($arreglo_calc_temp, $idEstacion, $variable, $idAno, $mes, $dia);
							}
						}
					}
				}
			}
		}
	}

	//Verificar existencio o generar datos POR MES de tmax, tmin y tmed en tabla indicador
	function garantizarTempsMesIndicador($idEstacion, $idAno, $variable){
		//limite de meses que existen en la bd
		$limtMes = mesMaximoIndicador($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
			$arreglo_temp_mes = cantTempsIndicador($idEstacion, $idAno, $mes);
			if ($arreglo_temp_mes) {
				foreach ($arreglo_temp_mes as $value) {
					$tamMaxMes = $value['maxi']; $tamMinMes = $value['mini']; $tamMedMes = $value['promedio'];
				}
			}
			if ($tamMaxMes < 1 && $tamMinMes < 1 && $tamMedMes < 1) {
				//obtener calculos del mes
				$arreglo_calc_temp_mes = obtenerDatosTempsIndicador($idEstacion, $idAno, $mes);
				//insertar datos calculados en la tabla indicador
				//insertar los calculos del mes
				if ( yaExisteEstacion($idEstacion, $idAno, $mes, 0) ) {
					updateTempsMesIndicador($arreglo_calc_temp_mes, $idEstacion, $variable, $idAno, $mes);
				}else{
					insertTempsMesIndicador($arreglo_calc_temp_mes, $idEstacion, $variable, $idAno, $mes);
				}
			}
		}
	}

	//nombre de una estacion 
	function getNombreEstacion($idEstacion){
		$objDatos = new clsDatos();	
		$sql = "SELECT estacion FROM station_dim WHERE estacion_sk=".$idEstacion;
		$datos_desordenados = $objDatos->hacerConsulta($sql);
		$arreglo_estacion = $objDatos->generarArreglo($datos_desordenados);
		$nombEstacion = $arreglo_estacion[0];
		return $nombEstacion;
	}

	//Retorna la cantidad de datos que hay en esa estacion, ese año, y segun la variable en tabla indicador
	function cantDatos($idEstacion, $variable, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT COUNT(id_estacion) FROM estacion_indicador WHERE id_estacion=".$idEstacion." 
				AND tipo_ind=".$variable." AND anio=".$idAno." AND dia=0";
		$datos_desordenados = $objDatos->hacerConsulta($sql);
		$arreglo_existe = $objDatos->generarArreglo($datos_desordenados);
		$existenDatos = $arreglo_existe[0];
		return $existenDatos;
	}
	
	//retorna la cantidad de datos de las temperaturas segun la estacion y el año, en tabla indicador 
	function cantDatosTemps($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT COUNT(tmax) AS maxi, COUNT(tmin) AS mini, COUNT(tmed) AS promedio
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno;
		return $objDatos->executeQuery($sql);
	}

	//Cantidad de datos de las temperaturas diarias si existen en la tabla de h##echos 
	function cantTempsFact($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT COUNT(temperatura_max) AS max, COUNT(temperatura_min) AS min, 
				COUNT(temperatura_med) AS med
				FROM fact_table, date_dim
				WHERE fact_table.estacion_sk=".$idEstacion." AND fact_table.fecha_sk=date_dim.fecha_sk 
				AND date_dim.año=".$idAno." AND date_dim.mes=".$mes;
		return $objDatos->executeQuery($sql);
	}

	//Extraer datos de las temp que ya existen en la fact_table
	function extraTempsFact($idEstacion, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		$sql = "SELECT dia AS dia, 
						MAX(temperatura_max) AS max, 
						MIN(temperatura_min) AS min, 
						AVG(temperatura_med) AS med 
				FROM fact_table, date_dim
				WHERE fact_table.temperatura_med is not null and fact_table.estacion_sk=".$idEstacion." 
					AND fact_table.fecha_sk=date_dim.fecha_sk 
					AND date_dim.año=".$idAno." AND date_dim.mes=".$mes." AND date_dim.dia=".$dia." 
					GROUP BY 1";
		return $objDatos->executeQuery($sql);
	}

	//Copiar datos fact_table y escibirlos en la tabla indicador SOLO TEMPERATURAS
	function copyTempFactIndicador($arreglo_tempMaxDia, $idEstacion, $variable, $idAno, $mes){
		$objDatos = new clsDatos();	
		if ($arreglo_tempMaxDia) {
			$sql= "INSERT INTO indicador (estacion, anio, mes, dia, tmax, tmin, tmed) 
					VALUES ";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_tempMaxDia as $value) {
				$sql .= "(".$idEstacion.", ".$idAno.", ".$mes.", ".$value['dia'].", ".$value['max'].", ".
					$value['min'].", ".$value['med']."), ";
				$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$value['dia']."), ";
			}
		}
		$sql = rtrim($sql,", ");
		$sql2 = rtrim($sql2,", ");
		$objDatos->operacionesCrud($sql);
		$objDatos->operacionesCrud($sql2);
	}

	//Se obtiene el mes mas grande de los datos registrados en fact_Table
	function mesMaximoFact($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT max(mes) 
				FROM fact_table, date_dim 
				WHERE fact_table.estacion_sk=".$idEstacion." 
					AND fact_table.fecha_sk=date_dim.fecha_sk 
					AND date_dim.año=".$idAno;
		$datos_desordenados = $objDatos->hacerConsulta($sql);
		$arreglo_mes = $objDatos->generarArreglo($datos_desordenados);
		$limtMes = $arreglo_mes[0];
		return $limtMes;
	}

	//Se obtiene el mes mas grande de los datos registrados en indicador
	function mesMaximoIndicador($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT max(mes) 
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno;
		$datos_desordenados = $objDatos->hacerConsulta($sql);
		$arreglo_mes = $objDatos->generarArreglo($datos_desordenados);
		$limtMes = $arreglo_mes[0];
		return $limtMes;
	}

	//Se obtiene el dia mas grande del mes para los datos registrados
	function diaMaximoFact($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT max(dia) 
				FROM fact_table, date_dim 
				WHERE fact_table.estacion_sk=".$idEstacion." 
					AND fact_table.fecha_sk=date_dim.fecha_sk 
					AND date_dim.año=".$idAno." AND date_dim.mes=".$mes;
		$datos_desordenados = $objDatos->hacerConsulta($sql);
		$arreglo_dia = $objDatos->generarArreglo($datos_desordenados);
		$limtDia = $arreglo_dia[0];
		return $limtDia;
	}

	//Se obtiene el dia mas grande del mes para los datos registrados
	function diaMaximoAire($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT max(dia) 
				FROM fact_aire, date_dim 
				WHERE fact_aire.estacion_sk=".$idEstacion." 
					AND fact_aire.fecha_sk=date_dim.fecha_sk 
					AND date_dim.año=".$idAno." AND date_dim.mes=".$mes;
		$datos_desordenados = $objDatos->hacerConsulta($sql);
		$arreglo_dia = $objDatos->generarArreglo($datos_desordenados);
		$limtDia = $arreglo_dia[0];
		return $limtDia;
	}
	//Hacer calculo del dia con los 288 datos de la fact_table
	function calculoTempsDiaFact($idEstacion, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		$sql = "SELECT min(temperatura) AS mini, max(temperatura) AS maxi,
						 sum(temperatura) AS total, count(temperatura) AS cant
				FROM fact_table, date_dim
				WHERE fact_table.temperatura IS NOT NULL AND fact_table.estacion_sk=".$idEstacion." 
					AND fact_table.fecha_sk=date_dim.fecha_sk 
					AND date_dim.año=".$idAno." AND date_dim.mes=".$mes." AND date_dim.dia=".$dia;
		return $objDatos->executeQuery($sql);
	}

	// Insertar nuevos datos en la tabla indicador
	function insertIndicador($arreglo_calc_temp, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp) {
			$sql= "INSERT INTO indicador (estacion, anio, mes, dia, tmax, tmin, tmed) 
					VALUES (";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_calc_temp as $value) {
				if ($value['cant'] > 0) {
					$sql .= $idEstacion.", ".$idAno.", ".$mes.", "
						.$dia.", ".$value['maxi'].", ".$value['mini'].", ".$value['total']/$value['cant'];
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$insertar = true;	
				}else{
					$insertar = false;
				}
			}
		}
		$sql .= ");";
		$sql2 .= ");";
		if ($insertar) {
			$objDatos->operacionesCrud($sql);
			$objDatos->operacionesCrud($sql2);
		}
	}

	// Insertar nuevos datos en la tabla indicador
	function updateIndicador($arreglo_calc_temp, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp) {
			$sql= "UPDATE indicador SET ";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_calc_temp as $value) {
				if ($value['cant'] > 0) {
					$sql .= "tmax=".$value['maxi'].", tmin=".$value['mini'].", tmed=".$value['total']/$value['cant'].
							" WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes." AND dia=".$dia;
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$insertar = true;	
				}else{
					$insertar = false;
				}
			}
		}
		$sql2 .= ");";
		if ($insertar) {
			$objDatos->operacionesCrud($sql);
			$objDatos->operacionesCrud($sql2);
		}
	}

	//Cantidad de temps en la tabla indicador
	function cantTempsIndicador($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT COUNT(tmax) AS maxi, COUNT(tmin) AS mini, COUNT(tmed) AS promedio
				FROM indicador
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes." AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	//obtener datos del dia apra calculos del mes tabla indicador
	function obtenerDatosTempsIndicador($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT sum(tmin) AS totalmini, sum(tmax) AS totalmaxi,
					 sum(tmed) AS totalmed, count(estacion) AS cant, min(tmin) AS mini, max(tmax) AS maxi
				FROM indicador
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes;
		return $objDatos->executeQuery($sql);
	}

	//Insertar los calculos del mes
	function insertTempsMesIndicador($arreglo_calc_temp_mes, $idEstacion, $variable, $idAno, $mes){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp_mes) {
			$sql= "INSERT INTO indicador (estacion, anio, mes, dia, tmax,"
					." tmin, tmed, tmax_prom, tmin_prom, tmes_med) 
					VALUES (";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_calc_temp_mes as $value) {
				if ($value['cant'] > 0) {
					$sql .= $idEstacion.", ".$idAno.", ".$mes.", 0, "
							.$value['maxi'].", "
							.$value['mini'].", "
							.$value['totalmed']/$value['cant'].", "
							.$value['totalmaxi']/$value['cant'].", "
							.$value['totalmini']/$value['cant'].", "
							.$value['totalmaxi']/$value['totalmini'];
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", 0";
					$insertar = true;	
				}else{
					$insertar = false;
				}
			}
		}
		$sql .= ");";
		$sql2 .= ");";
		if ($insertar) {
			$objDatos->operacionesCrud($sql);
			$objDatos->operacionesCrud($sql2);
		}
	}

	//Insertar los calculos del mes
	function updateTempsMesIndicador($arreglo_calc_temp_mes, $idEstacion, $variable, $idAno, $mes){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp_mes) {
			$sql= "UPDATE indicador SET tmax = ";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_calc_temp_mes as $value) {
				if ($value['cant'] > 0) {
					$sql .= $value['maxi'].", tmin=".$value['mini'].", tmax_prom="
							.$value['totalmaxi']/$value['cant'].", tmin_prom="
							.$value['totalmini']/$value['cant'].", tmed="
							.$value['totalmed']/$value['cant'].", tmes_med="
							.$value['totalmaxi']/$value['totalmini']
							." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes="
							.$mes." AND dia=0";
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", 0";
					$insertar = true;	
				}else{
					$insertar = false;
				}
			}
		}
		$sql2 .= ");";
		if ($insertar) {
			$objDatos->operacionesCrud($sql);
			$objDatos->operacionesCrud($sql2);
		}
	}

	//GENERAR RANGO POR DIA
	function generarRangoDia($idEstacion, $idAno, $variable){
		$objDatos = new clsDatos();	
		$arreglo_temps_dia = verTempsIndicadorDia($idEstacion, $idAno);
		if ($arreglo_temps_dia) {
			foreach ($arreglo_temps_dia as $value) {
				$sql = "INSERT INTO estacion_indicador VALUES (".$variable.", ".$idEstacion.", ".$idAno.", ".$value['mes'].", ".$value['dia'].")";
				$objDatos->operacionesCrud($sql);
				if ($value['rang'] > 0 || $value['rang'] == NULL) {
					$rangoTotal = $value['maxi']-$value['mini'];
					$sql = "UPDATE indicador SET trango=".$rangoTotal." 
							WHERE tmax=".$value['maxi']." AND tmin=".$value['mini']." AND tmed=".$value['promedio'];
					$objDatos->operacionesCrud($sql);
				}
			}
		}
	}

	//ver datos de la temperatura
	function verTempsIndicadorDia($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT mes, dia, tmax AS maxi, tmin AS mini, tmed AS promedio, trango AS rang
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno;
		return $objDatos->executeQuery($sql);
	}

	//Variable Precipitación (total diario y percentil 95)
	function garantizarPPTDia($idEstacion, $idAno, $variable){
		//generar los datos
		$limtMes = mesMaximoFact($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
		//obtiene el dia mas alto que existe se obtienen de la fact_table y date_dim
			$limtDia = diaMaximoFact($idEstacion, $idAno, $mes);
			for ($dia=1; $dia <= $limtDia; $dia++) { 
				//obtener calculos de temperatudara del dia
				$datosDia = sumaDatosPpt($idEstacion, $idAno, $mes, $dia);
				//insertar datos calculados en la tabla indicador
				if ( yaExisteEstacion($idEstacion, $idAno, $mes, $dia) ) {
					updateIndicadorPpt($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}else{
					insertIndicadorPpt($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}
			}
		}
	}

	// Insertar nuevos datos en la tabla indicador
	function insertIndicadorPpt($arreglo_calc_temp, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp) {
			$sql= "INSERT INTO indicador (estacion, anio, mes, dia, ppt) 
					VALUES (";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_calc_temp as $value) {
				if ($value['suma']) {
					$sql .= $idEstacion.", ".$idAno.", ".$mes.", ".$dia.", ".$value['suma'];
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$insertar = true;
				}else{
					$insertar = false;
				}
			}
		}
		$sql .= ");";
		$sql2 .= ");";
		if ($insertar) {
			$objDatos->operacionesCrud($sql);
			$objDatos->operacionesCrud($sql2);
		}
	}

	// Insertar nuevos datos en la tabla indicador
	function updateIndicadorPpt($arreglo_calc_temp, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp) {
			$sql= "UPDATE indicador SET ppt=";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_calc_temp as $value) {
				if ($value['suma']) {
					$sql .= $value['suma']." WHERE estacion=".$idEstacion." AND  anio=".$idAno." AND mes=".$mes." AND dia=".$dia;
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
						$insertar = true;
				}else{
					$insertar = false;
				}
			}
		}
		$sql2 .= ");";
		if ($insertar) {
			$objDatos->operacionesCrud($sql);
			$objDatos->operacionesCrud($sql2);
		}
	}

	//consultar datos de precipitacion Dia
	function sumaDatosPpt($idEstacion, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(precipitacion) AS suma  
				FROM fact_table, date_dim 
				WHERE fact_table.estacion_sk=".$idEstacion." 
					AND fact_table.fecha_sk=date_dim.fecha_sk 
					AND date_dim.año=".$idAno." AND date_dim.mes=".$mes." 
					AND date_dim.dia=".$dia;
		return $objDatos->executeQuery($sql);
	}

	//Existencia de la llave primaria en la tabla indicador
	function yaExisteEstacion($idEstacion, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		$existencia = false;
		$sql = "SELECT COUNT(estacion) 
				FROM indicador 
				WHERE estacion=".$idEstacion. " AND anio=".$idAno." AND mes=".$mes." AND dia=".$dia;
		$datos_desordenados = $objDatos->hacerConsulta($sql);
        $arreglo_datos = $objDatos->generarArreglo($datos_desordenados);
    	$cantDatos = $arreglo_datos[0]; 
    	if ($cantDatos > 0) {
    		$existencia = true;
    	}
		return $existencia;
	}

	//Variable Precipitación del mes
	function garantizarPPTMes($idEstacion, $idAno, $variable){
		//generar los datos
		$limtMes = mesMaximoFact($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
			//obtener calculos de temperatudara del dia
			$datosDia = sumaDatosMesPpt($idEstacion, $idAno, $mes);
			$diasSinLluvia = diasSinAgua($idEstacion, $idAno, $mes);
			//insertar datos calculados en la tabla indicador
			if ( yaExisteEstacion($idEstacion, $idAno, $mes, 0) ) {
				#echo "<br>hola";
				updateIndicadorMesPpt($datosDia, $idEstacion, $variable, $idAno, $mes, $diasSinLluvia);
			}else{
				insertIndicadorMesPpt($datosDia, $idEstacion, $variable, $idAno, $mes, $diasSinLluvia);
			}
		}
	}

	//consultar datos de precipitacion mes
	function diasSinAgua($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT COUNT(ppt) AS diasin  
				FROM indicador 
				WHERE estacion=".$idEstacion." 
					AND anio=".$idAno." AND mes=".$mes." AND ppt=0.0";
		$datos_desordenados = $objDatos->hacerConsulta($sql);
        $arreglo_datos = $objDatos->generarArreglo($datos_desordenados);
        $perfil = $arreglo_datos[0]; 
		return $perfil;
	}

	//Variable Precipitación del año
	function garantizarPPTAnual($idEstacion, $idAno, $variable){
		//generar los datos
		$datosMes = sumaDatosAnioPpt($idEstacion, $idAno);
		$diasSinLluvia = diasAnioAgua($idEstacion, $idAno);
		//insertar datos calculados en la tabla indicador
		if ( yaExisteEstacion($idEstacion, $idAno, 0, 0) ) {
			updateIndicadorMesPpt($datosMes, $idEstacion, $variable, $idAno, 0, $diasSinLluvia);
		}else{
			insertIndicadorMesPpt($datosMes, $idEstacion, $variable, $idAno, 0, $diasSinLluvia);
		}
	}

	//consultar datos de precipitacion mes
	function diasAnioAgua($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(dias_sin_lluvia) AS diasin  
				FROM indicador 
				WHERE estacion=".$idEstacion." 
					AND anio=".$idAno;
		$datos_desordenados = $objDatos->hacerConsulta($sql);
        $arreglo_datos = $objDatos->generarArreglo($datos_desordenados);
        $perfil = $arreglo_datos[0]; 
		return $perfil;
	}

	//consultar datos de precipitacion mes
	function sumaDatosAnioPpt($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(ppt) AS suma, COUNT(ppt) AS total   
				FROM indicador 
				WHERE estacion=".$idEstacion." 
					AND anio=".$idAno." AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	//consultar datos de precipitacion mes
	function sumaDatosMesPpt($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(ppt) AS suma, COUNT(ppt) AS total 
				FROM indicador 
				WHERE estacion=".$idEstacion." 
					AND anio=".$idAno." AND mes=".$mes;
		return $objDatos->executeQuery($sql);
	}

	// Insertar nuevos datos en la tabla indicador
	function insertIndicadorMesPpt($arreglo_calc_temp, $idEstacion, $variable, $idAno, $mes, $diasSinLluvia){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp) {
			$sql= "INSERT INTO indicador (estacion, anio, mes, dia, ppt, dias_sin_lluvia)   
					VALUES (";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_calc_temp as $value) {
				$cantidad = $value['total'];
				$sql .= $idEstacion.", ".$idAno.", ".$mes.", 0, ".$value['suma'].", ".$diasSinLluvia;
				$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", 0";
			}
		}
		$sql .= ");";
		$sql2 .= ");";
		if ($cantidad > 0) {
			$objDatos->operacionesCrud($sql);
			$objDatos->operacionesCrud($sql2);
		}
	}

	// Insertar nuevos datos en la tabla indicador
	function updateIndicadorMesPpt($arreglo_calc_temp, $idEstacion, $variable, $idAno, $mes, $diasSinLluvia){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp) {
			$sql= "UPDATE indicador SET ppt=";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_calc_temp as $value) {
				#echo $value['suma'];
				$cantidad = $value['total'];
				$sql .= $value['suma'].", dias_sin_lluvia=".$diasSinLluvia." WHERE estacion=".$idEstacion
					." AND  anio=".$idAno." AND mes=".$mes." AND dia=0 ";
				$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", 0";
			}
		}
		$sql2 .= ");";
		if ($cantidad > 0) {
			$objDatos->operacionesCrud($sql);
			$objDatos->operacionesCrud($sql2);
		}
	}

	//ES UTILIZdo por crear usuario 
	function crearUsu($idNombre, $idApellido, $idCedula, $idDependencia, $idCargo, $idRol, $idNomb_usuario, $idClave){
		$objDatos = new clsDatos();	
		$sql= "INSERT INTO usuario (nombre_usuario, contrasenia";
		if ($idNombre != null) {$sql .= ", nombre";}
		if ($idApellido != null) {$sql .= ", apellido";}
		if ($idCedula != null) {$sql .= ", cedula";}
		if ($idDependencia != null) {$sql .= ", dependencia";}
		if ($idCargo != null) {$sql .= ", cargo";}
		if ($idRol != "Seleccione") {$sql .= ", id_rol_usu";}
		$sql .= ") VALUES ('$idNomb_usuario', MD5('$idClave')";
		if ($idNombre != null) {$sql .= ", '$idNombre'";}
		if ($idApellido != null) {$sql .= ", '$idApellido'";}
		if ($idCedula != null) {$sql .= ", ".$idCedula;}
		if ($idDependencia != null) {$sql .= ", '$idDependencia'";}
		if ($idCargo != null) {$sql .= ", '$idCargo'";}
		if ($idRol != "Seleccione") {$sql .= ", ".$idRol;}
		$sql .= ");";
		$objDatos->operacionesCrud($sql);
	}

	// Elimirna un usuario
	function eliminaUsu($idUsuario){
		$objDatos = new clsDatos();
		$sql = "DELETE FROM usuario WHERE id_usuario=".$idUsuario;
		$objDatos->operacionesCrud($sql);
	}

	// ModificarUsuario
	function modUsu($idUsuario, $idNombre, $idApellido, $idCedula, $idDependencia, $idCargo, $idRol ){
		$objDatos = new clsDatos();	
		$sql= "UPDATE usuario SET id_usuario=".$idUsuario;
		if ($idNombre != null) {$sql .= ", nombre='$idNombre'";}
		if ($idApellido != null) {$sql .= ", apellido='$idApellido'";}
		if ($idCedula != null) {$sql .= ", cedula=".$idCedula;}
		if ($idDependencia != null) {$sql .= ", dependencia='$idDependencia'";}
		if ($idCargo != null) {$sql .= ", cargo='$idCargo'";}
		if ($idRol != "Seleccione") {$sql .= ", id_rol_usu=".$idRol;}
		$sql .= " WHERE id_usuario=".$idUsuario;
		$objDatos->operacionesCrud($sql);
	}

	//Descripcion de las caracteristicas climaticas de una regin sgun mm/año
	function clasificacionLluvia($idEstacion, $idAno){
		$objDatos = new clsDatos();
		$sql= "UPDATE indicador SET desc_lluvia='Poca' WHERE ppt<200 AND mes=0 AND dia=0 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET desc_lluvia='Escasa' WHERE ppt>=200 AND ppt<500 AND mes=0 AND dia=0 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET desc_lluvia='Normal' WHERE ppt>=500 AND ppt<1000 AND mes=0 AND dia=0 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET desc_lluvia='Abundante' WHERE ppt>=1000 AND ppt<2000 AND mes=0 AND dia=0 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET desc_lluvia='Muy Abundante' WHERE ppt>2000 AND mes=0 AND dia=0 AND anio=".$idAno.";";
		$objDatos->operacionesCrud($sql);
	}

	//Ejecutar el indicador 1 TEMP
	function ejecutarTemp($idEstacion, $idAno, $variable){
		/***************************************************************************************************************************************
		*  CALCULO DE DIA TRAS DIA
		***************************************************************************************************************************************/
		garantizarTempsDiaIndicador($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*  CALCULO DE MES A MES
		***************************************************************************************************************************************/
		garantizarTempsMesIndicador($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*  CALCULO DE año
		***************************************************************************************************************************************/
		garantizarTempsAnualIndicador($idEstacion, $idAno, $variable);
	}

	//Verificar existencio o generar datos POR MES de tmax, tmin y tmed en tabla indicador
	function garantizarTempsAnualIndicador($idEstacion, $idAno, $variable){
		//obtener calculos del año
		$arreglo_calc_temp_mes = obtenerDatosTempsIndicadorAnio($idEstacion, $idAno);
		//insertar datos calculados en la tabla indicador
		//insertar los calculos del año
		if ( yaExisteEstacion($idEstacion, $idAno, 0, 0) ) {
			updateTempsAnioIndicador($arreglo_calc_temp_mes, $idEstacion, $variable, $idAno, 0);
		}else{
			insertTempsAnnioIndicador($arreglo_calc_temp_mes, $idEstacion, $variable, $idAno, 0);
		}
	}

	//Insertar los calculos del mes
	function insertTempsAnnioIndicador($arreglo_calc_temp_mes, $idEstacion, $variable, $idAno, $mes){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp_mes) {
			$sql= "INSERT INTO indicador (estacion, anio, mes, dia, tmax, tmin, tmed) 
					VALUES (";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_calc_temp_mes as $value) {
				if ($value['cant'] > 0) {
					$sql .= $idEstacion.", ".$idAno.", ".$mes.", 0, "
							.$value['totalmaxi'].", ".$value['totalmini']
							.", ".$value['totalmedio']/$value['cant'];
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", 0";
					$insertar = true;	
				}else{
					$insertar = false;
				}
			}
		}
		$sql .= ");";
		$sql2 .= ");";
		if ($insertar) {
			$objDatos->operacionesCrud($sql);
			$objDatos->operacionesCrud($sql2);
		}
	}

	//Insertar los calculos del mes
	function updateTempsAnioIndicador($arreglo_calc_temp_mes, $idEstacion, $variable, $idAno, $mes){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp_mes) {
			$sql= "UPDATE indicador SET tmax = ";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_calc_temp_mes as $value) {
				if ($value['cant'] > 0) {
					$sql .= $value['totalmaxi'].", tmin="
							.$value['totalmini']
							.", tmed=".$value['totalmedio']/$value['cant']
							." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes="
							.$mes." AND dia=0";
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", 0";
					$insertar = true;	
				}else{
					$insertar = false;
				}
			}
		}
		$sql2 .= ");";
		if ($insertar) {
			$objDatos->operacionesCrud($sql);
			$objDatos->operacionesCrud($sql2);
		}
	}

	//obtener datos del dia apra calculos del mes tabla indicador
	function obtenerDatosTempsIndicadorAnio($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT min(tmin) AS totalmini, max(tmax) AS totalmaxi,
						 sum(tmed) AS totalmedio, count(estacion) AS cant
				FROM indicador
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	// Ejecutar el indicador 3 Ppt
	function ejecutarPpt($idEstacion, $idAno, $variable){
		/***************************************************************************************************************************************
		*  CALCULO DE DIA TRAS DIA
		***************************************************************************************************************************************/
		garantizarPPTDia($idEstacion, $idAno, $variable);
		/***************************************************
		*  CALCULANDO INTENSIDAD DE LLUVIA PRIMEROS 5 MINUTOS
		************************************************************/
		calcularIntLluvia5min($idEstacion, $idAno, $variable);
		/***************************************************
		*  CALCULANDO INTENSIDAD DE LLUVIA
		************************************************************/
		//calcularIntLluvia($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*  CALCULO DE MES A MES
		***************************************************************************************************************************************/
		garantizarPPTMes($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*  CALCULO DE ANUAL
		***************************************************************************************************************************************/
		garantizarPPTAnual($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*  Asignar la descripcion de lluvia segun el semaforo de las hojas metodologicas
		***************************************************************************************************************************************/
		clasificacionLluvia($idEstacion, $idAno);
	}

	//Variable Precipitación (total diario y percentil 95)
	function calcularIntLluvia5min($idEstacion, $idAno, $variable){
		//generar los datos
		$limtMes = mesMaximoFact($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
		//obtiene el dia mas alto que existe se obtienen de la fact_table y date_dim
			$limtDia = diaMaximoFact($idEstacion, $idAno, $mes);
			for ($dia=1; $dia <= $limtDia; $dia++) { 
				//obtener calculos de temperatudara del dia
				$datosDia = primPptDia5Minutos($idEstacion, $idAno, $mes, $dia);
				//insertar datos calculados en la tabla indicador
				if ( yaExisteEstacion($idEstacion, $idAno, $mes, $dia) ) {
					updateIndicadorPptIntLluvi($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}else{
					insertIndicadorPptIntLluvi($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}
			}
		}
	}

	// Insertar nuevos datos en la tabla indicador
	function insertIndicadorPptIntLluvi($arreglo_calc_temp, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp) {
			$sql= "INSERT INTO indicador (estacion, anio, mes, dia, int_lluvia_uno_cinco) 
					VALUES (";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($arreglo_calc_temp as $value) {
				if ($value['precip']) {
					$sql .= $idEstacion.", ".$idAno.", ".$mes.", ".$dia.", ".$value['precip']*12;
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$insertar = true;
				}else{
					$insertar = false;
				}
			}
			$sql .= ");";
			$sql2 .= ");";
			if ($insertar) {
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	//consultar datos de precipitacion Dia
	function primPptDia5Minutos($idEstacion, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		$sql = "SELECT precipitacion AS precip  
				FROM fact_table, date_dim 
				WHERE fact_table.estacion_sk=".$idEstacion." 
					AND fact_table.fecha_sk=date_dim.fecha_sk and fact_table.tiempo_sk = 301
					AND date_dim.año=".$idAno." AND date_dim.mes=".$mes." 
					AND date_dim.dia=".$dia;
		return $objDatos->executeQuery($sql);
	}

	//Variable Precipitación (total diario y percentil 95)
	function calcularIntLluvia($idEstacion, $idAno, $variable){

	}
	
	//consultar datos de precipitacion Dia
	function primPptDia($idEstacion, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		$sql = "SELECT precipitacion AS precip  
				FROM fact_table, date_dim 
				WHERE fact_table.fecha_sk=date_dim.fecha_sk AND fact_table.tiempo_sk<=10801 
					AND fact_table.estacion_sk=".$idEstacion." 
					AND date_dim.año=".$idAno." AND date_dim.mes=".$mes." 
					AND date_dim.dia=".$dia; 
		return $objDatos->executeQuery($sql);
	}

	// Insertar nuevos datos en la tabla indicador
	function updateIndicadorPptIntLluvi($arreglo_calc_temp, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($arreglo_calc_temp) {
			$sql= "UPDATE indicador SET int_lluvia_uno_cinco=";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			$insertar = false;
			foreach ($arreglo_calc_temp as $value) {
				if ($value['precip']) {
					$valor= $value['precip']*12;
					$sql .= $valor." WHERE estacion=".$idEstacion." AND  anio=".$idAno
					." AND mes=".$mes." AND dia=".$dia;
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$insertar = true;
				}
			}
			$sql2 .= ");";
			if ($insertar) {
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	function generarA25($idEstacion, $idAno){
		//generar los datos
		$limtMes = mesMaximoIndicador($idEstacion, $idAno);
		$diaLimite = 25;
		for ($mes=1; $mes <= $limtMes; $mes++) { 
		//obtiene el dia mas alto que existe se obtienen de la fact_table y date_dim
			$limtDia = diaMaximoIndicador($idEstacion, $idAno, $mes);
			$valorA25=0;
			$bandera=false;
			if ($mes==1 && !$bandera) {
				$limtDia=31;
				$diaFinal = 1;
				for ($dia=8; $dia <= $limtDia; $dia++){
					$idAno--; $mes=12;
					$valorA25 = calculoA25($idEstacion, $idAno, $mes, $dia, $limtDia);
					$diasFaltantes = $diaLimite - ($limtDia - $dia) -1;
					$diaFinal= $diasFaltantes;
					$idAno++; $mes=1;
					$valorA25 = $valorA25 + calculoA25($idEstacion, $idAno, $mes, 1, $diaFinal);
					escribeA25($idEstacion, $idAno, $mes, $diaFinal, $valorA25);
################################################################################################################################

					if ($dia==$limtDia) {
						$bandera=true;
					}
				}
			}else{
				$mes--;
				$cantDias = diaMaximoIndicador($idEstacion, $idAno, $mes);
				$limite = ($cantDias - $diaLimite)+2;
				$mes++;
				for ($dia=$limite; $dia <= $cantDias ; $dia++) { 
					$mes--;
					$valorA25 = calculoA25($idEstacion, $idAno, $mes, $dia, $cantDias);
					$diasFaltantes = $diaLimite - ($cantDias - $dia) -1;
					$diaFinal= $diasFaltantes;
					$mes++;
					$valorA25 = $valorA25 + calculoA25($idEstacion, $idAno, $mes, 1, $diaFinal);
					escribeA25($idEstacion, $idAno, $mes, $diaFinal, $valorA25);
				}
			}
			$diaInicio=0;
			for ($dia=$diaLimite; $dia <= $limtDia; $dia++) {
				$diaInicio++;
				$valorA25 = calculoA25($idEstacion, $idAno, $mes, $diaInicio, $dia);
				escribeA25($idEstacion, $idAno, $mes, $dia, $valorA25);
			}
		}
	}

	//Se obtiene el dia mas grande del mes para los datos registrados
	function diaMaximoIndicador($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT max(dia) 
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes;
		$datos_desordenados = $objDatos->hacerConsulta($sql);
		$arreglo_dia = $objDatos->generarArreglo($datos_desordenados);
		$limtDia = $arreglo_dia[0];
		return $limtDia;
	}
	
	//calcula la suma de los 25 dias 
	function calculoA25($idEstacion, $idAno, $mes, $diaInicio, $diaFin){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(ppt) FROM indicador WHERE estacion=".$idEstacion.
				" AND anio=".$idAno." AND mes=".$mes." AND dia>=".$diaInicio." AND dia<=".$diaFin;
		$datos_desordenados = $objDatos->hacerConsulta($sql);
		$arreglo_dia = $objDatos->generarArreglo($datos_desordenados);
		$limtDia = $arreglo_dia[0];
		return $limtDia;
	}

	function escribeA25($idEstacion, $idAno, $mes, $dia, $valor){
		$objDatos = new clsDatos();	
		$sql= "UPDATE indicador SET ac_25=".$valor." WHERE estacion=".$idEstacion.
				" AND anio=".$idAno." AND mes=".$mes." AND dia=".$dia;
		$objDatos->operacionesCrud($sql);
		$sql= "INSERT INTO estacion_indicador VALUES 
				(4, ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia.")";
		$objDatos->operacionesCrud($sql);
	}

	// Clasificacion del semaforo
	function clasificacionA25($idEstacion, $idAno){
		$objDatos = new clsDatos();
		$sql= "UPDATE indicador SET nivel_alerta='Baja' WHERE ac_25>=200 AND ac_25<300 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET nivel_alerta='Media' WHERE ac_25>=300 AND ac_25<400 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET nivel_alerta='Alta' WHERE ac_25>=400 AND anio=".$idAno.";";
		$objDatos->operacionesCrud($sql);
	}

	//captura datos de la fact table
	function datosDvvDia($idEstacion, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(velocidad_viento) AS suma, COUNT(velocidad_viento) AS total,
				 MAX(velocidad_viento) AS maximo 
				FROM fact_table, date_dim 
				WHERE fact_table.estacion_sk=".$idEstacion." 
					AND fact_table.fecha_sk=date_dim.fecha_sk 
					AND date_dim.año=".$idAno." AND date_dim.mes=".$mes." 
					AND date_dim.dia=".$dia." AND velocidad_viento > 0";
		return $objDatos->executeQuery($sql);
	}

	//si ya existe la tupla escribe los datos
	function updateIndicadorDvv($datosDia, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			$sql= "UPDATE indicador SET max_vv=";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($datosDia as $value) {
				if ($value['total']>0) {
					$sql .= $value['maximo'].", med_vv=".$value['suma']/$value['total'].
							" WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes="
							.$mes." AND dia=".$dia;
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$banderaDvv = true;
				}else{
					$banderaDvv = false;
				}
			}
			$sql2 .= ");";
			if ($banderaDvv) {
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	//si no existe la tupla escribe los datos
	function insertIndicadorDvv($datosDia, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			$sql= "INSERT INTO indicador (estacion, anio, mes, dia, max_vv, med_vv) 
					VALUES (";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($datosDia as $value) {
				if ($value['total']>0) {
					$sql .= $idEstacion.", ".$idAno.", ".$mes.", ".$dia.", "
							.$value['maximo'].", ".$value['suma']/$value['total'];
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$banderaDvv = true;
				}else{
					$banderaDvv = false;
				}
			}
			$sql .= ");";
			$sql2 .= ");";
			if ($banderaDvv) {
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	//genera el maximo y el medio del mes
	function generarDvvMes($idEstacion, $idAno, $variable){
		$objDatos = new clsDatos();	
		//generar los datos
		#consulta el mes maximo existente en la tabla indicador, es decir que los dias ya se calcularon.
		$limtMes = mesMaximoIndicador($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
			################################################################
			//se estan dando los datos de velocidad de viento
			###################################################################
			//obtener calculos de vv del dia
			$datosDia = sumaDatosMesDvv($idEstacion, $idAno, $mes);
			//insertar datos calculados en la tabla indicador
			$dia = 0;
			if ( yaExisteEstacion($idEstacion, $idAno, $mes, $dia) ) {
				updateIndicadorDvv($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
			}else{
				insertIndicadorDvv($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
			}
			//CALCULAR DIRECCION DEL VIENTO
			contarDvvMes($idEstacion, $idAno, $mes);
		}
	}

	//consultar datos de velocidad viento mes
	function sumaDatosMesDvv($idEstacion, $idAno, $mes){
		$objDatos =new clsDatos();	
		$sql = "SELECT SUM(med_vv) AS suma, COUNT(med_vv) AS total, MAX(max_vv) AS maximo 
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes;
		return $objDatos->executeQuery($sql);
	}

	//genera el maximo y el medio del anual
	function generarDvvAnual($idEstacion, $idAno, $variable){
		$objDatos = new clsDatos();	
		//generar los datos
		$datosMes = sumaDatosAnualDvv($idEstacion, $idAno);
		//insertar datos calculados en la tabla indicador
		if ( yaExisteEstacion($idEstacion, $idAno, 0, 0) ) {
			updateIndicadorDvv($datosMes, $idEstacion, $variable, $idAno, 0, 0);
		}else{
			insertIndicadorDvv($datosMes, $idEstacion, $variable, $idAno, 0, 0);
		}
		//CALCULAR DIRECCION DEL VIENTO
		contarDvvAnio($idEstacion, $idAno);
	}

	//consultar datos de radiacion solar anual
	function sumaDatosAnualDvv($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(med_vv) AS suma, COUNT(med_vv) AS total, MAX(max_vv) AS maximo
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	function escalaBeaufort($idEstacion, $idAno){
		$objDatos = new clsDatos();
		//escala beaufort del valor maximo
		$sql= "UPDATE indicador SET max_escala_beaufort=0 WHERE max_vv>=0 AND max_vv<=0.2 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=1 WHERE max_vv>=0.3 AND max_vv<=1.5 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=2 WHERE max_vv>=1.6 AND max_vv<=3.3 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=3 WHERE max_vv>=3.4 AND max_vv<=5.4 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=4 WHERE max_vv>=5.5 AND max_vv<=7.9 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=5 WHERE max_vv>=8.0 AND max_vv<=10.7 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=6 WHERE max_vv>=10.8 AND max_vv<=13.8 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=7 WHERE max_vv>=13.9 AND max_vv<=17.1 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=8 WHERE max_vv>=17.2 AND max_vv<=20.7 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=9 WHERE max_vv>=20.8 AND max_vv<=24.4 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=10 WHERE max_vv>=24.5 AND max_vv<=28.4 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=11 WHERE max_vv>=28.5 AND max_vv<=32.6 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_escala_beaufort=12 WHERE max_vv>=32.7 AND anio=".$idAno.";";
		//escala beaufort del valor medio
		$sql.= "UPDATE indicador SET med_escala_beaufort=0 WHERE med_vv>=0 AND med_vv<=0.2 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=1 WHERE med_vv>=0.3 AND med_vv<=1.5 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=2 WHERE med_vv>=1.6 AND med_vv<=3.3 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=3 WHERE med_vv>=3.4 AND med_vv<=5.4 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=4 WHERE med_vv>=5.5 AND med_vv<=7.9 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=5 WHERE med_vv>=8.0 AND med_vv<=10.7 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=6 WHERE med_vv>=10.8 AND med_vv<=13.8 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=7 WHERE med_vv>=13.9 AND med_vv<=17.1 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=8 WHERE med_vv>=17.2 AND med_vv<=20.7 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=9 WHERE med_vv>=20.8 AND med_vv<=24.4 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=10 WHERE med_vv>=24.5 AND med_vv<=28.4 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=11 WHERE med_vv>=28.5 AND med_vv<=32.6 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_escala_beaufort=12 WHERE med_vv>=32.7 AND anio=".$idAno.";";
		$objDatos->operacionesCrud($sql);
	}

	function descripcionBeaufort($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		//descripcion beaufort del valor maximo
		$sql= "UPDATE indicador SET max_desc_beaufort='Calma' WHERE max_vv>=0 AND max_vv<=0.2 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Aire ligero' WHERE max_vv>=0.3 AND max_vv<=1.5 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Brisa muy ligera' WHERE max_vv>=1.6 AND max_vv<=3.3 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Brisa suave' WHERE max_vv>=3.4 AND max_vv<=5.4 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Brisa moderada' WHERE max_vv>=5.5 AND max_vv<=7.9 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Brisa fresca' WHERE max_vv>=8.0 AND max_vv<=10.7 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Brisa fuerte' WHERE max_vv>=10.8 AND max_vv<=13.8 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Cercano a  vendaval' WHERE max_vv>=13.9 AND max_vv<=17.1 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Vendaval' WHERE max_vv>=17.2 AND max_vv<=20.7 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Vendaval fuerte' WHERE max_vv>=20.8 AND max_vv<=24.4 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Tormenta' WHERE max_vv>=24.5 AND max_vv<=28.4 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Tormenta violenta' WHERE max_vv>=28.5 AND max_vv<=32.6 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET max_desc_beaufort='Huracán' WHERE max_vv>=32.7 AND anio=".$idAno.";";
		//descripcion beaufort del valor medio
		$sql.= "UPDATE indicador SET med_desc_beaufort='Calma' WHERE med_vv>=0 AND med_vv<=0.2 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_desc_beaufort='Aire ligero' WHERE med_vv>=0.3 AND med_vv<=1.5 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_desc_beaufort='Brisa muy ligera' WHERE med_vv>=1.6 AND med_vv<=3.3 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_desc_beaufort='Brisa suave' WHERE med_vv>=3.4 AND med_vv<=5.4 AND anio=".$idAno.";"; 
		$sql.= "UPDATE indicador SET med_desc_beaufort='Brisa moderada' WHERE med_vv>=5.5 AND med_vv<=7.9 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_desc_beaufort='Brisa fresca' WHERE med_vv>=8.0 AND med_vv<=10.7 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_desc_beaufort='Brisa fuerte' WHERE med_vv>=10.8 AND med_vv<=13.8 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_desc_beaufort='Cercano a  vendaval' WHERE med_vv>=13.9 AND med_vv<=17.1 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_desc_beaufort='Vendaval' WHERE med_vv>=17.2 AND med_vv<=20.7 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_desc_beaufort='Vendaval fuerte' WHERE med_vv>=20.8 AND med_vv<=24.4 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_desc_beaufort='Tormenta' WHERE med_vv>=24.5 AND med_vv<=28.4 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_desc_beaufort='Tormenta violenta' WHERE med_vv>=28.5 AND med_vv<=32.6 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET med_desc_beaufort='Huracán' WHERE med_vv>=32.7 AND anio=".$idAno.";";
		$objDatos->operacionesCrud($sql);
	}

	function ejecutarPptA25($idEstacion, $idAno){
		//Ejecutar el tercer indicador Ppt
		$existenDatos = cantDatos($idEstacion, 3, $idAno);
		if ($existenDatos < 1) {
			ejecutarPpt($idEstacion, $idAno, 3);
		}
		$anio = $idAno-1;
		$existenDatos = cantDatos($idEstacion, 3, $anio);
		if ($existenDatos < 1) {
			ejecutarPpt($idEstacion, $anio, 3);
		}
		/***************************************************************************************************************************************
		*GENERAR los A25 del año
		****************************************************************************************************************************************/
		generarA25($idEstacion, $idAno);
		/***************************************************************************************************************************************
		*Hacer la clasificacion del semaforo del A25
		****************************************************************************************************************************************/
		clasificacionA25($idEstacion, $idAno);
		/***************************************************************************************************************************************
		*maximo A25 del mes
		****************************************************************************************************************************************/
		maximoMesA25($idEstacion, $idAno);
		/***************************************************************************************************************************************
		*maximo A25 del año
		****************************************************************************************************************************************/
		maximoAnioA25($idEstacion, $idAno);
	}

	function maximoMesA25($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		//generar los datos
		$limtMes = mesMaximoIndicador($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
			//obtener calculos de vv del dia
			$datosDia = maxDatoA25($idEstacion, $idAno, $mes);
			//insertar datos calculados en la tabla indicador
			$dia = 0;
			foreach ($datosDia as $value) {
				$sql = "UPDATE indicador SET ac_25=".(integer)$value['maximo']. 
				"WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes." AND dia=".$dia;
			}
			$objDatos->operacionesCrud($sql);
		}
	}

	function maxDatoA25($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT MAX(ac_25) AS maximo
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes;
		return $objDatos->executeQuery($sql);
	}

	function maximoAnioA25($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		//obtener calculos de vv del dia
		$datosDia = maxDatoAnioA25($idEstacion, $idAno);
		//insertar datos calculados en la tabla indicador
		$mes = $dia = 0;
		foreach ($datosDia as $value) {
			$sql = "UPDATE indicador SET ac_25=".(integer)$value['maximo']. 
			"WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes." AND dia=".$dia;
		}
		$objDatos->operacionesCrud($sql);
	}

	function maxDatoAnioA25($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT MAX(ac_25) AS maximo
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	function ejecutarDvv($idEstacion, $idAno, $variable){
		/***************************************************************************************************************************************
		*Generar maximo y medio vv por dia
		****************************************************************************************************************************************/
		generarDvvDia($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*Generar maximo y medio vv por mes
		****************************************************************************************************************************************/
		generarDvvMes($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*Generar maximo y medio vv por año
		****************************************************************************************************************************************/
		generarDvvAnual($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*Generar escalaBeaufort
		****************************************************************************************************************************************/
		escalaBeaufort($idEstacion, $idAno);
		/***************************************************************************************************************************************
		*Generar descipcion Beaufort
		****************************************************************************************************************************************/
		descripcionBeaufort($idEstacion, $idAno);
	}

	//genera el maximo y el medio del dia
	function generarHRDia($idEstacion, $idAno, $variable){
		//generar los datos
		$limtMes = mesMaximoFact($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
		//obtiene el dia mas alto que existe se obtienen de la fact_table y date_dim
			$limtDia = diaMaximoFact($idEstacion, $idAno, $mes);
			for ($dia=1; $dia <= $limtDia; $dia++) { 
				//obtener calculos de temperatudara del dia
				$datosDia = datosHRDia($idEstacion, $idAno, $mes, $dia);
				//insertar datos calculados en la tabla indicador
				if ( yaExisteEstacion($idEstacion, $idAno, $mes, $dia) ) {
					updateIndicadorHR($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}else{
					insertIndicadorHR($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}
			}
		}
	}

	//captura datos de la fact table
	function datosHRDia($idEstacion, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(humedad_relativa) AS suma, COUNT(humedad_relativa) AS total,
					 MAX(humedad_relativa) AS maximo, MIN(humedad_relativa) AS minimo
				FROM fact_table, date_dim 
				WHERE fact_table.estacion_sk=".$idEstacion." 
					AND fact_table.fecha_sk=date_dim.fecha_sk 
					AND date_dim.año=".$idAno." AND date_dim.mes=".$mes." 
					AND date_dim.dia=".$dia;
		return $objDatos->executeQuery($sql);
	}

	//si ya existe la tupla escribe los datos
	function updateIndicadorHR($datosDia, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			$sql= "UPDATE indicador SET max_hr=";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($datosDia as $value) {
				if ($value['total']>0) {
					$sql .= $value['maximo'].", min_hr=".$value['minimo'].
							", med_hr=".$value['suma']/$value['total'].
							" WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes="
							.$mes." AND dia=".$dia;
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$ejecutarHR = true;
				}else{
					$ejecutarHR = false;
				}
			}
			$sql2 .= ");";
			if ($ejecutarHR) {
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	//si no existe la tupla escribe los datos
	function insertIndicadorHR($datosDia, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			$sql= "INSERT INTO indicador (estacion, anio, mes, dia, max_hr, min_hr, med_hr) 
					VALUES (";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($datosDia as $value) {
				if ($value['total']>0) {
					$sql .= $idEstacion.", ".$idAno.", ".$mes.", ".$dia.", "
							.$value['maximo'].", ".$value['minimo'].", ".$value['suma']/$value['total'];
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$ejecutarHR = true;
				}else{
					$ejecutarHR = false;
				}
			}
			$sql .= ");";
			$sql2 .= ");";
			if ($ejecutarHR) {
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	//genera el maximo y el medio del mes
	function generarHRMes($idEstacion, $idAno, $variable){
		//generar los datos
		$limtMes = mesMaximoIndicador($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
			//obtener calculos de vv del dia
			$datosDia = sumaDatosMesHR($idEstacion, $idAno, $mes);
			//insertar datos calculados en la tabla indicador
			$dia = 0;
			if ( yaExisteEstacion($idEstacion, $idAno, $mes, $dia) ) {
				updateIndicadorHR($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
			}else{
				insertIndicadorHR($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
			}
		}
	}

	//consultar datos de humedad relativa mes
	function sumaDatosMesHR($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(med_hr) AS suma, COUNT(med_hr) AS total, 
						MAX(max_hr) AS maximo, MIN(min_hr) AS minimo
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes;
		return $objDatos->executeQuery($sql);
	}

	//genera el maximo y el medio del anual
	function generarHRAnual($idEstacion, $idAno, $variable){
		//generar los datos
		$datosMes = sumaDatosAnualHR($idEstacion, $idAno);
		//insertar datos calculados en la tabla indicador
		if ( yaExisteEstacion($idEstacion, $idAno, 0, 0) ) {
			updateIndicadorHR($datosMes, $idEstacion, $variable, $idAno, 0, 0);
		}else{
			insertIndicadorHR($datosMes, $idEstacion, $variable, $idAno, 0, 0);
		}
	}

	//consultar datos de humedad relativa anual
	function sumaDatosAnualHR($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(med_hr) AS suma, COUNT(med_hr) AS total, 
						MAX(max_hr) AS maximo, MIN(min_hr) AS minimo
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	//genera el maximo y el medio del dia
	function generarRSDia($idEstacion, $idAno, $variable){
		//generar los datos
		$limtMes = mesMaximoFact($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
		//obtiene el dia mas alto que existe se obtienen de la fact_table y date_dim
			$limtDia = diaMaximoFact($idEstacion, $idAno, $mes);
			for ($dia=1; $dia <= $limtDia; $dia++) { 
				//obtener calculos de temperatudara del dia
				$datosDia = datosRSDia($idEstacion, $idAno, $mes, $dia);
				//insertar datos calculados en la tabla indicador
				if ( yaExisteEstacion($idEstacion, $idAno, $mes, $dia) ) {
					updateIndicadorRS($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}else{
					insertIndicadorRS($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}
			}
		}
	}

	//captura datos de la fact table
	function datosRSDia($idEstacion, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(radiacion_solar) AS suma, COUNT(radiacion_solar) AS total,
					 MAX(radiacion_solar) AS maximo 
				FROM fact_table, date_dim 
				WHERE fact_table.estacion_sk=".$idEstacion." 
					AND fact_table.fecha_sk=date_dim.fecha_sk 
					AND date_dim.año=".$idAno." AND date_dim.mes=".$mes." 
					AND date_dim.dia=".$dia." AND radiacion_solar>0";
		return $objDatos->executeQuery($sql);
	}

	//si ya existe la tupla escribe los datos
	function updateIndicadorRS($datosDia, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			$sql= "UPDATE indicador SET max_rs=";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($datosDia as $value) {
				if ($value['total']>0) {
					$sql .= $value['maximo'].", med_rs=".$value['suma']/$value['total'].
							" WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes="
							.$mes." AND dia=".$dia;
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$ejecutarRS = true;
				}else{
					$ejecutarRS = false;
				}
			}
			$sql2 .= ");";
			if ($ejecutarRS) {
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	//si no existe la tupla escribe los datos
	function insertIndicadorRS($datosDia, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			$sql= "INSERT INTO indicador (estacion, anio, mes, dia, max_rs, med_rs) 
					VALUES (";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($datosDia as $value) {
				if ($value['total']>0) {
					$sql .= $idEstacion.", ".$idAno.", ".$mes.", ".$dia.", "
							.$value['maximo'].", ".$value['suma']/$value['total'];
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$ejecutarRS = true;
				}else{
					$ejecutarRS = false;
				}
			}
			$sql .= ");";
			$sql2 .= ");";
			if ($ejecutarRS) {
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	//genera el maximo y el medio del mes
	function generarRSMes($idEstacion, $idAno, $variable){
		//generar los datos
		$limtMes = mesMaximoIndicador($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
			//obtener calculos de vv del dia
			$datosDia = sumaDatosMesRS($idEstacion, $idAno, $mes);
			//insertar datos calculados en la tabla indicador
			$dia = 0;
			if ( yaExisteEstacion($idEstacion, $idAno, $mes, $dia) ) {
				updateIndicadorRS($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
			}else{
				insertIndicadorRS($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
			}
		}
	}

	//consultar datos de radiacion solar mes
	function sumaDatosMesRS($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(med_rs) AS suma, COUNT(med_rs) AS total, 
						MAX(max_rs) AS maximo 
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes;
		return $objDatos->executeQuery($sql);
	}

	//genera el maximo y el medio del anual
	function generarRSAnual($idEstacion, $idAno, $variable){
		//generar los datos
		$datosMes = sumaDatosAnualRS($idEstacion, $idAno);
		//insertar datos calculados en la tabla indicador
		if ( yaExisteEstacion($idEstacion, $idAno, 0, 0) ) {
			updateIndicadorRS($datosMes, $idEstacion, $variable, $idAno, 0, 0);
		}else{
			insertIndicadorRS($datosMes, $idEstacion, $variable, $idAno, 0, 0);
		}
	}

	//consultar datos de radiacion solar anual
	function sumaDatosAnualRS($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(med_rs) AS suma, COUNT(med_rs) AS total, 
						MAX(max_rs) AS maximo
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	function ejecutarHR($idEstacion, $idAno, $variable){
		/***************************************************************************************************************************************
		*Generar maximo, minimo y medio HR por dia
		****************************************************************************************************************************************/
		generarHRDia($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*Generar maximo y medio HR por mes
		****************************************************************************************************************************************/
		generarHRMes($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*Generar maximo y medio HR por anual
		****************************************************************************************************************************************/
		generarHRAnual($idEstacion, $idAno, $variable);
	}

	function ejecutarRS($idEstacion, $idAno, $variable){
		/***************************************************************************************************************************************
		*Generar maximo, minimo y medio RS por dia
		****************************************************************************************************************************************/
		generarRSDia($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*Generar maximo y medio RS por mes
		****************************************************************************************************************************************/
		generarRSMes($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*Generar maximo y medio HR por anual
		****************************************************************************************************************************************/
		generarRSAnual($idEstacion, $idAno, $variable);
	}

	function ejecutarPB($idEstacion, $idAno, $variable){
		/***************************************************************************************************************************************
		*Generar maximo, minimo y medio PB por dia
		****************************************************************************************************************************************/
		generarPBDia($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*Generar maximo y medio PB por mes
		****************************************************************************************************************************************/
		generarPBMes($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*Generar maximo y medio HR por anual
		****************************************************************************************************************************************/
		generarPBAnual($idEstacion, $idAno, $variable);
	}

	//genera el maximo y el medio del dia
	function generarPBDia($idEstacion, $idAno, $variable){
		//generar los datos
		$limtMes = mesMaximoFact($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
		//obtiene el dia mas alto que existe se obtienen de la fact_table y date_dim
			$limtDia = diaMaximoFact($idEstacion, $idAno, $mes);
			for ($dia=1; $dia <= $limtDia; $dia++) { 
				//obtener calculos de temperatudara del dia
				$datosDia = datosPBDia($idEstacion, $idAno, $mes, $dia);
				//insertar datos calculados en la tabla indicador
				if ( yaExisteEstacion($idEstacion, $idAno, $mes, $dia) ) {
					updateIndicadorPB($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}else{
					insertIndicadorPB($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}
			}
		}
	}

	//captura datos de la fact table
	function datosPBDia($idEstacion, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(presion_barometrica) AS suma, COUNT(presion_barometrica) AS total, 
						MAX(presion_barometrica) AS maximo, MIN(presion_barometrica) AS minimo
				FROM fact_table, date_dim 
				WHERE fact_table.estacion_sk=".$idEstacion." 
					AND fact_table.fecha_sk=date_dim.fecha_sk 
					AND date_dim.año=".$idAno." AND date_dim.mes=".$mes." 
					AND date_dim.dia=".$dia." AND presion_barometrica>0";
		return $objDatos->executeQuery($sql);
	}

	//si ya existe la tupla escribe los datos
	function updateIndicadorPB($datosDia, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			$constante = conversion($dia);
			$sql= "UPDATE indicador SET med_pb=";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			foreach ($datosDia as $value) {
				if ($value['total']>0) {
					$valorPB=($value['suma']/$value['total'])*$constante;
					$sql .= $valorPB.", min_pb=".$value['minimo']*$constante.", max_pb=".$value['maximo']*$constante
							." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes="
							.$mes." AND dia=".$dia;
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$ejecutarPB = true;
				}else{
					$ejecutarPB = false;
				}
			}
			$sql2 .= ");";
			if ($ejecutarPB) {
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	//si no existe la tupla escribe los datos
	function insertIndicadorPB($datosDia, $idEstacion, $variable, $idAno, $mes, $dia){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			$sql= "INSERT INTO indicador (estacion, anio, mes, dia, med_pb, min_pb, max_pb) 
					VALUES (";
			$sql2 = "INSERT INTO estacion_indicador VALUES ";
			$constante = conversion($dia);
			foreach ($datosDia as $value) {
				if ($value['total']>0) {
					$valorPB=($value['suma']/$value['total'])*$constante;
					$sql .= $idEstacion.", ".$idAno.", ".$mes.", ".$dia.", "
							.$valorPB.", ".$value['minimo']*$constante.", ".$value['maximo']*$constante;
					$sql2 .= "(".$variable.", ".$idEstacion.", ".$idAno.", ".$mes.", ".$dia;
					$ejecutarPB = true;
				}else{
					$ejecutarPB = false;
				}
			}
			$sql .= ");";
			$sql2 .= ");";
			if ($ejecutarPB) {
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	//define calor de conversion
	function conversion($dia){
		if ( $dia == 0 ) {
			return 1;
		}else{
			return 1.333224;//convertir las escalas de medida
		}
	}

	//genera el maximo y el medio del mes
	function generarPBMes($idEstacion, $idAno, $variable){
		//generar los datos
		$limtMes = mesMaximoIndicador($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
			//obtener calculos de vv del dia
			$datosDia = sumaDatosMesPB($idEstacion, $idAno, $mes);
			//insertar datos calculados en la tabla indicador
			$dia = 0;
			if ( yaExisteEstacion($idEstacion, $idAno, $mes, $dia) ) {
				updateIndicadorPB($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
			}else{
				insertIndicadorPB($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
			}
		}
	}

	//consultar datos de radiacion solar mes
	function sumaDatosMesPB($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(med_pb) AS suma, COUNT(med_pb) AS total,
						MAX(max_pb) AS maximo, MIN(min_pb) AS minimo
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes;
		return $objDatos->executeQuery($sql);
	}

	//genera el maximo y el medio del anual
	function generarPBAnual($idEstacion, $idAno, $variable){
		//generar los datos
		$datosMes = sumaDatosAnualPB($idEstacion, $idAno);
		//insertar datos calculados en la tabla indicador
		if ( yaExisteEstacion($idEstacion, $idAno, 0, 0) ) {
			updateIndicadorPB($datosMes, $idEstacion, $variable, $idAno, 0, 0);
		}else{
			insertIndicadorPB($datosMes, $idEstacion, $variable, $idAno, 0, 0);
		}
	}

	//consultar datos de radiacion solar anual
	function sumaDatosAnualPB($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT SUM(med_pb) AS suma, COUNT(med_pb) AS total,
						MAX(max_pb) AS maximo, MIN(min_pb) AS minimo
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	function ejecutarCI($idEstacion, $idAno, $variable){
		//Ejecutar el tercer indicador tempMed
		$existenDatos = cantDatos($idEstacion, 1, $idAno);
		if ($existenDatos < 1) {
			ejecutarTemp($idEstacion, $idAno, 1);
		}
		//Ejecutar el tercer indicador Dvv
		$existenDatos = cantDatos($idEstacion, 5, $idAno);
		if ($existenDatos < 1) {
			ejecutarDvv($idEstacion, $idAno, 5);
		}
		//Ejecutar el tercer indicador Hr
		$existenDatos = cantDatos($idEstacion, 6, $idAno);
		if ($existenDatos < 1) {
			ejecutarHR($idEstacion, $idAno, 6);
		}
		/***************************************************************************************************************************************
		*Generar  CI por dia
		****************************************************************************************************************************************/
		generarCI($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*Garantiza la clasificacion de la sensacion
		****************************************************************************************************************************************/
		sensacionExperimentada($idEstacion, $idAno);
	}

	//genera el maximo y el medio del dia
	function generarCI($idEstacion, $idAno, $variable){
		//Altura estacion
		$altura = alturaEstacion($idEstacion);
		//definir valor de constantes de la frmula segun la altura
		//IC = ($multTemp-ts)($sumCOnst+$multViento(raizViento)+h/$divHumedad)
		$sumConst = 0.05;
		if ($altura < 1000) {
			$multTemp = 36.5;
			$multViento = 0.04;
			$divHumedad = 250;
		}elseif ($altura >= 1000 && $altura < 2000) {
			$multTemp = 34.5;
			$multViento = 0.06;
			$divHumedad = 180;
		}else{
			$multTemp = 33.5;
			$multViento = 0.18;
			$divHumedad = 160;
		}
		//generar los datos obtener calculos de temperatudara del dia
		$datosDia = datosCIDia($idEstacion, $idAno);
		//insertar datos calculados en la tabla indicador
		updateIndicadorCI($datosDia, $idEstacion, $variable, $idAno, $multTemp, $sumConst, $multViento, $divHumedad);
	}

	// Altura de la estacion
	function alturaEstacion($idEstacion){
		$objDatos = new clsDatos();	
		$sql = "SELECT altitud FROM station_dim WHERE estacion_sk=".$idEstacion;
		$datos_desordenados = $objDatos->hacerConsulta($sql);
		$arreglo_dia = $objDatos->generarArreglo($datos_desordenados);
		$limtDia = $arreglo_dia[0];
		return $limtDia;
	}

	//captura datos de la fact table
	function datosCIDia($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT anio AS anio, mes AS mes, dia AS dia, tmed AS temp, med_vv AS viento, med_hr AS humedad 
				FROM indicador 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." ORDER BY 2,3";
		return $objDatos->executeQuery($sql);
	}

	//si ya existe la tupla escribe los datos
	function updateIndicadorCI($datosDia, $idEstacion, $variable, $idAno, $multTemp, $sumConst, $multViento, $divHumedad){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			foreach ($datosDia as $value) {
				$valorCI= ($multTemp-$value['temp'])*($sumConst+$multViento*sqrt($value['viento'])+$value['humedad']/$divHumedad);
				$sql = "UPDATE indicador SET ci=".$valorCI." WHERE estacion=".$idEstacion." AND anio=".$value['anio']." AND mes="
						.$value['mes']." AND dia=".$value['dia'];
				$sql2 = "INSERT INTO estacion_indicador VALUES (".$variable.", ".$idEstacion.", ".$value['anio'].", ".$value['mes'].", ".$value['dia'].")";
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	function sensacionExperimentada($idEstacion, $idAno){
		$objDatos = new clsDatos();
		//escala beaufort del valor maximo
		$sql = "UPDATE indicador SET sensacion_experimentada='Incómodamente caluroso' WHERE ci>=0 AND ci<=3 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET sensacion_experimentada='Caluroso' WHERE ci>=3.1 AND ci<=5 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET sensacion_experimentada='Cálido' WHERE ci>=5.1 AND ci<=7 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET sensacion_experimentada='Agradable' WHERE ci>=7.1 AND ci<=11 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET sensacion_experimentada='Algo frío' WHERE ci>=11.1 AND ci<=13 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET sensacion_experimentada='Frío' WHERE ci>=13.1 AND ci<=15 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET sensacion_experimentada='Muy frío' WHERE ci>15 AND anio=".$idAno.";";
		$objDatos->operacionesCrud($sql);
	}
	
	//Ejecutar el indicador 11 Indice de aridez
	function ejecutarIA($idEstacion, $idAno, $variable){
		//Ejecutar el tercer indicador temp
		$existenDatos = cantDatos($idEstacion, 1, $idAno);
		if ($existenDatos < 1) {
			ejecutarTemp($idEstacion, $idAno, 1);
		}
		//Ejecutar el tercer indicador Ppt
		$existenDatos = cantDatos($idEstacion, 3, $idAno);
		if ($existenDatos < 1) {
			ejecutarPpt($idEstacion, $idAno, 3);
		}
		/***************************************************************************************************************************************
		*  GENERAR INDICE LANG
		***************************************************************************************************************************************/
		garantizarLang($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*  GENERAR ZONA LANG
		***************************************************************************************************************************************/
		zonaLang($idEstacion, $idAno);
		/***************************************************************************************************************************************
		*  GENERAR INDICE MARTONNE ANUAL
		***************************************************************************************************************************************/
		garantizarMartonne($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*  GENERAR INDICE MARTONNE Mes
		***************************************************************************************************************************************/
		garantizarMartonneMes($idEstacion, $idAno, $variable);
		/***************************************************************************************************************************************
		*  GENERAR ZONA MARTONNE
		***************************************************************************************************************************************/
		zonaMartonne($idEstacion, $idAno);
	}

	//Variable Precipitación del mes
	function garantizarMartonneMes($idEstacion, $idAno, $variable){
		//generar los datos
		$limtMes = mesMaximoIndicador($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
			//obtener calculos de temperatudara del dia
			$datosDia = datosIAMartonne($idEstacion, $idAno, $mes);
			//insertar datos calculados en la tabla indicador
			updateIndicadorMartonneMes($datosDia, $idEstacion, $variable, $idAno, $mes);
		}
	}

	//si ya existe la tupla escribe los datos
	function updateIndicadorMartonneMes($datosDia, $idEstacion, $variable, $idAno, $mes){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			foreach ($datosDia as $value) {
				$valorCI= (12*$value['ppt'])/($value['tmed']+10);
				$sql = "UPDATE indicador SET indice_martonne=".$valorCI." WHERE estacion=".$idEstacion
						." AND anio=".$idAno." AND mes=".$mes." AND dia=0";
				$sql2 = "INSERT INTO estacion_indicador VALUES (".$variable.", "
						.$idEstacion.", ".$idAno.", 0, 0)";
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	// traer presipitacion y temperatura
	function datosIAMartonne($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT tmed, ppt FROM indicador WHERE estacion=".$idEstacion
				." AND anio=".$idAno." AND mes=".$mes;
		return $objDatos->executeQuery($sql);
	}

	//genera el maximo y el medio del dia
	function garantizarMartonne($idEstacion, $idAno, $variable){
		//generar los datos obtener calculos de temperatudara del dia
		$datosDia = datosIAMartonne($idEstacion, $idAno);
		//insertar datos calculados en la tabla indicador
		updateIndicadorMartonne($datosDia, $idEstacion, $variable, $idAno);
	}

	//si ya existe la tupla escribe los datos
	function updateIndicadorMartonne($datosDia, $idEstacion, $variable, $idAno){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			foreach ($datosDia as $value) {
				$valorCI= $value['ppt']/($value['tmed']+10);
				$sql = "UPDATE indicador SET indice_martonne=".$valorCI." WHERE estacion=".$idEstacion
						." AND anio=".$idAno." AND mes=0 AND dia=0";
				$sql2 = "INSERT INTO estacion_indicador VALUES (".$variable.", "
						.$idEstacion.", ".$idAno.", 0, 0)";
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}

	//genera el maximo y el medio del dia
	function garantizarLang($idEstacion, $idAno, $variable){
		//generar los datos obtener calculos de temperatudara del dia
		$datosDia = datosIALang($idEstacion, $idAno);
		//insertar datos calculados en la tabla indicador
		updateIndicadorLang($datosDia, $idEstacion, $variable, $idAno);
	}

	// traer presipitacion y temperatura
	function datosIALang($idEstacion, $idAno){
		$objDatos = new clsDatos();	
		$sql = "SELECT tmed, ppt FROM indicador WHERE estacion=".$idEstacion
				." AND anio=".$idAno." AND mes=0 AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	//si ya existe la tupla escribe los datos
	function updateIndicadorLang($datosDia, $idEstacion, $variable, $idAno){
		$objDatos = new clsDatos();	
		if ($datosDia) {
			foreach ($datosDia as $value) {
				$valorCI= $value['ppt']/$value['tmed'];
				$sql = "UPDATE indicador SET indice_lang=".$valorCI." WHERE estacion=".$idEstacion
						." AND anio=".$idAno." AND mes=0 AND dia=0";
				$sql2 = "INSERT INTO estacion_indicador VALUES (".$variable.", "
						.$idEstacion.", ".$idAno.", 0, 0)";
				$objDatos->operacionesCrud($sql);
				$objDatos->operacionesCrud($sql2);
			}
		}
	}
	
	function zonaLang($idEstacion, $idAno){
		$objDatos = new clsDatos();
		//escala beaufort del valor maximo
		$sql = "UPDATE indicador SET zona_lang='Desiertos' WHERE indice_lang>=0 AND indice_lang<20 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET zona_lang='Árida' WHERE indice_lang>=20 AND indice_lang<40 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET zona_lang='Húmedas de estepa y sabana' WHERE indice_lang>=40 AND indice_lang<60 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET zona_lang='Húmeda de bosques claros' WHERE indice_lang>=60 AND indice_lang<100 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET zona_lang='Húmedas de grandes bosques' WHERE indice_lang>=100 AND indice_lang<160 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET zona_lang='Perhúmedas con prados y tundras' WHERE indice_lang>=160 AND anio=".$idAno.";";
		$objDatos->operacionesCrud($sql);
	}

	function zonaMartonne($idEstacion, $idAno){
		$objDatos = new clsDatos();
		//escala beaufort del valor maximo
		$sql = "UPDATE indicador SET zona_martonne='Desiertos (Hiperárido)' WHERE indice_martonne>=0 AND indice_martonne<5 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET zona_martonne='Semidesierto (Árido)' WHERE indice_martonne>=5 AND indice_martonne<10 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET zona_martonne='Semiárido' WHERE indice_martonne>=10 AND indice_martonne<20 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET zona_martonne='Subhúmeda' WHERE indice_martonne>=20 AND indice_martonne<30 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET zona_martonne='Húmeda' WHERE indice_martonne>=30 AND indice_martonne<60 AND anio=".$idAno.";";
		$sql.= "UPDATE indicador SET zona_martonne='Perhúmedas ' WHERE indice_martonne>=60 AND anio=".$idAno.";";
		$objDatos->operacionesCrud($sql);
	}

	//genera el maximo y el medio del dia
	function generarDvvDia($idEstacion, $idAno, $variable){
		$objDatos = new clsDatos();
		//generar los datos
		$limtMes = mesMaximoFact($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
		//obtiene el dia mas alto que existe se obtienen de la fact_table y date_dim
			$limtDia = diaMaximoFact($idEstacion, $idAno, $mes);
			for ($dia=1; $dia <= $limtDia; $dia++) { 
				//obtener calculos de temperatudara del dia
				$datosDia = datosDvvDia($idEstacion, $idAno, $mes, $dia);
				//insertar datos calculados en la tabla indicador
				if ( yaExisteEstacion($idEstacion, $idAno, $mes, $dia) ) {
					updateIndicadorDvv($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}else{
					insertIndicadorDvv($datosDia, $idEstacion, $variable, $idAno, $mes, $dia);
				}
				//CALCULAR DIRECCION DEL VIENTO
				contarDvvDia($idEstacion, $idAno, $mes, $dia);
			}
		}
	}

	// contar la direccion del viento y clasificarla	
	function contarDvvDia($idEstacion, $idAno, $mes, $dia){
		$objDatos = new clsDatos();
		/************
		Madrugada		0-21600		00:00:00-05.59:59
		Mañana		21601-43200		06:00:00-11:59:59
		Tarde 		43201-64800		12:00:00-17:59:59
		Noche 		64801-86400		18:00:00-23:59:59
		************/
		$idMenorDiurno = 21601;
		$idMayorDiurno = 64800;
		$idMenorNoctur = 0;
		$idMayorNoctur = 86400;
		$constDivi = 144;
		/*if ($dia=0) {
			#$diaMax = diaMaximoFact($idEstacion, $idAno, $mes);
			#$constDivi = $constDivi * $diaMax;
			$constDivi = 4420;
			diurnoMes($idEstacion, $idAno, $mes, $idMenorDiurno, $idMayorDiurno, $constDivi);
			nocturnoMes($idEstacion, $idAno, $mes, $idMenorNoctur, $idMenorDiurno-1, $idMayorDiurno+1, $idMayorNoctur, $constDivi);
	
		}
		if ($mes=0) {
			$constDivi = 52560;#$constDivi * 365;
			diurnoAnio($idEstacion, $idAno, $idMenorDiurno, $idMayorDiurno, $constDivi);
			nocturnoAnio($idEstacion, $idAno, $idMenorNoctur, $idMenorDiurno-1, $idMayorDiurno+1, $idMayorNoctur, $constDivi);
		}
		if ($dia>0 && $mes>0) {*/
			diurno($idEstacion, $idAno, $mes, $dia, $idMenorDiurno, $idMayorDiurno, $constDivi);
			nocturno($idEstacion, $idAno, $mes, $dia, $idMenorNoctur, $idMenorDiurno-1, $idMayorDiurno+1, $idMayorNoctur, $constDivi);

		#}
	}

	// contar la direccion del viento y clasificarla	
	function contarDvvMes($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();
		/************
		Madrugada		0-21600		00:00:00-05.59:59
		Mañana		21601-43200		06:00:00-11:59:59
		Tarde 		43201-64800		12:00:00-17:59:59
		Noche 		64801-86400		18:00:00-23:59:59
		************/
		$idMenorDiurno = 21601;
		$idMayorDiurno = 64800;
		$idMenorNoctur = 0;
		$idMayorNoctur = 86400;
		/*$constDivi = 144;
		if ($dia=0) {
			#$diaMax = diaMaximoFact($idEstacion, $idAno, $mes);
			#$constDivi = $constDivi * $diaMax;
			*/
			$constDivi = 4420;
			diurnoMes($idEstacion, $idAno, $mes, $idMenorDiurno, $idMayorDiurno, $constDivi);
			nocturnoMes($idEstacion, $idAno, $mes, $idMenorNoctur, $idMenorDiurno-1, $idMayorDiurno+1, $idMayorNoctur, $constDivi);
	/*
		}
		if ($mes=0) {
			$constDivi = 52560;#$constDivi * 365;
			diurnoAnio($idEstacion, $idAno, $idMenorDiurno, $idMayorDiurno, $constDivi);
			nocturnoAnio($idEstacion, $idAno, $idMenorNoctur, $idMenorDiurno-1, $idMayorDiurno+1, $idMayorNoctur, $constDivi);
		}
		if ($dia>0 && $mes>0) {
			diurno($idEstacion, $idAno, $mes, $dia, $idMenorDiurno, $idMayorDiurno, $constDivi);
			nocturno($idEstacion, $idAno, $mes, $dia, $idMenorNoctur, $idMenorDiurno-1, $idMayorDiurno+1, $idMayorNoctur, $constDivi);
		}*/
	}

	// contar la direccion del viento y clasificarla	
	function contarDvvAnio($idEstacion, $idAno){
		$objDatos = new clsDatos();
		/************
		Madrugada		0-21600		00:00:00-05.59:59
		Mañana		21601-43200		06:00:00-11:59:59
		Tarde 		43201-64800		12:00:00-17:59:59
		Noche 		64801-86400		18:00:00-23:59:59
		************/
		$idMenorDiurno = 21601;
		$idMayorDiurno = 64800;
		$idMenorNoctur = 0;
		$idMayorNoctur = 86400;
		/*$constDivi = 144;
		if ($dia=0) {
			#$diaMax = diaMaximoFact($idEstacion, $idAno, $mes);
			#$constDivi = $constDivi * $diaMax;
			$constDivi = 4420;
			diurnoMes($idEstacion, $idAno, $mes, $idMenorDiurno, $idMayorDiurno, $constDivi);
			nocturnoMes($idEstacion, $idAno, $mes, $idMenorNoctur, $idMenorDiurno-1, $idMayorDiurno+1, $idMayorNoctur, $constDivi);
		}
		if ($mes=0) {
			*/
			$constDivi = 52560;#$constDivi * 365;
			diurnoAnio($idEstacion, $idAno, $idMenorDiurno, $idMayorDiurno, $constDivi);
			nocturnoAnio($idEstacion, $idAno, $idMenorNoctur, $idMenorDiurno-1, $idMayorDiurno+1, $idMayorNoctur, $constDivi);
	/*
		}
		if ($dia>0 && $mes>0) {
			diurno($idEstacion, $idAno, $mes, $dia, $idMenorDiurno, $idMayorDiurno, $constDivi);
			nocturno($idEstacion, $idAno, $mes, $dia, $idMenorNoctur, $idMenorDiurno-1, $idMayorDiurno+1, $idMayorNoctur, $constDivi);
		}*/
	}

	function nocturno($idEstacion, $idAno, $mes, $dia, $iniRang1, $finRang1, $iniRang2, $finRang2, $constDivi){
		$objDatos = new clsDatos();	
		$rango = array(0 => 0, 1 => 11, 2 => 12, 3 => 33, 4 => 34, 5 => 56, 6 => 57, 7 => 78, 
			8 => 79, 9 => 101, 10 => 102, 11 => 123, 12 => 124, 13 => 146, 14 => 147, 15 => 168,
			16 => 169, 17 => 191, 18 => 192, 19 => 216, 20 => 217, 21 => 236, 22 => 237, 23 => 258,
			24 => 259, 25 => 281, 26 => 282, 27 => 303, 28 => 304, 29 => 326, 30 => 327,
			31 => 348, 32 => 349, 33 => 360);
		$direccion = array( 0 =>'N' , 1 =>'N' ,  2 => 'NNE',3 => 'NNE',  4 => 'NE', 5 => 'NE',  
							6 => 'ENE', 7 => 'ENE',  8 => 'E', 9 => 'E', 10 => 'ESE', 11 => 'ESE',  
							12 => 'SE', 13 => 'SE',  14 => 'SSE', 15 => 'SSE',  16 => 'S', 17 => 'S',  
							18 => 'SSO', 19 => 'SSO',  20 => 'SO', 21 => 'SO', 22 => 'OSO', 23 => 'OSO',  
							24 => 'O', 25 => 'O',  26 => 'ONO', 27 => 'ONO',  28 => 'NO', 29 => 'NO',  
							30 => 'NNO', 31 => 'NNO',  32 => 'N', 33 => 'N' );
		$dirV = array();
		$dirVPre = array();
		$posMayor=0;
		$numMayor=0;
		$tam = count($rango);
		for ($i=1; $i < $tam; $i = $i+2) { 
			$sql = "SELECT COUNT(direccion_viento)
					FROM fact_table, date_dim 
					WHERE fact_table.direccion_viento>=".$rango[$i-1]." 
							AND fact_table.direccion_viento<=".$rango[$i]." 
							AND fact_table.fecha_sk=date_dim.fecha_sk 
							AND fact_table.estacion_sk=".$idEstacion."  
							AND date_dim.año=".$idAno;
							//if ($mes>0) {
								$sql = $sql." AND date_dim.mes=".$mes;
							//}
							//if ($dia>0) {
								$sql .= " AND date_dim.dia=".$dia;
							//}
							$sql .= " AND ((fact_table.tiempo_sk>=".$iniRang1." 
							AND fact_table.tiempo_sk<=".$finRang1.") OR
							(fact_table.tiempo_sk>=".$iniRang2." 
							AND fact_table.tiempo_sk<=".$finRang2."))";
			$datos_desordenados = $objDatos->hacerConsulta($sql);
			$arreglo_dir = $objDatos->generarArreglo($datos_desordenados);
			$dirVPre[$i] = $arreglo_dir[0];
			$dirV[$i] = ($arreglo_dir[0]/$constDivi)*100;
			if ($numMayor<=$dirV[$i]) {
				$numMayor=$dirV[$i];
			}
			$objDatos->cerrarConsulta($sql);
		}
		for ($i=1; $i <= $tam; $i = $i+2) { 
			if ($numMayor>=$rango[$i-1] && $numMayor<=$rango[$i]) {
				$posMayor=$i;
			}
		}
		$sumN = $dirV[1]+$dirV[33];
		$sql = "UPDATE indicador SET n_dia_nocturno=".$sumN
				.", nne_dia_nocturno=".$dirV[3]
				.", ne_dia_nocturno= ".$dirV[5]
				.", ene_dia_nocturno= ".$dirV[7] 
				.", e_dia_nocturno= ".$dirV[9] 
				.", ese_dia_nocturno= ".$dirV[11] 
				.", se_dia_nocturno= ".$dirV[13]
				.", sse_dia_nocturno= ".$dirV[15] 
				.", s_dia_nocturno= ".$dirV[17]
				.", sso_dia_nocturno= ".$dirV[19] 
				.", so_dia_nocturno= ".$dirV[21] 
				.", oso_dia_nocturno= ".$dirV[23]
				.", o_dia_nocturno= ".$dirV[25] 
				.", ono_dia_nocturno= ".$dirV[27] 
				.", no_dia_nocturno= ".$dirV[29] 
				.", nno_dia_nocturno= ".$dirV[31] 
				." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=".$dia;
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);

		$sumN = $dirVPre[1]+$dirVPre[33];
		$sql = "UPDATE indicador SET pre_n_dia_nocturno=".$sumN
				.", pre_nne_dia_nocturno=".$dirVPre[3]
				.", pre_ne_dia_nocturno= ".$dirVPre[5]
				.", pre_ene_dia_nocturno= ".$dirVPre[7] 
				.", pre_e_dia_nocturno= ".$dirVPre[9] 
				.", pre_ese_dia_nocturno= ".$dirVPre[11] 
				.", pre_se_dia_nocturno= ".$dirVPre[13]
				.", pre_sse_dia_nocturno= ".$dirVPre[15] 
				.", pre_s_dia_nocturno= ".$dirVPre[17]
				.", pre_sso_dia_nocturno= ".$dirVPre[19] 
				.", pre_so_dia_nocturno= ".$dirVPre[21] 
				.", pre_oso_dia_nocturno= ".$dirVPre[23]
				.", pre_o_dia_nocturno= ".$dirVPre[25] 
				.", pre_ono_dia_nocturno= ".$dirVPre[27] 
				.", pre_no_dia_nocturno= ".$dirVPre[29] 
				.", pre_nno_dia_nocturno= ".$dirVPre[31] 
				." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=".$dia;
		$objDatos->operacionesCrud($sql);
		$sql = "UPDATE indicador SET frec_dv_nocturno=".$numMayor.
				", des_dv_nocturno='".$direccion[$posMayor]."'
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=".$dia;
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);
	}

	function diurno($idEstacion, $idAno, $mes, $dia, $idMenor, $idMayor, $constDivi){
		$objDatos = new clsDatos();	
		$rango = array( 0 => 0, 1 => 11, 
						2 => 12, 3 => 33, 
						4 => 34, 5 => 56, 
						6 => 57, 7 => 78, 
						8 => 79, 9 => 101, 
						10 => 102, 11 => 123, 
						12 => 124, 13 => 146, 
						14 => 147, 15 => 168,
						16 => 169, 17 => 191, 
						18 => 192, 19 => 216, 
						20 => 217, 21 => 236, 
						22 => 237, 23 => 258,
						24 => 259, 25 => 281, 
						26 => 282, 27 => 303, 
						28 => 304, 29 => 326, 
						30 => 327, 31 => 348, 
						32 => 349, 33 => 360);
		$direccion = array( 0 =>'N' , 1 =>'N' ,  2 => 'NNE',3 => 'NNE',  4 => 'NE', 5 => 'NE',  
							6 => 'ENE', 7 => 'ENE',  8 => 'E', 9 => 'E', 10 => 'ESE', 11 => 'ESE',  
							12 => 'SE', 13 => 'SE',  14 => 'SSE', 15 => 'SSE',  16 => 'S', 17 => 'S',  
							18 => 'SSO', 19 => 'SSO',  20 => 'SO', 21 => 'SO', 22 => 'OSO', 23 => 'OSO',  
							24 => 'O', 25 => 'O',  26 => 'ONO', 27 => 'ONO',  28 => 'NO', 29 => 'NO',  
							30 => 'NNO', 31 => 'NNO',  32 => 'N', 33 => 'N' );
		$dirV = array();
		$dirVP = array();
		$posMayor=0;
		$numMayor=0;
		$tam = count($rango);
		for ($i=1; $i < $tam; $i = $i+2) { 
			$sql = "SELECT COUNT(direccion_viento)
					FROM fact_table, date_dim 
					WHERE fact_table.direccion_viento>=".$rango[$i-1]." 
							AND fact_table.direccion_viento<=".$rango[$i]." 
							AND fact_table.fecha_sk=date_dim.fecha_sk 
							AND fact_table.estacion_sk=".$idEstacion."  
							AND fact_table.tiempo_sk>=".$idMenor." 
							AND fact_table.tiempo_sk<=".$idMayor."
							AND date_dim.año=".$idAno;
							//if ($mes>0) {
								$sql .= " AND date_dim.mes=".$mes;
							//}
							//if ($dia>0) {
								$sql .= " AND date_dim.dia=".$dia;
							//}
			$datos_desordenados = $objDatos->hacerConsulta($sql);
			$arreglo_dir = $objDatos->generarArreglo($datos_desordenados);
			$dirVPre[$i] = $arreglo_dir[0];
			$dirV[$i] = ($arreglo_dir[0]/$constDivi)*100;
			if ($numMayor<=$dirV[$i]) {
				$numMayor=$dirV[$i];
			}
			$objDatos->cerrarConsulta($sql);
		}
		for ($i=1; $i < $tam; $i = $i+2) { 
			if ($numMayor>=$rango[$i-1] && $numMayor<=$rango[$i]) {
				$posMayor=$i;
			}
		}
		$sumN = $dirV[1]+$dirV[33];
		$sql = "UPDATE indicador SET n_dia_diurno=".$sumN
				.", nne_dia_diurno=".$dirV[3] 
				.", ne_dia_diurno= ".$dirV[5] 
				.", ene_dia_diurno= ".$dirV[7] 
				.", e_dia_diurno= ".$dirV[9] 
				.", ese_dia_diurno= ".$dirV[11] 
				.", se_dia_diurno= ".$dirV[13] 
				.", sse_dia_diurno= ".$dirV[15] 
				.", s_dia_diurno= ".$dirV[17] 
				.", sso_dia_diurno= ".$dirV[19] 
				.", so_dia_diurno= ".$dirV[21] 
				.", oso_dia_diurno= ".$dirV[23] 
				.", o_dia_diurno= ".$dirV[25] 
				.", ono_dia_diurno= ".$dirV[27] 
				.", no_dia_diurno= ".$dirV[29] 
				.", nno_dia_diurno= ".$dirV[31] 
				." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=".$dia;
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);
		$sumN = $dirVPre[1]+$dirVPre[33];
		$sql = "UPDATE indicador SET pre_n_dia_diurno=".$sumN
			.", pre_nne_dia_diurno=".$dirVPre[3] 
			.", pre_ne_dia_diurno= ".$dirVPre[5] 
			.", pre_ene_dia_diurno= ".$dirVPre[7] 
			.", pre_e_dia_diurno= ".$dirVPre[9] 
			.", pre_ese_dia_diurno= ".$dirVPre[11] 
			.", pre_se_dia_diurno= ".$dirVPre[13] 
			.", pre_sse_dia_diurno= ".$dirVPre[15] 
			.", pre_s_dia_diurno= ".$dirVPre[17] 
			.", pre_sso_dia_diurno= ".$dirVPre[19] 
			.", pre_so_dia_diurno= ".$dirVPre[21] 
			.", pre_oso_dia_diurno= ".$dirVPre[23] 
			.", pre_o_dia_diurno= ".$dirVPre[25] 
			.", pre_ono_dia_diurno= ".$dirVPre[27] 
			.", pre_no_dia_diurno= ".$dirVPre[29] 
			.", pre_nno_dia_diurno= ".$dirVPre[31] 
			." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=".$dia;
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);
		$sql = "UPDATE indicador SET frec_dv_diurno=".$numMayor.
				", des_dv_diurno='".$direccion[$posMayor]."' 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=".$dia;
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);
	}

	function nocturnoMes($idEstacion, $idAno, $mes, $iniRang1, $finRang1, $iniRang2, $finRang2, $constDivi){
		$objDatos = new clsDatos();	
		$rango = array(0 => 0, 1 => 11, 2 => 12, 3 => 33, 4 => 34, 5 => 56, 6 => 57, 7 => 78, 
			8 => 79, 9 => 101, 10 => 102, 11 => 123, 12 => 124, 13 => 146, 14 => 147, 15 => 168,
			16 => 169, 17 => 191, 18 => 192, 19 => 216, 20 => 217, 21 => 236, 22 => 237, 23 => 258,
			24 => 259, 25 => 281, 26 => 282, 27 => 303, 28 => 304, 29 => 326, 30 => 327,
			31 => 348, 32 => 349, 33 => 360);
		$direccion = array( 0 =>'N' , 1 =>'N' ,  2 => 'NNE',3 => 'NNE',  4 => 'NE', 5 => 'NE',  
							6 => 'ENE', 7 => 'ENE',  8 => 'E', 9 => 'E', 10 => 'ESE', 11 => 'ESE',  
							12 => 'SE', 13 => 'SE',  14 => 'SSE', 15 => 'SSE',  16 => 'S', 17 => 'S',  
							18 => 'SSO', 19 => 'SSO',  20 => 'SO', 21 => 'SO', 22 => 'OSO', 23 => 'OSO',  
							24 => 'O', 25 => 'O',  26 => 'ONO', 27 => 'ONO',  28 => 'NO', 29 => 'NO',  
							30 => 'NNO', 31 => 'NNO',  32 => 'N', 33 => 'N' );
		$dirV = array();
		$dirVPre = array();
		$posMayor=0;
		$numMayor=0;
		$tam = count($rango);
		for ($i=1; $i < $tam; $i = $i+2) { 
			$sql = "SELECT COUNT(direccion_viento)
					FROM fact_table, date_dim 
					WHERE fact_table.direccion_viento>=".$rango[$i-1]." 
							AND fact_table.direccion_viento<=".$rango[$i]." 
							AND fact_table.fecha_sk=date_dim.fecha_sk 
							AND fact_table.estacion_sk=".$idEstacion."  
							AND date_dim.año=".$idAno;
							//if ($mes>0) {
								$sql = $sql." AND date_dim.mes=".$mes;
							//}
							//if ($dia>0) {
								#$sql .= " AND date_dim.dia=".$dia;
							//}
							$sql .= " AND ((fact_table.tiempo_sk>=".$iniRang1." 
							AND fact_table.tiempo_sk<=".$finRang1.") OR
							(fact_table.tiempo_sk>=".$iniRang2." 
							AND fact_table.tiempo_sk<=".$finRang2."))";
			$datos_desordenados = $objDatos->hacerConsulta($sql);
			$arreglo_dir = $objDatos->generarArreglo($datos_desordenados);
			$dirVPre[$i] = (int)$arreglo_dir[0];
			$dirV[$i] = ($arreglo_dir[0]/$constDivi)*100;
			if ($numMayor<=$dirV[$i]) {
				$numMayor=$dirV[$i];
			}
			$objDatos->cerrarConsulta($sql);
		}
		for ($i=1; $i <= $tam; $i = $i+2) { 
			if ($numMayor>=$rango[$i-1] && $numMayor<=$rango[$i]) {
				$posMayor=$i;
			}
		}

		$sumN = $dirV[1]+$dirV[33];
		$sql = "UPDATE indicador SET n_dia_nocturno=".$sumN
				.", nne_dia_nocturno=".$dirV[3]
				.", ne_dia_nocturno= ".$dirV[5]
				.", ene_dia_nocturno= ".$dirV[7] 
				.", e_dia_nocturno= ".$dirV[9] 
				.", ese_dia_nocturno= ".$dirV[11] 
				.", se_dia_nocturno= ".$dirV[13]
				.", sse_dia_nocturno= ".$dirV[15] 
				.", s_dia_nocturno= ".$dirV[17]
				.", sso_dia_nocturno= ".$dirV[19] 
				.", so_dia_nocturno= ".$dirV[21] 
				.", oso_dia_nocturno= ".$dirV[23]
				.", o_dia_nocturno= ".$dirV[25] 
				.", ono_dia_nocturno= ".$dirV[27] 
				.", no_dia_nocturno= ".$dirV[29] 
				.", nno_dia_nocturno= ".$dirV[31] 
				." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);

		$sumN = $dirVPre[1]+$dirVPre[33];
		$sql = "UPDATE indicador SET pre_n_dia_nocturno=".$sumN
				.", pre_nne_dia_nocturno=".$dirVPre[3]
				.", pre_ne_dia_nocturno= ".$dirVPre[5]
				.", pre_ene_dia_nocturno= ".$dirVPre[7] 
				.", pre_e_dia_nocturno= ".$dirVPre[9] 
				.", pre_ese_dia_nocturno= ".$dirVPre[11] 
				.", pre_se_dia_nocturno= ".$dirVPre[13]
				.", pre_sse_dia_nocturno= ".$dirVPre[15] 
				.", pre_s_dia_nocturno= ".$dirVPre[17]
				.", pre_sso_dia_nocturno= ".$dirVPre[19] 
				.", pre_so_dia_nocturno= ".$dirVPre[21] 
				.", pre_oso_dia_nocturno= ".$dirVPre[23]
				.", pre_o_dia_nocturno= ".$dirVPre[25] 
				.", pre_ono_dia_nocturno= ".$dirVPre[27] 
				.", pre_no_dia_nocturno= ".$dirVPre[29] 
				.", pre_nno_dia_nocturno= ".$dirVPre[31] 
				." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);

		$sql = "UPDATE indicador SET frec_dv_nocturno=".$numMayor.
				", des_dv_nocturno='".$direccion[$posMayor]."'
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);

	}

	function diurnoMes($idEstacion, $idAno, $mes, $idMenor, $idMayor, $constDivi){
		$objDatos = new clsDatos();	
		$rango = array( 0 => 0, 1 => 11, 
						2 => 12, 3 => 33, 
						4 => 34, 5 => 56, 
						6 => 57, 7 => 78, 
						8 => 79, 9 => 101, 
						10 => 102, 11 => 123, 
						12 => 124, 13 => 146, 
						14 => 147, 15 => 168,
						16 => 169, 17 => 191, 
						18 => 192, 19 => 216, 
						20 => 217, 21 => 236, 
						22 => 237, 23 => 258,
						24 => 259, 25 => 281, 
						26 => 282, 27 => 303, 
						28 => 304, 29 => 326, 
						30 => 327, 31 => 348, 
						32 => 349, 33 => 360);
		$direccion = array( 0 =>'N' , 1 =>'N' ,  2 => 'NNE',3 => 'NNE',  4 => 'NE', 5 => 'NE',  
							6 => 'ENE', 7 => 'ENE',  8 => 'E', 9 => 'E', 10 => 'ESE', 11 => 'ESE',  
							12 => 'SE', 13 => 'SE',  14 => 'SSE', 15 => 'SSE',  16 => 'S', 17 => 'S',  
							18 => 'SSO', 19 => 'SSO',  20 => 'SO', 21 => 'SO', 22 => 'OSO', 23 => 'OSO',  
							24 => 'O', 25 => 'O',  26 => 'ONO', 27 => 'ONO',  28 => 'NO', 29 => 'NO',  
							30 => 'NNO', 31 => 'NNO',  32 => 'N', 33 => 'N' );
		$dirV = array();
		$dirVP = array();
		$posMayor=0;
		$numMayor=0;
		$tam = count($rango);
		for ($i=1; $i < $tam; $i = $i+2) { 
			$sql = "SELECT COUNT(direccion_viento)
					FROM fact_table, date_dim 
					WHERE fact_table.direccion_viento>=".$rango[$i-1]." 
							AND fact_table.direccion_viento<=".$rango[$i]." 
							AND fact_table.fecha_sk=date_dim.fecha_sk 
							AND fact_table.estacion_sk=".$idEstacion."  
							AND fact_table.tiempo_sk>=".$idMenor." 
							AND fact_table.tiempo_sk<=".$idMayor."
							AND date_dim.año=".$idAno;
							//if ($mes>0) {
								$sql .= " AND date_dim.mes=".$mes;
							//}
							//if ($dia>0) {
								#$sql .= " AND date_dim.dia=".$dia;
							//}
			$datos_desordenados = $objDatos->hacerConsulta($sql);
			$arreglo_dir = $objDatos->generarArreglo($datos_desordenados);
			$dirVPre[$i] = $arreglo_dir[0];
			$dirV[$i] = ($arreglo_dir[0]/$constDivi)*100;
			if ($numMayor<=$dirV[$i]) {
				$numMayor=$dirV[$i];
			}
			$objDatos->cerrarConsulta($sql);
		}
		for ($i=1; $i < $tam; $i = $i+2) { 
			if ($numMayor>=$rango[$i-1] && $numMayor<=$rango[$i]) {
				$posMayor=$i;
			}
		}
		$sumN = $dirV[1]+$dirV[33];
		$sql = "UPDATE indicador SET n_dia_diurno=".$sumN
				.", nne_dia_diurno=".$dirV[3] 
				.", ne_dia_diurno= ".$dirV[5] 
				.", ene_dia_diurno= ".$dirV[7] 
				.", e_dia_diurno= ".$dirV[9] 
				.", ese_dia_diurno= ".$dirV[11] 
				.", se_dia_diurno= ".$dirV[13] 
				.", sse_dia_diurno= ".$dirV[15] 
				.", s_dia_diurno= ".$dirV[17] 
				.", sso_dia_diurno= ".$dirV[19] 
				.", so_dia_diurno= ".$dirV[21] 
				.", oso_dia_diurno= ".$dirV[23] 
				.", o_dia_diurno= ".$dirV[25] 
				.", ono_dia_diurno= ".$dirV[27] 
				.", no_dia_diurno= ".$dirV[29] 
				.", nno_dia_diurno= ".$dirV[31] 
				." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);

		$sumN = $dirVPre[1]+$dirVPre[33];
		$sql = "UPDATE indicador SET pre_n_dia_diurno=".$sumN
			.", pre_nne_dia_diurno=".$dirVPre[3] 
			.", pre_ne_dia_diurno= ".$dirVPre[5] 
			.", pre_ene_dia_diurno= ".$dirVPre[7] 
			.", pre_e_dia_diurno= ".$dirVPre[9] 
			.", pre_ese_dia_diurno= ".$dirVPre[11] 
			.", pre_se_dia_diurno= ".$dirVPre[13] 
			.", pre_sse_dia_diurno= ".$dirVPre[15] 
			.", pre_s_dia_diurno= ".$dirVPre[17] 
			.", pre_sso_dia_diurno= ".$dirVPre[19] 
			.", pre_so_dia_diurno= ".$dirVPre[21] 
			.", pre_oso_dia_diurno= ".$dirVPre[23] 
			.", pre_o_dia_diurno= ".$dirVPre[25] 
			.", pre_ono_dia_diurno= ".$dirVPre[27] 
			.", pre_no_dia_diurno= ".$dirVPre[29] 
			.", pre_nno_dia_diurno= ".$dirVPre[31] 
			." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);

		$sql = "UPDATE indicador SET frec_dv_diurno=".$numMayor.
				", des_dv_diurno='".$direccion[$posMayor]."' 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=".$mes." AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);
	}


	function nocturnoAnio($idEstacion, $idAno, $iniRang1, $finRang1, $iniRang2, $finRang2, $constDivi){
		$objDatos = new clsDatos();	
		$rango = array(0 => 0, 1 => 11, 2 => 12, 3 => 33, 4 => 34, 5 => 56, 6 => 57, 7 => 78, 
			8 => 79, 9 => 101, 10 => 102, 11 => 123, 12 => 124, 13 => 146, 14 => 147, 15 => 168,
			16 => 169, 17 => 191, 18 => 192, 19 => 216, 20 => 217, 21 => 236, 22 => 237, 23 => 258,
			24 => 259, 25 => 281, 26 => 282, 27 => 303, 28 => 304, 29 => 326, 30 => 327,
			31 => 348, 32 => 349, 33 => 360);
		$direccion = array( 0 =>'N' , 1 =>'N' ,  2 => 'NNE',3 => 'NNE',  4 => 'NE', 5 => 'NE',  
							6 => 'ENE', 7 => 'ENE',  8 => 'E', 9 => 'E', 10 => 'ESE', 11 => 'ESE',  
							12 => 'SE', 13 => 'SE',  14 => 'SSE', 15 => 'SSE',  16 => 'S', 17 => 'S',  
							18 => 'SSO', 19 => 'SSO',  20 => 'SO', 21 => 'SO', 22 => 'OSO', 23 => 'OSO',  
							24 => 'O', 25 => 'O',  26 => 'ONO', 27 => 'ONO',  28 => 'NO', 29 => 'NO',  
							30 => 'NNO', 31 => 'NNO',  32 => 'N', 33 => 'N' );
		$dirV = array();
		$dirVPre = array();
		$posMayor=0;
		$numMayor=0;
		$tam = count($rango);
		for ($i=1; $i < $tam; $i = $i+2) { 
			$sql = "SELECT COUNT(direccion_viento)
					FROM fact_table, date_dim 
					WHERE fact_table.direccion_viento>=".$rango[$i-1]." 
							AND fact_table.direccion_viento<=".$rango[$i]." 
							AND fact_table.fecha_sk=date_dim.fecha_sk 
							AND fact_table.estacion_sk=".$idEstacion."  
							AND date_dim.año=".$idAno;
							//if ($mes>0) {
								#$sql = $sql." AND date_dim.mes=".$mes;
							//}
							//if ($dia>0) {
								#$sql .= " AND date_dim.dia=".$dia;
							//}
							$sql .= " AND ((fact_table.tiempo_sk>=".$iniRang1." 
							AND fact_table.tiempo_sk<=".$finRang1.") OR
							(fact_table.tiempo_sk>=".$iniRang2." 
							AND fact_table.tiempo_sk<=".$finRang2."))";
			$datos_desordenados = $objDatos->hacerConsulta($sql);
			$arreglo_dir = $objDatos->generarArreglo($datos_desordenados);
			$dirVPre[$i] = $arreglo_dir[0];
			$dirV[$i] = ($arreglo_dir[0]/$constDivi)*100;
			if ($numMayor<=$dirV[$i]) {
				$numMayor=$dirV[$i];
			}
			$objDatos->cerrarConsulta($sql);
		}
		for ($i=1; $i <= $tam; $i = $i+2) { 
			if ($numMayor>=$rango[$i-1] && $numMayor<=$rango[$i]) {
				$posMayor=$i;
			}
		}
		$sumN = $dirV[1]+$dirV[33];
		$sql = "UPDATE indicador SET n_dia_nocturno=".$sumN
				.", nne_dia_nocturno=".$dirV[3]
				.", ne_dia_nocturno= ".$dirV[5]
				.", ene_dia_nocturno= ".$dirV[7] 
				.", e_dia_nocturno= ".$dirV[9] 
				.", ese_dia_nocturno= ".$dirV[11] 
				.", se_dia_nocturno= ".$dirV[13]
				.", sse_dia_nocturno= ".$dirV[15] 
				.", s_dia_nocturno= ".$dirV[17]
				.", sso_dia_nocturno= ".$dirV[19] 
				.", so_dia_nocturno= ".$dirV[21] 
				.", oso_dia_nocturno= ".$dirV[23]
				.", o_dia_nocturno= ".$dirV[25] 
				.", ono_dia_nocturno= ".$dirV[27] 
				.", no_dia_nocturno= ".$dirV[29] 
				.", nno_dia_nocturno= ".$dirV[31] 
				." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=0 AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);

		$sumN = $dirVPre[1]+$dirVPre[33];
		$sql = "UPDATE indicador SET pre_n_dia_nocturno=".$sumN
				.", pre_nne_dia_nocturno=".$dirVPre[3]
				.", pre_ne_dia_nocturno= ".$dirVPre[5]
				.", pre_ene_dia_nocturno= ".$dirVPre[7] 
				.", pre_e_dia_nocturno= ".$dirVPre[9] 
				.", pre_ese_dia_nocturno= ".$dirVPre[11] 
				.", pre_se_dia_nocturno= ".$dirVPre[13]
				.", pre_sse_dia_nocturno= ".$dirVPre[15] 
				.", pre_s_dia_nocturno= ".$dirVPre[17]
				.", pre_sso_dia_nocturno= ".$dirVPre[19] 
				.", pre_so_dia_nocturno= ".$dirVPre[21] 
				.", pre_oso_dia_nocturno= ".$dirVPre[23]
				.", pre_o_dia_nocturno= ".$dirVPre[25] 
				.", pre_ono_dia_nocturno= ".$dirVPre[27] 
				.", pre_no_dia_nocturno= ".$dirVPre[29] 
				.", pre_nno_dia_nocturno= ".$dirVPre[31] 
				." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=0 AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);

		$sql = "UPDATE indicador SET frec_dv_nocturno=".$numMayor.
				", des_dv_nocturno='".$direccion[$posMayor]."'
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=0 AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);
	}

	function diurnoAnio($idEstacion, $idAno, $idMenor, $idMayor, $constDivi){
		$objDatos = new clsDatos();	
		$rango = array( 0 => 0, 1 => 11, 
						2 => 12, 3 => 33, 
						4 => 34, 5 => 56, 
						6 => 57, 7 => 78, 
						8 => 79, 9 => 101, 
						10 => 102, 11 => 123, 
						12 => 124, 13 => 146, 
						14 => 147, 15 => 168,
						16 => 169, 17 => 191, 
						18 => 192, 19 => 216, 
						20 => 217, 21 => 236, 
						22 => 237, 23 => 258,
						24 => 259, 25 => 281, 
						26 => 282, 27 => 303, 
						28 => 304, 29 => 326, 
						30 => 327, 31 => 348, 
						32 => 349, 33 => 360);
		$direccion = array( 0 =>'N' , 1 =>'N' ,  2 => 'NNE',3 => 'NNE',  4 => 'NE', 5 => 'NE',  
							6 => 'ENE', 7 => 'ENE',  8 => 'E', 9 => 'E', 10 => 'ESE', 11 => 'ESE',  
							12 => 'SE', 13 => 'SE',  14 => 'SSE', 15 => 'SSE',  16 => 'S', 17 => 'S',  
							18 => 'SSO', 19 => 'SSO',  20 => 'SO', 21 => 'SO', 22 => 'OSO', 23 => 'OSO',  
							24 => 'O', 25 => 'O',  26 => 'ONO', 27 => 'ONO',  28 => 'NO', 29 => 'NO',  
							30 => 'NNO', 31 => 'NNO',  32 => 'N', 33 => 'N' );
		$dirV = array();
		$dirVP = array();
		$posMayor=0;
		$numMayor=0;
		$tam = count($rango);
		for ($i=1; $i < $tam; $i = $i+2) { 
			$sql = "SELECT COUNT(direccion_viento)
					FROM fact_table, date_dim 
					WHERE fact_table.direccion_viento>=".$rango[$i-1]." 
							AND fact_table.direccion_viento<=".$rango[$i]." 
							AND fact_table.fecha_sk=date_dim.fecha_sk 
							AND fact_table.estacion_sk=".$idEstacion."  
							AND fact_table.tiempo_sk>=".$idMenor." 
							AND fact_table.tiempo_sk<=".$idMayor."
							AND date_dim.año=".$idAno;
							//if ($mes>0) {
								#$sql .= " AND date_dim.mes=".$mes;
							//}
							//if ($dia>0) {
								#$sql .= " AND date_dim.dia=".$dia;
							//}
			$datos_desordenados = $objDatos->hacerConsulta($sql);
			$arreglo_dir = $objDatos->generarArreglo($datos_desordenados);
			$dirVPre[$i] = $arreglo_dir[0];
			$dirV[$i] = ($arreglo_dir[0]/$constDivi)*100;
			if ($numMayor<=$dirV[$i]) {
				$numMayor=$dirV[$i];
			}
			$objDatos->cerrarConsulta($sql);
		}
		for ($i=1; $i < $tam; $i = $i+2) { 
			if ($numMayor>=$rango[$i-1] && $numMayor<=$rango[$i]) {
				$posMayor=$i;
			}
		}
		$sumN = $dirV[1]+$dirV[33];
		$sql = "UPDATE indicador SET n_dia_diurno=".$sumN
				.", nne_dia_diurno=".$dirV[3] 
				.", ne_dia_diurno= ".$dirV[5] 
				.", ene_dia_diurno= ".$dirV[7] 
				.", e_dia_diurno= ".$dirV[9] 
				.", ese_dia_diurno= ".$dirV[11] 
				.", se_dia_diurno= ".$dirV[13] 
				.", sse_dia_diurno= ".$dirV[15] 
				.", s_dia_diurno= ".$dirV[17] 
				.", sso_dia_diurno= ".$dirV[19] 
				.", so_dia_diurno= ".$dirV[21] 
				.", oso_dia_diurno= ".$dirV[23] 
				.", o_dia_diurno= ".$dirV[25] 
				.", ono_dia_diurno= ".$dirV[27] 
				.", no_dia_diurno= ".$dirV[29] 
				.", nno_dia_diurno= ".$dirV[31] 
				." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=0 AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);

		$sumN = $dirVPre[1]+$dirVPre[33];
		$sql = "UPDATE indicador SET pre_n_dia_diurno=".$sumN
			.", pre_nne_dia_diurno=".$dirVPre[3] 
			.", pre_ne_dia_diurno= ".$dirVPre[5] 
			.", pre_ene_dia_diurno= ".$dirVPre[7] 
			.", pre_e_dia_diurno= ".$dirVPre[9] 
			.", pre_ese_dia_diurno= ".$dirVPre[11] 
			.", pre_se_dia_diurno= ".$dirVPre[13] 
			.", pre_sse_dia_diurno= ".$dirVPre[15] 
			.", pre_s_dia_diurno= ".$dirVPre[17] 
			.", pre_sso_dia_diurno= ".$dirVPre[19] 
			.", pre_so_dia_diurno= ".$dirVPre[21] 
			.", pre_oso_dia_diurno= ".$dirVPre[23] 
			.", pre_o_dia_diurno= ".$dirVPre[25] 
			.", pre_ono_dia_diurno= ".$dirVPre[27] 
			.", pre_no_dia_diurno= ".$dirVPre[29] 
			.", pre_nno_dia_diurno= ".$dirVPre[31] 
			." WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=0 AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);

		$sql = "UPDATE indicador SET frec_dv_diurno=".$numMayor.
				", des_dv_diurno='".$direccion[$posMayor]."' 
				WHERE estacion=".$idEstacion." AND anio=".$idAno." AND  mes=0 AND dia=0";
		$objDatos->operacionesCrud($sql);
		$objDatos->cerrarConsulta($sql);
		
	}

	function ejecutarISP($idEstacion, $idAno){
		//Ejecutar el tercer indicador Ppt
		$existenDatos = cantDatos($idEstacion, 3, $idAno);
		if ($existenDatos < 1) {
			ejecutarPpt($idEstacion, $idAno, 3);
		}
		//CALCULAR g()

		//CALCULAR G()
		garantizarGammaAcum($idEstacion, $idAno);

		//CALCULAR T()
		/*garantizarT($idEstacion, $idAno);

		//CALCULAR ISP
		garantizarISP($idEstacion, $idAno);

		//ASIGNAR CATEGORIZACION
		categoriaISP($idEstacion, $idAno);*/
	}

	function garantizarGammaAcum($idEstacion, $idAno){
		$alfa = 8.1;
		$beta = 19.2;
		$acumular = "VERDADERO";
		include "PHPExcel/PHPExcel.php";
		$prueba = new PHPExcel(); 
		$prueba->setActiveSheetIndex(0)->setCellValue("A1","PRUEBA");
		$prueba->getActiveSheet()->setTitle("Hoja de prueba"); 
		$objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007'); 
		$objWriter->save('prueba.xlsx'); 
	}

	function garantizarT($idEstacion, $idAno){
		$objDatos = new clsDatos();
		#SI(G5<=0,5;(LN(1/(G5^2)))^0,5;(LN(1/((1-G5)^2)))^0,5)
		#G5 es G()
		$dividendo = 1;
		$expDivisor = 2;
		$exp = 0.5;
		$sustraendo = 1;
		//obtiene el mes mas alto que existe se obtienen de la indicador
		$limtMes = mesMaximoIndicador($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
			$datos = optenDatGammaAcum($idEstacion, $idAno, $mes);
			if ($datos) {
				foreach ($datos as $value) {
					$gammaAcum = $value['gamma'];
				}
				if ($gammaAcum <= 0.5) {
					$parLN = $dividendo/(pow($gammaAcum, $expDivisor));
				}else{
					$parLN = $dividendo/(pow(($sustraendo-$gammaAcum), $expDivisor));
				}
				$valT = pow(log($parLN), $exp);
				$sql = "UPDATE indicador SET t=".$valT." 
						WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes." AND dia=0".";";
				$objDatos->operacionesCrud($sql);
			}
		}
	}

	function optenDatGammaAcum($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT g_con_acumular as gamma 
				FROM indicador 
				WHERE estacion=".$idEstacion." 
					AND anio=".$idAno." AND mes=".$mes." 
					AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	function garantizarISP($idEstacion, $idAno){
		$objDatos = new clsDatos();
		#G11<=0,5    -(H11-($DM$2+($DM$3*H11)+($DM$4*H11^2))/(1+($DM$5^H11)+($DM$6*H11^2)+($DM$7*H11^3)))
		#G11>0,5      (H11-($DM$2+($DM$3*H11)+($DM$4*H11^2))/(1+($DM$5^H11)+($DM$6*H11^2)+($DM$7*H11^3)))
		#H11 es t, y el G11 es gammaAcum
		$C0	= 2.515517; #DM2
		$C1	= 0.802853; #DM3
		$C2	= 0.010328; #DM4
		$D1	= 1.432788; #DM5
		$D2	= 0.189269; #DM6
		$D3	= 0.001308; #DM7
		$exp = 2;
		$valIsp = 0;
		//obtiene el mes mas alto que existe se obtienen de la indicador
		$limtMes = mesMaximoIndicador($idEstacion, $idAno);
		for ($mes=1; $mes <= $limtMes; $mes++) { 
			$datos = optenDatISP($idEstacion, $idAno, $mes);
			if ($datos) {
				foreach ($datos as $value) {
					$gammaAcum = $value['gamma'];
					$t = $value['t'];
				}
				$valIsp = ($t-($C0+($C1*$t)+($C2*pow($t,$exp))/(1+pow($D1,$t)+($D2*pow($t,$exp))+($D3*pow($t,3)))));
				if ($gammaAcum <=0.5) {
					$valIsp = $valIsp*-1;
				}
				$sql = "UPDATE indicador SET isp=".$valIsp." 
						WHERE estacion=".$idEstacion." AND anio=".$idAno." AND mes=".$mes." AND dia=0".";";
				$objDatos->operacionesCrud($sql);
			}
		}
	}

	function optenDatISP($idEstacion, $idAno, $mes){
		$objDatos = new clsDatos();	
		$sql = "SELECT t as t, g_con_acumular as gamma 
				FROM indicador 
				WHERE estacion=".$idEstacion." 
					AND anio=".$idAno." AND mes=".$mes." 
					AND dia=0";
		return $objDatos->executeQuery($sql);
	}

	function categoriaISP($idEstacion, $idAno){
		$objDatos = new clsDatos();
		//escala beaufort del valor maximo
		$sql = "UPDATE indicador SET cat_isp='Extremadamente Seco (Sequia Extrema)' WHERE isp<-2 AND anio=".$idAno." AND estacion=".$idEstacion." ;";
		$sql.= "UPDATE indicador SET cat_isp='Muy Seco (Sequia Severa)' WHERE isp>=-2 AND isp<-1.5 AND anio=".$idAno." AND estacion=".$idEstacion.";";
		$sql.= "UPDATE indicador SET cat_isp='Moderadamente Seco (Sequia Moderada)' WHERE isp>=1.5 AND isp<-1 AND anio=".$idAno." AND estacion=".$idEstacion.";";
		$sql.= "UPDATE indicador SET cat_isp='Ligeramente Seco' WHERE isp>=-1 AND isp<-0.5 AND anio=".$idAno." AND estacion=".$idEstacion.";";
		$sql.= "UPDATE indicador SET cat_isp='Normal' WHERE isp>=-0.5 AND isp<0.5 AND anio=".$idAno." AND estacion=".$idEstacion.";";
		$sql.= "UPDATE indicador SET cat_isp='Ligeramente Húmedo' WHERE isp>=0.5 AND isp<1 AND anio=".$idAno." AND estacion=".$idEstacion.";";
		$sql.= "UPDATE indicador SET cat_isp='Moderadamente Húmedo' WHERE isp>=1 AND isp<1.5 AND anio=".$idAno." AND estacion=".$idEstacion.";";
		$sql.= "UPDATE indicador SET cat_isp='Muy Húmedo' WHERE isp>=1.5 AND isp<2 AND anio=".$idAno." AND estacion=".$idEstacion.";";
		$sql.= "UPDATE indicador SET cat_isp='Extremadamente Húmedo' WHERE isp>=2 AND anio=".$idAno." AND estacion=".$idEstacion.";";
		$objDatos->operacionesCrud($sql);
	}

	function calcularPM10($idEstacion, $menor, $mayor, $variable){
		$IL0 = array( 0,  51, 101, 151, 201, 301, 401);
		$IHi = array(50, 100, 150, 200, 300, 400, 500);
		$calificacion = array('Buena', 'Moderada', 'Daniña a la salud para grupos sensibles', 'Dañina a la salud', 'Muy dañina a la salud', 'Peligrosa', 'Peligrosa');
		$BPL0 = array( 0,  55, 155, 255, 355, 425, 505);
		$BPHi = array(54, 154, 254, 354, 424, 504, 604);
		$div = array((($IHi[0]-$IL0[0])/($BPHi[0]-$BPL0[0])), 
						(($IHi[1]-$IL0[1])/($BPHi[1]-$BPL0[1])), 
						(($IHi[2]-$IL0[2])/($BPHi[2]-$BPL0[2])), 
						(($IHi[3]-$IL0[3])/($BPHi[3]-$BPL0[3])), 
						(($IHi[4]-$IL0[4])/($BPHi[4]-$BPL0[4])), 
						(($IHi[5]-$IL0[5])/($BPHi[5]-$BPL0[5])), 
						(($IHi[6]-$IL0[6])/($BPHi[6]-$BPL0[6])));
		$pos;
		$tam = 7;
		$objDatos = new clsDatos();
		$sql = "SELECT año, mes, dia, pm10 
				FROM fact_aire f, date_dim d 
				WHERE f.fecha_sk=d.fecha_sk AND f.pm10 IS NOT NULL AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor;
		$datos = $objDatos->executeQuery($sql);
		$sql = "INSERT INTO indicador_aire (estacion, anio, mes, dia, hora_inicio, hora_fin, ica_pm10) 
				VALUES ";
		$sqlValidar = "INSERT INTO estacion_indicador VALUES ";
		if ($datos != null) {
			foreach ($datos as $value) {
				$valor = $value['pm10'];
				for ($i=0; $i < $tam ; $i++) { 
					if ($valor >= $BPL0[$i] && $valor <= $BPHi[$i]) {
						$pos = $i;
						break;
					}
				}
				$resultado = $div[$pos] * ($valor - $BPL0[$pos]) + $IL0[$pos];
				if ($resultado < $IL0[$pos] || $resultado > $IHi[$pos]) {
					$resultado = -1;
				}
				$sql .= "(".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia'].", '00:00:00', '23:59:59', ".$resultado."), ";
				$sql2 = "UPDATE indicador_aire SET ica_pm10=".$resultado." WHERE estacion=".$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']
						." AND dia=".$value['dia']." AND hora_inicio='00:00:00' AND hora_fin='23:59:59'";
				$sqlValidar .= "(".$variable.", ".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia']."), ";

				$sqlConsulta = "SELECT count(estacion) FROM indicador_aire WHERE estacion="
								.$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']." AND dia=".$value['dia'];
				$existe = $objDatos->executeQuery($sqlConsulta);
				$existe = $existe[0];
				if ($existe>0) {
					$objDatos->operacionesCrud($sql2);
				}
			}
		}
		$sql = rtrim($sql, ", ");
		$sqlValidar = rtrim($sqlValidar, ", ");
		$objDatos->operacionesCrud($sql);
		$objDatos->operacionesCrud($sqlValidar);
		for ($i=0; $i < $tam; $i++) { 
			$sql = "UPDATE indicador_aire 
					SET calificacion_pm10='".$calificacion[$i]."'
					 WHERE ica_pm10 >= ".$IL0[$i]." AND ica_pm10 <= ".$IHi[$i]." AND estacion =".$idEstacion;
			$objDatos->operacionesCrud($sql);
		}
	}

	function validarIndAire($idEstacion, $idVariable, $menor, $mayor){
		$objDatos = new clsDatos();
		$existe = false;
		do{
			$sqlConsulta = "SELECT count(id_estacion) AS total FROM estacion_indicador WHERE id_estacion="
							.$idEstacion." AND anio=".$menor." AND tipo_ind=".$idVariable;
			$dato = $objDatos->executeQuery($sqlConsulta);
			$dato = $dato[0]['total'];
			if ($dato>0) {
				$existe = false;
			}else{
				$existe = true;
				break;
			}
			$menor++;
		}while ($menor<$mayor);
		return $existe;
	}

	function calcularPM25($idEstacion, $menor, $mayor, $variable){
		$IL0 = array( 0,  51, 101, 151, 201, 301, 401);
		$IHi = array(50, 100, 150, 200, 300, 400, 500);
		$calificacion = array('Buena', 'Moderada', 'Daniña a la salud para grupos sensibles', 'Dañina a la salud', 'Muy dañina a la salud', 'Peligrosa', 'Peligrosa');
		$BPL0 = array( 0,  15.5, 40.5, 65.5, 150.5, 250.5, 350.5);
		$BPHi = array(15.4, 40.4, 65.4, 150.4, 250.4, 350.4, 500.4);
		$div = array((($IHi[0]-$IL0[0])/($BPHi[0]-$BPL0[0])), 
						(($IHi[1]-$IL0[1])/($BPHi[1]-$BPL0[1])), 
						(($IHi[2]-$IL0[2])/($BPHi[2]-$BPL0[2])), 
						(($IHi[3]-$IL0[3])/($BPHi[3]-$BPL0[3])), 
						(($IHi[4]-$IL0[4])/($BPHi[4]-$BPL0[4])), 
						(($IHi[5]-$IL0[5])/($BPHi[5]-$BPL0[5])), 
						(($IHi[6]-$IL0[6])/($BPHi[6]-$BPL0[6])));$pos;
		$tam = 7;
		$objDatos = new clsDatos();
		$sql = "SELECT año, mes, dia, pm2_5 
				FROM fact_aire f, date_dim d 
				WHERE f.fecha_sk=d.fecha_sk AND f.pm2_5 IS NOT NULL AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor;
		$datos = $objDatos->executeQuery($sql);
		$sql = "INSERT INTO indicador_aire (estacion, anio, mes, dia, hora_inicio, hora_fin, ica_pm25) 
				VALUES ";
		$sqlValidar = "INSERT INTO estacion_indicador VALUES ";
		if ($datos != null) {
			foreach ($datos as $value) {
				$valor = $value['pm2_5'];
				for ($i=0; $i < $tam ; $i++) { 
					if ($valor >= $BPL0[$i] && $valor <= $BPHi[$i]) {
						$pos = $i;
						break;
					}
				}
				$resultado = $div[$pos] * ($valor - $BPL0[$pos]) + $IL0[$pos];
				if ($resultado < $IL0[$pos] || $resultado > $IHi[$pos]) {
					$resultado = -1;
				}
				$sql .= "(".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia'].", '00:00:00', '23:59:59', ".$resultado."), ";
				$sql2 = "UPDATE indicador_aire SET ica_pm25=".$resultado." WHERE estacion=".$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']
						." AND dia=".$value['dia']." AND hora_inicio='00:00:00' AND hora_fin='23:59:59'";
				$sqlValidar .= "(".$variable.", ".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia']."), ";
				$sqlConsulta = "SELECT count(estacion) FROM indicador_aire WHERE estacion="
								.$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']." AND dia=".$value['dia'];
				$existe = $objDatos->executeQuery($sqlConsulta);
				$existe = $existe[0];
				if ($existe>0) {
					$objDatos->operacionesCrud($sql2);
				}
			}
		}
		$sql = rtrim($sql, ", ");
		$sqlValidar = rtrim($sqlValidar, ", ");
		$objDatos->operacionesCrud($sql);
		$objDatos->operacionesCrud($sqlValidar);
		for ($i=0; $i < $tam; $i++) { 
			$sql = "UPDATE indicador_aire 
					SET calificacion_pm25='".$calificacion[$i]."'
					 WHERE ica_pm25 >= ".$IL0[$i]." AND ica_pm25 <= ".$IHi[$i]." AND estacion =".$idEstacion;
			$objDatos->operacionesCrud($sql);
		}
	}

	function calcularSO2($idEstacion, $menor, $mayor, $variable){
		$IL0 = array( 0,  51, 101, 151, 201, 301, 401);
		$IHi = array(50, 100, 150, 200, 300, 400, 500);
		$calificacion = array('Buena', 'Moderada', 'Daniña a la salud para grupos sensibles', 'Dañina a la salud', 'Muy dañina a la salud', 'Peligrosa', 'Peligrosa');
		$BPL0 = array(    0, 0.035, 0.145, 0.225, 0.305, 0.605, 0.805);
		$BPHi = array(0.034, 0.144, 0.224, 0.304, 0.604, 0.804, 1);
		$div = array((($IHi[0]-$IL0[0])/($BPHi[0]-$BPL0[0])), 
						(($IHi[1]-$IL0[1])/($BPHi[1]-$BPL0[1])), 
						(($IHi[2]-$IL0[2])/($BPHi[2]-$BPL0[2])), 
						(($IHi[3]-$IL0[3])/($BPHi[3]-$BPL0[3])), 
						(($IHi[4]-$IL0[4])/($BPHi[4]-$BPL0[4])), 
						(($IHi[5]-$IL0[5])/($BPHi[5]-$BPL0[5])), 
						(($IHi[6]-$IL0[6])/($BPHi[6]-$BPL0[6])));
		$pos;
		$tam = 7;
		$objDatos = new clsDatos();
		$sql = "SELECT año, mes, dia, AVG(so2_local_ppt) AS prom, COUNT(so2_local_ppt) AS total
				FROM fact_aire f, date_dim d 
				WHERE f.fecha_sk=d.fecha_sk AND f.so2_local_ppt IS NOT NULL AND f.estacion_sk=".$idEstacion.
				" AND d.año>=".$menor." AND d.año<=".$mayor." GROUP BY 1, 2, 3";
		$datos = $objDatos->executeQuery($sql);
		$sql = "INSERT INTO indicador_aire (estacion, anio, mes, dia, hora_inicio, hora_fin, concentracion_so2_24h,
		 ica_so2_24h, confianza_so2_24h, desviacion_so2_24h) 
				VALUES ";
		$sqlValidar = "INSERT INTO estacion_indicador VALUES ";
		if ($datos != null) {
			foreach ($datos as $value) {
				//desviación estandar, sin la corrección de Bessel, solo es un dato
				/*$n = $value['total'];
				$prom = $value['prom'];
				$multipli = 1/($n);
				$sqlDesv = "SELECT año, mes, dia, so2_local_ppt AS dato
							FROM fact_aire f, date_dim d
							WHERE f.fecha_sk=d.fecha_sk AND f.so2_local_ppt IS NOT NULL AND f.estacion_sk=".$idEstacion.
							" AND d.año>=".$menor." AND d.año<=".$mayor;
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$suma = 0;
				foreach ($datosDesv as $valorDesv) {
					$resta = ($valorDesv['dato']-$prom);
					$suma = $suma+pow($resta, 2);
				}
				$desvEst = round(sqrt($multipli*$suma)/1000, 3);
				*/

				$sqlDesv = "SELECT stddev(so2_local_ppt) AS dato 
							FROM fact_aire f, date_dim d, time_dim t
							WHERE f.fecha_sk=d.fecha_sk  
							AND f.so2_local_ppt IS NOT NULL AND f.estacion_sk=".$idEstacion
							." AND d.año=".$value['año']." AND d.mes=".$value['mes']." AND d.dia=".$value['dia'];
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$desvEst = round($datosDesv[0]["dato"]/1000, 5);

				$valor = ($value['prom']/1000);
				for ($i=0; $i < $tam ; $i++) { 
					if ($valor >= $BPL0[$i] && $valor <= $BPHi[$i]) {
						$pos = $i;
						break;
					}
				}
				$resultado = $div[$pos] * ($valor - $BPL0[$pos]) + $IL0[$pos];
				if ($resultado < $IL0[$pos] || $resultado > $IHi[$pos]) {
					$resultado = -1;
				}
				$confianza = ($value['total']/288)*100;
				$valor = round($valor, 4);
				$sql .= "(".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia'].", '00:00:00', '23:59:59', "
					.$valor.", ".$resultado.", ".$confianza.", ".$desvEst."), ";
				$sql2 = "UPDATE indicador_aire SET concentracion_so2_24h=".$valor.", ica_so2_24h=".$resultado
						.", confianza_so2_24h=".$confianza.", desviacion_so2_24h=".$desvEst
						." WHERE estacion=".$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']
						." AND dia=".$value['dia']." AND hora_inicio='00:00:00' AND hora_fin='23:59:59'";
				$sqlValidar .= "(".$variable.", ".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia']."), ";

				$sqlConsulta = "SELECT count(estacion) FROM indicador_aire WHERE estacion="
								.$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']." AND dia=".$value['dia'];
				$existe = $objDatos->executeQuery($sqlConsulta);
				$existe = $existe[0];
				if ($existe>0) {
					$objDatos->operacionesCrud($sql2);
				}
			}
		}
		$sql = rtrim($sql, ", ");
		$sqlValidar = rtrim($sqlValidar, ", ");
		$objDatos->operacionesCrud($sql);
		$objDatos->operacionesCrud($sqlValidar);
		for ($i=0; $i < $tam; $i++) { 
			$sql = "UPDATE indicador_aire 
					SET calificacion_so2_24h='".$calificacion[$i]."'
					 WHERE ica_so2_24h >= ".$IL0[$i]." AND ica_so2_24h <= ".$IHi[$i]." AND estacion =".$idEstacion;
			$objDatos->operacionesCrud($sql);
		}
	}

	function calcularCO8H($idEstacion, $menor, $mayor, $variable){
		$IL0 = array( 0,  51, 101, 151, 201, 301, 401);
		$IHi = array(50, 100, 150, 200, 300, 400, 500);
		$calificacion = array('Buena', 'Moderada', 'Daniña a la salud para grupos sensibles', 'Dañina a la salud', 'Muy dañina a la salud', 'Peligrosa', 'Peligrosa');
		$BPL0 = array(  0, 4.5,  9.5, 12.5, 15.5, 30.5, 40.5);
		$BPHi = array(4.4, 9.4, 12.4, 15.4, 30.4, 40.4, 50.4);
		$div = array((($IHi[0]-$IL0[0])/($BPHi[0]-$BPL0[0])), 
						(($IHi[1]-$IL0[1])/($BPHi[1]-$BPL0[1])), 
						(($IHi[2]-$IL0[2])/($BPHi[2]-$BPL0[2])), 
						(($IHi[3]-$IL0[3])/($BPHi[3]-$BPL0[3])), 
						(($IHi[4]-$IL0[4])/($BPHi[4]-$BPL0[4])), 
						(($IHi[5]-$IL0[5])/($BPHi[5]-$BPL0[5])), 
						(($IHi[6]-$IL0[6])/($BPHi[6]-$BPL0[6])));$pos;
		$tam = 7;
		$maxiDatos = 96;
		$objDatos = new clsDatos();
		#PRIMERAS 8 HORAS
		$sql = "SELECT año, mes, dia, AVG(co_local_ppt) AS prom, COUNT(co_local_ppt) AS total
				FROM fact_aire f, date_dim d
				WHERE f.fecha_sk=d.fecha_sk AND f.co_local_ppt IS NOT NULL AND f.tiempo_sk >= 1 AND f.tiempo_sk <= 28800 
				AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor." GROUP BY 1, 2, 3";
		$datos = $objDatos->executeQuery($sql);
		$sql = "INSERT INTO indicador_aire (estacion, anio, mes, dia, hora_inicio, hora_fin, 
							concentracion_co_8h, ica_co_8h, confianza_co_8h, desviacion_co_8h) 
				VALUES ";
		$sqlValidar = "INSERT INTO estacion_indicador VALUES ";
		if ($datos != null) {
			foreach ($datos as $value) {
				//desviación estandar, con la corrección de Bessel
				/*
				$n = $value['total'];
				$prom = $value['prom'];
				$multipli = 1/($n-1);
				$sqlDesv = "SELECT año, mes, dia, co_local_ppt AS dato
							FROM fact_aire f, date_dim d
							WHERE f.fecha_sk=d.fecha_sk AND f.co_local_ppt IS NOT NULL AND f.tiempo_sk >= 1 AND f.tiempo_sk <= 28800 
							AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor;
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$suma = 0;
				foreach ($datosDesv as $valorDesv) {
					$resta = ($valorDesv['dato']-$prom);
					$suma = $suma+pow($resta, 2);
				}
				$desvEst = round(sqrt($multipli*$suma)/1000, 3);
				*/

				$sqlDesv = "SELECT stddev(co_local_ppt) AS dato 
							FROM fact_aire f, date_dim d, time_dim t
							WHERE f.fecha_sk=d.fecha_sk AND f.tiempo_sk >= 1 AND f.tiempo_sk <= 28800 
							AND f.co_local_ppt IS NOT NULL AND f.estacion_sk=".$idEstacion
							." AND d.año=".$value['año']." AND d.mes=".$value['mes']." AND d.dia=".$value['dia'];
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$desvEst = round($datosDesv[0]["dato"]/1000, 5);


				$valor = ($value['prom']/1000);
				for ($i=0; $i < $tam ; $i++) { 
					if ($valor >= $BPL0[$i] && $valor <= $BPHi[$i]) {
						$pos = $i;
						break;
					}
				}
				$resultado = $div[$pos] * ($valor - $BPL0[$pos]) + $IL0[$pos];
				$confianza = ($value['total']/$maxiDatos)*100;
				$valor = round($valor, 1);
				$sql .= "(".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia'].", '00:00:00', '07:59:59', ".$valor.", ".
					$resultado.", ".$confianza.", ".$desvEst."), ";
				$sql2 = "UPDATE indicador_aire SET concentracion_co_8h=".$valor.", ica_co_8h=".$resultado
								.", confianza_co_8h=".$confianza.", desviacion_co_8h=".$desvEst
								." WHERE estacion=".$idEstacion
								." AND anio=".$value['año']." AND mes=".$value['mes']
								." AND dia=".$value['dia']." AND hora_inicio='00:00:00' AND hora_fin='07:59:59'";
				$sqlValidar .= "(".$variable.", ".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia']."), ";
				$sqlConsulta = "SELECT count(estacion) FROM indicador_aire WHERE estacion="
								.$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']." AND dia=".$value['dia'];
				$existe = $objDatos->executeQuery($sqlConsulta);
				$existe = $existe[0];
				if ($existe>0) {
					$objDatos->operacionesCrud($sql2);
				}
			}
		}
		$sql = rtrim($sql, ", ");
		$sqlValidar = rtrim($sqlValidar, ", ");
		$objDatos->operacionesCrud($sql);
		$objDatos->operacionesCrud($sqlValidar);
		#SEGUNDAS 8 HORAS
		$sql = "SELECT año, mes, dia, AVG(co_local_ppt) AS prom, COUNT(co_local_ppt) AS total
				FROM fact_aire f, date_dim d
				WHERE f.fecha_sk=d.fecha_sk AND f.co_local_ppt IS NOT NULL AND f.tiempo_sk >= 28801 AND f.tiempo_sk <= 57600 
				AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor." GROUP BY 1, 2, 3";
		$datos = $objDatos->executeQuery($sql);
		$sql = "INSERT INTO indicador_aire (estacion, anio, mes, dia, hora_inicio, hora_fin, concentracion_co_8h, 
							ica_co_8h, confianza_co_8h, desviacion_co_8h) 
				VALUES ";
		if ($datos != null) {
			foreach ($datos as $value) {
				//desviación estandar, con la corrección de Bessel
				/*
				$n = $value['total'];
				$prom = $value['prom'];
				$multipli = 1/($n-1);
				$sqlDesv = "SELECT año, mes, dia, co_local_ppt AS dato
							FROM fact_aire f, date_dim d
							WHERE f.fecha_sk=d.fecha_sk AND f.co_local_ppt IS NOT NULL AND f.tiempo_sk >= 28801 AND f.tiempo_sk <= 57600 
							AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor;
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$suma = 0;
				foreach ($datosDesv as $valorDesv) {
					$resta = ($valorDesv['dato']-$prom);
					$suma = $suma+pow($resta, 2);
				}
				$desvEst = round(sqrt($multipli*$suma)/1000, 3);

				*/

				$sqlDesv = "SELECT stddev(co_local_ppt) AS dato 
							FROM fact_aire f, date_dim d, time_dim t
							WHERE f.fecha_sk=d.fecha_sk AND f.tiempo_sk >= 28801 AND f.tiempo_sk <= 57600 
							AND f.co_local_ppt IS NOT NULL AND f.estacion_sk=".$idEstacion
							." AND d.año=".$value['año']." AND d.mes=".$value['mes']." AND d.dia=".$value['dia'];
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$desvEst = round($datosDesv[0]["dato"]/1000, 5);


				$valor = ($value['prom']/1000);
				for ($i=0; $i < $tam ; $i++) { 
					if ($valor >= $BPL0[$i] && $valor <= $BPHi[$i]) {
						$pos = $i;
						break;
					}
				}
				$resultado = $div[$pos] * ($valor - $BPL0[$pos]) + $IL0[$pos];
				$confianza = ($value['total']/$maxiDatos)*100;
				$valor = round($valor, 1);
				$sql .= "(".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia'].", '08:00:00', '15:59:59', ".
						$valor.", ".$resultado.", ".$confianza.", ".$desvEst."), ";
				$sql2 = "UPDATE indicador_aire SET concentracion_co_8h=".$valor.", ica_co_8h=".$resultado.
							", confianza_co_8h=".$confianza.", desviacion_co_8h=".$desvEst
							." WHERE estacion=".$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']
						." AND dia=".$value['dia']." AND hora_inicio='08:00:00' AND hora_fin='15:59:59'";
				$sqlConsulta = "SELECT count(estacion) FROM indicador_aire WHERE estacion="
								.$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']." AND dia=".$value['dia'];
				$existe = $objDatos->executeQuery($sqlConsulta);
				$existe = $existe[0];
				if ($existe>0) {
					$objDatos->operacionesCrud($sql2);
				}
			}
		}
		$sql = rtrim($sql, ", ");
		$objDatos->operacionesCrud($sql);
		#TERCERAS 8 HORAS
		$sql = "SELECT año, mes, dia, AVG(co_local_ppt) AS prom, COUNT(co_local_ppt) AS total
				FROM fact_aire f, date_dim d
				WHERE f.fecha_sk=d.fecha_sk AND f.co_local_ppt IS NOT NULL AND f.tiempo_sk >= 57601 AND f.tiempo_sk <= 86400 
				AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor." GROUP BY 1, 2, 3";
		$datos = $objDatos->executeQuery($sql);
		$sql = "INSERT INTO indicador_aire (estacion, anio, mes, dia, hora_inicio, hora_fin, concentracion_co_8h, ica_co_8h,
						 confianza_co_8h, desviacion_co_8h) 
				VALUES ";
		if ($datos != null) {
			foreach ($datos as $value) {
				//desviación estandar, con la corrección de Bessel
				/*
				$n = $value['total'];
				$prom = $value['prom'];
				$multipli = 1/($n-1);
				$sqlDesv = "SELECT año, mes, dia, co_local_ppt AS dato
							FROM fact_aire f, date_dim d
							WHERE f.fecha_sk=d.fecha_sk AND f.co_local_ppt IS NOT NULL AND f.tiempo_sk >= 57601 AND f.tiempo_sk <= 86400
							AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor;
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$suma = 0;
				foreach ($datosDesv as $valorDesv) {
					$resta = ($valorDesv['dato']-$prom);
					$suma = $suma+pow($resta, 2);
				}
				$desvEst = round(sqrt($multipli*$suma)/1000, 3);
				*/

				$sqlDesv = "SELECT stddev(co_local_ppt) AS dato 
							FROM fact_aire f, date_dim d, time_dim t
							WHERE f.fecha_sk=d.fecha_sk AND f.tiempo_sk >= 57601 AND f.tiempo_sk <= 86400 
							AND f.co_local_ppt IS NOT NULL AND f.estacion_sk=".$idEstacion
							." AND d.año=".$value['año']." AND d.mes=".$value['mes']." AND d.dia=".$value['dia'];
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$desvEst = round($datosDesv[0]["dato"]/1000, 5);

				$valor = ($value['prom']/1000);
				for ($i=0; $i < $tam ; $i++) { 
					if ($valor >= $BPL0[$i] && $valor <= $BPHi[$i]) {
						$pos = $i;
						break;
					}
				}
				$resultado = $div[$pos] * ($valor - $BPL0[$pos]) + $IL0[$pos];
				$confianza = ($value['total']/$maxiDatos)*100;
				$valor = round($valor, 1);
				$sql .= "(".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia'].", '16:00:00', '23:59:59', ".
					$valor.", ".$resultado.", ".$confianza.", ".$desvEst."), ";
				$sql2 = "UPDATE indicador_aire SET concentracion_co_8h=".$valor.", ica_co_8h=".$resultado
							.", confianza_co_8h=".$confianza.", desviacion_co_8h=".$desvEst
							." WHERE estacion=".$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']
						." AND dia=".$value['dia']." AND hora_inicio='16:00:00' AND hora_fin='23:59:59'";
				$sqlConsulta = "SELECT count(estacion) FROM indicador_aire WHERE estacion="
								.$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']." AND dia=".$value['dia'];
				$existe = $objDatos->executeQuery($sqlConsulta);
				$existe = $existe[0];
				if ($existe>0) {
					$objDatos->operacionesCrud($sql2);
				}
			}
		}
		$sql = rtrim($sql, ", ");
		$objDatos->operacionesCrud($sql);
		for ($i=0; $i < $tam; $i++) { 
			$sql = "UPDATE indicador_aire 
					SET calificacion_co_8h='".$calificacion[$i]."'
					 WHERE ica_co_8h >= ".$IL0[$i]." AND ica_co_8h <= ".$IHi[$i]." AND estacion =".$idEstacion;
			$objDatos->operacionesCrud($sql);
		}
	}

	function calcularO38H($idEstacion, $menor, $mayor, $variable){
		$IL0 = array( 0,  51, 101, 151, 201);
		$IHi = array(50, 100, 150, 200, 300);
		$calificacion = array('Buena', 'Moderada', 'Daniña a la salud para grupos sensibles', 
								'Dañina a la salud', 'Muy dañina a la salud');
		$BPL0 = array(     0,  0.06, 0.076, 0.096, 0.116);
		$BPHi = array( 0.059, 0.075, 0.095, 0.115, 0.374);
		$div = array((($IHi[0]-$IL0[0])/($BPHi[0]-$BPL0[0])), 
						(($IHi[1]-$IL0[1])/($BPHi[1]-$BPL0[1])), 
						(($IHi[2]-$IL0[2])/($BPHi[2]-$BPL0[2])), 
						(($IHi[3]-$IL0[3])/($BPHi[3]-$BPL0[3])), 
						(($IHi[4]-$IL0[4])/($BPHi[4]-$BPL0[4])));
		$pos;
		$tam = 5;
		$maxiDatos = 96;
		$objDatos = new clsDatos();
		#PRIMERAS 8 HORAS
		$sql = "SELECT año, mes, dia, AVG(o3_local_ppt) AS prom, COUNT(o3_local_ppt) AS total
				FROM fact_aire f, date_dim d
				WHERE f.fecha_sk=d.fecha_sk AND f.o3_local_ppt IS NOT NULL AND f.tiempo_sk >= 1 AND f.tiempo_sk <= 28800 
				AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor." GROUP BY 1, 2, 3";
		$datos = $objDatos->executeQuery($sql);
		$sql = "INSERT INTO indicador_aire (estacion, anio, mes, dia, hora_inicio, hora_fin, concentracion_o3_8h, ica_o3_8h,
							 confianza_o3_8h, desviacion_o3_8h) 
				VALUES ";
		$sqlValidar = "INSERT INTO estacion_indicador VALUES ";
		if ($datos != null) {
			foreach ($datos as $value) {
				//desviación estandar, con la corrección de Bessel
				/*
				$n = $value['total'];
				$prom = $value['prom'];
				$multipli = 1/($n-1);
				$sqlDesv = "SELECT año, mes, dia, o3_local_ppt AS dato
							FROM fact_aire f, date_dim d
							WHERE f.fecha_sk=d.fecha_sk AND f.o3_local_ppt IS NOT NULL AND f.tiempo_sk >= 1 AND f.tiempo_sk <= 28800 
							AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor;
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$suma = 0;
				foreach ($datosDesv as $valorDesv) {
					$resta = ($valorDesv['dato']-$prom);
					$suma = $suma+pow($resta, 2);
				}
				$desvEst = round(sqrt($multipli*$suma)/1000, 3);
				*/

				$sqlDesv = "SELECT stddev(o3_local_ppt) AS dato 
							FROM fact_aire f, date_dim d, time_dim t
							WHERE f.fecha_sk=d.fecha_sk AND f.tiempo_sk >= 1 AND f.tiempo_sk <= 28800 
							AND f.o3_local_ppt IS NOT NULL AND f.estacion_sk=".$idEstacion
							." AND d.año=".$value['año']." AND d.mes=".$value['mes']." AND d.dia=".$value['dia'];
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$desvEst = round($datosDesv[0]["dato"]/1000, 5);

				$valor = ($value['prom']/1000);
				for ($i=0; $i < $tam ; $i++) { 
					if ($valor >= $BPL0[$i] && $valor <= $BPHi[$i]) {
						$pos = $i;
						break;
					}
				}
				$resultado = $div[$pos] * ($valor - $BPL0[$pos]) + $IL0[$pos];
				$confianza = ($value['total']/$maxiDatos)*100;
				$valor = round($valor, 3);
				$sql .= "(".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia'].", '00:00:00', '07:59:59', "
					.$valor.", ".$resultado.", ".$confianza.", ".$desvEst."), ";
				$sql2 = "UPDATE indicador_aire SET concentracion_o3_8h=".$valor.", ica_o3_8h=".$resultado.", confianza_o3_8h=".
						$confianza.", desviacion_o3_8h=".$desvEst
						." WHERE estacion=".$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']
						." AND dia=".$value['dia']." AND hora_inicio='00:00:00' AND hora_fin='07:59:59'";
				$sqlValidar .= "(".$variable.", ".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia']."), ";

				$sqlConsulta = "SELECT count(estacion) FROM indicador_aire WHERE estacion="
								.$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']." AND dia=".$value['dia'];
				$existe = $objDatos->executeQuery($sqlConsulta);
				$existe = $existe[0];
				if ($existe>0) {
					$objDatos->operacionesCrud($sql2);
				}
			}
		}
		$sql = rtrim($sql, ", ");
		$sqlValidar = rtrim($sqlValidar, ", ");
		$objDatos->operacionesCrud($sql);
		$objDatos->operacionesCrud($sqlValidar);
		#SEGUNDAS 8 HORAS
		$sql = "SELECT año, mes, dia, AVG(o3_local_ppt) AS prom, COUNT(o3_local_ppt) AS total
				FROM fact_aire f, date_dim d
				WHERE f.fecha_sk=d.fecha_sk AND f.o3_local_ppt IS NOT NULL AND f.tiempo_sk >= 28801 AND f.tiempo_sk <= 57600 
				AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor." GROUP BY 1, 2, 3";
		$datos = $objDatos->executeQuery($sql);
		$sql = "INSERT INTO indicador_aire (estacion, anio, mes, dia, hora_inicio, hora_fin, concentracion_o3_8h, ica_o3_8h,
							 confianza_o3_8h, desviacion_o3_8h) 
				VALUES ";
		if ($datos != null) {
			foreach ($datos as $value) {
				//desviación estandar, con la corrección de Bessel
				/*
				$n = $value['total'];
				$prom = $value['prom'];
				$multipli = 1/($n-1);
				$sqlDesv = "SELECT año, mes, dia, o3_local_ppt AS dato
							FROM fact_aire f, date_dim d
							WHERE f.fecha_sk=d.fecha_sk AND f.o3_local_ppt IS NOT NULL AND f.tiempo_sk >= 28801 AND f.tiempo_sk <= 57600 
							AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor;
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$suma = 0;
				foreach ($datosDesv as $valorDesv) {
					$resta = ($valorDesv['dato']-$prom);
					$suma = $suma+pow($resta, 2);
				}
				$desvEst = round(sqrt($multipli*$suma)/1000, 3);
				*/

				$sqlDesv = "SELECT stddev(o3_local_ppt) AS dato 
							FROM fact_aire f, date_dim d, time_dim t
							WHERE f.fecha_sk=d.fecha_sk AND f.tiempo_sk >= 28801 AND f.tiempo_sk <= 57600
							AND f.o3_local_ppt IS NOT NULL AND f.estacion_sk=".$idEstacion
							." AND d.año=".$value['año']." AND d.mes=".$value['mes']." AND d.dia=".$value['dia'];
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$desvEst = round($datosDesv[0]["dato"]/1000, 5);


				$valor = ($value['prom']/1000);
				for ($i=0; $i < $tam ; $i++) { 
					if ($valor >= $BPL0[$i] && $valor <= $BPHi[$i]) {
						$pos = $i;
						break;
					}
				}
				$resultado = $div[$pos] * ($valor - $BPL0[$pos]) + $IL0[$pos];
				$confianza = ($value['total']/$maxiDatos)*100;
				$valor = round($valor, 3);
				$sql .= "(".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia'].", '08:00:00', '15:59:59', "
					.$valor.", ".$resultado.", ".$confianza.", ".$desvEst."), ";
				$sql2 = "UPDATE indicador_aire SET concentracion_o3_8h=".$valor.", ica_o3_8h=".$resultado
						.", confianza_o3_8h=".$confianza.", desviacion_o3_8h=".$desvEst
						." WHERE estacion=".$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']
						." AND dia=".$value['dia']." AND hora_inicio='08:00:00' AND hora_fin='15:59:59'";
				$sqlConsulta = "SELECT count(estacion) FROM indicador_aire WHERE estacion="
								.$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']." AND dia=".$value['dia'];
				$existe = $objDatos->executeQuery($sqlConsulta);
				$existe = $existe[0];
				if ($existe>0) {
					$objDatos->operacionesCrud($sql2);
				}
			}
		}
		$sql = rtrim($sql, ", ");
		$objDatos->operacionesCrud($sql);
		#SEGUNDAS 8 HORAS
		$sql = "SELECT año, mes, dia, AVG(o3_local_ppt) AS prom, COUNT(o3_local_ppt) AS total
				FROM fact_aire f, date_dim d
				WHERE f.fecha_sk=d.fecha_sk AND f.o3_local_ppt IS NOT NULL AND f.tiempo_sk >= 57601 AND f.tiempo_sk <= 86400 
				AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor." GROUP BY 1, 2, 3";
		$datos = $objDatos->executeQuery($sql);
		$sql = "INSERT INTO indicador_aire (estacion, anio, mes, dia, hora_inicio, hora_fin, concentracion_o3_8h, ica_o3_8h,
							 confianza_o3_8h, desviacion_o3_8h) 
				VALUES ";
		if ($datos != null) {
			foreach ($datos as $value) {
				//desviación estandar, con la corrección de Bessel
				/*
				$n = $value['total'];
				$prom = $value['prom'];
				$multipli = 1/($n-1);
				$sqlDesv = "SELECT año, mes, dia, o3_local_ppt AS dato
							FROM fact_aire f, date_dim d
							WHERE f.fecha_sk=d.fecha_sk AND f.o3_local_ppt IS NOT NULL AND f.tiempo_sk >= 57601 AND f.tiempo_sk <= 86400
							AND f.estacion_sk=".$idEstacion." AND d.año>=".$menor." AND d.año<=".$mayor;
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$suma = 0;
				foreach ($datosDesv as $valorDesv) {
					$resta = ($valorDesv['dato']-$prom);
					$suma = $suma+pow($resta, 2);
				}
				$desvEst = round(sqrt($multipli*$suma)/1000, 3);
				*/

				
				$sqlDesv = "SELECT stddev(o3_local_ppt) AS dato 
							FROM fact_aire f, date_dim d, time_dim t
							WHERE f.fecha_sk=d.fecha_sk AND f.tiempo_sk >= 57601 AND f.tiempo_sk <= 86400
							AND f.o3_local_ppt IS NOT NULL AND f.estacion_sk=".$idEstacion
							." AND d.año=".$value['año']." AND d.mes=".$value['mes']." AND d.dia=".$value['dia'];
				$datosDesv = $objDatos->executeQuery($sqlDesv);
				$desvEst = round($datosDesv[0]["dato"]/1000, 5);



				$valor = ($value['prom']/1000);
				for ($i=0; $i < $tam ; $i++) { 
					if ($valor >= $BPL0[$i] && $valor <= $BPHi[$i]) {
						$pos = $i;
						break;
					}
				}
				$resultado = $div[$pos] * ($valor - $BPL0[$pos]) + $IL0[$pos];
				$confianza = ($value['total']/$maxiDatos)*100;
				$valor = round($valor, 3);
				$sql .= "(".$idEstacion.", ".$value['año'].", ".$value['mes'].", ".$value['dia'].", '16:00:00', '23:59:59', "
						.$valor.", ".$resultado.", ".$confianza.", ".$desvEst."), ";
				$sql2 = "UPDATE indicador_aire SET concentracion_o3_8h=".$valor.", ica_o3_8h=".$resultado
						.", confianza_o3_8h=".$confianza.", desviacion_o3_8h=".$desvEst
						." WHERE estacion=".$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']
						." AND dia=".$value['dia']." AND hora_inicio='16:00:00' AND hora_fin='23:59:59'";
				$sqlConsulta = "SELECT count(estacion) FROM indicador_aire WHERE estacion="
								.$idEstacion." AND anio=".$value['año']." AND mes=".$value['mes']." AND dia=".$value['dia'];
				$existe = $objDatos->executeQuery($sqlConsulta);
				$existe = $existe[0];
				if ($existe>0) {
					$objDatos->operacionesCrud($sql2);
				}
			}
		}
		$sql = rtrim($sql, ", ");
		$objDatos->operacionesCrud($sql);
		for ($i=0; $i < $tam; $i++) { 
			$sql = "UPDATE indicador_aire 
					SET calificacion_o3_8h='".$calificacion[$i]."'
					 WHERE ica_o3_8h >= ".$IL0[$i]." AND ica_o3_8h <= ".$IHi[$i]." AND estacion =".$idEstacion;
			$objDatos->operacionesCrud($sql);
		}
	}
	

?>