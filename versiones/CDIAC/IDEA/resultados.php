<?php
    include('head.php');
?>
		<div class="divider"><hr/></div>
		<center>
		<!--img src="images/Sunny.png" width=12%>
		<img src="images/Drizzle.png" width=12%>
		<img src="images/Slight Drizzle.png" width=12%>
		<img src="images/Snow.png" width=12%>
		<img src="images/Mostly Cloudy.png" width=12%>
		<img src="images/Thunderstorms.png" width=12%-->
		<br></center>
	<br><br><br>
		<table>
			<tr>
				<td width=30%><h3><center><font color='green'>Generador de indicadores climatológicos</font><center></h3></td>
				<td width=5%></td>
				<td width=30%><a href="../bd/index.php" target="_blank"><h3><center><font color='green'>Sistema de consultas<br><br></font><center></h3></a></td>
				<td width=5%></td>
				<td width=30%><a href="../cube/index.php/" target="_blank"><h3><center><font color='green'>Sistema de filtrado y cargue de datos</font><center></h3></a></td>
			</tr>
			<tr>
				<td><center><b>Acceso público</b></center></td>
				<td></td>
				<td><center><b>Acceso con autorización</b></center></td>
				<td></td>
				<td><center><b>Acceso con autorización</b></center></td>
			</tr>
			<tr>
				<td><p align='justify'><br>
					<a href="indicadores.php" target="_blank">Indicadores Meteorológicos e Hidrometeorológicos</a><br>
					<a href="indicadores.php" target="_blank">Indicadores de Calidad del Aire</a><br>
				</p></td>
				<td></td>
				<td><p align='justify'>Este sistema de acceso para personal autorizado, es utilizado para obtener los datos brutos medidos por las estaciones ambientales. </p></td>
				<td></td>
				<td><p align='justify'>Este es un sistema que administra los parámetros de filtración y cargue de los datos originales a la bodega de datos que centraliza la información. </p></td>
			</tr>
		</table>
<?php
    include('pie.php');
?>