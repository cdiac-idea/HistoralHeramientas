<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("class/class.php");
require_once("../conexion/conexion.php");
$red = $_SESSION["red"];
$estacion = $_SESSION["estacion"];
$tra = new Trabajo();
if (isset($_POST["grabar"]) and $_POST["grabar"]=="si") {
	$tra->add();
	
	exit();
}
$datos=$tra->get_variable_por_id($_GET["id"]);
$datos2=$tra->extraer($datos[0]['id_esta_var']);
$datos3 = $tra->actualizar($datos[0]['id_esta_var']);
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>AGREGAR con PostgreSQL</title>
	<header id="header">
		<hgroup>			
			<h2 class="section_title"></h2>
		</hgroup>
	</header>
	<link rel="stylesheet" type="text/css" href="../style/admin/css/layout.css" media="screen" />
</head>
<body>
	<section id="secondary_bar">

		
	</section>
	<aside id="sidebar" class="">
	
	   <p><a href="agregar_list.php" title="Volver atras">Volver atras</a></p>             
		<footer>
			<center>
			<h1><p><strong><?php echo $datos2[1]["nombre_estacion"];?></strong></p></h1>
		</center>
			<hr />
			<p><strong>&copy; 2015 IDEA</strong></p>
		</footer>
	</aside><!-- end of sidebar -->
	<br>
	<br>
	<?php
		if(isset($_GET["m"])){
			switch ($_GET["m"]) {
				case '1':
					?>
					<h2 style="color:red;"><center> Los datos estan vacios <br><br></center></h2>
					<?php
					break;
				case '2':
					?>
					<h2 style="color:#5EAC6F;"><center> El filtro se creo satisfactoriamente <br><br></center></h2>
					<?php
					break;
				
				default:
					# code...
					break;
			}
		}
	?>


	<form name="form" action="" method="post" align="center">

		Estacion_sk: <input type="text" name="est_sk" value="<?php echo $datos2[1]["estacion_sk"];?>" readonly="readonly"/>
		<br><br>
		Estacion: <input type="text" name="est" value="<?php echo $datos2[1]["nombre_estacion"];?>" readonly="readonly"/>
		<br><br>
		Variable: <input type="text" name="var" value="<?php echo $datos2[1]["nombre"];?>" readonly="readonly"/>
		<br><br>
		Minimo: <input type="text" name="min" />
		<br><br>
		Maximo: <input type="text" name="max" />
		<br><br>
		Diferencia: <input type="text" name="dif" />
		<br><br>
		Variable_excel: <input type="text" name="var_exc" value="<?php echo $datos2[1]["variable_excel"];?>" readonly="readonly"/>
		<br><br>
		Correcion: <input type="text" name="cor" value="<?php echo $datos2[1]["correccion"];?>"  readonly="readonly"/>
		<br>
		<br>
		<br>
		<input type="hidden" name="grabar" value="si" />
		<input type="submit" value="Crear" title="Crear" />
	</form>

</body>
</html>