<?php session_start();
require_once("../../conexion/conexiondwh.php");
$red = $_POST["red"];
$estacion = $_POST["estacion"];
?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Lista de variables no asignadas</title>
		<header id="header">
		<hgroup>			
			<h2 class="section_title"></h2>
		</hgroup>
	</header>
	<link rel="stylesheet" type="text/css" href="../../style/admin/css/layout.css" media="screen" />
</head>
<body>
		<section id="secondary_bar">

		
	</section>

	<aside id="sidebar" class="">
	
	   <p><a href="../../index.php/asignar_variables" title="Volver atras">Volver atras</a></p>
		<footer>
			<center>
			<h1><p><strong><?php print("$estacion");?></strong></p></h1>
		</center>
			<hr />
			<p><strong>&copy; 2015 IDEA</strong></p>
		</footer>
	</aside><!-- end of sidebar -->
<?php






//echo($red);
echo "<br>";
//echo($estacion);
$esta_sk = "SELECT estacion_sk from estacion where nombre_estacion = '$estacion'";
$e_esta_sk = pg_query($esta_sk);
$r_esta_sk = pg_fetch_array($e_esta_sk);
$_SESSION['esta_sk']=$r_esta_sk['estacion_sk'];

$_SESSION['red'] = $red;
$_SESSION['estacion'] = $estacion;



$v_esta_sk = $r_esta_sk['estacion_sk'];
//echo($v_esta_sk);
$consulta = "SELECT id_variable, nombre from variable where id_variable not in (select id_variable from esta_var where estacion_sk='$v_esta_sk')";
$e_consulta = pg_query($consulta);

print("<form action='prueba.php' method='post'>");
print("<center><table border= \"0\" width =\"40%\" style=\"font-weight:bold; color:#E0E0E3; background-color:#E0E0E3\"><tr>
			<td width= \"33%\"><font color ='black'> <b><center>Id Variable</center></font></b></td>
			<td width= \"33%\"> <b><font color ='black'>Nombre Variable</font></b></td>
			
		</tr>");
$x=0;
while ($r_consulta = pg_fetch_array($e_consulta)) {
	print"<center><table border= \"0\" width =\"40%\" >		

		<tr>			
			<td width= \"34%\"><center> $r_consulta[id_variable]</center></td>
			<td width= \"34%\"><input type='checkbox' name='check$x' value = '$r_consulta[nombre]' />$r_consulta[nombre]<br></td>";$x++;
		print"</tr>
			</table>
						</center>";
}
print"<center><br><br><input type=\"submit\" name=\"boton\" value=\"Enviar\"></center></form></html>";
$_SESSION['x']=$x;
?>
</body>
</html>