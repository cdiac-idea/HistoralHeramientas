<?php   
	include('base/inicioGraf.php');
	if ($_GET) {
		$idVariable = array_key_exists('variable', $_GET) ? $_GET['variable'] : null;
		$ani = array_key_exists('anio', $_GET) ? $_GET['anio'] : null;
		$ani2 = array_key_exists('anio2', $_GET) ? $_GET['anio2'] : null;
		$idEst = array_key_exists('est', $_GET) ? $_GET['est'] : null;
		$nameEst = array_key_exists('nes', $_GET) ? $_GET['nes'] : null;

		#echo $origen;
		$tipoGraf = 'spline';
		$un = 'una';
		if ($idVariable==1) {$nombreVar='Temperatura '; $unidadMedida='(°C)'; 
		}elseif ($idVariable==2) {$nombreVar='Rango Temperatura '; $unidadMedida='(°C)'; $un = 'un';
		}elseif ($idVariable==3) {$nombreVar='Precipitación '; $unidadMedida='(mm)'; $tipoGraf = 'column';
		}elseif ($idVariable==4) {$nombreVar='A25 '; $unidadMedida='(mm)'; $un = 'un';
		}elseif ($idVariable==5) {$nombreVar='Dirección y Velocidad del Viento '; $unidadMedida='(m/s)';
		}elseif ($idVariable==6) {$nombreVar='Humedad Relativa '; $unidadMedida='(%)';
		}elseif ($idVariable==7) {$nombreVar='Radiación Solar '; $unidadMedida='(w/m2)';
		}elseif ($idVariable==8) {$nombreVar='Presión Barométrica '; $unidadMedida='(mmHg)';
		}elseif ($idVariable==9) {$nombreVar='Confort Térmico'; $unidadMedida=''; $un = 'un';
		}elseif ($idVariable==10) {$nombreVar='Índice Estandarizado de precipitación'; $unidadMedida=''; $un = 'un';
		}elseif ($idVariable==11) {$nombreVar='Índice de Aridez'; $unidadMedida=''; $un = 'un';
		}

		$tituloGraf = $nombreVar.' '.$ani.' - '.$ani2.' '.$nameEst;
		$serie = $nombreVar." VS Tiempo";

		$data = array();
		

		$datosEst = getTiempoDatoRangoMes($idVariable, $idEst, $ani, $ani2);

		if ( $datosEst) {
			foreach ( $datosEst as $value) {
				$data["id"][] = $value["dia"]."/".$value["mes"]."/".$value["año"];
				$data["nombre"][] = (float)$value["dato"];
				$data["maximo"][] = (float)$value["maximo"];
				$data["minimo"][] = (float)$value["minimo"];
			}
		}

		$tam = count($data["nombre"]);
		$tam=$tam/($tam/18);
	}

	$periodoTiempo = ' la fecha ';

?>


<script type="text/javascript" src="../bd/js/highcharts.js"></script>
<script type="text/javascript" src="../bd/js/exporting.js"></script>
<script type="text/javascript">
	var variable = "<?php echo $nombreVar; ?>";
	var titulo = "<?php echo $tituloGraf; ?>";
	var typeGrafica = "<?php echo $tipoGraf; ?>";
	var union = "<?php echo $un; ?>";
	var punteada = "";
	var serie = "<?php echo $serie ?>";
	var	punteada = 'longdash';
	var unidad = "<?php echo $unidadMedida ?>";
	var intervalo = "<?php echo $tam; ?>";
	var serieTiempo = "<?php echo $periodoTiempo ?>";
	var unidad = "<?php echo $unidadMedida ?>";
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
                xAxis: {
                    // Le pasamos los datos que irán en el eje de las 'X' en JSON
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
                navigator: {
                    enabled: true
                },
                scrollBar:
                {
                    enabled: true
                },
                series: [
					{
						type: typeGrafica,
						dashStyle: punteada,
						name: 'Máximo',
						data: <?php echo json_encode($data["maximo"]) ?> ,
						color: '#B40404',
					},
					{
						type: typeGrafica,
						name: 'Promedio',
						dashStyle: punteada,
						data: <?php echo json_encode($data["nombre"]) ?> ,
						color: '#D7DF01',
					},
					{
						type: typeGrafica,
						dashStyle: punteada,
						name: 'Mínimo',
						data: <?php echo json_encode($data["minimo"]) ?> ,
						color: '#0404B4',
					}
				]
            });
        });
 </script>	

<div id="regEtacion" style="width:1200px; height:500px; margin: 20px;"></div>


<?php
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
include('../bd/base/fin.php');
?>