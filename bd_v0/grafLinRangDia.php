<?php   
	include('base/inicioGraf.php');
	if ($_GET) {
		$idVariable = array_key_exists('variable', $_GET) ? $_GET['variable'] : null;
		$ani = array_key_exists('anio', $_GET) ? $_GET['anio'] : null;
		$ani2 = array_key_exists('anio2', $_GET) ? $_GET['anio2'] : null;
		$idEst = array_key_exists('est', $_GET) ? $_GET['est'] : null;
		$nameEst = array_key_exists('nes', $_GET) ? $_GET['nes'] : null;
		$idVariable = array_key_exists('variable', $_GET) ? $_GET['variable'] : null;

		if ($idVariable==1 || $idVariable==2) {$nombreVar='Temperatura '; $unidadMedida='(°C)';}
		elseif ($idVariable==3 || $idVariable==4 || $idVariable==10) {$nombreVar='Precipitación '; $unidadMedida='(mm)';}
		elseif ($idVariable==5) {$nombreVar='Velocidad del Viento '; $unidadMedida='(m/s)';}
		elseif ($idVariable==6) {$nombreVar='Humedad Relativa '; $unidadMedida='(%)';}
		elseif ($idVariable==7) {$nombreVar='Radiación Solar '; $unidadMedida='(w/m2)';}
		elseif ($idVariable==8 || $idVariable==9 || $idVariable==11) {$nombreVar='Presión Barométrica '; $unidadMedida='(mmHg)';}

		$tituloGraf = $nombreVar.' '.$ani.' - '.$ani2.' '.$nameEst;
		$serie = $nombreVar." VS Tiempo";

		$data = array();
		

		$datosEst = getTiempoDatoDia($idVariable, $idEst, $ani, $ani2);


		if ( $datosEst) {
			foreach ( $datosEst as $value) {
				$data["id"][] = $value["dia"]."/".$value["mes"]."/".$value["año"];
				$data["nombre"][] = (float)$value["dato"];
			}
		}

		$tam = count($data["nombre"]);
		$tam=$tam/($tam/18);
	}

	$periodoTiempo = ' el mes número ';

?>


<script type="text/javascript" src="js/highcharts.js"></script>
<script type="text/javascript" src="js/exporting.js"></script>
<script type="text/javascript">
	var variable = "<?php echo $nombreVar; ?>";
	var titulo = "<?php echo $tituloGraf; ?>";
	var typeGrafica= 'spline';
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
						'En' + serieTiempo + this.x +' se tuvo  una ' + variable +
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
						name: 'Dato original',
						dashStyle: punteada,
						data: <?php echo json_encode($data["nombre"]) ?> ,
						color: '#D7DF01',
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