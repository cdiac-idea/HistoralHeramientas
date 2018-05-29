<?php
	//inicio de html y parte del menu ademas de funciones con las consultas sql
    include('base/inicio.php');


	/*******************************************************************************************************
	 *  CARGANDO DATOS ELEGIDOS POR EL USUARIO
	 ******************************************************************************************************/
    $separador=";";
    $salto="\n";

    #echo var_dump($_POST);

	//Atributos de consulta
	$idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
	$idAno1 = array_key_exists('idAno1', $_POST) ? $_POST['idAno1'] : null;
	$idAno2 = array_key_exists('idAno2', $_POST) ? $_POST['idAno2'] : null;
	$idMes1 = array_key_exists('idMes1', $_POST) ? $_POST['idMes1'] : null;
	$idMes2 = array_key_exists('idMes2', $_POST) ? $_POST['idMes2'] : null;
	$idDia1 = array_key_exists('idDia1', $_POST) ? $_POST['idDia1'] : null;
	$idDia2 = array_key_exists('idDia2', $_POST) ? $_POST['idDia2'] : null;
	$prec = array_key_exists('idPrecipitacion', $_POST) ? $_POST['idPrecipitacion'] : null;
	$temp = array_key_exists('idTemperatura', $_POST) ? $_POST['idTemperatura'] : null;
	$tMax = array_key_exists('idTemperatura_max', $_POST) ? $_POST['idTemperatura_max'] : null;
	$tMin = array_key_exists('idTemperatura_min', $_POST) ? $_POST['idTemperatura_min'] : null;
	$tMed = array_key_exists('idTemperatura_med', $_POST) ? $_POST['idTemperatura_med'] : null;
	$bril = array_key_exists('idBrillo', $_POST) ? $_POST['idBrillo'] : null;
	$humR = array_key_exists('idHumedad_relativa', $_POST) ? $_POST['idHumedad_relativa'] : null;
	$nive = array_key_exists('idNivel', $_POST) ? $_POST['idNivel'] : null;
	$caud = array_key_exists('idCaudal', $_POST) ? $_POST['idCaudal'] : null;
	$vVie = array_key_exists('idVelocidad_viento', $_POST) ? $_POST['idVelocidad_viento'] : null;
	$dVie = array_key_exists('idDireccion_viento', $_POST) ? $_POST['idDireccion_viento'] : null;
	$pBar = array_key_exists('idPresion_barometrica', $_POST) ? $_POST['idPresion_barometrica'] : null;
	$evap = array_key_exists('idEvapotranspiracion', $_POST) ? $_POST['idEvapotranspiracion'] : null;
	$radS = array_key_exists('idRadiacion_solar', $_POST) ? $_POST['idRadiacion_solar'] : null;
	$idVariable = array_key_exists('idVariable', $_POST) ? $_POST['idVariable'] : null;
	//Para encabezado de la tabla
	$cabeza = "<center><table border = 1 ><tr class = 'cabecera'><td>Estacion</td><td>Fecha</td><td>Hora</td>";
	//$archivoPlano = "Estacion".$separador."Fecha".$separador."Hora";
	$encabezado = "Estacion".$separador."Fecha".$separador."Hora";

	/*******************************************************************************************************
	 *  GENERAR CONSULTA SQL
	 ******************************************************************************************************/
	$sql = "SELECT estacion, fecha, tiempo";
	
	if ($idVariable!=null) {
		$sql1 = "SELECT variable_fact as atributo, nombre as nombre FROM variable WHERE id_variable=".$idVariable;
		$datoVariable = $objDatos->executeQuery($sql1);
		#print_r($datoVariable);
		$atributo = $datoVariable[0]['atributo'];
		#echo $atributo;
		$nombreVariable = $datoVariable[0]['nombre'];
		#echo $nombreVariable;
		$sql .= ", $atributo FROM station_dim, date_dim, fact_aire, time_dim
		WHERE station_dim.estacion_sk=fact_aire.estacion_sk AND fact_aire.tiempo_sk=time_dim.tiempo_sk
		AND date_dim.fecha_sk=fact_aire.fecha_sk";
		if ($nombreVariable == "PM2,5" || $nombreVariable == "PM10") {
			$unidad = "(µg/m3)std";
		}else{
			$unidad = "(ppb)";
		}
		$cabeza .= "<td>".$nombreVariable." ".$unidad."</td>";
		$encabezado .= $separador.$nombreVariable." ".$unidad;

		#$cabeza .= "<td>".$nombreVariable."</td>";
	}else{
		//Datos a ver
		if($prec == "precipitacion") {
			$sql = $sql.", precipitacion";
			$cabeza = $cabeza."<td>Precipitacion (mm)</td>";
			//$archivoPlano = $archivoPlano.$separador."Precipitacion";
			$encabezado .= $separador."Precipitacion (mm)";
		}
		if($temp == "temperatura") {
			$sql = $sql.", temperatura"; 
			$cabeza = $cabeza."<td>Temperatura (°C)</td>";
			//$archivoPlano = $archivoPlano.$separador."Temperatura";
			$encabezado .= $separador."Temperatura (°C)";
		}
		if($tMax == "temperatura_max") {
			$sql = $sql.", temperatura_max";
			$cabeza = $cabeza."<td>Temperatura<br>Maxima (°C)</td>";
			//$archivoPlano = $archivoPlano.$separador."Temperatura Maxima";
			$encabezado .= $separador."Temperatura Maxima (°C)";
		}
		if($tMin == "temperatura_min") {
			$sql = $sql.", temperatura_min"; 
			$cabeza = $cabeza."<td>Temperatura<br>Minima (°C)</td>";
			//$archivoPlano = $archivoPlano.$separador."Temperatura Minima";
			$encabezado .= $separador."Temperatura Minima (°C)";
		}
		if($tMed == "temperatura_med") {
			$sql = $sql.", temperatura_med"; 
			$cabeza = $cabeza."<td>Temperatura<br>Media (°C)</td>";
			//$archivoPlano = $archivoPlano.$separador."Temperatura Media";
			$encabezado .= $separador."Temperatura Media (°C)";
		}
		if($bril == "brillo") {
			$sql = $sql.", brillo"; 
			$cabeza = $cabeza."<td>Brillo (h/día)</td>";
			//$archivoPlano = $archivoPlano.$separador."Brillo";
			$encabezado .= $separador."Brillo (h/día)";
		}
		if($humR == "humedad_relativa") {
			$sql = $sql.", humedad_relativa"; 
			$cabeza = $cabeza."<td>Humeadad<br>Relativa (%)</td>";
			//$archivoPlano = $archivoPlano.$separador."Humeadad Relativa";
			$encabezado .= $separador."Humeadad Relativa (%)";
		}
		if($nive == "nivel") {
			$sql = $sql.", nivel";	
			$cabeza = $cabeza."<td>Nivel (cm)</td>";
			//$archivoPlano = $archivoPlano.$separador."Nivel";
			$encabezado .= $separador."Nivel (cm)";
		}
		if($caud == "caudal") {
			$sql = $sql.", caudal"; 
			$cabeza = $cabeza."<td>Caudal (l/seg)</td>";
			//$archivoPlano = $archivoPlano.$separador."Caudal";
			$encabezado .= $separador."Caudal (l/seg)";
		}
		if($vVie == "velocidad_viento") {
			$sql = $sql.", velocidad_viento";	
			$cabeza = $cabeza."<td>Velocidad<br>Viento (m/seg)</td>";
			//$archivoPlano = $archivoPlano.$separador."Velocidad Viento";
			$encabezado .= $separador."Velocidad Viento (m/seg)";
		}	
		if($dVie == "direccion_viento") {
			$sql = $sql.", direccion_viento";
			$cabeza = $cabeza."<td>Direccion<br>Viento (°)</td>";
			//$archivoPlano = $archivoPlano.$separador."Direccion Viento";
			$encabezado .= $separador."Direccion Viento (°)";
		}
		if($pBar == "presion_barometrica") {
			$sql = $sql.", presion_barometrica"; 
			$cabeza = $cabeza."<td>Presion<br>Barometrica (mmHg)</td>";
			//$archivoPlano = $archivoPlano.$separador."Presion Barometrica";
			$encabezado .= $separador."Presion Barometrica (mmHg)";
		}
		if($evap == "evapotranspiracion") {
			$sql = $sql.", evapotranspiracion"; 
			$cabeza = $cabeza."<td>Evapotranspiracion (mm)</td>";
			//$archivoPlano = $archivoPlano.$separador."Evapotranspiracion";
			$encabezado .= $separador."Evapotranspiracion (mm)";
		}
		if($radS == "radiacion_solar") {
			$sql = $sql.", radiacion_solar"; 
			$cabeza = $cabeza."<td>Radiacion<br>Solar (W/m2)</td>";
			//$archivoPlano = $archivoPlano.$separador."Radiacion Solar";
			$encabezado .= $separador."Radiacion Solar (W/m2)";
		}


		$sql = $sql." FROM station_dim, date_dim, fact_table, time_dim
		WHERE station_dim.estacion_sk=fact_table.estacion_sk AND fact_table.tiempo_sk=time_dim.tiempo_sk
		AND date_dim.fecha_sk=fact_table.fecha_sk";
	}

	

	//Complemento de la consulta SQL dependiendo de las condiciones del Usuario
	if($idEstacion != "Seleccione") {$sql = $sql." AND station_dim.estacion_sk=".$idEstacion;}

	if ($idAno1 != "Seleccione" && $idAno2 == "Seleccione") {
		$idAno2 = $idAno1;
	}elseif ($idAno1 == "Seleccione" && $idAno2 != "Seleccione") {
		$idAno1 = $idAno2;
	}

	if ($idMes1 != "Seleccione" && $idMes2 == "Seleccione") {
		$idMes2 = $idMes1;
	}elseif ($idMes1 == "Seleccione" && $idMes2 != "Seleccione") {
		$idMes1 = $idMes2;
	}

	if ($idDia1 != "Seleccione" && $idDia2 == "Seleccione") {
		$idDia2 = $idDia1;
	}elseif ($idDia1 == "Seleccione" && $idDia2 != "Seleccione") {
		$idDia1 = $idDia2;
	}/*elseif ($idDia1 == "Selccione" && $idDia2 == "Seleccione") {
		$idDia1 = $idDia2 = 1;
	}*/

	if($idAno1 != null && $idAno1 != "Seleccione"){// && ($mes1 == null || $mes2 == null) && ($dia1 == null || $dia2 == null)){
        if ($idAno2 != null  && $idAno2 != "Seleccione"){
            $menor = $idAno1;
            $mayor = $idAno2;
			if ($menor > $idAno2) {
				$menor = $idAno2;
				$mayor = $idAno1;
			}
			$sql = $sql." AND date_dim.año >= '$menor' AND date_dim.año <= '$mayor'";
		}else{
			$sql = $sql." AND date_dim.año=". $idAno1;
		}
	}elseif ($idAno2 != null  && $idAno2 != "Seleccione"){// && ($mes1 == null || $mes2 == null) && ($dia1 == null || $dia2 == null)) {
		$sql = $sql." AND date_dim.año=".$idAno2;
	}
    
    if (($idAno1 == "Seleccione" && $idAno2 != "Seleccione") || ($idAno1 != "Seleccione" && $idAno2 == "Seleccione")) {
        $banderaAño = "true";
    }else{
        $banderaAño = "false";
    }

    if($idMes1 != "Seleccione"){
        if ($idMes2 != "Seleccione" && $banderaAño  == "true" && ($idDia1 == "Seleccione" || $idDia2 == "Seleccione")){
            $menor = $idMes1;
            $mayor = $idMes2;
            if ($menor > $idMes2) {
                $menor = $idMes2;
                $mayor = $idMes1;
            }
            $sql = $sql." AND date_dim.mes >= '$menor' AND date_dim.mes <= '$mayor'";
        }elseif ($idMes2 != "Seleccione" && $banderaAño == "false") {
        	if ($idAno1 != "Seleccione" && $idAno2 == "Seleccione") {
        		$idAno2=$idAno1;
        	}elseif ($idAno1 == "Seleccione" && $idAno2 != "Seleccione") {
        		$idAno1=$idAno2;
        	}
            $menor = $idAno1;
            $mayor = $idAno2;
            if ($menor > $idAno2) {
                $menor = $idAno2;
                $mayor = $idAno1;
            }
            $fechaMenor = $menor."-".$idMes1."-01";
            if ($idVariable!=null) {
            	$dia= diaMaximoAire($idEstacion, $mayor, $idMes2);
			}else{
            	$dia= diaMaximoFact($idEstacion, $mayor, $idMes2);
			}
            $fechaMayor = $mayor."-".$idMes2."-".$dia;
            $sql = $sql." AND date_dim.fecha >= '$fechaMenor' AND date_dim.fecha <= '$fechaMayor'";
        }else{
            $sql = $sql." AND date_dim.mes=".$idMes1;
        }
    }elseif ($idMes2 != "Seleccione" && $banderaAño == "true" && ($idDia1 == "Seleccione" || $idDia2 == "Seleccione")) {
        $sql = $sql." AND date_dim.mes=".$idMes2;
    }

    if (($idMes1 == "Seleccione" && $idMes2 != "Seleccione") || ($idMes1 != "Seleccione" && $idMes2 == "Seleccione")) {
        $banderaMes = "true";
    }else{
        $banderaMes = "false";
    }

    if ($idDia1 != "Seleccione" ) {
        if ($idDia2 != "Seleccione" && $banderaAño  == "true" && $banderaMes == "true") {
            $menor = $idDia1;
            $mayor = $idDia2;
            if ($menor > $idDia2) {
                $menor = $idDia2;
                $mayor = $idDia1;
            }
            $sql .= " AND date_dim.dia >='$menor' AND date_dim.dia <='$mayor'";
        }elseif ($idDia2 != "Seleccione" && $banderaAño  == "false") {
            $menor = $idAno1;
            $mayor = $idAno2;
            if ($menor > $idAno2) {
                $menor = $idAno2;
                $mayor = $idAno1;
            }
            $fechaMenor = $menor."-".$idMes1."-".$idDia1;
            $fechaMayor = $mayor."-".$idMes2."-".$idDia2;
            $sql = $sql." AND date_dim.fecha >= '$fechaMenor' AND date_dim.fecha <= '$fechaMayor'";
        }else{
            $sql .= " AND date_dim.dia=".$idDia1;
        }
    }elseif ($idDia2 != "Seleccione" && $banderaAño == "true" && $banderaMes = "true") {
        $sql .= " AND date_dim.dia=".$idDia2;
    }

	if ($idVariable!=null) {
    	$sql .= " AND $atributo>0";
	}


	$sql = $sql." ORDER BY 2, 3";
	//Fina encabezado
	$cabeza = $cabeza."</tr><tr>";
	#echo $sql;
	//Ejecutando Consulta en el Postgresql
	
	$result = $objDatos->executeQuery($sql);

	//Longitud de la respuesta
	$tam = count($result);

	function obtenerDatos($array){
		//Convierte el array en un string de formato json, para poderlo mandar a la otra pagina
		$tmp = serialize($array); 
     	$tmp = urlencode($tmp); 
     	return $tmp; 
	}

?>
<h4 class="alert_info">Resultados de la consulta</h4><br>
	<form method="POST" action="csv.php">
		<input type="hidden" value="<?php echo obtenerDatos($result); ?>" name="datos" >
		<input type="hidden" value = "<?php echo $encabezado;?>" name = "titulos">
		<input type="hidden" value="consulta" name = "origen">
		<input id="boton" type="submit" value="Generar Reporte" />
	</form>
<?php
	echo "<br>La cantidad de datos que cumplen los requisitos son: $tam <br>";
	if ($result != null) {
		echo $cabeza;
		foreach ($result as $value) {
			echo "<tr>";
			//$archivoPlano = $archivoPlano.$salto;
			foreach ($value as $field) {
				echo "<td>$field</td>";
				//$archivoPlano = $archivoPlano."$field".$separador;
			}
		}
		echo "</tr></tr></table></center><br><br>";
	}else{
		echo "<center><p><br><h1>Lo sentimos no hay datos que cumplan todas las caracteristicas 
		<br>solicitadas para la consulta</h1></p></center>";
	}
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('base/fin.php');
?>