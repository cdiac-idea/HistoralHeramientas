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
		}else {
			$datosEst = getTiempoDatoDia($idVariable, $idEst, $ani, $ani2);
		}

		if ( $datosEst) {
			foreach ( $datosEst as $value) {
				if ($value["dia"]!=null) {
					$fechaId = $value["dia"];
				}
				if ($value["mes"]!=null) {
					$fechaId .= "-".$value["mes"];
				}
				if ($value["año"]!=null) {
					$fechaId .= "-".$value["año"];
				}
				if ($value["tiempo"]!=null) {
					$fechaId .= "-".$value["tiempo"];
				}
				$data["id"][] = $fechaId;
				$data["nombre"][] = (float)$value["dato"];
			}
		}
		$tam = count($data["nombre"]);
		
		$periodoTiempo;
		if ($ani!=null && $mes==null && $dia==null) {
			$periodoTiempo = ' el mes número ';
		}elseif ($mes!=null && $dia==null) {
			$periodoTiempo = ' el mes número '.$mes.' y día ';
		}
	}
?>

<script type="text/javascript" src="js/highstock.js"></script>
<script type="text/javascript" src="js/stock-jquery.min.js"></script>
<script type="text/javascript" src="js/stock-highcharts-more.js"></script>
<script type="text/javascript" src="js/exporting.js"></script>
<script type="text/javascript">
	var variable = "<?php echo $nombreVar; ?>";
	var titulo = "<?php echo $tituloGraf; ?>";
	var mesAnio = "<?php echo ' - '.$dia.' - '.$mes.' - '.$ani ?>";
	var typeGrafica;
	var punteada = "";
	var serie = "<?php echo $serie ?>";
	typeGrafica= '';
	var intervalo = "<?php echo $tam/4; ?>";
	var unidad = "<?php echo $unidadMedida ?>";
	var serieTiempo = "<?php echo $periodoTiempo ?>";

</script>
<script type="text/javascript">
	$(function () {
		var chart;
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'regEtacion'
				},
				rangeSelector : {
	                selected : 1
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
						'A las ' + serieTiempo + this.x +' se tuvo  una ' + variable +
						 ' ' + ' de: '+ this.y + ' ' + unidad;
					}
				},
				series: [
					{
						name: 'Dato original',
						data: <?php echo json_encode($data["nombre"]) ?> ,
						type: typeGrafica,
						color: '#B40404',
					}
				]
			});
		});
	});
</script>

<!--script type="text/javascript">
    $(function () {
        $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function (data) {

            // Create the chart
            $('#container').highcharts('StockChart', {


                rangeSelector : {
                    selected : 1
                },

                title : {
                    text : 'AAPL Stock Price'
                },

                series : [{
                    name : 'AAPL Stock Price',
                    data : data,
                    type : 'area',
                    threshold : null,
                    tooltip : {
                        valueDecimals : 2
                    },
                    fillColor : {
                        linearGradient : {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops : [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    }
                }]
            });
        });
    });
</script-->


<div id="regEtacion" style="width:1200px; height:500px; margin: 20px;"></div>


<?php
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
include('base/fin.php');
?>