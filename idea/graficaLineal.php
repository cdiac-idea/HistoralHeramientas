<?php   
	include('base/inicioGraf.php');
	if ($_GET) {
		#echo var_dump($_GET);
		$idVariable = array_key_exists('variable', $_GET) ? $_GET['variable'] : null;
		$idEst = array_key_exists('est', $_GET) ? $_GET['est'] : null;
		$ani = array_key_exists('anio', $_GET) ? $_GET['anio'] : null;
		$ani2 = array_key_exists('anio2', $_GET) ? $_GET['anio2'] : null;
		$origen = array_key_exists('origen', $_GET) ? $_GET['origen'] : null;
		$mes = array_key_exists('mes', $_GET) ? $_GET['mes'] : null;
		$dia = array_key_exists('dia', $_GET) ? $_GET['dia'] : null;
		$nameEst = array_key_exists('nes', $_GET) ? $_GET['nes'] : null;
		$tipoGraf = 'spline';
		$un = 'una';
		if ($idVariable==1) {$nombreVar='Temperatura '; $unidadMedida='(°C)'; $color = '#B40404'; 
		}elseif ($idVariable==2) {$nombreVar='Rango Temperatura '; $unidadMedida='(°C)'; $un = 'un'; $color = '#B40404';
		}elseif ($idVariable==3) {$nombreVar='Precipitación '; $unidadMedida='(mm)'; $tipoGraf = 'column'; $color = '#0000FF';
		}elseif ($idVariable==4) {$nombreVar='A25 '; $unidadMedida='(mm)'; $un = 'un'; $color = '#0000FF';
		}elseif ($idVariable==5) {$nombreVar='Dirección y Velocidad del Viento '; $unidadMedida='(m/s)'; $color = '#380B61';
		}elseif ($idVariable==6) {$nombreVar='Humedad Relativa '; $unidadMedida='(%)'; $color = '#088A08';
		}elseif ($idVariable==7) {$nombreVar='Radiación Solar '; $unidadMedida='(w/m2)'; $color = '#B40404';
		}elseif ($idVariable==8) {$nombreVar='Presión Barométrica '; $unidadMedida='(mmHg)'; $color = '#8904B1';
		}elseif ($idVariable==9) {$nombreVar='Confort Térmico'; $unidadMedida=''; $un = 'un'; $color = '#B40404';
		}elseif ($idVariable==10) {$nombreVar='Índice Estandarizado de precipitación'; $unidadMedida=''; $un = 'un'; $color = '#0000FF';
		}elseif ($idVariable==11) {$nombreVar='Índice de Aridez'; $unidadMedida=''; $un = 'un'; $color = '#0000FF';
		}
		$tituloGraf = $nombreVar.' ';
		if ($ani2!=null) {
			$tituloGraf .= $ani.' - '.$ani2;
		}else{
			$tituloGraf .= $ani;
		}
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
		if($origen=="mes"){
			$datosEst = getTiempoDatoMes($idVariable, $idEst, $ani, $ani2, $mes, $dia);
		}elseif ($origen=="anio") {
			$datosEst = getTiempoDatoAnual($idVariable, $idEst, $ani, $ani2, 0, $dia);
		}else{
			$datosEst = getTiempoDato($idVariable, $idEst, $ani, $ani2, $mes, $dia);
		}
		if ( $datosEst) {
			foreach ( $datosEst as $value) {
				if ($origen=="anio") {
					$data["id"][] = $value["año"];
				}else{
					if ($value["dia"]!=null) {
						$fechaId = $value["dia"];
					}
					if ($value["mes"]!=null) {
						$fechaId = $value["mes"];
					}
					if ($value["año"]!=null) {
						$fechaId .= "-".$value["año"];
					}
					$data["id"][] = $fechaId;
				}
				$data["nombre"][] = (float)$value["dato"];
			}
		}

		$tam = count($data["nombre"]);
		if ($ani!=null && $ani2!=null) {
			$tam=$tam/4;
		}else{
			$tam=1;
		}
	}
	$fecha='';
	if($mes>0){
		$fecha .= ' - '.$mes;
	}
	$fecha .= ' - '.$ani;

	$periodoTiempo;
	if ($ani!=null && $mes==null && $dia==null) {
		$periodoTiempo = ' el mes  ';
	}elseif ($mes!=null && $dia==null) {
		$periodoTiempo = ' el mes  '.$mes.' y día ';
	}
	if ($origen=="anio") {
		$periodoTiempo = ' el año ';

	}
?>
<script type="text/javascript" src="../bd/js/highcharts.js"></script>
<script type="text/javascript" src="../bd/js/exporting.js"></script>
<script type="text/javascript">
	var variable = "<?php echo $nombreVar; ?>";
	var titulo = "<?php echo $tituloGraf; ?>";
	var mesAnio = "<?php echo $fecha; ?>";
	var typeGrafica = "<?php echo $tipoGraf; ?>";
	var serie = "<?php echo $serie; ?>";
	var intervalo = "<?php echo $tam; ?>";
	var unidad = "<?php echo $unidadMedida; ?>";
	var serieTiempo = "<?php echo $periodoTiempo; ?>";
	var union = "<?php echo $un; ?>";
	var colGraf = "<?php echo $color ?>";
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
					text: titulo,
					style: {
						fontSize: "28px"
					}
				},
				subtitle: {
					text: serie,
					style: {
						fontSize: "18px"
					}
				},
				xAxis: {
						// Le pasamos los datos que irán en el eje de las 'X' en JSON
						labels: {
							style: {
								fontSize: "18px"
							}
						},
						title: {
							text: "TIEMPO",
							style: {
								fontSize: "18px"
							}
						},
						categories: <?php echo json_encode( $data["id"]) ?>,
						minTickInterval: intervalo
					},
				yAxis: {
					labels: {
						style: {
							fontSize: "18px"
						}
					},
					title: {
						text: variable + ' ' + unidad,
						style: {
							fontSize: "18px"
						}
					}
				},
				tooltip: {
					enabled: true,
					formatter: function() {
						return '<b>'+ this.series.name +'</b><br/>'+
						'En' + serieTiempo + this.x +' se tuvo ' + union + ' ' + variable +
						 ' ' + ' de: '+ this.y + ' ' + unidad;
					}
				},
				series: [
					{
						type: typeGrafica,
						name: variable,
						data: <?php echo json_encode($data["nombre"]) ?>,
						color: colGraf,
					}
				]
			});
		});
	});
</script>

<div id="regEtacion" style="width:1200px; height:500px; margin: 20px;"></div>


<?php
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
include('../bd/base/fin.php');
?>