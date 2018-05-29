<?php
require_once("class/class.php");
$tra = new Trabajo();
if (isset($_POST["grabar"])) {
	$tra->edit();
	exit();
}
$datos=$tra->get_noticia_por_id($_GET["id"]);

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>EDITAR </title>
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
	
	   <p><a href="../index.php/editar_controles" title="Volver atras">Volver atras</a></p>             
		<footer>
			<center>
			<h1><p><strong><?php echo $datos[0]["estacion"];?></strong></p></h1>
		</center>
			<hr />
			<p><strong>&copy; 2015 IDEA</strong></p>
		</footer>
	</aside><!-- end of sidebar -->
	<?php
		if(isset($_GET["m"])){
			switch ($_GET["m"]) {
				case '1':
					?>
					<h2 style="color:red;"><center>Los datos estan vacios <br><br></center></h2>
					<?php
					break;
				case '2':
					?>
					<h2 style="color:#5EAC6F;"><center>Se editó satisfactoriamente <br><br></center></h2>
					<?php
					break;
				
			}
		}
	?>
	<br/><br/>
<center>
	<form name="form" action="" method="post">

		Estacion_sk: <input type="text" name="est_sk" value="<?php echo $datos[0]["estacion_sk"];?>" readonly="readonly"/>
		<br><br>
		Estacion: <input type="text" name="est" value="<?php echo $datos[0]["estacion"];?>" readonly="readonly"/>
		<br><br>
		Variable: <input type="text" name="var" value="<?php echo $datos[0]["variables"];?>" readonly="readonly"/>
		<br><br>
		Minimo: <input type="text" name="min" value="<?php echo $datos[0]["minimo"];?>"/>
		<br><br>
		Maximo: <input type="text" name="max" value="<?php echo $datos[0]["maximo"];?>"/>
		<br><br>
		Diferencia anterior: <input type="text" name="diferencia" value="<?php echo $datos[0]["diferencia_anterior"];?>"/>
		<br><br>
		Variable_excel: <input type="text" name="var_exc" value="<?php echo $datos[0]["variable_excel"];?>" readonly="readonly"/>
		<br><br>
		Correcion: <input type="text" name="cor" value="<?php echo $datos[0]["tipo_correccion"];?>"  readonly="readonly"/>
		<br>
		<br><br>

		
		<input type="hidden" name="grabar" value="si" />
		<input type="hidden" name="id_variable_estacion" value="<?php echo $_GET["id"];?>" />
		<input type="submit" value="Editar" title="Editar" />
	</form>
</center>
</body>
</html>