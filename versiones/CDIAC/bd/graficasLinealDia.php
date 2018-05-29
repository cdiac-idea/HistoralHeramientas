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

		if ($idVariable==1) {
			$nombreVar='Temperatura';
		}elseif ($idVariable==2) {
			$nombreVar='Rango Temperatura';
		}elseif ($idVariable==3) {
			$nombreVar='Precipitación';
		}elseif ($idVariable==4) {
			$nombreVar='A25';
		}elseif ($idVariable==5) {
			$nombreVar='Dirección y Velocidad del Viento';
		}elseif ($idVariable==6) {
			$nombreVar='Humedad Relativa';
		}elseif ($idVariable==7) {
			$nombreVar='Radiación Solar';
		}elseif ($idVariable==8) {
			$nombreVar='Presión Barométrica';
		}elseif ($idVariable==9) {
			$nombreVar='Confort Térmico';
		}elseif ($idVariable==10) {
			$nombreVar='Índice Estandarizado de precipitación';
		}elseif ($idVariable==11) {
			$nombreVar='Índice de Aridez';
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
		//echo var_dump($datosEst);
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
	typeGrafica= 'scatter';
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
						categories: <?php echo json_encode( $data["id"]) ?>,
						minTickInterval: 60
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
						'En la fecha ' + this.x + /*mesAnio +*/' se tuvo  una ' + variable +
						 ' ' + this.series.name + ' de: '+ this.y;
					}
				},
				series: [
					{
						name: 'Promedio',
						data: <?php echo json_encode($data["nombre"]) ?> ,
						type: typeGrafica,
                		threshold : null,
						marker: {
							//lineWidth: 1,
							//lineColor: Highcharts.getOptions().colors[1],
							fillColor: Highcharts.getOptions().colors[1]//'white'
						}
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