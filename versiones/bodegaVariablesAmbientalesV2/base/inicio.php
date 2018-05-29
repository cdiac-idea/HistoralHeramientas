<?php

	session_start();
	$nombreUsuario = $_SESSION['nombreUsuario'];
	$perfil = $_SESSION['perfil'];
	$usuario = $_SESSION['idUsu'];
	error_reporting(0);

	if ($nombreUsuario==null) {
		header("Location: cierre.php");
	}

	$visible='true';
	if ($perfil<5) {
		$visible='false';
	}

	include("inicioSql.php");
	
	$sql= "SELECT nombre, apellido, cedula, dependencia, cargo, contrasenia 
			FROM usuario 
			WHERE id_usuario=".$usuario;
	$datos_desordenados = $objDatos->hacerConsulta($sql);
	$arreglo_datos = $objDatos->generarArreglo($datos_desordenados);

	function arregloTablasIndicadores($sql, $cabeza, $archivoPlano){
		global $sqlAnual, $sqlMes, $sqlDia, $cabezaAnual, $cabezaMes, $cabezaDia, $archivoPlanoAnual, $archivoPlanoMes, $archivoPlanoDia;

		$sqlAnual .= $sql;
		$cabezaAnual .= $cabeza;
		$archivoPlanoAnual .= $archivoPlano;

		$sqlMes .= $sql;
		$cabezaMes .= $cabeza;
		$archivoPlanoMes .= $archivoPlano;

		$sqlDia .= $sql;
		$cabezaDia .= $cabeza;
		$archivoPlanoDia .= $archivoPlano;
	}

	function arregloTablasAnioMes($sql, $cabeza, $archivoPlano){
		global $sqlAnual, $sqlMes, $sqlDia, $cabezaAnual, $cabezaMes, $cabezaDia, $archivoPlanoAnual, $archivoPlanoMes, $archivoPlanoDia;

		$sqlAnual .= $sql;
		$cabezaAnual .= $cabeza;
		$archivoPlanoAnual .= $archivoPlano;

		$sqlMes .= $sql;
		$cabezaMes .= $cabeza;
		$archivoPlanoMes .= $archivoPlano;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SISTEMA DE CONSULTAS</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <header id="header">
        <hgroup>            
        	<h2 class="section_title">SISTEMA DE CONSULTAS DE VARIABLES AMBIENTALES</h2>
    	</hgroup>
    </header>
    <link rel="stylesheet" type="text/css" href="css/style/admin/css/layout.css" media="screen" />
	<script type="text/javascript" src="js/jquery.js"  ></script>
	<script type="text/javascript">
		function obtenerEstadistica(){
			var estacion = $("#idEstacion").val();
				if(estacion != "Seleccione"){
					var datos = {idEstacion : estacion};
					$("#cabeza").html("<option>Cargando...</option>");
					$.post("cabTabla.php", datos, function(data) {
						$("#cabeza").html(data);});
				}else{
			    	alert("Debe elegir una estacion");
				}
		}
		/****************************************************************************************
		los llama consulta.php
		*****************************************************************************************/

		function validacion(){
			var estacion = $("#idEstacion").val();
			if (estacion == "Seleccione") {
				alert ('Debe elegir una estacion');
				return false;
			}else{
				var anio1 = $("#idAno1").val();
				var anio2 = $("#idAno2").val();
				if (anio1 == "Seleccione" && anio2 == "Seleccione") {
					alert('Debe elegir AL MENOS un año');
					return false;
				}else{
					return true;
				}
			}
		}
			
		function obtenerEstacion(){
			var variable = $("#idVariable").val();
			if(variable > 0){
				var datos = {idVariable : variable};
				$("#idEstacion").html("<option>Cargando...</option>");
				$.post("consultarDataStation.php", datos, function(data) {
					$("#idEstacion").html(data);
				});
			}
		}

		function obtener(tabla){
			//alert(tabla);
			var estacion = $("#idEstacion").val();
			if(estacion > 0){
				var datos;
				if (tabla=='aire') {
					var variable = $("#idVariable").val();
					datos = {idEstacion : estacion, idTabla: tabla, idVariable: variable}; 
				}else{
					datos = {idEstacion : estacion};           
				}
				$("#idAno1").html("<option>Cargando...</option>");
				$("#idAno2").html("<option>Cargando...</option>");
				$.post("consultarDataDim.php", datos, function(data) {
					$("#idAno1").html(data);
					$("#idAno2").html(data);
				});
			}
		}

		function obtenerMes(dir, tabla){
			var estacion = $("#idEstacion").val();
			var anio1 = $("#idAno1").val();
			var anio2 = $("#idAno2").val();  
			if(estacion > 0){
				if (anio1 > 0 || anio2 > 0) {
					$("#idMes1").html("Cargando...");
					$("#idMes2").html("Cargando...");
					var datos;
					if (tabla=='aire') {
						var variable = $("#idVariable").val;
						datos = {idEstacion : estacion, idAnio1: anio1, idAnio2:anio2, idTabla: tabla, variable: variable};
						//alert("");
						datos = {idEstacion : estacion, idAnio1: anio1, idAnio2:anio2, idTabla: tabla};
					}else{
						datos = {idEstacion : estacion, idAnio1: anio1, idAnio2:anio2};
					}

					$.post("consultarDataDimMes.php", datos, function(data) {
						$("#idMes1").html(data);
						$("#idMes2").html(data);
					});
				};
			}
			if (tabla!='aire') {
				obtenerVariables(dir);
			}
		}

		function obtenerDia(dir, tabla){
			var estacion = $("#idEstacion").val();
			var anio1 = $("#idAno1").val();
			var anio2 = $("#idAno2").val();
			var mes1 = $("#idMes1").val();
			var mes2 = $("#idMes2").val();
			if(estacion > 0){
				if (anio1 > 0 || anio2 > 0) {
					if (mes1 > 0 || mes2 > 0) {
						$("#idDia1").html("Cargando...");
						$("#idDia2").html("Cargando...");
						var datos;
						if (tabla=='aire') {
							var variable = $("#idVariable").val();
							datos= {idEstacion : estacion, idAnio1: anio1, idAnio2:anio2, idMes1:mes1, idMes2:mes2, idTabla: tabla, idVariable: variable};
						}else{
							datos= {idEstacion : estacion, idAnio1: anio1, idAnio2:anio2, idMes1:mes1, idMes2:mes2};
						} 
						$.post("consultarDataDimDia.php", datos, function(data) {
							$("#idDia1").html(data);
							$("#idDia2").html(data);
						});
					}
				}
			}
			if (tabla!='aire') {
				obtenerVariables(dir);
			}
			//obtenerVariables(dir);
		}

		function obtenerVariables(dir){
			var estacion = $("#idEstacion").val();
			var anio1 = $("#idAno1").val();
			var anio2 = $("#idAno2").val();
			var mes1 = $("#idMes1").val();
			var mes2 = $("#idMes2").val();
			var dia1 = $("#idDia1").val();
			var dia2 = $("#idDia2").val();
			if (anio1 == "Seleccione") {
				anio1 = null;
			}
			if (anio2 == "Seleccione") {
				anio2 = null;
			}
			if (mes1 == "Seleccione") {
				mes1 = null;
			}
			if (mes2 == "Seleccione") {
				mes2 = null;
			}
			if (dia1 == "Seleccione") {
				dia1 = null;
			}
			if (dia2 == "Seleccione") {
				dia2 = null;
			}
			if(estacion > 0){
				if (anio1 > 0 || anio2 > 0) {
					if (mes1 > 0 || mes2 > 0 || mes1 == null || mes2 == null) {
						if (dia1 > 0 || dia2 > 0 || dia1 == null || dia2 == null) {
							$("#listVar").html("Cargando...");
							var datos = {idEstacion : estacion, idAnio1: anio1, idAnio2:anio2, idMes1:mes1, idMes2:mes2, idDia1:dia1, idDia2:dia2};
							$.post(dir+".php", datos, function(data) {
								$("#listVar").html(data);
							});
						}
					}
				}
			}
		}
	</script>
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
	<section id="secondary_bar">
        <h1 id="bienvenida">Bienvenido <?php echo $nombreUsuario;?></h1>
    	<a id="cierre" href="cierre.php">Cerrar sesion</a>
    </section>

    <aside id="sidebar">
       <br><br><br><br><br><br><br>
       <div id="fondo">
			<!--a  href="http://www.corpocaldas.gov.co/" target="_blank"><img src="images/logo_Corpocaldass.png" width=27%></a-->
			<img src="images/fondo.PNG" width=33%>
		</div>
		<div id="corp">
			<a  href="http://www.corpocaldas.gov.co/" target="_blank"><img src="images/logo_Corpocaldass.png" width=27%></a>
			<!--img src="images/fondo.PNG" width=27%-->
		</div>
       <ul class="toggle">
			<li class="icn_categories"><a href="menu.php">Presentación</a></li>
			<?php
				if ($perfil == 1 || $perfil ==  3 || $perfil == 5) {
					echo "<li class='icn_categories'><a>Manejo de Usuarios</a></li>";
					echo "<li><a href='crearUsu.php'>- Crear</a></li>";//?usuario=$usuario&perfil=$perfil'>- Crear</a></li>";
					echo "<li><a href='modificarUsu.php'>- Modificar</a></li>";//?usuario=$usuario&perfil=$perfil'>- Modificar</a></li>";
					echo "<li><a href='eliminarUsu.php'>- Eliminar</a></li>";//?usuario=$usuario&perfil=$perfil'>- Eliminar</a></li>";
				}
			?>
			<li class="icn_categories"><a href="adminPerfil.php">Administracion de cuenta</a></li>
			<li class="icn_categories"><a>Consultas</a></li>
			<li><a href="consulta.php">- Consulta Clima</a></li>
			<?php
				if ($perfil<5) {
					echo "<li><a href='consultaAire.php'>- Consulta Aire</a></li>";
				}
			?>
			<li class='icn_categories'><a href='introIndicadores.php'>Indicadores</a></li>
			<li><a href='indicadores.php'>- Indicadores Clima</a></li>
			<?php
				if ($perfil<5) {
					echo "<li><a href='indicadoresAire.php'>- Indicadores Aire</a></li>";
				}
				/*if ($usuario==1) {
					echo "<li><a href='estadisticasClima.php'>- Estadisticas datos Climatológicos</a></li>";
				}*/
			?>
		</ul>
        <footer id="pie">
            <hr /><p><strong>IDEA -- GAIA</strong></p>
        </footer>
    </aside>
<section id="main" class="column">

					