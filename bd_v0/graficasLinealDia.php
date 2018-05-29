<?php   
	include('base/inicioGraf.php');
	#echo var_dump($_GET);
	#echo "<br>";
	if ($_GET) {
		$idVariable = array_key_exists('variable', $_GET) ? $_GET['variable'] : null;
		$idEst = array_key_exists('est', $_GET) ? $_GET['est'] : null;
		$ani = array_key_exists('anio', $_GET) ? $_GET['anio'] : null;
		$ani2 = array_key_exists('anio2', $_GET) ? $_GET['anio2'] : null;
		$mes = array_key_exists('mes', $_GET) ? $_GET['mes'] : null;
		$dia = array_key_exists('dia', $_GET) ? $_GET['dia'] : null;
		$nameEst = array_key_exists('nes', $_GET) ? $_GET['nes'] : null;

		$un = 'una';
		if ($idVariable==1) {$nombreVar='Temperatura '; $unidadMedida='(°C)'; $tipoGraf='scatter'; $color = '#B40404';
		}elseif ($idVariable==2) {$nombreVar='Rango Temperatura '; $unidadMedida='(°C)'; $tipoGraf=''; $un = 'un'; $color = '#B40404';
		}elseif ($idVariable==3) {$nombreVar='Precipitación '; $unidadMedida='(mm)'; $tipoGraf='column'; $color = '#0000FF';
		}elseif ($idVariable==4) {$nombreVar='A25 '; $unidadMedida='(mm)'; $tipoGraf=''; $un = 'un'; $color = '#0000FF';
		}elseif ($idVariable==5) {$nombreVar='Dirección y Velocidad del Viento '; $unidadMedida='(m/s)'; $tipoGraf=''; $color = '#380B61';
		}elseif ($idVariable==6) {$nombreVar='Humedad Relativa '; $unidadMedida='(%)'; $tipoGraf=''; $color = '#088A08';
		}elseif ($idVariable==7) {$nombreVar='Radiación Solar '; $unidadMedida='(w/m2)'; $tipoGraf=''; $color = '#B40404';
		}elseif ($idVariable==8) {$nombreVar='Presión Barométrica '; $unidadMedida='(mmHg)'; $tipoGraf=''; $color = '#8904B1';
		}elseif ($idVariable==9) {$nombreVar='Confort Térmico'; $unidadMedida=''; $tipoGraf=''; $un = 'un'; $color = '#B40404';
		}elseif ($idVariable==10) {$nombreVar='Índice Estandarizado de precipitación'; $unidadMedida=''; $tipoGraf=''; $un = 'un'; $color = '#0000FF';
		}elseif ($idVariable==11) {$nombreVar='Índice de Aridez'; $unidadMedida=''; $tipoGraf=''; $un = 'un'; $color = '#0000FF';
		}

		#$tituloGraf = $nombreVar.' '.$ani;
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

		if ($ani2==null) {
			$datosEst = getTiempoDato($idVariable, $idEst, $ani, $ani2, $mes, $dia);
			//echo "string";
		}else {
			$datosEst = getTiempoDatoDia($idVariable, $idEst, $ani, $ani2);
		}

		if ( $datosEst) {
			foreach ( $datosEst as $value) {
				if ($value["dia"]!=null) {
					$fechaId = $value["dia"];
				}
				if ($value["mes"]!=null) {
					$fechaId .= "/".$value["mes"];
				}
				if ($value["año"]!=null) {
					$fechaId .= "/".$value["año"];
				}
				if ($value["tiempo"]!=null) {
					$fechaId .= "-".$value["tiempo"];
				}
				$data["id"][] = $fechaId;
				$data["nombre"][] = (float)$value["dato"];
			}
		}
		$tam = count($data["nombre"]);
		$tam = $tam/($tam/6);
		$periodoTiempo;
		if ($ani!=null && $mes==null && $dia==null) {
			$periodoTiempo = ' el mes número ';
		}elseif ($mes!=null && $dia==null) {
			$periodoTiempo = ' el mes número '.$mes.' y día ';
		}
	}
?>

<script type="text/javascript" src="js/highcharts.js"></script>
<script type="text/javascript" src="js/exporting.js"></script>

<script type="text/javascript">
	var variable = "<?php echo $nombreVar; ?>";
	var titulo = "<?php echo $tituloGraf; ?>";
	var mesAnio = "<?php echo ' - '.$dia.' - '.$mes.' - '.$ani ?>";
	var punteada = "";
	var serie = "<?php echo $serie ?>";
	var typeGrafica = "<?php echo $tipoGraf; ?>";
	var intervalo = "<?php echo $tam; ?>";
	var unidad = "<?php echo $unidadMedida ?>";
	var serieTiempo = "<?php echo $periodoTiempo ?>";
	var union = "<?php echo $un; ?>";
	var colGraf = "<?php echo $color ?>";
</script>
<script type="text/javascript">
	$(function () {
        $('#regEtacion').highcharts({
			chart: {
                type: 'spline',
                resetZoom: 'Reset zoom',
                resetZoomTitle: 'Reset zoom à 1:1',
                zoomType: 'x',
                alignTicks: false
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
			xAxis: {// Le pasamos los datos que irán en el eje de las 'X' en JSON
					title: {
						text: "TIEMPO",
						style: {
							fontSize: "18px"
						}
					},
					labels : { 
						y : 20, 
						style: {
							fontSize: "18px"
						},
						rotation: -90 
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
					text: variable + ' ' + unidad
				}
			},
			tooltip: {
				enabled: true,
				formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					'A las ' + serieTiempo + this.x +' se tuvo ' + union + ' ' +  variable +
					 ' ' + ' de: '+ this.y + ' ' + unidad;
				}
			},
            navigator: {
                enabled: true
            },
            scrollBar: {
                enabled: true
            },
			series: [
				{
					name: 'Dato original',
					data: <?php echo json_encode($data["nombre"]) ?> ,
					type: typeGrafica,
					color: colGraf,
				}
			]
		});
	});
</script>


<div id="regEtacion" style="width:1200px; height:500px; margin: 20px;"></div>


<?php
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
include('base/fin.php');
?>