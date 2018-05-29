<?php
    include('head.php');
    include('../configuracion/sql.php');
?>

<link type="text/css" href="css/tabla.css">

<table border='2'>
	<tr>
		<td><font size="5"><center><b>Entidad</b></center><br><hr><br></font></td>
		<td><font size="5"><center><b>Estaciones que aporta</b></center><br><hr><br></font></td>
	</tr>
	<hr>
	<tr>
		<td>
			<center>
			<font size="4">
					Corporación Autónoma Regional de Caldas - Corpocaldas
			</font><br>
			<a href="http://www.corpocaldas.gov.co/" target="_blank"><img src="images/logo_Corpocaldass.png" width=25%></a>
				</center>
		</td>
		<td>
			<font size="3" face="arial">
				<?php
					$propietario = "Corpocaldas";
					$propietarioD = null;
					if (nombreEstacion($propietario, $propietarioD) != null) {
                        foreach (nombreEstacion($propietario, $propietarioD) as $value) {
                            echo $value["estacion"]." - ".$value["tipologia"]."<br>";
                        }
                    }else{
                        echo "NO HAY ESTACIONES";
                    }
				?>
			</font>
		</td>
	</tr>
	<tr>
		<td>
			<hr>
				<center>
			<font size="4">
				Corporación Autónoma Regional de Caldas - Corpocaldas <br>
				<br> y Universidad Nacional de Colombia - UN<br>
			</font>
			<a href="http://www.corpocaldas.gov.co/" target="_blank">
				<img src="images/logo_Corpocaldass.png" width=20%>
			</a>
		 	<a href="http://unal.edu.co/" target="_blank">
		 		<img src="images/logoUnal.png" width=25%>
		 	</a>
				</center>
		</td>
		<td>
			<font size="3">
				<?php
					$propietario = "Corpocaldas y Universidad Nacional de Colombia";
					$propietarioD = "Corpocaldas Universidad Nacional";
					if (nombreEstacion($propietario, $propietarioD) != null) {
                        foreach (nombreEstacion($propietario, $propietarioD) as $value) {
                            echo $value["estacion"]." - ".$value["tipologia"]."<br>";
                        }
                    }else{
                        echo "NO HAY ESTACIONES";
                    }
				?>
			</font>
		</td>
	</tr>
	<tr>
		<td>
			<hr>
			<center>
			<font size="4">Universidad Nacional de Colombia - UN</font><br>
			<a href="http://unal.edu.co/" target="_blank">
				<img src="images/logoUnal.png" width=25%>
			</a>
			</center>
		</td>
		<td>
			<font size="3">
				<br><br><br>
				<?php
					$propietario = "Universidad Nacional de Colombia";
					$propietarioD = null;
					if (nombreEstacion($propietario, $propietarioD) != null) {
                        foreach (nombreEstacion($propietario, $propietarioD) as $value) {
                            echo $value["estacion"]." - ".$value["tipologia"]."<br>";
                        }
                    }else{
                        echo "NO HAY ESTACIONES";
                    }
				?>
			</font>
		</td>
	</tr>
	<tr>
		<td>
			<hr>
			<center>
			<font size="4">Gobernación de Caldas - Udeger<br></font>
			<a href="http://www.gobernaciondecaldas.gov.co/" target="_blank">
				<img src="images/gobernacion.png" width=25%>
			</a>
			</center>
		</td>
		<td>
			<font size="3">
				<br><br><br><br>
				<?php
					$propietario = "Gobernación de Caldas - Udeger";
					$propietarioD = null;
					if (nombreEstacion($propietario, $propietarioD) != null) {
                        foreach (nombreEstacion($propietario, $propietarioD) as $value) {
                            echo $value["estacion"]." - ".$value["tipologia"]."<br>";
                        }
                    }else{
                        echo "NO HAY ESTACIONES";
                    }
				?>
			</font>
		</td>
	</tr>
	<tr>
		<td>
			<hr>
			<center>
			<font size="4">Alcaldía de Manizales - OMPAD<br></font>
			<a href="http://www.manizales.gov.co/" target="_blank">
				<img src="images/Manizales.png" width=25%>
			</a>
			</center>
		</td>
		<td>
			<font size="3">
				<br><br><br><br><br><br>
				<?php
					$propietario = "Alcaldía de Manizales - OMPAD";
					$propietarioD = null;
					if (nombreEstacion($propietario, $propietarioD) != null) {
                        foreach (nombreEstacion($propietario, $propietarioD) as $value) {
                            echo $value["estacion"]." - ".$value["tipologia"]."<br>";
                        }
                    }else{
                        echo "NO HAY ESTACIONES";
                    }
				?>
			</font>
		</td>
	</tr>
	<!--tr>
		<td>
			<hr>
			<center>
			<font size="4">Corporación Autónoma Regional de Risaralda - CARDER</font><br>
			<a href="http://www.carder.gov.co/" target="_blank">
				<img src="images/logoCarder.png" width=15%>
			</a>
			</center>
		</td>
		<td>
			<font size="3">
				<?php
					/*$propietario = "CARDER";
					$propietarioD = null;
					if (nombreEstacion($propietario, $propietarioD) != null) {
                        foreach (nombreEstacion($propietario, $propietarioD) as $value) {
                            echo $value["estacion"]." - ".$value["tipologia"]."<br>";
                        }
                    }else{
                        echo "NO HAY ESTACIONES";
                    }*/
				?>
			</font>
		</td>
	</tr-->
	<!--tr>
		<td>
			<hr>
			<center>
				<br><br><br>
			<font size="4">Federación Nacional de Cafeteros</font><br>
			<a href="http://www.federaciondecafeteros.org/" target="_blank">
				<img src="images/logoFederacion.png" width=20%>
			</a>
			</center>
		</td>
		<td>
			<font size="3">
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				<?php
					/*$propietario = "Federación Nacional de Cafeteros";
					$propietarioD = null;
					if (nombreEstacion($propietario, $propietarioD) != null) {
                        foreach (nombreEstacion($propietario, $propietarioD) as $value) {
                            echo $value["estacion"]." - ".$value["tipologia"]."<br>";
                        }
                    }else{
                        echo "NO HAY ESTACIONES";
                    }*/
				?>
			</font>
		</td>
	</tr-->
	<tr>
		<td>
			<hr>
			<center>
			<font size="4">CHEC S.A E.S.P</font><br>
			<a href="http://www.chec.com.co/" target="_blank">
				<img src="images/logoChec.png" width=25%>
			</a>
			</center>
		</td>
		<td>
			<font size="3">
				<br><br><br>
				<?php
					$propietario = "CHEC S.A E.S.P";
					$propietarioD = null;
					if (nombreEstacion($propietario, $propietarioD) != null) {
                        foreach (nombreEstacion($propietario, $propietarioD) as $value) {
                            echo $value["estacion"]." - ".$value["tipologia"]."<br>";
                        }
                    }else{
                        echo "NO HAY ESTACIONES";
                    }
				?>
			</font>
		</td>
	</tr>
	<!--tr>
		<td>
			<hr>
			<center>
			<font size="4">Empresa Metropolitana de Aseo - EMAS S.A E.S.P</font><br>
			<a href="http://emas.com.co/" target="_blank">
				<img src="images/logoEmas.png" width=15%>
			</a>
			</center>
		</td>
		<td>
			<font size="3">
				<?php
					/*$propietario = "EMAS S.A E.S.P";
					$propietarioD = null;
					if (nombreEstacion($propietario, $propietarioD) != null) {
                        foreach (nombreEstacion($propietario, $propietarioD) as $value) {
                            echo $value["estacion"]." - ".$value["tipologia"]."<br>";
                        }
                    }else{
                        echo "NO HAY ESTACIONES";
                    }*/
				?>
			</font>
		</td>
	</tr-->
</table>

<hr>
<?php
    include('pie.php');
?>