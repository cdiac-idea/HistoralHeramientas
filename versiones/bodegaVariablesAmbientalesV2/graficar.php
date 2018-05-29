<?php
	include('base/inicioGraf.php');
	error_reporting (E_ALL & ~ E_NOTICE);
	if ($_POST) {
		$estacion = array_key_exists('estacion', $_POST) ? $_POST['estacion'] : null;
		$idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
		$menor = array_key_exists('menor', $_POST) ? $_POST['menor'] : null;
		$mayor = array_key_exists('mayor', $_POST) ? $_POST['mayor'] : null;
		$variable = array_key_exists('variable', $_POST) ? $_POST['variable'] : null;
		$nombreVar = array_key_exists('nombVar', $_POST) ? $_POST['nombVar'] : null;
		$tituloGraf = $nombreVar.' '.$menor;#.' - '.$mayor;
		$serie = $nombreVar." VS Fecha";
		$data = array();
		$tituloGraf .= ' '.$estacion;
		$calificacion = array('Buena', 'Moderada', 'Daniña a la salud para grupos sensibles', 'Dañina a la salud', 'Muy dañina a la salud', 'Peligrosa', 'Peligrosa');
		$tam = 6;
		$fechas = getFechaAire($variable, $idEstacion, $menor, $mayor, $calificacion[0]);
		$tamFecha = count($fechas);
		$datosBuena = getDatoAire($variable, $idEstacion, $menor, $mayor, $calificacion[0]);
		$tamMax = count($datosBuena);
		$datosModerada = getDatoAire($variable, $idEstacion, $menor, $mayor, $calificacion[1]);
		$tamModerada = count($datosModerada);
		$datosDanina = getDatoAire($variable, $idEstacion, $menor, $mayor, $calificacion[2]);
		$tamDanina = count($datosDanina);
		$datosDaninaSalud = getDatoAire($variable, $idEstacion, $menor, $mayor, $calificacion[3]);
		$tamDaninaSalud = count($datosDaninaSalud);
		$datosMuyDanina = getDatoAire($variable, $idEstacion, $menor, $mayor, $calificacion[4]);
		$tamMuyDanina = count($datosMuyDanina);
		$datosPeligrosa = getDatoAire($variable, $idEstacion, $menor, $mayor, $calificacion[5]);
		$tamPeligrosa = count($datosPeligrosa);
		$valorNulo = 0.00;

		$cB = $cM = $cD = $cDS = $cMD = $cP = 0;
		for ($i=0; $i < $tamFecha; $i++) { 
			if ($fechas[$i]["anio"]==$datosBuena[$cB]["anio"] && 
				$fechas[$i]["mes"]==$datosBuena[$cB]["mes"] && 
				$fechas[$i]["dia"]==$datosBuena[$cB]["dia"] && 
				$fechas[$i]["hora_fin"]==$datosBuena[$cB]["hora_fin"]) {
				$data["id"][] = $datosBuena[$cB]["anio"].' - '.$datosBuena[$cB]['mes'].' - '.
									$datosBuena[$cB]['dia'].'<br>'.$datosBuena[$cB]['hora_fin'];
				$data[$calificacion[0]][] = (float)$datosBuena[$cB]["dato"];
				$data[$calificacion[1]][] = $valorNulo;
				$data[$calificacion[2]][] = $valorNulo;
				$data[$calificacion[3]][] = $valorNulo;
				$data[$calificacion[4]][] = $valorNulo;
				$data[$calificacion[5]][] = $valorNulo;
				$cB++;
			}elseif ($fechas[$i]["anio"]==$datosModerada[$cM]["anio"] && 
				$fechas[$i]["mes"]==$datosModerada[$cM]["mes"] && 
				$fechas[$i]["dia"]==$datosModerada[$cM]["dia"] && 
				$fechas[$i]["hora_fin"]==$datosModerada[$cM]["hora_fin"]) {
				$data["id"][] = $datosModerada[$cM]["anio"].' - '.$datosModerada[$cM]['mes'].' - '.
									$datosModerada[$cM]['dia'].'<br>'.$datosModerada[$cM]['hora_fin'];
				$data[$calificacion[0]][] = $valorNulo;
				$data[$calificacion[1]][] = (float)$datosModerada[$cM]["dato"];
				$data[$calificacion[2]][] = $valorNulo;
				$data[$calificacion[3]][] = $valorNulo;
				$data[$calificacion[4]][] = $valorNulo;
				$data[$calificacion[5]][] = $valorNulo;
				$cM++;
			}elseif ($fechas[$i]["anio"]==$datosDanina[$cD]["anio"] && 
				$fechas[$i]["mes"]==$datosDanina[$cD]["mes"] && 
				$fechas[$i]["dia"]==$datosDanina[$cD]["dia"] && 
				$fechas[$i]["hora_fin"]==$datosDanina[$cD]["hora_fin"]) {
				$data["id"][] = $datosDanina[$cD]["anio"].' - '.$datosDanina[$cD]['mes'].' - '.
									$datosDanina[$cD]['dia'].'<br>'.$datosDanina[$cD]['hora_fin'];
				$data[$calificacion[0]][] = $valorNulo;
				$data[$calificacion[1]][] = $valorNulo;
				$data[$calificacion[2]][] = (float)$datosDanina[$cD]["dato"];
				$data[$calificacion[3]][] = $valorNulo;
				$data[$calificacion[4]][] = $valorNulo;
				$data[$calificacion[5]][] = $valorNulo;
				$cD++;
			}elseif ($fechas[$i]["anio"]==$datosDaninaSalud[$cDS]["anio"] && 
				$fechas[$i]["mes"]==$datosDaninaSalud[$cDS]["mes"] && 
				$fechas[$i]["dia"]==$datosDaninaSalud[$cDS]["dia"] && 
				$fechas[$i]["hora_fin"]==$datosDaninaSalud[$cDS]["hora_fin"]) {
				$data["id"][] = $datosDaninaSalud[$cDS]["anio"].' - '.$datosDaninaSalud[$cDS]['mes'].' - '.$datosDaninaSalud[$cDS]['dia'].'<br>'.$datosDaninaSalud[$cDS]['hora_fin'];
				$data[$calificacion[0]][] = $valorNulo;
				$data[$calificacion[1]][] = $valorNulo;
				$data[$calificacion[2]][] = $valorNulo;
				$data[$calificacion[3]][] = (float)$datosDaninaSalud[$cDS]["dato"];
				$data[$calificacion[4]][] = $valorNulo;
				$data[$calificacion[5]][] = $valorNulo;
				$cDS++;
			}elseif ($fechas[$i]["anio"]==$datosMuyDanina[$cMD]["anio"] && 
				$fechas[$i]["mes"]==$datosMuyDanina[$cMD]["mes"] && 
				$fechas[$i]["dia"]==$datosMuyDanina[$cMD]["dia"] && 
				$fechas[$i]["hora_fin"]==$datosMuyDanina[$cMD]["hora_fin"]) {
				$data["id"][] = $datosMuyDanina[$cMD]["anio"].' - '.$datosMuyDanina[$cMD]['mes'].' - '.$datosMuyDanina[$cMD]['dia'].'<br>'.$datosMuyDanina[$cMD]['hora_fin'];
				$data[$calificacion[0]][] = $valorNulo;
				$data[$calificacion[1]][] = $valorNulo;
				$data[$calificacion[2]][] = $valorNulo;
				$data[$calificacion[3]][] = $valorNulo;
				$data[$calificacion[4]][] = (float)$datosMuyDanina[$cMD]["dato"];
				$data[$calificacion[5]][] = $valorNulo;
				$cMD++;
			}elseif ($fechas[$i]["anio"]==$datosPeligrosa[$cP]["anio"] && 
				$fechas[$i]["mes"]==$datosPeligrosa[$cP]["mes"] && 
				$fechas[$i]["dia"]==$datosPeligrosa[$cP]["dia"] && 
				$fechas[$i]["hora_fin"]==$datosPeligrosa[$cP]["hora_fin"]) {
				$data["id"][] = $datosPeligrosa[$cP]["anio"].' - '.$datosPeligrosa[$cP]['mes'].' - '.$datosPeligrosa[$cP]['dia'].'<br>'.$datosPeligrosa[$cP]['hora_fin'];
				$data[$calificacion[0]][] = $valorNulo;
				$data[$calificacion[1]][] = $valorNulo;
				$data[$calificacion[2]][] = $valorNulo;
				$data[$calificacion[3]][] = $valorNulo;
				$data[$calificacion[4]][] = $valorNulo;
				$data[$calificacion[5]][] = (float)$datosPeligrosa[$cP]["dato"];
				$cP++;
			}
		}
		$intervalo = $tamFecha/3;
		$intervalo = (int)$intervalo-1;
		
	}

	function fechaMenor($anio1, $mes1, $dia1, $anio2, $mes2, $dia2, $anio3, $mes3, $dia3, 
						$anio4, $mes4, $dia4, $anio5, $mes5, $dia5, $anio6, $mes6, $dia6){
		$anioMenor = $anio1;
		$mesMenor = $mes1;
		$diaMenor = $dia1;
	}
?>


<script type="text/javascript" src="js/highcharts.js"></script>
<script type="text/javascript" src="js/exporting.js"></script>
<script type="text/javascript">
	var variable = "<?php echo 'ICA '.$nombreVar; ?>";
	var titulo = "<?php echo $tituloGraf; ?>";
	var mesAnio = "<?php echo $menor ?>";
	var typeGrafica = "column";
	var punteada = "";
	var serie = "<?php echo $serie ?>";
	var intervalo = "<?php echo $intervalo ?>";
</script>
<script type="text/javascript">
	$(function () {
		var chart;
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'regEtacion'
				},
				title: {
					text: titulo
				},
				subtitle: {
					text: serie
				},
				xAxis: {
						// Le pasamos los datos que irán en el eje de las 'X' en JSON
						title: {
							text: "TIEMPO"
						},
						categories: <?php echo json_encode( $data["id"]); ?>,
						minTickInterval: intervalo
					},
				yAxis: {
					title: {
						text: variable
					}
				},
				tooltip: {
					enabled: true,
					formatter: function() {
						return '<b>'+ this.series.name +'</b><br/>'+
						'En la fecha ' + this.x +' se tuvo  una ' + variable + ' ' + this.series.name + ' de: '+ this.y;
					}
				},
				series: [
					{
						type: typeGrafica,
						name: 'Buena',
						data: <?php echo json_encode($data["Buena"]) ?> ,
						/*marker: {
							lineWidth: 1,
							/*lineColor: Highcharts.getOptions().colors[1],
							fillColor: 'white'
						},*/
						color: '#04B404'
					},
					{
						type: typeGrafica,
						name: 'Moderada',
						data: <?php echo json_encode($data['Moderada']) ?> ,
						/*marker: {
							lineWidth: 1,
							lineColor: Highcharts.getOptions().colors[1],
							fillColor: 'white'
						}*/
						color: "#FFFF00"
					},
					{
						type: typeGrafica,
						name: 'Daniña a la salud para grupos sensibles',
						data: <?php echo json_encode($data['Daniña a la salud para grupos sensibles']) ?> ,
						/*marker: {
							lineWidth: 1,
							lineColor: Highcharts.getOptions().colors[1],
							fillColor: 'white'
						}*/
						color: "#FF8000"
					},
					{
						type: typeGrafica,
						name: 'Dañina a la salud',
						data: <?php echo json_encode($data['Dañina a la salud']) ?> ,
						/*marker: {
							lineWidth: 1,
							lineColor: Highcharts.getOptions().colors[1],
							fillColor: 'white'
						}*/
						color: "#FF0000"
					},
					{
						type: typeGrafica,
						name: 'Muy dañina a la salud',
						data: <?php echo json_encode($data['Muy dañina a la salud']) ?> ,
						/*marker: {
							lineWidth: 1,
							lineColor: Highcharts.getOptions().colors[1],
							fillColor: 'white'
						}*/
						color: "#4C0B5F"
					},
					{
						type: typeGrafica,
						name: 'Peligrosa',
						data: <?php echo json_encode($data['Peligrosa']) ?> ,
						/*marker: {
							lineWidth: 1,
							lineColor: Highcharts.getOptions().colors[1],
							fillColor: 'white'
						}*/
						color: "#610B0B"
					}
				]
			});
		});
	});
</script>

<div id="regEtacion" style="width:1300px; height:500px; margin: 20px;"></div>

<?php
include('base/fin.php');
?>