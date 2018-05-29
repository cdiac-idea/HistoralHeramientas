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
		$idVariable = array_key_exists('idVariable', $_POST) ? $_POST['idVariable'] : null;
		$mostrar = false;
		$variable = nombreVarAire($idEstacion, $idVariable);
		if ($idAno1 != "Seleccione") {
			if ($idAno2 != "Seleccione") {
				$menor = $idAno1;
				$mayor = $idAno2;
				if ($menor > $mayor) {
					$menor = $idAno2;
					$mayor = $idAno1;
				}
			}else{
				$menor = $mayor = $idAno1;
			}
		}else{
			if ($idAno2 != "Seleccione") {
				$menor = $mayor = $idAno2;	
			}
		}

		$titulo1 = "<br><br><center> <table border='1'> <tr class = 'cabecera'>
							<td>Estación</td>
							<td>Año</td>
							<td>Mes</td>
							<td>Día</td>
							<td>Hora Inicio</td>
							<td>Hora Final</td>";
		$archivoPlano = "Estación".$separador."Año".$separador."Mes".$separador."Día".$separador."Hora Inicio".$separador."Hora Final";
		//identificando el nombre de la estacion para optimizar busquedas, haciendolas directas en tablas independientes
		$nombEstacion = getNombreEstacion($idEstacion);
		$sql = "SELECT i.anio, i.mes, i.dia, i.hora_inicio, i.hora_fin";

		if ($idVariable == 173) {
			$titulo1 .= "<td>ICA PM10</td><td>Clasificación</td>";
			$archivoPlano .= $separador."ICA PM10".$separador."Clasificación";
			$sql .= ", i.ica_pm10, i.calificacion_pm10";
			$validar = validarIndAire($idEstacion, $idVariable, $menor, $mayor);
			if ($validar) {
				calcularPM10($idEstacion, $menor, $mayor, $idVariable);
			}
		}

		if ($idVariable == 174) {
			$titulo1 .= "<td>ICA PM2,5</td><td>Clasificación</td>"; 
			$archivoPlano .= $separador."ICA PM2,5".$separador."Clasificación";
			$sql .= ", i.ica_pm25, i.calificacion_pm25";
			$validar = validarIndAire($idEstacion, $idVariable, $menor, $mayor);
			if ($validar) {
				calcularPM25($idEstacion, $menor, $mayor, $idVariable);
			}
		}

		if ($idVariable == 175) {
			$titulo1 .= "<td>Concentración<br>(ppm)</td><td>ICA CO</td><td>Clasificación</td>
							<td>Confianza (%)</td><td>Desviación <br>Estandar</td>"; 
			$archivoPlano .= $separador."Concentración".$separador."ICA CO".$separador."Clasificación"
							.$separador."Confianza (%)".$separador."Desviación Estandar";
			$sql .= ", i.concentracion_co_8h, i.ica_co_8h, i.calificacion_co_8h, i.confianza_co_8h, 
			i.desviacion_co_8h";
			$validar = validarIndAire($idEstacion, $idVariable, $menor, $mayor);
			if ($validar) {
				calcularCO8H($idEstacion, $menor, $mayor, $idVariable);
			}
		}

		if ($idVariable == 176) {
			$titulo1 .= "<td>Concentración<br>(ppm)</td><td>ICA O3</td><td>Clasificación</td><td>Confianza (%)</td>
						<td>Desviación <br>Estandar</td>"; 
			$archivoPlano .= $separador."Concentración".$separador."ICA O3".$separador."Clasificación"
							.$separador."Confianza (%)".$separador."Desviación Estandar";
			$sql .= ", i.concentracion_o3_8h, i.ica_o3_8h, i.calificacion_o3_8h, i.confianza_o3_8h, 
			i.desviacion_o3_8h";
			$validar = validarIndAire($idEstacion, $idVariable, $menor, $mayor);
			if ($validar) {
				calcularO38H($idEstacion, $menor, $mayor, $idVariable);
			}
		}

		if ($idVariable == 177) {
			$titulo1 .= "<td>Concentración<br>(ppm)</td><td>ICA SO2</td><td>Clasificación</td><td>Confianza (%)</td>
						<td>Desviación <br>Estandar</td>"; 
			$archivoPlano .= $separador."Concentración".$separador."ICA SO2".$separador."Clasificación"
							.$separador."Confianza (%)".$separador."Desviación Estandar";
			$sql .= ", i.concentracion_so2_24h, i.ica_so2_24h, i.calificacion_so2_24h, i.confianza_so2_24h, i.desviacion_so2_24h";
			$validar = validarIndAire($idEstacion, $idVariable, $menor, $mayor);
			if ($validar) {
				calcularSO2($idEstacion, $menor, $mayor, $idVariable);
			}
		}

		$titulo1 .= "</tr>";
		$sql .= " FROM indicador_aire i 
				WHERE i.estacion=".$idEstacion." AND i.anio>=".$menor." AND i.anio<=".$mayor;
		if ($idVariable == 173) {
			$sql .= " AND i.ica_pm10  IS NOT NULL";
		}

		if ($idVariable == 174) {
			$sql .= " AND i.ica_pm25  IS NOT NULL";
		}

		if ($idVariable == 175) {
			$sql .= " AND i.ica_co_8h IS NOT NULL";
		}

		if ($idVariable == 176) {
			$sql .= " AND i.ica_o3_8h IS NOT NULL";
		}

		if ($idVariable == 177) {
			$sql .= " AND i.ica_so2_24h IS NOT NULL";
		}

		$sql .= " ORDER BY 1, 2, 3, 4, 5";

		$result = $objDatos->executeQuery($sql);

		$variable = getVarAire($idVariable);
		$nombreVa = $variable[0]['nombre'];
		$variable = $variable[0]['variable'];
	}

	function obtenerDatos($array){
		//Convierte el array en un string de formato json, para poderlo mandar a la otra pagina
		$tmp = serialize($array); 
     	$tmp = urlencode($tmp); 
     	return $tmp; 
	}
?>

<h4 class='alert_info'>Generacion de Indicadores de Clima</h4><br>
	<form method="POST" action="csv.php">
		<?php
			$varPost = "<input type='hidden' value='".$nombEstacion ."' name='nombEsta'>
						<input type='hidden' value='indicadorAire' name = 'origen'>";
			$varPost .= "<input type='hidden' value='".obtenerDatos($result) ."' name='datos'>
						<input type='hidden' value='".$archivoPlano."' name = 'titulos'>";
			echo $varPost;
		?>
		<input id="boton" type="submit" value="Generar Reporte" />
	</form>
	<form method='POST' action = 'graficar.php' target='_blank'>
		<?php
			echo "<input name = 'menor' type = 'hidden' value=".$menor."></input>";
			echo "<input name = 'mayor' type = 'hidden' value=".$mayor."></input>";
			echo "<input name = 'estacion' type = 'hidden' value=".$nombEstacion."></input>";
			echo "<input name = 'idEstacion' type = 'hidden' value=".$idEstacion."></input>";
			echo "<input name = 'variable' type = 'hidden' value=".$variable."></input>";
			echo "<input name = 'nombVar' type = 'hidden' value=".$nombreVa."></input>";
		?>
		<input id='boton' type='submit' value='Generar Gráfica' />
	</form>
<center>

<?php

	if ($result != null) {
		echo $titulo1;
		foreach ($result as $value) {
			echo "<tr><td>$nombEstacion</td>";
			foreach ($value as $field) {
				if ($field=="Buena") {
					echo "<td class='buena'>$field</td>";
				}elseif($field=="Moderada") {
					echo "<td class='moderada'>$field</td>";
				}elseif($field=="Daniña a la salud para grupos sensibles") {
					echo "<td class='daninaSalud'>$field</td>";
				}elseif($field=="Dañina a la salud") {
					echo "<td class='danina'>$field</td>";
				}elseif($field=="Muy dañina a la salud") {
					echo "<td class='muyDanina'>$field</td>";
				}elseif($field=="Peligrosa") {
					echo "<td class='peligrosa'>$field</td>";
				}else{
					echo "<td>$field</td>";
				}
			}
		}
		echo "</tr></tr></table></center><br><br>";
	}else{
		echo "<center><p><br><h1>Lo sentimos no hay datos que cumplan todas las caracteristicas 
		<br>solicitadas para la consulta</h1></p></center>";
	}
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('../bd/base/fin.php');
?>