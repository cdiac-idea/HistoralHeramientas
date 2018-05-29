<?php
	include("../bd/base/inicioSql.php");
	


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
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon; charset=binary">
    <header id="header">
    	<hgroup>
    		<h2 class='section_title'>CDIAC - Centro de Datos e Indicadores Ambientales de Caldas</h2>
    	</hgroup>
    </header>
    <link type="text/css" href="../bd/css/style/admin/css/layout.css" media="screen" rel="stylesheet" />
	<script type="text/javascript" src="../bd/js/jquery.js"  ></script>
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
    <aside id="sidebar">
       <br><br><br><br>
       <div id="fondo">
			<img src="../bd/images/fondo.PNG" width=33%>
		</div>
		<div id="corp">
			<a  href="http://www.corpocaldas.gov.co/" target="_blank"><img src="images/logo_Corpocaldass.png" width=27%></a>
		</div>
        <footer id="pie">
            <hr /><p><strong>IDEA -- GAIA</strong></p>
        </footer>
    </aside>
<section id="main" class="column">

					