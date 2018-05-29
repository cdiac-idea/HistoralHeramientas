<!DOCTYPE html>
<html class="no-js ie9 lang_0" id="html">
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon; charset=binary">
	<link rel="shortcut icon" href="logo2.png" type="image/png" />
	<title>Centro de Datos e Indicadores Ambientales de Caldas</title>
	<meta name="revisit-after" content="1 hour">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=0.5, maximum-scale=2.5, user-scalable=yes">
	<base href="">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/reset.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/unal.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/base.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/tablet.css" media="only screen and (min-width: 992px) and (max-width: 1199px)">
	<link rel="stylesheet" type="text/css" href="css/phone.css" media="only screen and (min-width: 768px) and (max-width: 991px)">
	<link rel="stylesheet" type="text/css" href="css/small.css" media="only screen and (max-width: 767px)">
	<script src="js/jquery.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="css/form.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css" media="all">
	<script src="js/bootstrap-select.min.js" type="text/javascript"></script>
	<script>jQuery(document).ready(function($){$('select','form').selectpicker();})</script>
	<link rel="stylesheet" type="text/css" href="engine0/style.css" />
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

h4.alert_info {
display: block;
width: 90%;
margin: 20px 3% 0 3%;
margin-top: 20px;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
background: #D6D6D6 url(images/icn_alert_info.png) no-repeat;
background-position: 10px 10px;
border: 1px solid #77BACE;
color: #3D3F3F;
padding: 10px 0;
text-indent: 40px;
font-size: 14px;}

</style>

</head>
<body>
	<header id="unalTop">
	<div class="logo">
		<a href="http://unal.edu.co">
		<img alt="Escudo de la Universidad Nacional de Colombia" src="images/escudoUnal.png" width="189" height="70" title="Escudo de la Universidad Nacional de Colombia"/>
		</a>
		<div class="diag">
		</div>
	</div>
	<div class="seal">
		<img alt="Escudo de la República de Colombia" src="images/sealColombia.png" width="66" height="66" title="Escudo de la República de Colombia"/>
	</div>
	<div class="firstMenu">
		<div class="btn-group tx-srlanguagemenu">
			<div class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				 ES <span class="caret"></span>
			</div>
			<ul class="dropdown-menu" role="menu">
			</ul>
		</div>
	</div>
	<div class="navigation">
		<div class="site-url">
			<div class="icon">
			</div>
			CDIAC - Centro de Datos e Indicadores Ambientales de Caldas
		</div>

	<div class="buscador">
		<gcse:searchbox-only resultsurl="http://unal.edu.co/resultados-de-la-busqueda/"></gcse:searchbox-only>
	</div>
	</header>
	<div id="services">
		<div class="indicator">
		</div>
		<ul>
			<li><img src="images/icnServEmail.png" width="32" height="32" border="0" alt=""><a href="http://correo.unal.edu.co" target="_top">Correo institucional</a></li>
			<li><img src="images/icnServSia.png" width="32" height="32" border="0" alt=""><a href="http://www.sia.unal.edu.co" target="_top">Sistema de Información Académica</a></li>
			<li><img src="images/icnServLibrary.png" width="32" height="32" border="0" alt=""><a href="http://www.sinab.unal.edu.co" target="_top">Bibliotecas</a></li>
			<li><img src="images/icnServCall.png" width="32" height="32" border="0" alt=""><a href="http://168.176.5.43:8082/Convocatorias/indice.iface" target="_blank">Convocatorias</a></li>
		</ul>
	</div>
	<div class="home-image">
		<img src="img_demo.jpg" width="2000" height="80" border="0" alt="">
	</div>
	<main class="detalle">
	<br>
	<br>
	<br>
