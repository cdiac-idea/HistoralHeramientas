<?php   
    //inicio de html y parte del menu ademas de funciones con las consultas sql
    include('base/inicio.php');
    if ($_POST) {
    	/*******************************************************************************************************
		 *  CARGANDO DATOS ELEGIDOS POR EL USUARIO
		 ******************************************************************************************************/
		$separador=";";
		$salto="\n";
		//Atributos de consulta
		$idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
		$idAno1 = array_key_exists('idAno1', $_POST) ? $_POST['idAno1'] : null;
		$idAno2 = array_key_exists('idAno2', $_POST) ? $_POST['idAno2'] : null;
		$temp = array_key_exists('TEMP', $_POST) ? $_POST['TEMP'] : null;
		$rangoTemp = array_key_exists('RANGO-TEMP', $_POST) ? $_POST['RANGO-TEMP'] : null;
		$ppt = array_key_exists('Ppt', $_POST) ? $_POST['Ppt'] : null;
		$pptA25 = array_key_exists('A25', $_POST) ? $_POST['A25'] : null;
		$dvv = array_key_exists('DVV', $_POST) ? $_POST['DVV'] : null;
		$hrmHrmm = array_key_exists('HRm-HRmm', $_POST) ? $_POST['HRm-HRmm'] : null;
		$rs = array_key_exists('RS', $_POST) ? $_POST['RS'] : null;
		$pbm = array_key_exists('Pbm-Pbmm', $_POST) ? $_POST['Pbm-Pbmm'] : null;
		$confort = array_key_exists('CONFORT-T', $_POST) ? $_POST['CONFORT-T'] : null;
		$isp = array_key_exists('isp', $_POST) ? $_POST['isp'] : null;
		$aridez = array_key_exists('I-ARIDEZ', $_POST) ? $_POST['I-ARIDEZ'] : null;
		//periodo
		$Anual = array_key_exists('idAnual', $_POST) ? $_POST['idAnual'] : null;
		$mes = array_key_exists('idMensu', $_POST) ? $_POST['idMensu'] : null;
		$dia = array_key_exists('idDiari', $_POST) ? $_POST['idDiari'] : null;
		$hayDatos = false;
		if ($idAno1 != "Seleccione") {
			if ($idAno2 != "Seleccione") {
				if ($idAno1<$idAno2) {
					$menor=$idAno1;
					$mayor=$idAno2;
				}else{
					$menor=$idAno2;
					$mayor=$idAno1;
				}
			}else{
				$menor = $idAno1;
				$mayor = $idAno1;
			}
		}else{
			if ($idAno2 != "Seleccione") {
				$menor = $idAno2;
				$mayor = $idAno2;
			}
		}
		#echo $Anual;

		//Para encabezado de la tabla
		$títulos1 = "<br><br><center> <table border='1'> <tr class = 'cabecera'>";
		$tamCabeza = strlen($títulos1);
		$cabeza = $títulos1."<td>Estacion</td>";
		//$arrayCabeza = array(0 => "<br><br><center><table border = 1 ><tr class = 'cabecera'>", 1 => "<td>Estacion</td>" );
		$archivoPlano = "Estacion";
		$posGrafica = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
		$posGraficaRangoAnios = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);


		//identificando el nombre de la estacion para optimizar busquedas, haciendolas directas en tablas independientes
		$nombEstacion = getNombreEstacion($idEstacion);
		$pos = 0;
		//Inicio consulta SQL
		$sqlAnual = "";
		$cabezaAnual = "";
		$archivoPlanoAnual = "";

		$cabezaRangoAn="";
		$sqlRangoAnual="";
		$archivoRangAn="";
		$nombRang="a";
		$valRango=$nombRang;

		$sqlMes = "";
		$cabezaMes = "";
		$archivoPlanoMes = "";

		$sqlDia = "";
		$cabezaDia = "";
		$archivoPlanoDia = "";

		$títulos = "<td colspan='4'>  </td>";
		$titRangoAño = "<td colspan='2'>  </td>";
		$titAño = "<td colspan='2'>  </td>";
		$titMes = "<td colspan='3'>  </td>";

		if ($Anual == 1) {
			$sqlAnual = "SELECT anio";
			$cabezaAnual = $cabeza."<td>Año</td>";
			$archivoPlanoAnual = $archivoPlano.$separador."Año";
			$incremento = 2;
			$posGrafica = array($incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento);
			$incremento=1;
			$posGraficaAnual = array($incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento, $incremento);
		}

		if ($menor!=$mayor) {
			$sqlRangoAnual="SELECT count(estacion) as total";
			$cabezaRangoAn= $cabeza."<td>Rango de<br> Años</td>";
			$archivoRangAn=$archivoPlano.$separador."Rango de años";
			$incremento = 0;
			$posGraficaRangoAnios = array($incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento);
		}
		/*echo var_dump($posGraficaRangoAnios);
		echo "<br>";*/
		if ($mes == 2) {
			$sqlMes = "SELECT anio,  mes";
			$cabezaMes = $cabeza."<td>Año</td><td>Mes</td>";
			$archivoPlanoMes = $archivoPlano.$separador."Año".$separador."Mes";
			$incremento = 3;
			$posGrafica = array($incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento);
			$incremento = 2;
			$posGraficaMes = array($incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento, $incremento);
		}
		if ($dia == 3) {
			$sqlDia = "SELECT anio, mes, dia";
			$cabezaDia .= $títulos.$cabeza."<td>Año</td><td>Mes</td><td>Día</td>";
			#$posGrafica = array(4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4);
			#$posGrafica += 4;
			$incremento = 4;
			$posGrafica = array($incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento, 
								$incremento, $incremento, $incremento);
			$archivoPlanoDia = $archivoPlano.$separador."Año".$separador."Mes".$separador."Dia";
		}

		//identificar indicador y preparando consulta SQL y la muestra de los datos
		if ($temp == 1) {
			$indic[$pos] = $temp;
			$pos = $pos+1;
			$sql = ", tmax, tmin, tmed";
			$cabeza = "<td>Temp <br>Maxima (ºC)</td><td>Temp <br>Minima (ºC)</td><td>Temp<br>Promedio (ºC)</td><td>Grafica</td>";
			$títulos .= "<td colspan='4'>TEMP  Temperatura <br>(percentil 95, promedio, máxima y mínima)</td>";
			$titRangoAño .= "<td colspan='4'>TEMP  Temperatura <br>(percentil 95, promedio, máxima y mínima)</td>";
			$titAño .= "<td colspan='4'>TEMP  Temperatura <br>(percentil 95, promedio, máxima y mínima)</td>";
			$titMes .= "<td colspan='4'>TEMP  Temperatura <br>(percentil 95, promedio, máxima y mínima)</td>";

			$incremento = 3;
			$posGrafica = array($posGrafica[0]+$incremento, $posGrafica[1]+$incremento, $posGrafica[2]+$incremento, 
								$posGrafica[3]+$incremento, $posGrafica[4]+$incremento, $posGrafica[5]+$incremento, 
								$posGrafica[6]+$incremento, $posGrafica[7]+$incremento, $posGrafica[8]+$incremento, 
								$posGrafica[9]+$incremento, $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);
			$posGraficaAnual = array($posGraficaAnual[0]+$incremento, $posGraficaAnual[1]+$incremento, $posGraficaAnual[2]+$incremento, 
								$posGraficaAnual[3]+$incremento, $posGraficaAnual[4]+$incremento, $posGraficaAnual[5]+$incremento, 
								$posGraficaAnual[6]+$incremento, $posGraficaAnual[7]+$incremento, $posGraficaAnual[8]+$incremento, 
								$posGraficaAnual[9]+$incremento, $posGraficaAnual[10]+$incremento);
			$posGraficaMes = array($posGraficaMes[0]+$incremento, $posGraficaMes[1]+$incremento, $posGraficaMes[2]+$incremento, 
								$posGraficaMes[3]+$incremento, $posGraficaMes[4]+$incremento, $posGraficaMes[5]+$incremento, 
								$posGraficaMes[6]+$incremento, $posGraficaMes[7]+$incremento, $posGraficaMes[8]+$incremento, 
								$posGraficaMes[9]+$incremento, $posGraficaMes[10]+$incremento);
			$archivoPlano = $separador."Temp Maxima (ºC)".$separador."Temp Minima (ºC)".$separador."Temp Promedio (ºC)";
			arregloTablasIndicadores($sql, $cabeza, $archivoPlano);
			if ($menor!=$mayor) {
				$sqlRangoAnual.=", sum(tmax) AS ".$valRango;
				$valRango.=$nombRang;
				$sqlRangoAnual.=", sum(tmin) AS ".$valRango;
				$valRango.=$nombRang;
				$sqlRangoAnual.=", sum(tmed) AS ".$valRango;
				$valRango.=$nombRang;

				$cabezaRangoAn.="<td>Promedio Temps<br>Maxima (ºC)</td><td>Promedio Temps<br>Minima (ºC)</td><td>Promedio Temps<br>Promedio (ºC)</td><td>Grafica</td>";
				$archivoRangAn.=$separador."Promedio Temps Maxima (ºC)".$separador."Promedio Temps Minima (ºC)".$separador."Promedio Temps Promedio (ºC)";

				$incremento = 3;
				$posGraficaRangoAnios = array($posGraficaRangoAnios[0]+$incremento, $posGraficaRangoAnios[1]+$incremento, 
					$posGraficaRangoAnios[2]+$incremento, $posGraficaRangoAnios[3]+$incremento, $posGraficaRangoAnios[4]+$incremento, 
					$posGraficaRangoAnios[5]+$incremento, $posGraficaRangoAnios[6]+$incremento, $posGraficaRangoAnios[7]+$incremento, 
					$posGraficaRangoAnios[8]+$incremento, $posGraficaRangoAnios[9]+$incremento, $posGraficaRangoAnios[10]+$incremento);
			}
		}

		#echo var_dump($posGraficaRangoAnios);

		if ($rangoTemp == 2) {
			$indic[$pos] = $rangoTemp;
			$pos = $pos+1;
			$sql = ", trango";
			$cabeza = "<td>Rango<br>Temp (ºC)</td><td>Grafica</td>";
			$títulos .= "<td colspan='2'>RANGO-TEMP <br> Amplitud o rango <br>de temperatura</td>";
			$titRangoAño .= "<td colspan='2'>RANGO-TEMP <br> Amplitud o rango <br>de temperatura</td>";
			$titAño .= "<td colspan='2'>RANGO-TEMP <br> Amplitud o rango <br>de temperatura</td>";
			$titMes .= "<td colspan='2'>RANGO-TEMP <br> Amplitud o rango <br>de temperatura</td>";

			$archivoPlano = $separador."Rango (ºC)";
			#$posGrafica += 1;
			#$posGrafica = array(7, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8);
			$incremento = 1;
			$posGrafica = array($posGrafica[0], $posGrafica[1]+$incremento, $posGrafica[2]+$incremento, 
								$posGrafica[3]+$incremento, $posGrafica[4]+$incremento, $posGrafica[5]+$incremento, 
								$posGrafica[6]+$incremento, $posGrafica[7]+$incremento, $posGrafica[8]+$incremento, 
								$posGrafica[9]+$incremento, $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);
			
			$posGraficaAnual = array($posGraficaAnual[0], $posGraficaAnual[1]+$incremento, $posGraficaAnual[2]+$incremento, 
								$posGraficaAnual[3]+$incremento, $posGraficaAnual[4]+$incremento, $posGraficaAnual[5]+$incremento, 
								$posGraficaAnual[6]+$incremento, $posGraficaAnual[7]+$incremento, $posGraficaAnual[8]+$incremento, 
								$posGraficaAnual[9]+$incremento, $posGraficaAnual[10]+$incremento);
			$posGraficaMes = array($posGraficaMes[0], $posGraficaMes[1]+$incremento, $posGraficaMes[2]+$incremento, 
								$posGraficaMes[3]+$incremento, $posGraficaMes[4]+$incremento, $posGraficaMes[5]+$incremento, 
								$posGraficaMes[6]+$incremento, $posGraficaMes[7]+$incremento, $posGraficaMes[8]+$incremento, 
								$posGraficaMes[9]+$incremento, $posGraficaMes[10]+$incremento);
			arregloTablasIndicadores($sql, $cabeza, $archivoPlano);
			if ($menor!=$mayor) { 
				$sqlRangoAnual.=", sum(trango) AS ".$valRango;
				$valRango.=$nombRang;
				$cabezaRangoAn.="<td>Promedio Rango<br>Temp (ºC)</td><td>Grafica</td>";
				$archivoRangAn.=$separador."Promedio Rango (ºC)";
				$incremento = 1;
				$posGraficaRangoAnios = array($posGraficaRangoAnios[0], $posGraficaRangoAnios[1]+$incremento, 
						$posGraficaRangoAnios[2]+$incremento, $posGraficaRangoAnios[3]+$incremento, $posGraficaRangoAnios[4]+$incremento, 
						$posGraficaRangoAnios[5]+$incremento, $posGraficaRangoAnios[6]+$incremento, $posGraficaRangoAnios[7]+$incremento, 
						$posGraficaRangoAnios[8]+$incremento, $posGraficaRangoAnios[9]+$incremento, $posGraficaRangoAnios[10]+$incremento);
			}
		}

		if ($ppt == 3) {
			$indic[$pos] = $ppt;
			$pos = $pos+1;
			$sql = ", ppt";
			$cabeza = "<td>Ppt<br>(mm)</td>";
			$títulos .= "<td colspan='3'>Ppt  Precipitación <br>(total diario y percentil 95)</td>";
			$titRangoAño .= "<td colspan='2'>Ppt  Precipitación <br>(total diario y percentil 95)</td>";
			$titAño .= "<td colspan='3'>Ppt  Precipitación <br>(total diario y percentil 95)</td>";
			$titMes .= "<td colspan='3'>Ppt  Precipitación <br>(total diario y percentil 95)</td>";
			$archivoPlano = $separador."Ppt (mm)";

			arregloTablasIndicadores($sql, $cabeza, $archivoPlano);
			if ($menor!=$mayor) {
				$sqlRangoAnual.=", sum(ppt) AS ".$valRango;
				$valRango.=$nombRang;
				$cabezaRangoAn.="<td>Promedio Ppt<br>(mm)</td><td>Grafica</td>";
				$archivoRangAn.=$separador."Promedio Ppt (mm)";
				$incremento = 1;
				$posGraficaRangoAnios = array($posGraficaRangoAnios[0], $posGraficaRangoAnios[1], 
							$posGraficaRangoAnios[2]+$incremento, $posGraficaRangoAnios[3]+$incremento, $posGraficaRangoAnios[4]+$incremento, 
							$posGraficaRangoAnios[5]+$incremento, $posGraficaRangoAnios[6]+$incremento, $posGraficaRangoAnios[7]+$incremento, 
							$posGraficaRangoAnios[8]+$incremento, $posGraficaRangoAnios[9]+$incremento, $posGraficaRangoAnios[10]+$incremento);
			}
			$sqlDia .= ", int_lluvia_uno_cinco";
			$cabezaDia .= "<td>Intensidad de <br>LLuvia (mm/h)<br>-Primeros 5 minutos-</td><td>Grafica</td>";
			$archivoPlanoDia .= $separador."Intensidad de LLuvia -Primeros 5 minutos-(mm/h)";

			$sqlMes .= ", dias_sin_lluvia";
			$cabezaMes .= "<td>Dias sin<br> LLuvia</td><td>Grafica</td>";
			$archivoPlanoMes .= $separador."Dias sin LLuvia";
		
			$sqlAnual .= ", desc_lluvia";
			$cabezaAnual .= "<td>Descripción</td><td>Grafica</td>";
			$archivoPlanoAnual .= $separador."Descripcion";

			$incremento = 1;
			$posGraficaAnual = array($posGraficaAnual[0], $posGraficaAnual[1], $posGraficaAnual[2]+$incremento, 
								$posGraficaAnual[3]+$incremento, $posGraficaAnual[4]+$incremento, $posGraficaAnual[5]+$incremento, 
								$posGraficaAnual[6]+$incremento, $posGraficaAnual[7]+$incremento, $posGraficaAnual[8]+$incremento, 
								$posGraficaAnual[9]+$incremento, $posGraficaAnual[10]+$incremento);
			$incremento = 2;
			$posGrafica = array($posGrafica[0], $posGrafica[1], $posGrafica[2]+$incremento, 
								$posGrafica[3]+$incremento, $posGrafica[4]+$incremento, $posGrafica[5]+$incremento, 
								$posGrafica[6]+$incremento, $posGrafica[7]+$incremento, $posGrafica[8]+$incremento, 
								$posGrafica[9]+$incremento, $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);
			$posGraficaMes = array($posGraficaMes[0], $posGraficaMes[1], $posGraficaMes[2]+$incremento, 
								$posGraficaMes[3]+$incremento, $posGraficaMes[4]+$incremento, $posGraficaMes[5]+$incremento, 
								$posGraficaMes[6]+$incremento, $posGraficaMes[7]+$incremento, $posGraficaMes[8]+$incremento, 
								$posGraficaMes[9]+$incremento, $posGraficaMes[10]+$incremento);
		}

		if ($pptA25 == 4) {
			$indic[$pos] = $pptA25;
			$pos = $pos+1;
			$sqlMes .= ", ac_25";
			$cabezaMes .= "<td>A25<br> Maximo</td><td>Grafica</td>";
			$titRangoAño .= "<td>A25</td>";
			$archivoPlanoMes .= $separador."A25 Maximo Mes";
			$sqlAnual .= ", ac_25";
			$cabezaAnual .= "<td>A25<br> Maximo</td><td>Grafica</td>";
			$archivoPlanoAnual .= $separador."A25 Maximo Año";

			$sqlDia .= ", ac_25, nivel_alerta";
			$cabezaDia .= "<td>A25</td><td>Nivel<br>Alerta</td><td>Grafica</td>";
			$títulos .= "<td colspan='3'>Ppt.Ac-A25  <br>Lluvia acumulada</td>";
			$titAño .= "<td colspan='2'>Ppt.Ac-A25  <br>Lluvia acumulada</td>";
			$titMes .= "<td colspan='2'>Ppt.Ac-A25  <br>Lluvia acumulada</td>";
			
			if ($menor!=$mayor) {
				$cabezaRangoAn.="<td>Grafica</td>";
			}

			$incremento = 2;
			$posGrafica = array($posGrafica[0], $posGrafica[1], $posGrafica[2], 
								$posGrafica[3]+$incremento, $posGrafica[4]+$incremento, $posGrafica[5]+$incremento, 
								$posGrafica[6]+$incremento, $posGrafica[7]+$incremento, $posGrafica[8]+$incremento, 
								$posGrafica[9]+$incremento, $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);
			$posGraficaAnual = array($posGraficaAnual[0], $posGraficaAnual[1], $posGraficaAnual[2], 
								$posGraficaAnual[3]+$incremento, $posGraficaAnual[4]+$incremento, $posGraficaAnual[5]+$incremento, 
								$posGraficaAnual[6]+$incremento, $posGraficaAnual[7]+$incremento, $posGraficaAnual[8]+$incremento, 
								$posGraficaAnual[9]+$incremento, $posGraficaAnual[10]+$incremento);
			$incremento = 1;
			$posGraficaMes = array($posGraficaMes[0], $posGraficaMes[1], $posGraficaMes[2],
								$posGraficaMes[3]+$incremento, $posGraficaMes[4]+$incremento, $posGraficaMes[5]+$incremento, 
								$posGraficaMes[6]+$incremento, $posGraficaMes[7]+$incremento, $posGraficaMes[8]+$incremento, 
								$posGraficaMes[9]+$incremento, $posGraficaMes[10]+$incremento);
			$archivoPlanoDia .= $separador."A25".$separador."Nivel Alerta";
		}

		if ($dvv == 5) {
			$indic[$pos] = $dvv;
			$pos = $pos+1;
			$sql = ", max_vv, max_escala_beaufort, max_desc_beaufort, med_vv, med_escala_beaufort, med_desc_beaufort";
			$cabeza = "<td>VV Max (m/s)</td><td>Escala<br>Beaufort</td><td>Descripción<br>Beaufort</td>
						<td>VV Media (m/s)</td><td>Escala<br>Beaufort</td><td>Descripción<br>Beaufort</td>
						<td>Grafica</td>";

			$títulos .= "<td colspan='7'>DVV  Dirección y velocidad del viento <br>(promedios mensual y mensual multianual)</td>";
			$titRangoAño .= "<td colspan='3'>DVV  Dirección y velocidad del viento <br>(promedios mensual y mensual multianual)</td>";
			$titAño .= "<td colspan='7'>DVV  Dirección y velocidad del viento <br>(promedios mensual y mensual multianual)</td>";
			$titMes .= "<td colspan='7'>DVV  Dirección y velocidad del viento <br>(promedios mensual y mensual multianual)</td>";

			$archivoPlano = $separador."VV Max (m/s)".$separador."Escala Beaufort".$separador
							."Descripcion Beaufort".$separador."VV Media (m/s)".$separador."Escala Beaufort"
							.$separador."Descripcion Beaufort";
			arregloTablasAnioMes($sql, $cabeza, $archivoPlano);
			if ($menor!=$mayor) {
				$sqlRangoAnual.=", sum(max_vv) AS ".$valRango;
				$valRango.=$nombRang;
				$sqlRangoAnual.=", sum(med_vv) AS ".$valRango;
				$valRango.=$nombRang;
				$cabezaRangoAn.="<td>Promedio VV Max (m/s)</td><td>Promedio VV Media (m/s)</td><td>Grafica</td>";
				$archivoRangAn.=$separador."Promedio VV Max (m/s)".$separador."Promedio VV Media (m/s)";
				$incremento = 2;
				$posGraficaRangoAnios = array($posGraficaRangoAnios[0], $posGraficaRangoAnios[1], $posGraficaRangoAnios[2], 
					$posGraficaRangoAnios[3], $posGraficaRangoAnios[4]+$incremento, 
					$posGraficaRangoAnios[5]+$incremento, $posGraficaRangoAnios[6]+$incremento, $posGraficaRangoAnios[7]+$incremento, 
					$posGraficaRangoAnios[8]+$incremento, $posGraficaRangoAnios[9]+$incremento, $posGraficaRangoAnios[10]+$incremento);
			}
			$sqlDia .= ", max_vv, med_vv, des_dv_diurno, frec_dv_diurno, des_dv_nocturno, frec_dv_nocturno";
			$cabezaDia .= "<td>VV Max<br>(m/s)</td>
							<td>VV Media<br>(m/s)</td>
							<td>Direccion<br>Diurno</td>
							<td>Frecuencia<br>Direccion<br>Diurno(%)</td>
							<td>Direccion<br>Nocturno</td>
							<td>Frecuencia<br>Direccion<br>Nocturno (%)</td>
							<td>Rosa de<br>los Vientos</td>";
			$archivoPlanoDia .= $separador."VV Max (m/s)".$separador."VV Media (m/s)".$separador."Direccion Diurno".$separador."Frecuencia Direccion Diurno (%)".$separador."Direccion Nocturno".$separador."Frecuencia Direccion Nocturno (%)";

			$incremento = 6;
			$posGrafica = array($posGrafica[0], $posGrafica[1], $posGrafica[2], 
								$posGrafica[3], $posGrafica[4]+$incremento, $posGrafica[5]+$incremento, 
								$posGrafica[6]+$incremento, $posGrafica[7]+$incremento, $posGrafica[8]+$incremento, 
								$posGrafica[9]+$incremento, $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);

			$posGraficaAnual = array($posGraficaAnual[0], $posGraficaAnual[1], $posGraficaAnual[2], 
								$posGraficaAnual[3], $posGraficaAnual[4]+$incremento, $posGraficaAnual[5]+$incremento, 
								$posGraficaAnual[6]+$incremento, $posGraficaAnual[7]+$incremento, $posGraficaAnual[8]+$incremento, 
								$posGraficaAnual[9]+$incremento, $posGraficaAnual[10]+$incremento);
			$posGraficaMes = array($posGraficaMes[0], $posGraficaMes[1], $posGraficaMes[2], 
								$posGraficaMes[3], $posGraficaMes[4]+$incremento, $posGraficaMes[5]+$incremento, 
								$posGraficaMes[6]+$incremento, $posGraficaMes[7]+$incremento, $posGraficaMes[8]+$incremento, 
								$posGraficaMes[9]+$incremento, $posGraficaMes[10]+$incremento);
		}

		if ($hrmHrmm == 6) {
			$indic[$pos] = $hrmHrmm;
			$pos = $pos+1;
			$sql = ", max_hr, min_hr, med_hr";
			$cabeza = "<td>HR<br> Max (%)</td><td>HR<br> Min (%)</td><td>HR<br> Med (%)</td><td>Grafica</td>";
			$títulos .= "<td colspan='4'>HRm-HRmm  Humedad <br>relativa (promedios mensual <br>y mensual multianual)</td>";
			$titRangoAño .= "<td colspan='4'>HRm-HRmm  Humedad <br>relativa (promedios mensual <br>y mensual multianual)</td>";
			$titAño .= "<td colspan='4'>HRm-HRmm  Humedad <br>relativa (promedios mensual <br>y mensual multianual)</td>";
			$titMes .= "<td colspan='4'>HRm-HRmm  Humedad <br>relativa (promedios mensual <br>y mensual multianual)</td>";

			$archivoPlano = $separador."HR Max (%)".$separador."HR Min (%)".$separador."HR Med (%)";
			arregloTablasIndicadores($sql, $cabeza, $archivoPlano);
			if ($menor!=$mayor) {
				$sqlRangoAnual.=", sum(max_hr) AS ".$valRango;
				$valRango.=$nombRang;
				$sqlRangoAnual.=", sum(min_hr) AS ".$valRango;
				$valRango.=$nombRang;
				$sqlRangoAnual.=", sum(med_hr) AS ".$valRango;
				$valRango.=$nombRang;
				$cabezaRangoAn.="<td>Promedio HR<br> Max (%)</td><td>Promedio HR<br> Min (%)</td>
				<td>Promedio HR<br> Med (%)</td><td>Grafica</td>";
				$archivoRangAn.=$separador."Promedio HR Max (%)".$separador."Promedio HR Min (%)".$separador."Promedio HR Med (%)";
				$incremento = 3;
				$posGraficaRangoAnios = array($posGraficaRangoAnios[0], $posGraficaRangoAnios[1], $posGraficaRangoAnios[2], 
					$posGraficaRangoAnios[3], $posGraficaRangoAnios[4], 
					$posGraficaRangoAnios[5]+$incremento, $posGraficaRangoAnios[6]+$incremento, $posGraficaRangoAnios[7]+$incremento, 
					$posGraficaRangoAnios[8]+$incremento, $posGraficaRangoAnios[9]+$incremento, $posGraficaRangoAnios[10]+$incremento);
			}
			$incremento = 3;
			$posGrafica = array($posGrafica[0], $posGrafica[1], $posGrafica[2], 
								$posGrafica[3], $posGrafica[4], $posGrafica[5]+$incremento, 
								$posGrafica[6]+$incremento, $posGrafica[7]+$incremento, $posGrafica[8]+$incremento, 
								$posGrafica[9]+$incremento, $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);
			$posGraficaAnual = array($posGraficaAnual[0], $posGraficaAnual[1], $posGraficaAnual[2], 
								$posGraficaAnual[3], $posGraficaAnual[4], $posGraficaAnual[5]+$incremento, 
								$posGraficaAnual[6]+$incremento, $posGraficaAnual[7]+$incremento, $posGraficaAnual[8]+$incremento, 
								$posGraficaAnual[9]+$incremento, $posGraficaAnual[10]+$incremento);
			$posGraficaMes = array($posGraficaMes[0], $posGraficaMes[1], $posGraficaMes[2], 
								$posGraficaMes[3], $posGraficaMes[4], $posGraficaMes[5]+$incremento, 
								$posGraficaMes[6]+$incremento, $posGraficaMes[7]+$incremento, $posGraficaMes[8]+$incremento, 
								$posGraficaMes[9]+$incremento, $posGraficaMes[10]+$incremento);
		}

		if ($rs == 7) {
			$indic[$pos] = $rs;
			$pos = $pos+1;
			$sql = ", max_rs, med_rs";
			$cabeza = "<td>RS(W/m2)<br> Max</td><td>RS(W/m2)<br> Med</td><td>Grafica</td>";

			$títulos .= "<td colspan='3'>RS  Radiación solar <br>(promedios mensual y mensual multianual)</td>";
			$titRangoAño .=  "<td colspan='3'>RS  Radiación solar <br>(promedios mensual y mensual multianual)</td>";
			$titAño .=  "<td colspan='3'>RS  Radiación solar <br>(promedios mensual y mensual multianual)</td>";
			$titMes .=  "<td colspan='3'>RS  Radiación solar <br>(promedios mensual y mensual multianual)</td>";

			$archivoPlano = $separador."RS(W/m2) Max".$separador."RS(W/m2) Med";
			arregloTablasIndicadores($sql, $cabeza, $archivoPlano);
			if ($menor!=$mayor) {
				$sqlRangoAnual.=", sum(max_rs) AS ".$valRango;
				$valRango.=$nombRang;
				$sqlRangoAnual.=", sum(med_rs) AS ".$valRango;
				$valRango.=$nombRang;
				$cabezaRangoAn.="<td>Promedio RS(W/m2)<br> Max</td><td>Promedio RS(W/m2)<br> Med</td>
				<td>Grafica</td>";
				$archivoRangAn.=$separador."Promedio RS(W/m2) Max".$separador."Promedio RS(W/m2) Med";
				$incremento = 2;
				$posGraficaRangoAnios = array($posGraficaRangoAnios[0], $posGraficaRangoAnios[1], $posGraficaRangoAnios[2], 
					$posGraficaRangoAnios[3], $posGraficaRangoAnios[4], $posGraficaRangoAnios[5], 
					$posGraficaRangoAnios[6]+$incremento, $posGraficaRangoAnios[7]+$incremento, 
					$posGraficaRangoAnios[8]+$incremento, $posGraficaRangoAnios[9]+$incremento, $posGraficaRangoAnios[10]+$incremento);
			}
			$incremento = 2;
			$posGrafica = array($posGrafica[0], $posGrafica[1], $posGrafica[2], 
								$posGrafica[3], $posGrafica[4], $posGrafica[5], 
								$posGrafica[6]+$incremento, $posGrafica[7]+$incremento, $posGrafica[8]+$incremento, 
								$posGrafica[9]+$incremento, $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);
			$posGraficaAnual = array($posGraficaAnual[0], $posGraficaAnual[1], $posGraficaAnual[2], 
								$posGraficaAnual[3], $posGraficaAnual[4], $posGraficaAnual[5], 
								$posGraficaAnual[6]+$incremento, $posGraficaAnual[7]+$incremento, $posGraficaAnual[8]+$incremento, 
								$posGraficaAnual[9]+$incremento, $posGraficaAnual[10]+$incremento);
			$posGraficaMes = array($posGraficaMes[0], $posGraficaMes[1], $posGraficaMes[2], 
								$posGraficaMes[3], $posGraficaMes[4], $posGraficaMes[5], 
								$posGraficaMes[6]+$incremento, $posGraficaMes[7]+$incremento, $posGraficaMes[8]+$incremento, 
								$posGraficaMes[9]+$incremento, $posGraficaMes[10]+$incremento);

		}

		if ($pbm == 8) {
			$indic[$pos] = $pbm;
			$pos = $pos+1;
			$sql = ", max_pb, min_pb, med_pb";
			$cabeza = "<td>Max PB<br>(hPa)</td><td>Min PB<br>(hPa)</td><td>Med PB<br>(hPa)</td><td>Grafica</td>";

			$títulos .= "<td colspan='4'>Pbm-Pbmm  Presión barométrica <br>(promedios mensual y mensual multianual)</td>";
			$titRangoAño .= "<td colspan='4'>Pbm-Pbmm  Presión barométrica <br>(promedios mensual y mensual multianual)</td>";
			$titAño .= "<td colspan='4'>Pbm-Pbmm  Presión barométrica <br>(promedios mensual y mensual multianual)</td>";
			$titMes .= "<td colspan='4'>Pbm-Pbmm  Presión barométrica <br>(promedios mensual y mensual multianual)</td>";

			$archivoPlano = $separador."Max PB (hPa)".$separador."Min PB (hPa)".$separador."Med PB (hPa)";
			arregloTablasIndicadores($sql, $cabeza, $archivoPlano);
			if ($menor!=$mayor) {
				$sqlRangoAnual.=", sum(max_pb) AS ".$valRango;
				$valRango.=$nombRang;
				$sqlRangoAnual.=", sum(max_pb) AS ".$valRango;
				$valRango.=$nombRang;
				$sqlRangoAnual.=", sum(med_pb) AS ".$valRango;
				$valRango.=$nombRang;
				$cabezaRangoAn.="<td>Promedio Max PB<br>(hPa)</td><td>Promedio Min PB<br>(hPa)</td>
				<td>Promedio Med PB<br>(hPa)</td><td>Grafica</td>";
				$archivoRangAn.= $separador."Promedio Max PB (hPa)".$separador."Promedio Min PB (hPa)".$separador."Promedio Med PB (hPa)";
				$incremento = 3;
				$posGraficaRangoAnios = array($posGraficaRangoAnios[0], $posGraficaRangoAnios[1], $posGraficaRangoAnios[2], 
					$posGraficaRangoAnios[3], $posGraficaRangoAnios[4], $posGraficaRangoAnios[5], $posGraficaRangoAnios[6], 
					$posGraficaRangoAnios[7]+$incremento, 
					$posGraficaRangoAnios[8]+$incremento, $posGraficaRangoAnios[9]+$incremento, $posGraficaRangoAnios[10]+$incremento);
			}
			$incremento = 3;
			$posGrafica = array($posGrafica[0], $posGrafica[1], $posGrafica[2], 
								$posGrafica[3], $posGrafica[4], $posGrafica[5], 
								$posGrafica[6], $posGrafica[7]+$incremento, $posGrafica[8]+$incremento, 
								$posGrafica[9]+$incremento, $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);
			$posGraficaAnual = array($posGraficaAnual[0], $posGraficaAnual[1], $posGraficaAnual[2], 
								$posGraficaAnual[3], $posGraficaAnual[4], $posGraficaAnual[5], 
								$posGraficaAnual[6], $posGraficaAnual[7]+$incremento, $posGraficaAnual[8]+$incremento, 
								$posGraficaAnual[9]+$incremento, $posGraficaAnual[10]+$incremento);
			$posGraficaMes = array($posGraficaMes[0], $posGraficaMes[1], $posGraficaMes[2], 
								$posGraficaMes[3], $posGraficaMes[4], $posGraficaMes[5], 
								$posGraficaMes[6], $posGraficaMes[7]+$incremento, $posGraficaMes[8]+$incremento, 
								$posGraficaMes[9]+$incremento, $posGraficaMes[10]+$incremento);
		}

		if ($confort == 9) {
			$indic[$pos] = $confort;
			$pos = $pos+1;
			$sql = ", ci, sensacion_experimentada";
			$cabeza = "<td>CI</td><td>Sensacion<br>Experimentada</td><td>Grafica</td>";
			$títulos .= "<td colspan='3'>CONFORT-T <br>Confort térmico</td>";
			$titRangoAño .= "<td colspan='2'>CONFORT-T <br>Confort térmico</td>";
			$titAño .= "<td colspan='3'>CONFORT-T <br>Confort térmico</td>";
			$titMes .= "<td colspan='3'>CONFORT-T <br>Confort térmico</td>";

			$archivoPlano = $separador."CI".$separador."Sensacion Experimentada";
			arregloTablasIndicadores($sql, $cabeza, $archivoPlano);
			if ($menor!=$mayor) {
				$sqlRangoAnual.=", sum(ci) AS ".$valRango;
				$valRango.=$nombRang;
				$cabezaRangoAn.="<td>Promedio CI</td><td>Grafica</td>";
				$archivoRangAn.=$separador."Promedio CI";
				$incremento = 1;
				$posGraficaRangoAnios = array($posGraficaRangoAnios[0], $posGraficaRangoAnios[1], $posGraficaRangoAnios[2], 
					$posGraficaRangoAnios[3], $posGraficaRangoAnios[4], $posGraficaRangoAnios[5], $posGraficaRangoAnios[6], 
					$posGraficaRangoAnios[7], $posGraficaRangoAnios[8]+$incremento, $posGraficaRangoAnios[9]+$incremento, $posGraficaRangoAnios[10]+$incremento);
			}
			$incremento = 2;
			$posGrafica = array($posGrafica[0], $posGrafica[1], $posGrafica[2], 
								$posGrafica[3], $posGrafica[4], $posGrafica[5], 
								$posGrafica[6], $posGrafica[7], $posGrafica[8]+$incremento, 
								$posGrafica[9]+$incremento, $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);
			$posGraficaAnual = array($posGraficaAnual[0], $posGraficaAnual[1], $posGraficaAnual[2], 
								$posGraficaAnual[3], $posGraficaAnual[4], $posGraficaAnual[5], 
								$posGraficaAnual[6], $posGraficaAnual[7], $posGraficaAnual[8]+$incremento, 
								$posGraficaAnual[9]+$incremento, $posGraficaAnual[10]+$incremento);
			$posGraficaMes = array($posGraficaMes[0], $posGraficaMes[1], $posGraficaMes[2], 
								$posGraficaMes[3], $posGraficaMes[4], $posGraficaMes[5], 
								$posGraficaMes[6], $posGraficaMes[7], $posGraficaMes[8]+$incremento, 
								$posGraficaMes[9]+$incremento, $posGraficaMes[10]+$incremento);
		}

		if ($isp == 10) {
			$indic[$pos] = $isp;
			$pos = $pos+1;
			$sql = ", g_sin_acumular, g_con_acumular, t, isp, cat_isp";
			$cabeza = "<td>g(x)</td><td>G(x)</td><td>t</td><td>ISP</td><td>Categoria</td><td>Grafica</td>";
			$titMes .= "<td colspan='6'>ISP Índice estandarizado <br>de precipitación (Series de <br>Precipitación mensual)</td>";

			$sqlMes .= $sql;
			$cabezaMes .= $cabeza;
			$archivoPlanoMes .= $archivoPlano;
			$incremento = 5;
			$posGrafica = array($posGrafica[0], $posGrafica[1], $posGrafica[2], 
								$posGrafica[3], $posGrafica[4], $posGrafica[5], 
								$posGrafica[6], $posGrafica[7], $posGrafica[8], 
								$posGrafica[9]+$incremento, $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);
			$posGraficaRangoAnios = array($posGraficaRangoAnios[0], $posGraficaRangoAnios[1], $posGraficaRangoAnios[2], 
				$posGraficaRangoAnios[3], $posGraficaRangoAnios[4], $posGraficaRangoAnios[5], $posGraficaRangoAnios[6], 
				$posGraficaRangoAnios[7], $posGraficaRangoAnios[8], $posGraficaRangoAnios[9]+$incremento, $posGraficaRangoAnios[10]+$incremento);
			$posGraficaAnual = array($posGraficaAnual[0], $posGraficaAnual[1], $posGraficaAnual[2], 
								$posGraficaAnual[3], $posGraficaAnual[4], $posGraficaAnual[5], 
								$posGraficaAnual[6], $posGraficaAnual[7], $posGraficaAnual[8], 
								$posGraficaAnual[9]+$incremento, $posGraficaAnual[10]+$incremento);
			$posGraficaMes = array($posGraficaMes[0], $posGraficaMes[1], $posGraficaMes[2], 
								$posGraficaMes[3], $posGraficaMes[4], $posGraficaMes[5], 
								$posGraficaMes[6], $posGraficaMes[7], $posGraficaMes[8], 
								$posGraficaMes[9]+$incremento, $posGraficaMes[10]+$incremento);
		}

		if ($aridez == 11) {
			$indic[$pos] = $aridez;
			$pos = $pos+1;
			$sql = ", indice_martonne, zona_martonne";
			$cabeza = "<td>Indice de<br>aridez Martonne</td><td>Zona de<br>aridez Martonne</td><td>Grafica</td>";
			$titAño .= "<td colspan='5'>I-ARIDEZ  <br>Índice de Aridez</td>";
			$titMes .= "<td colspan='5'>I-ARIDEZ  <br>Índice de Aridez</td>";
			$titRangoAño .= "<td colspan='3'>Indice de<br>aridez Martonne</td>";

			$archivoPlano = $separador."Indice de aridez Martonne".$separador."Zona de aridez Martonne";
			$sqlAnual .= ", indice_lang, zona_lang".$sql;
			$cabezaAnual .= "<td>Indice de<br>aridez Lang</td><td>Zona de<br>aridez Lang</td>".$cabeza;
			$archivoPlanoAnual .= $separador."Indice de aridez Lang".$separador."Zona de aridez Lang".$archivoPlano;
			if ($menor!=$mayor) {
				$sqlRangoAnual.=", sum(indice_lang) AS ".$valRango;
				$valRango.=$nombRang;
				$sqlRangoAnual.=", sum(indice_martonne) AS ".$valRango;
				$valRango.=$nombRang;
				$cabezaRangoAn.="<td>Promedio Indice de<br>aridez Lang</td><td>Promedio Indice de<br>
				aridez Martonne</td><td>Grafica</td>";
				$archivoRangAn.=$separador."Promedio Indice de aridez Lang".$separador."Promedio Indice de aridez Martonne";
				$incremento = 2;
				$posGraficaRangoAnios = array($posGraficaRangoAnios[0], $posGraficaRangoAnios[1], $posGraficaRangoAnios[2], 
					$posGraficaRangoAnios[3], $posGraficaRangoAnios[4], $posGraficaRangoAnios[5], $posGraficaRangoAnios[6], 
					$posGraficaRangoAnios[7], $posGraficaRangoAnios[8], $posGraficaRangoAnios[9], $posGraficaRangoAnios[10]+$incremento);
			}
			$sqlMes .= $sql;
			$cabezaMes .= $cabeza;
			$archivoPlanoMes .= $archivoPlano;
			$incremento = 2;
			$posGrafica = array($posGrafica[0], $posGrafica[1], $posGrafica[2], 
								$posGrafica[3], $posGrafica[4], $posGrafica[5], 
								$posGrafica[6], $posGrafica[7], $posGrafica[8], 
								$posGrafica[9], $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);
			$posGraficaMes = array($posGraficaMes[0], $posGraficaMes[1], $posGraficaMes[2], 
								$posGraficaMes[3], $posGraficaMes[4], $posGraficaMes[5], 
								$posGraficaMes[6], $posGraficaMes[7], $posGraficaMes[8], 
								$posGraficaMes[9], $posGraficaMes[10]+$incremento);
			$incremento = 4;
			$posGraficaAnual = array($posGraficaAnual[0], $posGraficaAnual[1], $posGraficaAnual[2], 
								$posGraficaAnual[3], $posGraficaAnual[4], $posGraficaAnual[5], 
								$posGraficaAnual[6], $posGraficaAnual[7], $posGraficaAnual[8], 
								$posGraficaAnual[9], $posGraficaAnual[10]+$incremento);
		}

		//Fin consulta SQL
		$sql = " FROM indicador WHERE estacion=".$idEstacion;
		$sqlAnual .= $sql;
		$sqlMes .= $sql;
		$sqlDia .= $sql;
		$sqlRangoAnual.=$sql;

		#echo var_dump($posGrafica);
		if ($Anual == 1) {
			if ($menor==$mayor) {
				$sqlAnual .= " AND anio=".$menor." AND mes=0 AND dia=0 AND dia=0 ";
			}else{
				$sql = " AND anio>=".$menor." AND anio<=".$mayor." AND mes=0 AND dia=0 AND dia=0 ORDER BY 1";
				$sqlAnual .= $sql;
				$sqlRangoAnual.=$sql;
			}
		}

		if ($mes == 2) {
			if ($menor==$mayor) {
				$sqlMes .= " AND anio=".$menor." AND mes>0 AND dia=0 ORDER BY 2";
			}else{
				$sqlMes .= " AND anio>=".$menor." AND anio<=".$mayor." AND mes>0 AND dia=0 ORDER BY 1, 2";
			}
		}

		if ($dia == 3) {
			if ($menor==$mayor) {
				$sqlDia .= " AND anio=".$menor." AND mes>0 AND dia>0 ORDER BY 2, 3";
			}else{
				$sqlDia .= " AND anio>=".$menor." AND anio<=".$mayor." AND mes>0 AND dia>0 ORDER BY 1, 2, 3";
			}
		}

		//Fina encabezado
		$cabezaAnual.="</tr>";
		$cabezaMes .= "</tr>";
		$cabezaDia .= "</tr>";

		$tam = ($mayor - $menor) +1;
		$menorOrig = $menor;

		for ($i=0; $i < $tam; $i++) {
			if ($temp == 1) {
				//Ejecutar el primer indicador temp
				$existenDatos = cantDatos($idEstacion, $temp, $menor);
				if ($existenDatos > 0) {
					$hayDatos = true;
				}else{
					ejecutarTemp($idEstacion, $menor, $temp);
					$hayDatos = true;
				}
			}
			if ($rangoTemp == 2) {
				$existenDatos = cantDatos($idEstacion, $rangoTemp, $menor);
				if ($existenDatos > 0) {
					$hayDatos = true;
				}else{
					//Ejecutar el tercer indicador temp
					$existenDatos = cantDatos($idEstacion, 1, $menor);
					if ($existenDatos < 1) {
						ejecutarTemp($idEstacion, $menor, 1);
					}
					/***************************************************************************************************************************************
					*GENERAR RANGO POR DIA
					****************************************************************************************************************************************/
					generarRangoDia($idEstacion, $menor, $rangoTemp);
					$hayDatos = true;
				}
			}
			if ($ppt == 3) {
				$existenDatos = cantDatos($idEstacion, $ppt, $menor);
				if ($existenDatos > 0) {
					$hayDatos = true;
				}else{
					//Ejecutar el tercer indicador Ppt
					ejecutarPpt($idEstacion, $menor, $ppt);
					$hayDatos = true;
				}
			}
			if ($pptA25 == 4) {
				$existenDatos = cantDatos($idEstacion, $pptA25, $menor);
				if ($existenDatos > 0) {
					$hayDatos = true;
				}else{
					//Ejecutar el tercer indicador PptA25
					ejecutarPptA25($idEstacion, $menor);
					$hayDatos = true;
				}
			}
			if ($dvv == 5) {
				$existenDatos = cantDatos($idEstacion, $dvv, $menor);
				if ($existenDatos > 0) {
					$hayDatos = true;
				}else{
					//Ejecutar el tercer indicador Dvv
					ejecutarDvv($idEstacion, $menor, $dvv);
					$hayDatos = true;
				}
			}
			if ($hrmHrmm == 6) {
				$existenDatos = cantDatos($idEstacion, $hrmHrmm, $menor);
				if ($existenDatos > 0) {
					$hayDatos = true;
				}else{
					//Ejecutar el tercer indicador HR
					ejecutarHR($idEstacion, $menor, $hrmHrmm);
					$hayDatos = true;
				}
			}
			if ($rs == 7) {
				$existenDatos = cantDatos($idEstacion, $rs, $menor);
				if ($existenDatos > 0) {
					$hayDatos = true;
				}else{
					//Ejecutar el tercer indicador RS
					ejecutarRS($idEstacion, $menor, $rs);
					$hayDatos = true;
				}
			}
			if ($pbm == 8) {
				$existenDatos = cantDatos($idEstacion, $pbm, $menor);
				if ($existenDatos > 0) {
					$hayDatos = true;
				}else{
					//Ejecutar el tercer indicador PB
					ejecutarPB($idEstacion, $menor, $pbm);
					$hayDatos = true;
				}
			}
			if ($confort == 9) {
				$existenDatos = cantDatos($idEstacion, $confort, $menor);
				if ($existenDatos > 0) {
					$hayDatos = true;
				}else{
					//Ejecutar el tercer indicador CI
					ejecutarCI($idEstacion, $menor, $confort);
					$hayDatos = true;
				}
			}
			if ($isp == 10) {
				$existenDatos = cantDatos($idEstacion, $isp, $menor);
				if ($existenDatos > 0) {
					$hayDatos = true;
				}else{
					//Ejecutar el tercer indicador CI
					ejecutarISP($idEstacion, $menor);
					$hayDatos = true;
				}
			}
			if ($aridez == 11) {
				$existenDatos = cantDatos($idEstacion, $aridez, $menor);
				if ($existenDatos > 0) {
					$hayDatos = true;
				}else{
					//Ejecutar el tercer indicador IA
					ejecutarIA($idEstacion, $menor, $aridez);
					$hayDatos = true;
				}
			}
			$menor++;
		}

		$pidioAnio = false;
		$pidioMes = false;
		if ($menorOrig!=$mayor) {
			$sql = $sqlRangoAnual;
			$rangAnios = array();
			$result = $objDatos->executeQuery($sql);
			if ($result != null) {
				foreach ($result as $value) {
					$tamRang = strlen($valRango);
					$indiceRang="";
					for ($i=1; $i < $tamRang; $i++) { 
						$indiceRang.=$nombRang;
						$rangAnios[$i-1]=round($value[$indiceRang]/$value['total'],2);
					}
				}
			}
		}

		if ($Anual == 1) {
			$sql = $sqlAnual."; ";
			$resultAnio = $objDatos->executeQuery($sql);
		}

		if ($mes == 2) {
			$sql = $sqlMes."; ";
			if ($pidioAnio) {
				$archivoPlano = $archivoPlano.$salto.$archivoPlanoMes;
				$result = array_merge($result, $objDatos->executeQuery($sql));
			}else{
				$resultMes = $objDatos->executeQuery($sql);
			}
		}

		if ($dia == 3) {
			$sql = $sqlDia."; ";
			if ($pidioAnio || $pidioMes) {
				$archivoPlano = $archivoPlano.$salto.$archivoPlanoDia;
				$result = array_merge($result, $objDatos->executeQuery($sql));
			}else{
				$resultDia = $objDatos->executeQuery($sql);
			}
		}

		#echo var_dump($posGraficaMes);
    }

	function obtenerDatos($array){
		//Convierte el array en un string de formato json, para poderlo mandar a la otra pagina
		$tmp = serialize($array); 
     	$tmp = urlencode($tmp); 
     	return $tmp; 
	}

?>
<h4 class="alert_info">Generacion de Indicadores de Clima</h4><br>
	<form method="POST" action="csv.php">
		<?php
			$varPost = "<input type='hidden' value='".$nombEstacion ."' name='nombEsta'>
						<input type='hidden' value='indicador' name = 'origen'>";
			if ($menorOrig != $mayor) {
				$varPost .= "<input type='hidden' value='".obtenerDatos($rangAnios) ."' name='promRango'>
							<input type='hidden' value='".$archivoRangAn."' name = 'titProm'>
							<input type='hidden' value='".$menorOrig ."' name='anioMenor'>
							<input type='hidden' value='".$mayor."' name = 'anioMayor'>";
			}
			if ($Anual == 1) {
				$varPost .= "<input type='hidden' value='".obtenerDatos($resultAnio) ."' name='anio'>
							<input type='hidden' value='".$archivoPlanoAnual."' name = 'titulosAnio'>";
			}
			if ($mes == 2) {
				$varPost .= "<input type='hidden' value='".obtenerDatos($resultMes) ."' name='mes'>
							<input type='hidden' value='".$archivoPlanoMes."' name = 'titulosMes'>";
			}
			if ($dia == 3) {
				$varPost .= "<input type='hidden' value='".obtenerDatos($resultDia) ."' name='dia'>
							<input type='hidden' value='".$archivoPlanoDia."' name = 'titulosDia'>";
			}
			#echo $varPost;
		?>
		<input id="boton" type="submit" value="Generar Reporte" />
	</form>
<center>
<?php
	if ($hayDatos) {

		if ($Anual == 1) {
			$saltos = 3;
		}
		
		if ($mes == 2) {
			$saltos = 4;
		}

		if ($dia == 3) {
			$saltos = 5;
		}

		#echo var_dump($posGrafica);
		if ($menorOrig!=$mayor) {
			$saltosRango = 5;
			$sql = $sqlRangoAnual;
			$cabeza = $cabezaRangoAn;
			if ($result != null) {
				echo $títulos1;
				echo $titRangoAño."</tr><tr>";
				echo  substr($cabeza, $tamCabeza);
				echo "<tr>";
				$tamRanAnio = count($rangAnios);
				echo "<tr><td>$nombEstacion</td><td>".$menorOrig." - ".$mayor."</td>";
				$controlGraf=0;
				for ($i=0; $i < $tamRanAnio; $i++) { 
					echo "<td>".$rangAnios[$i]."</td>";
					#echo "<td>".$i."</td>";
					#posGraficaRangoAnios
					#posGrafica
					$controlGraf++;
					if ($controlGraf == $posGraficaRangoAnios[0] && $temp == 1) {#-$saltosRango && $temp == 1) {
							$variablee = $temp;
							echo "<td>";
							echo "<a href='graficasLineal.php?variable=$variablee
									&anio=".$menorOrig."&anio2=".$mayor
									."&est=".$idEstacion
									."&nes=".$nombEstacion
									."' target='_blank' >Ver grafica Año a Año</a><br><br>
									<a href='graficasLineal.php?variable=$variablee
									&anio=".$menorOrig."&anio2=".$mayor."&origen=mes"
									."&est=".$idEstacion
									."&nes=".$nombEstacion
									."' target='_blank' >Ver grafica Mes a Mes</a><br><br>
									<a href='graficasLinealDia.php?variable=$variablee
									&anio=".$menorOrig."&anio2=".$mayor
									."&est=".$idEstacion
									."&nes=".$nombEstacion
									."' target='_blank'>
									Ver grafica Dia a Dia</a>";
							echo "</td>";
					}else{
						if ($controlGraf == $posGraficaRangoAnios[1]  && $rangoTemp == 2) { #-$saltosRango  && $rangoTemp == 2) {
							$variablee = $rangoTemp;
							echo "<td>";
							echo "<a href='graficaLineal.php?variable=$variablee
									&anio=".$menorOrig."&anio2=".$mayor
									."&est=".$idEstacion
									."&nes=".$nombEstacion
									."' target='_blank' >Ver grafica Año a Año</a><br><br>
									<a href='graficaLineal.php?variable=$variablee
									&anio=".$menorOrig."&anio2=".$mayor."&origen=mes"
									."&est=".$idEstacion
									."&nes=".$nombEstacion
									."' target='_blank' >Ver grafica Mes a Mes</a><br><br>
									<a href='graficaLinealDia.php?variable=$variablee
										&anio=".$menorOrig."&anio2=".$mayor
										."&est=".$idEstacion
										."&nes=".$nombEstacion
										."' target='_blank'>
									Ver grafica Dia a Dia</a>";
							echo "</td>";
						}else{
							if ($controlGraf == $posGraficaRangoAnios[2]  && $ppt == 3) { #-$saltosRango-1  && $ppt == 3) {
								$variablee = $ppt;
								echo "<td>";
								echo "<a href='graficaLineal.php?variable=$variablee
										&anio=".$menorOrig."&anio2=".$mayor
										."&est=".$idEstacion
										."&nes=".$nombEstacion
										."' target='_blank' >Ver grafica Año a Año</a><br><br>
										<a href='graficaLineal.php?variable=$variablee
										&anio=".$menorOrig."&anio2=".$mayor."&origen=mes"
										."&est=".$idEstacion
										."&nes=".$nombEstacion
										."' target='_blank' >Ver grafica Mes a Mes</a><br><br>
										<a href='graficaLinealDia.php?variable=$variablee
											&anio=".$menorOrig."&anio2=".$mayor
											."&est=".$idEstacion
											."&nes=".$nombEstacion
											."' target='_blank'>
										Ver grafica Dia a Dia</a>";
								echo "</td>";
								if ($pptA25 == 4) { #-$saltosRango-2  && $pptA25 == 4) {
									$variablee = $pptA25;
									echo "<td>";
									echo "<a href='graficaLineal.php?variable=$variablee
											&anio=".$menorOrig."&anio2=".$mayor
											."&est=".$idEstacion
											."&nes=".$nombEstacion
											."' target='_blank' >Ver grafica Año a Año</a><br><br>
											<a href='graficaLineal.php?variable=$variablee
											&anio=".$menorOrig."&anio2=".$mayor."&origen=mes"
											."&est=".$idEstacion
											."&nes=".$nombEstacion
											."' target='_blank' >Ver grafica Mes a Mes</a><br><br>
											<a href='graficaLinealDia.php?variable=$variablee
												&anio=".$menorOrig."&anio2=".$mayor
												."&est=".$idEstacion
												."&nes=".$nombEstacion
												."' target='_blank'>
											Ver grafica Dia a Dia</a>";
									echo "</td>";
								}
							}else{
								if ($controlGraf == $posGraficaRangoAnios[4]   && $dvv == 5) {# -$saltosRango-7  && $dvv == 5) {
									$variablee = $dvv;
									echo "<td>";
									echo "<a href='grafiLineal.php?variable=$variablee
											&anio=".$menorOrig."&anio2=".$mayor
											."&est=".$idEstacion
											."&nes=".$nombEstacion
											."' target='_blank' >Ver grafica Año a Año</a><br><br>
											<a href='grafiLineal.php?variable=$variablee
											&anio=".$menorOrig."&anio2=".$mayor."&origen=mes"
											."&est=".$idEstacion
											."&nes=".$nombEstacion
											."' target='_blank' >Ver grafica Mes a Mes</a><br><br>
											<a href='grafRosa.php?anio=".$menorOrig."&anio2=".$mayor
												."&est=".$idEstacion."&origen=dia"
												."&nes=".$nombEstacion
												."' target='_blank'>
											Ver grafica Dia a Dia</a>";
									echo "</td>";
								}else{
									if ($controlGraf == $posGraficaRangoAnios[5] && $hrmHrmm == 6) {# -$saltosRango-7  && $hrmHrmm == 6) {
										$variablee = $hrmHrmm;
										echo "<td>";
										echo "<a href='graficasLineal.php?variable=$variablee
												&anio=".$menorOrig."&anio2=".$mayor
												."&est=".$idEstacion
												."&nes=".$nombEstacion
												."' target='_blank' >Ver grafica Año a Año</a><br><br>
												<a href='graficasLineal.php?variable=$variablee
												&anio=".$menorOrig."&anio2=".$mayor."&origen=mes"
												."&est=".$idEstacion
												."&nes=".$nombEstacion
												."' target='_blank' >Ver grafica Mes a Mes</a><br><br>
												<a href='graficasLinealDia.php?variable=$variablee
													&anio=".$menorOrig."&anio2=".$mayor
													."&est=".$idEstacion
													."&nes=".$nombEstacion
													."' target='_blank'>
												Ver grafica Dia a Dia</a>";
										echo "</td>";
									}else{
										if ($controlGraf == $posGraficaRangoAnios[6]  && $rs == 7) { #-$saltosRango-7  && $rs == 7) {
											$variablee = $rs;
											echo "<td>";
											echo "<a href='graficLineal.php?variable=$variablee
													&anio=".$menorOrig."&anio2=".$mayor
													."&est=".$idEstacion
													."&nes=".$nombEstacion
													."' target='_blank' >Ver grafica Año a Año</a><br><br>
													<a href='graficLineal.php?variable=$variablee
													&anio=".$menorOrig."&anio2=".$mayor."&origen=mes"
													."&est=".$idEstacion
													."&nes=".$nombEstacion
													."' target='_blank' >Ver grafica Mes a Mes</a><br><br>
													<a href='graficasLinealDia.php?variable=$variablee
													&anio=".$menorOrig."&anio2=".$mayor
													."&est=".$idEstacion
													."&nes=".$nombEstacion
													."' target='_blank'>
													Ver grafica Dia a Dia</a>";
											echo "</td>";
										}else{
											if ($controlGraf == $posGraficaRangoAnios[7]  && $pbm == 8) {# -$saltosRango-7  && $pbm == 8) {
												$variablee = $pbm;
												echo "<td>";
												echo "<a href='graficasLineal.php?variable=$variablee
														&anio=".$menorOrig."&anio2=".$mayor
														."&est=".$idEstacion
														."&nes=".$nombEstacion
														."' target='_blank' >Ver grafica Año a Año</a><br><br>
														<a href='graficLineal.php?variable=$variablee
														&anio=".$menorOrig."&anio2=".$mayor."&origen=mes"
														."&est=".$idEstacion
														."&nes=".$nombEstacion
														."' target='_blank' >Ver grafica Mes a Mes</a><br><br>
														<a href='graficasLinealDia.php?variable=$variablee
															&anio=".$menorOrig."&anio2=".$mayor
															."&est=".$idEstacion
															."&nes=".$nombEstacion
															."' target='_blank'>
														Ver grafica Dia a Dia</a>";
												echo "</td>";
											}else{
												if ($controlGraf == $posGraficaRangoAnios[8]  && $confort == 9) {# -$saltosRango-8  && $confort == 9) {
													$variablee = $confort;
													echo "<td>";
													echo "<a href='graficaLineal.php?variable=$variablee
															&anio=".$menorOrig."&anio2=".$mayor
															."&est=".$idEstacion
															."&nes=".$nombEstacion
															."' target='_blank' >Ver grafica Año a Año</a><br><br>
															<a href='graficaLineal.php?variable=$variablee
															&anio=".$menorOrig."&anio2=".$mayor."&origen=mes"
															."&est=".$idEstacion
															."&nes=".$nombEstacion
															."' target='_blank' >Ver grafica Mes a Mes</a><br><br>
															<a href='graficaLinealDia.php?variable=$variablee
																&anio=".$menorOrig."&anio2=".$mayor
																."&est=".$idEstacion
																."&nes=".$nombEstacion
																."' target='_blank'>
															Ver grafica Dia a Dia</a>";
													echo "</td>";
												}else{
													if ($controlGraf == $posGraficaRangoAnios[9]  && $isp == 10) {# -$saltosRango-7  && $isp == 10) {
														$variablee = $isp;
														echo "<td>";
														echo "<a href='graficaLineal.php?variable=$variablee
																&anio=".$menorOrig."&anio2=".$mayor
																."&est=".$idEstacion
																."&nes=".$nombEstacion
																."' target='_blank' >Ver grafica Año a Año</a><br><br>
																<a href='graficaLineal.php?variable=$variablee
																&anio=".$menorOrig."&anio2=".$mayor."&origen=mes"
																."&est=".$idEstacion
																."&nes=".$nombEstacion
																."' target='_blank' >Ver grafica Mes a Mes</a><br><br>
																<a href='graficaLinealDia.php?variable=$variablee
																	&anio=".$menorOrig."&anio2=".$mayor
																	."&est=".$idEstacion
																	."&nes=".$nombEstacion
																	."' target='_blank'>
																Ver grafica Dia a Dia</a>";
														echo "</td>";
													}else{
														if ($controlGraf == $posGraficaRangoAnios[10] && $aridez == 11) {# -$saltosRango-10 && $aridez == 11) {
															$variablee = $aridez;
															echo "<td>";
															echo "<a href='graficaLineal.php?variable=$variablee
																	&anio=".$menorOrig."&anio2=".$mayor
																	."&est=".$idEstacion
																	."&nes=".$nombEstacion
																		."' target='_blank'>
																	Ver grafica Año a Año</a><br><br>
																	<a href='graficaLineal.php?variable=$variablee
																	&anio=".$menorOrig."&anio2=".$mayor."&origen=mes"
																	."&est=".$idEstacion
																	."&nes=".$nombEstacion
																	."' target='_blank' >Ver grafica Mes a Mes</a><br><br>
																	<a href='graficaLinealDia.php?variable=$variablee
																		&anio=".$menorOrig."&anio2=".$mayor
																		."&est=".$idEstacion
																		."&nes=".$nombEstacion
																		."' target='_blank'>
																		Ver grafica Dia a Dia</a>";
															echo "</td>";
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			echo "</tr></tr></table></center><br><br>";
		}

		if ($Anual == 1) {
			$sql = $sqlAnual."; ";
			$cabeza = $cabezaAnual;
			$result = $objDatos->executeQuery($sql);
			if ($result != null) {
				echo $títulos1;
				echo $titAño."</tr><tr>";
				echo  substr($cabeza, $tamCabeza);
				echo "<tr>";
				foreach ($result as $value) {
					echo "<tr><td>$nombEstacion</td>";
					$controlGraf = 0;
					foreach ($value as $field) {
						$controlGraf++;
						echo "<td>$field</td>";
						if ($controlGraf == $posGraficaAnual[0] && $temp == 1) {
							$variablee = $temp;
							echo "<td>";
							echo "<a href='graficasLineal.php?variable=$variablee
									&anio=".$value['anio']
									."&est=".$idEstacion
									."&nes=".$nombEstacion
									."' target='_blank' >Ver grafica</a>";
							echo "</td>";
						}else{
							if ($controlGraf == $posGraficaAnual[1] && $rangoTemp == 2) {
								$variablee = $rangoTemp;
								echo "<td>";
								echo "<a href='graficaLineal.php?variable=$variablee
										&anio=".$value['anio']
										."&est=".$idEstacion
										."&nes=".$nombEstacion
										."' target='_blank' >Ver grafica</a>";
								echo "</td>";
							}else{
								if ($controlGraf == $posGraficaAnual[2] && $ppt == 3) {
									$variablee = $ppt;
									echo "<td>";
									echo "<a href='graficaLineal.php?variable=$variablee
											&anio=".$value['anio']
											."&est=".$idEstacion
											."&nes=".$nombEstacion
											."' target='_blank' >Ver grafica</a>";
									echo "</td>";
								}else{
									if ($controlGraf == $posGraficaAnual[3] && $pptA25 == 4) {
										$variablee = $pptA25;
										echo "<td>";
										echo "<a href='graficaLineal.php?variable=$variablee
												&anio=".$value['anio']
												."&est=".$idEstacion
												."&nes=".$nombEstacion
												."' target='_blank' >Ver grafica</a>";
										echo "</td>";
									}else{
										if ($controlGraf == $posGraficaAnual[4] && $dvv == 5) {
											$variablee = $dvv;
											echo "<td>";
											echo "<a href='grafiLineal.php?variable=$variablee
													&anio=".$value['anio']
													."&est=".$idEstacion
													."&nes=".$nombEstacion
													."' target='_blank' >Ver grafica</a>";
											echo "</td>";
										}else{
											if ($controlGraf == $posGraficaAnual[5] && $hrmHrmm == 6) {
												$variablee = $hrmHrmm;
												echo "<td>";
												echo "<a href='graficasLineal.php?variable=$variablee
														&anio=".$value['anio']
														."&est=".$idEstacion
														."&nes=".$nombEstacion
														."' target='_blank' >Ver grafica</a>";
												echo "</td>";
											}else{
												if ($controlGraf == $posGraficaAnual[6] && $rs == 7) {
													$variablee = $rs;
													echo "<td>";
													echo "<a href='graficLineal.php?variable=$variablee
															&anio=".$value['anio']
															."&est=".$idEstacion
															."&nes=".$nombEstacion
															."' target='_blank' >Ver grafica</a>";
													echo "</td>";
												}else{
													if ($controlGraf == $posGraficaAnual[7] && $pbm == 8) {
														$variablee = $pbm;
														echo "<td>";
														echo "<a href='graficasLineal.php?variable=$variablee
																&anio=".$value['anio']
																."&est=".$idEstacion
																."&nes=".$nombEstacion
																."' target='_blank' >Ver grafica</a>";
														echo "</td>";
													}else{
														if ($controlGraf == $posGraficaAnual[8] && $confort == 9) {
															$variablee = $confort;
															echo "<td>";
															echo "<a href='graficaLineal.php?variable=$variablee
																	&anio=".$value['anio']
																	."&est=".$idEstacion
																	."&nes=".$nombEstacion
																	."' target='_blank' >Ver grafica</a>";
															echo "</td>";
														}else{
															if ($controlGraf == $posGraficaAnual[9] && $isp == 10) {
																$variablee = $isp;
																echo "<td>";
																echo "<a href='graficaLineal.php?variable=$variablee
																		&anio=".$value['anio']
																		."&est=".$idEstacion
																		."&nes=".$nombEstacion
																		."' target='_blank' >Ver grafica</a>";
																echo "</td>";
															}else{
																if ($controlGraf == $posGraficaAnual[10] && $aridez == 11) {
																	$variablee = $aridez;
																	echo "<td>";
																	echo "<a href='graficaLineal.php?variable=$variablee
																			&anio=".$value['anio']
																			."&est=".$idEstacion
																			."&nes=".$nombEstacion
																			."' target='_blank' >Ver grafica</a>";
																	echo "</td>";
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
				echo "</tr></tr></table></center><br><br>";
			}else{
				echo "<center><p><br><h1>Lo sentimos no hay datos que cumplan todas las caracteristicas 
				<br>solicitadas para la consulta</h1></p></center>";
			}
		}
		/*
		else{
			$incremento = 1;
			$posGrafica = array($posGrafica[0]+$incremento, $posGrafica[1]+$incremento, $posGrafica[2]+$incremento, 
								$posGrafica[3]+$incremento, $posGrafica[4]+$incremento, $posGrafica[5]+$incremento, 
								$posGrafica[6]+$incremento, $posGrafica[7]+$incremento, $posGrafica[8]+$incremento, 
								$posGrafica[9]+$incremento, $posGrafica[10]+$incremento, $posGrafica[11]+$incremento);
		}*/

		if ($mes == 2) {
			$sql = $sqlMes."; ";
			$cabeza = $cabezaMes;
			$result = $objDatos->executeQuery($sql);
			if ($result != null) {
				echo $títulos1;
				echo $titMes."</tr><tr>";
				echo  substr($cabeza, $tamCabeza);
				echo "<tr>";
				foreach ($result as $value) {
					echo "<tr><td>$nombEstacion</td>";
					$controlGraf = 0;
					foreach ($value as $field) {
						$controlGraf++;
						echo "<td>$field</td>";
						if ($controlGraf == $posGraficaMes[0] && $temp == 1) {
							$variablee = $temp;
							echo "<td>";
							echo "<a href='graficasLineal.php?variable=$variablee
									&anio=".$value['anio']
									."&mes=".$value['mes']
									."&est=".$idEstacion
									."&nes=".$nombEstacion
									."' target='_blank' >Ver grafica</a>";
							echo "</td>";
						}else{
							if ($controlGraf == $posGraficaMes[1] && $rangoTemp == 2) {
								$variablee = $rangoTemp;
								echo "<td>";
								echo "<a href='graficaLineal.php?variable=$variablee
										&anio=".$value['anio']
										."&mes=".$value['mes']
										."&est=".$idEstacion
										."&nes=".$nombEstacion
										."' target='_blank' >Ver grafica</a>";
								echo "</td>";
							}else{
								if ($controlGraf == $posGraficaMes[2] && $ppt == 3) {
									$variablee = $ppt;
									echo "<td>";
									echo "<a href='graficaLineal.php?variable=$variablee
											&anio=".$value['anio']
											."&mes=".$value['mes']
											."&est=".$idEstacion
											."&nes=".$nombEstacion
											."' target='_blank' >Ver grafica</a>";
									echo "</td>";
								}else{
									if ($controlGraf == $posGraficaMes[3] && $pptA25 == 4) {
										$variablee = $pptA25;
										echo "<td>";
										echo "<a href='graficaLineal.php?variable=$variablee
												&anio=".$value['anio']
												."&mes=".$value['mes']
												."&est=".$idEstacion
												."&nes=".$nombEstacion
												."' target='_blank' >Ver grafica</a>";
										echo "</td>";
									}else{
										if ($controlGraf == $posGraficaMes[4] && $dvv == 5) {
											$variablee = $dvv;
											echo "<td>";
											echo "<a href='grafiLineal.php?variable=$variablee
													&anio=".$value['anio']
													."&mes=".$value['mes']
													."&est=".$idEstacion
													."&nes=".$nombEstacion
													."' target='_blank' >Ver grafica</a>";
											echo "</td>";
										}else{
											if ($controlGraf == $posGraficaMes[5] && $hrmHrmm == 6) {
												$variablee = $hrmHrmm;
												echo "<td>";
												echo "<a href='graficasLineal.php?variable=$variablee
														&anio=".$value['anio']
														."&mes=".$value['mes']
														."&est=".$idEstacion
														."&nes=".$nombEstacion
														."' target='_blank' >Ver grafica</a>";
												echo "</td>";
											}else{
												if ($controlGraf == $posGraficaMes[6] && $rs == 7) {
													$variablee = $rs;
													echo "<td>";
													echo "<a href='graficLineal.php?variable=$variablee
															&anio=".$value['anio']
															."&mes=".$value['mes']
															."&est=".$idEstacion
															."&nes=".$nombEstacion
															."' target='_blank' >Ver grafica</a>";
													echo "</td>";
												}else{
													if ($controlGraf == $posGraficaMes[7] && $pbm == 8) {
														$variablee = $pbm;
														echo "<td>";
														echo "<a href='graficasLineal.php?variable=$variablee
																&anio=".$value['anio']
																."&mes=".$value['mes']
																."&est=".$idEstacion
																."&nes=".$nombEstacion
																."' target='_blank' >Ver grafica</a>";
														echo "</td>";
													}else{
														if ($controlGraf == $posGraficaMes[8] && $confort == 9) {
															$variablee = $confort;
															echo "<td>";
															echo "<a href='graficaLineal.php?variable=$variablee
																	&anio=".$value['anio']
																	."&mes=".$value['mes']
																	."&est=".$idEstacion
																	."&nes=".$nombEstacion
																	."' target='_blank' >Ver grafica</a>";
															echo "</td>";
														}else{
															if ($controlGraf == $posGraficaMes[9] && $isp == 10) {
																$variablee = $isp;
																echo "<td>";
																echo "<a href='graficaLineal.php?variable=$variablee
																		&anio=".$value['anio']
																		."&mes=".$value['mes']
																		."&est=".$idEstacion
																		."&nes=".$nombEstacion
																		."' target='_blank' >Ver grafica</a>";
																echo "</td>";
															}else{
																if ($controlGraf == $posGraficaMes[10]&& $aridez == 11) {
																	$variablee = $aridez;
																	echo "<td>";
																	echo "<a href='graficaLineal.php?variable=$variablee
																			&anio=".$value['anio']
																			."&mes=".$value['mes']
																			."&est=".$idEstacion
																			."&nes=".$nombEstacion
																			."' target='_blank' >Ver grafica</a>";
																	echo "</td>";
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
				echo "</tr></tr></table></center><br><br>";
			}else{
				echo "<center><p><br><h1>Lo sentimos no hay datos que cumplan todas las caracteristicas 
				<br>solicitadas para la consulta</h1></p></center>";
			}
		}

		echo "<br><br>";

		if ($dia == 3) {
			$sql = $sqlDia."; ";
			$cabeza = $cabezaDia;
			$result = $objDatos->executeQuery($sql);
			if ($result != null) {
				echo $títulos1;
				echo $títulos."</tr><tr>";
				echo  substr($cabeza, $tamCabeza);
				echo "<tr>";
				foreach ($result as $value) {
					echo "<tr><td>$nombEstacion</td>";
					$controlGraf = 1;
					foreach ($value as $field) {
						$controlGraf++;
						/*if ($pptA25 == 4 && ($controlGraf == $posGrafica[3]-1)) {
							echo "<td color='red'>$field</td>";
						}else{*/
							echo "<td>$field</td>";
						#}
						if ($controlGraf == $posGrafica[0] && $temp == 1) {
							$variablee = $temp;
							echo "<td>";
							echo "<a href='graficasLinealDia.php?variable=$variablee
									&anio=".$value['anio']
									."&mes=".$value['mes']
									."&dia=".$value['dia']
									."&est=".$idEstacion
									."&nes=".$nombEstacion
									."' target='_blank' >Ver grafica</a>";
							echo "</td>";
						}else{
							if ($controlGraf == $posGrafica[1] && $rangoTemp == 2) {
								$variablee = $rangoTemp;
								echo "<td>";
								echo "<a href='graficaLinealDia.php?variable=$variablee
										&anio=".$value['anio']
										."&mes=".$value['mes']
										."&dia=".$value['dia']
										."&est=".$idEstacion
										."&nes=".$nombEstacion
										."' target='_blank' >Ver grafica</a>";
								echo "</td>";
							}else{
								if ($controlGraf == $posGrafica[2] && $ppt == 3) {
									$variablee = $ppt;
									echo "<td>";
									echo "<a href='graficaLinealDia.php?variable=$variablee
											&anio=".$value['anio']
											."&mes=".$value['mes']
											."&dia=".$value['dia']
											."&est=".$idEstacion
											."&nes=".$nombEstacion
											."' target='_blank' >Ver grafica</a>";
									echo "</td>";
								}else{
									if ($controlGraf == $posGrafica[3] && $pptA25 == 4) {
										$variablee = $pptA25;
										echo "<td>";
										echo "<a href='graficaLinealDia.php?variable=$variablee
												&anio=".$value['anio']
												."&mes=".$value['mes']
												."&dia=".$value['dia']
												."&est=".$idEstacion
												."&nes=".$nombEstacion
												."' target='_blank' >Ver grafica</a>";
										echo "</td>";
									}else{
										if ($controlGraf == $posGrafica[4] && $dvv == 5) {
											echo "<td>";
											echo "<a href='rosaVientos1.php?anio=".$value['anio']
													."&mes=".$value['mes']
													."&dia=".$value['dia']
													."&est=".$idEstacion
													."&nes=".$nombEstacion
													."' target='_blank' >Ver grafica</a>";
											echo "</td>";
										}else{
											if ($controlGraf == $posGrafica[5] && $hrmHrmm == 6) {
												$variablee = $hrmHrmm;
												echo "<td>";
												echo "<a href='graficasLinealDia.php?variable=$variablee
														&anio=".$value['anio']
														."&mes=".$value['mes']
														."&dia=".$value['dia']
														."&est=".$idEstacion
														."&nes=".$nombEstacion
														."' target='_blank' >Ver grafica</a>";
												echo "</td>";
											}else{
												if ($controlGraf == $posGrafica[6] && $rs == 7) {
													$variablee = $rs;
													echo "<td>";
													echo "<a href='graficaLinealDia.php?variable=$variablee
															&anio=".$value['anio']
															."&mes=".$value['mes']
															."&dia=".$value['dia']
															."&est=".$idEstacion
															."&nes=".$nombEstacion
															."' target='_blank' >Ver grafica</a>";
													echo "</td>";
												}else{
													if ($controlGraf == $posGrafica[7] && $pbm == 8) {
														$variablee = $pbm;
														echo "<td>";
														echo "<a href='graficasLinealDia.php?variable=$variablee
																&anio=".$value['anio']
																."&mes=".$value['mes']
																."&dia=".$value['dia']
																."&est=".$idEstacion
																."&nes=".$nombEstacion
																."' target='_blank' >Ver grafica</a>";
														echo "</td>";
													}else{
														if ($controlGraf == $posGrafica[8] && $confort == 9) {
															$variablee = $confort;
															echo "<td>";
															echo "<a href='graficaLinealDia.php?variable=$variablee
																	&anio=".$value['anio']
																	."&mes=".$value['mes']
																	."&dia=".$value['dia']
																	."&est=".$idEstacion
																	."&nes=".$nombEstacion
																	."' target='_blank' >Ver grafica</a>";
															echo "</td>";
														}else{
															if ($controlGraf == $posGrafica[9] && $isp == 10) {
																$variablee = $isp;
																echo "<td>";
																echo "<a href='graficaLinealDia.php?variable=$variablee
																		&anio=".$value['anio']
																		."&mes=".$value['mes']
																		."&dia=".$value['dia']
																		."&est=".$idEstacion
																		."&nes=".$nombEstacion
																		."' target='_blank' >Ver grafica</a>";
																echo "</td>";
															}else{
																if ($controlGraf == $posGrafica[10] && $aridez == 11) {
																	$variablee = $aridez;
																	echo "<td>";
																	echo "<a href='graficaLinealDia.php?variable=$variablee
																			&anio=".$value['anio']
																			."&mes=".$value['mes']
																			."&dia=".$value['dia']
																			."&est=".$idEstacion
																			."&nes=".$nombEstacion
																			."' target='_blank' >Ver grafica</a>";
																	echo "</td>";
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
				echo "</tr></tr></table></center><br><br>";
			}else{
				echo "<center><p><br><h1>Lo sentimos no hay datos que cumplan todas las caracteristicas 
				<br>solicitadas para la consulta</h1></p></center>";
			}
		}
	}
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('base/fin.php');
?>