<?php
session_start();
require_once("class/class.php");
$red = $_POST["red"];
$estacion = $_POST["estacion"];

$tra = new Trabajo();
$_SESSION['red']=$red;
$_SESSION['estacion']=$estacion;
$datos=$tra->get_variables();
$_SESSION['datos'] = $datos;

?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>MENU INICIO</title>
	<header id="header">
		<hgroup>			
			<h2 class="section_title"></h2>
		</hgroup>
	</header>
		<link rel="stylesheet" type="text/css" href="../style/admin/css/layout.css" media="screen" />
<section id="secondary_bar">

		
	</section>
	<aside id="sidebar" class="">
	
	   <p><a href="../index.php/editar_controles" title="Volver atras">Volver atras</a></p>
		<footer>
			<center>
			<h1><p><strong><?php echo($estacion);?></strong></p></h1>
		</center>
			<hr />
			<p><strong>&copy; 2015 IDEA</strong></p>
		</footer>
	</aside><!-- end of sidebar -->
</head>
<body>
	
<table align="center">
	<tr><td align="left" colspan="5"><a href="agregar_list.php"><h2>Agregar</h2>
	<br></a></td></tr>
	<br>

<tr style="font-weight:bold; color:#7E7E7F; background-color:#E0E0E3">

	<!--<td>estacion_sk</td>-->
	<td><h3><center>ESTACION</h3></center></td>
	<td><h3><center>VARIABLES</h3></center></td>
	<td><h3><center>MINIMO</h3></center></td>
	<td><h3><center>MAXIMO</h3></center></td>
	<td><h3><center>DIFERENCIA ANTERIOR</h3></center></td>
	<!--<td>id_variable_estacion</td>-->
	<!--<td>variable_excel</td>-->
	<!--<td>tipo_correccion</td>-->
	<td><h3><center>EDITAR</h3></center></td>
</tr>
<?php


for($i=0;$i<sizeof($datos);$i++){
?>
<tr style="background-color:#f0f0f0">
	<!--<td><?php echo $datos[$i]["estacion_sk"];?></td>-->
	<td><center><?php echo $datos[$i]["estacion"];?></center></td>
	<td><center><?php echo $datos[$i]["variables"];?></center></td>
	<td><center><?php echo $datos[$i]["minimo"];?></center></td>
	<td><center><?php echo $datos[$i]["maximo"];?></center></td>
	<td><center><?php echo $datos[$i]["diferencia_anterior"];?></td>
	<!--<td><?php echo $datos[$i]["id_variable_estacion"];?></td>-->
	<!--<td><?php echo $datos[$i]["variable_excel"];?></td>-->
	<!--<td><?php echo $datos[$i]["tipo_correccion"];?></td>-->
	
	<td><h2><center><a href="edit.php?id=<?php echo $datos[$i]["id_variable_estacion"];?> " title="Editar <?php echo $datos[$i]["estacion"];?>">Editar</a></h2><center></td>
	<!--<td><a href="javascript:void(0);" title="Eliminar <?php// echo $datos[$i]["titulo"];?>" onclick="eliminar('delete.php?id=<?php //echo $datos[$i]["id"];?>');">Eliminar</a></td>-->
</tr>
<?php
}
?>
</table>
</body>
</html>