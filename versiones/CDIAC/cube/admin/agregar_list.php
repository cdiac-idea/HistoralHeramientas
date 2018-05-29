<?php
session_start();
require_once("class/class.php");
require_once("../conexion/conexion.php");


$tra = new Trabajo();
$_SESSION['red'];
$_SESSION['estacion'];
$datos=$tra->get_interseccion();
$_SESSION['datos'] = $datos;
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>MENU Agregar Lista</title>
	<header id="header">
		<hgroup>			
			<h2 class="section_title"></h2>
		</hgroup>
	</header>

</head>
<body>
	<link rel="stylesheet" type="text/css" href="../style/admin/css/layout.css" media="screen" />
	<section id="secondary_bar">

		
	</section>

	<aside id="sidebar" class="">
	
	   <p><a href="../index.php/editar_controles" title="Volver atras">Volver atras</a></p>             
		<footer>
			<center>
			<h1><p><strong><br><?php echo($_SESSION['estacion'])?></strong></p></h1>
		</center>
			<hr />
			<p><strong>&copy; 2015 IDEA</strong></p>
		</footer>
	</aside><!-- end of sidebar -->
	<br>
<table align="center">
	
<tr style="color:#7E7E7F; background-color:#E0E0E3">

	<td><h3><center>ID VARIABLE EN ESTACION</h3></td>
	<!--<td>estacion_sk</td>-->
	<!--<td><h3><center>ESTACION</h3></td>-->
	<!--<td>id_variable</td>-->
	<td><h3><center>VARIABLE</h3></td>
	<!--<td>deteccion</td>-->
	<td><h3><center>AGREGAR</h3></td>
</center>
</tr>
<?php



for($i=0;$i<sizeof($datos);$i++){
?>
<tr style="background-color:#f0f0f0">
	
	<td><center><?php echo $datos[$i]["id_esta_var"];?></center></td>
	<!--<td><?php echo $datos[$i]["estacion_sk"];?></td>-->
	<!--<td><center><?php echo $datos[$i]["nombre_estacion"];?></center></td>-->
	<!--<td><?php echo $datos[$i]["id_variable"];?></td>-->
	<td><center><?php echo $datos[$i]["nombre"];?></center></td>
	<!--<td><?php echo $datos[$i]["deteccion"];?></td>-->


	<td><center><a href="add.php?id=<?php echo $datos[$i]["id_esta_var"];?> " title="Agregar <?php echo $datos[$i]["estacion_sk"];?>"><h3>Agregar</h3></a></center></td>
	<!--<td><a href="javascript:void(0);" title="Eliminar <?php// echo $datos[$i]["titulo"];?>" onclick="eliminar('delete.php?id=<?php //echo $datos[$i]["id"];?>');">Eliminar</a></td>-->
</tr>
<?php
}
?>
</table>
</body>
</html>