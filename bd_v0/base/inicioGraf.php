<?php

	session_start();

		$nombreUsuario = $_SESSION['nombreUsuario'];
		$perfil = $_SESSION['perfil'];
		$usuario = $_SESSION['idUsu'];
		error_reporting(0);

		if ($nombreUsuario==null) {
			header("Location: index.php");
		}

		$visible='true';
		if ($perfil<5) {
			$visible='false';
		}

	include("inicioSql.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>SISTEMA DE CONSULTAS</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="../IDEA/images/favicon.ico" type="image/x-icon; charset=binary">
    <header id="header">
    	<hgroup>
    		<h2 class='section_title'>SISTEMA DE CONSULTAS DE VARIABLES AMBIENTALES</h2>
    	</hgroup>
    </header>
    <link rel="stylesheet" type="text/css" href="css/style/admin/css/layout.css" media="screen" />
	<script type="text/javascript" src="js/jquery.js"  ></script>
	<style type="text/css">
		#corp {
			position: absolute;
			top:  8px;
			left: 900px;
		}
		#fondo {
			position: absolute;
			top:  0px;
			left: 885px;
		}
	</style>
</head>
<body>
	<section id='secondary_bar'>
		<h1 id='bienvenida'>Bienvenido <?php echo $nombreUsuario ?></h1>
		<a id='cierre' href='cierre.php'>Cerrar sesion</a>
	</section>
    <div id="fondo">
		<!--a  href="http://www.corpocaldas.gov.co/" target="_blank"><img src="images/logo_Corpocaldass.png" width=27%></a-->
		<img src="images/fondo.PNG" width=33%>
	</div>
	<div id="corp">
		<a  href="http://www.corpocaldas.gov.co/" target="_blank"><img src="images/logo_Corpocaldass.png" width=27%></a>
		<!--img src="images/fondo.PNG" width=27%-->
	</div>
    

					