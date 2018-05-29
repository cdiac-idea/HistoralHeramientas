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
		if ($idVariable==1) {$nombreVar='Temperatura '; $unidadMedida='(°C)';
		}elseif ($idVariable==2) {$nombreVar='Rango Temperatura '; $unidadMedida='(°C)';
		}elseif ($idVariable==3) {$nombreVar='Precipitación '; $unidadMedida='(mm)';
		}elseif ($idVariable==4) {$nombreVar='A25 '; $unidadMedida='(mm)';
		}elseif ($idVariable==5) {$nombreVar='Dirección y Velocidad del Viento '; $unidadMedida='(m/s)';
		}elseif ($idVariable==6) {$nombreVar='Humedad Relativa '; $unidadMedida='(%)';
		}elseif ($idVariable==7) {$nombreVar='Radiación Solar '; $unidadMedida='(w/m2)';
		}elseif ($idVariable==8) {$nombreVar='Presión Barométrica '; $unidadMedida='(mmHg)';
		}elseif ($idVariable==9) {$nombreVar='Confort Térmico'; $unidadMedida='';
		}elseif ($idVariable==10) {$nombreVar='Índice Estandarizado de precipitación'; $unidadMedida='';
		}elseif ($idVariable==11) {$nombreVar='Índice de Aridez'; $unidadMedida='';
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
		$tam = count($data["nombre"]);
	}
	$fecha='';
	if($mes>0){
		$fecha .= ' - '.$mes;
	}
	$fecha .= ' - '.$ani;
	
	$periodoTiempo;
	if ($ani!=null && $mes==null && $dia==null) {
		$periodoTiempo = ' el mes número ';
	}elseif ($mes!=null && $dia==null) {
		$periodoTiempo = ' el mes número '.$mes.' y día ';
	}
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
	var intervalo = "<?php echo $tam/4; ?>";
	var unidad = "<?php echo $unidadMedida ?>";
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
						categories: <?php echo json_encode( $data["id"]) ?>,
						minTickInterval: intervalo
					},
				yAxis: {
					title: {
						text: variable + ' ' + unidad
					}
				},
				tooltip: {
					enabled: true,
					formatter: function() {
						return '<b>'+ this.series.name +'</b><br/>'+
						'En' + serieTiempo + this.x +' se tuvo  una ' + variable +
						 ' ' + ' de: '+ this.y + ' ' + unidad;
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