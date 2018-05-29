<?php	
//inicio de html y parte del menu ademas de funciones con las consultas sql
include('base/inicio.php');


$cantidad =  countRegistros($visible);
$total_registros = $cantidad[0]['dato'];
$cantidadAire =  countRegistrosAire($visible);
$total_registros_aire = $cantidadAire[0]['dato'];
$data = array();
$datosEst = getEstacionOrderId($visible);
#echo var_dump($datosEst);
$contador=1;
if ( $datosEst) {
	foreach ( $datosEst as $value) {
		$data["id"][] = $contador;
		$contador++;
		$data["nombre"][] = $value["nombre"];
		$data["cantReg"][] = (integer)$value["cant"];
	}
}
$tam = count($data["id"]);
#echo var_dump($data);
?>

<script type="text/javascript" src="js/highcharts.js"></script>
<script type="text/javascript" src="js/exporting.js"></script>
<script type="text/javascript">
	var arraystation = <?php echo json_encode($data["nombre"]); ?>;

	function get_station(id){
		return arraystation[id];
	}
</script>
<script type="text/javascript">
	$(function () {
		var chart;
		var n
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'regEtacion'
				},
				title: {
					text: 'Resumen de registros de Clima por estaciones',
				},
				subtitle: {
					text: 'Número de registros VS Estaciones',
				},
				xAxis: {
					categories: <?php echo json_encode( $data["id"]) ?>
				},
				yAxis: {
					title: {
						text: 'Número Registros (Millones)',
					}
				},
				tooltip: {
					enabled: true,
					formatter: function() {
						var station = get_station(this.x-1);
						return '<b>'+ this.series.name +'</b><br/>'+
							'La estación ' + station + ' tiene '+ this.y +' registros';
					}
				},
				series: [{
					type: 'spline',
					name: 'Registros VS Estación',
					data: <?php echo json_encode($data["cantReg"]) ?> ,
					marker: {
						lineWidth: 1,
						lineColor: Highcharts.getOptions().colors[1],
						fillColor: 'white'
					}
				}]
			});
		});
	});
</script>
<h4 class="alert_info">Datos Generales</h4>

<div id="menuTotDatos" class="totDatos">
	<h4>Total de datos Climatológicos:</h4>
	<h1><?php echo number_format($total_registros) ?></h1>
</div>
<div id="menuTotDatos" class="totDatos">
	<h4>Total de datos Calidad del aire:</h4>
	<h1><?php echo number_format($total_registros_aire) ?></h1>
</div>
<div id="menuTotDatos" class="totDatos">
	<h4>Total datos:</h4>
	<h1><?php echo number_format($total_registros+$total_registros_aire) ?></h1>
</div>

<div id="regEtacion" style="width:1000px; height:300px; margin: 20px;"></div>

<div id="listEst">
	<center>
		<table border="2">
			<tr align="center" >
				<th colspan="15">LISTA DE ESTACIONES</th>
			</tr>
			<tr>
				<th>Número</th>
				<th>Nombre Estación</th>
				<th>Propietario</th>
				<th>Tipología</th>
				<th>Red</th>
				<th>Municipio</th>
				<th>Ubicación</th>
				<th>Latitud</th>
				<th>Longitud</th>
				<th>Altitud</th>
				<th>Cuenca</th>
				<th>Subcuenca</th>
				<th>Fecha inicio de funcionamiento</th>
				<th>Fecha fin de funcionamiento</th>
				<th>Observaciones</th>
			</tr>
			<?php
			#SELECT station_dim.estacion_sk as id, station_dim.estacion as nombre, COUNT(fact_table.estacion_sk) as cant,
				#red, tipologia, municipio, ubicacion, latitud, longitud, altitud, propietario, inicio_funcionamiento, 
				#fin_funcionamiento, observacion, cuenca, subcuenca
			$contador=1;
			if ($datosEst) {
				foreach ( $datosEst as $value) {
					echo "<tr>";
						echo "<td>".$contador."</td>";
						$contador++;
						echo "<td>".$value["nombre"]."</td>";
						echo "<td>".$value["propietario"]."</td>";
						echo "<td>".$value["tipologia"]."</td>";
						echo "<td>".$value["red"]."</td>";
						echo "<td>".$value["municipio"]."</td>";
						echo "<td>".$value["ubicacion"]."</td>";
						echo "<td>".$value["latitud"]."</td>";
						echo "<td>".$value["longitud"]."</td>";
						echo "<td>".$value["altitud"]."</td>";
						echo "<td>".$value["cuenca"]."</td>";
						echo "<td>".$value["subcuenca"]."</td>";
						echo "<td>".$value["inicio_funcionamiento"]."</td>";
						echo "<td>".$value["fin_funcionamiento"]."</td>";
						echo "<td>".$value["observacion"]."</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
	</center>
</div>

<?php
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
	include('base/fin.php');
?>