<?php   
	include('base/inicioGraf.php');
	if ($_GET) {
		$idVariable = array_key_exists('variable', $_GET) ? $_GET['variable'] : null;
		$idEst = array_key_exists('est', $_GET) ? $_GET['est'] : null;
		$ani = array_key_exists('anio', $_GET) ? $_GET['anio'] : null;
		$ani2 = array_key_exists('anio2', $_GET) ? $_GET['anio2'] : null;
		$mes = array_key_exists('mes', $_GET) ? $_GET['mes'] : null;
		$dia = array_key_exists('dia', $_GET) ? $_GET['dia'] : null;
		$nameEst = array_key_exists('nes', $_GET) ? $_GET['nes'] : null;
		if ($idVariable==1) { $nombreVar='Temperatura';
		}elseif ($idVariable==2) { $nombreVar='Rango Temperatura';
		}elseif ($idVariable==3) { $nombreVar='Precipitación';
		}elseif ($idVariable==4) { $nombreVar='A25';
		}elseif ($idVariable==5) { $nombreVar='Dirección y Velocidad del Viento';
		}elseif ($idVariable==6) { $nombreVar='Humedad Relativa';
		}elseif ($idVariable==7) { $nombreVar='Radiación Solar';
		}elseif ($idVariable==8) { $nombreVar='Presión Barométrica';
		}elseif ($idVariable==9) { $nombreVar='Confort Térmico';
		}elseif ($idVariable==10) { $nombreVar='Índice Estandarizado de precipitación';
		}elseif ($idVariable==11) { $nombreVar='Índice de Aridez';
		}
		$tituloGraf = $nombreVar.' '.$ani;
		$serie = $nombreVar." VS ";
		$data = array();
		if ($dia==null && $mes!=null) {
			$tituloGraf .= '-'.$mes;
			$serie .= "Dias";
			$dia=0;
		}elseif ($dia==null && $mes==null) {
			$serie .= "Meses";
			$mes=0;
			$dia=0;
		}else{
			$serie .= "Tiempo";
			$tituloGraf .= '-'.$mes.'-'.$dia;
		}
		$tituloGraf .= ' '.$nameEst;
		$datosEst = getTiempoDatoAnio($idVariable, $idEst, $ani, null, $mes, $dia);
		if ( $datosEst) {
			foreach ( $datosEst as $value) {
				$data["id"][] = $value["dia"];
				$data["nombre"][] = (float)$value["dato"];
			}
		}
	}
	$fecha='';
	if($mes>0){
		$fecha .= ' - '.$mes;
	}
	$fecha .= ' - '.$ani;
?>


<script type="text/javascript" src="js/highcharts.js"></script>
<script type="text/javascript" src="js/exporting.js"></script>
<script type="text/javascript">
	var variable = "<?php echo $nombreVar; ?>";
	var titulo = "<?php echo $tituloGraf; ?>";
	var mesAnio = "<?php echo $fecha ?>";
	var typeGrafica;
	var punteada = "";
	var serie = "<?php echo $serie ?>";
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
						categories: <?php echo json_encode( $data["id"]) ?>
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
						'En la fecha ' + this.x + mesAnio +' se tuvo  una ' + variable + ' ' + this.series.name + ' de: '+ this.y;
					}
				},
				series: [
					{
						type: 'spline',
						name: 'Promedio',
						data: <?php echo json_encode($data["nombre"]) ?> ,
						marker: {
							lineWidth: 1,
							lineColor: Highcharts.getOptions().colors[1],
							fillColor: 'white'
						}
					}
				]
			});
		});
	});
</script>
<div id="regEtacion" style="width:1200px; height:500px; margin: 20px;"></div>
<?php
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
include('base/fin.php');
?>