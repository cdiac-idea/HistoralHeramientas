<?php
    session_start(); $nombreUsuario = $_SESSION['nombreUsuario']; $perfil = $_SESSION['perfil']; $usuario = $_SESSION['idUsu'];
    if ($nombreUsuario==null) { header("Location: index.php"); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>SISTEMA DE AUDITORIA CDIAC</title> <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <header id="header"><hgroup><h2>SISTEMA DE AUDITORIA</h2></hgroup></header>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script>
        function obtenerEstacion(origen){
            var red = $('#red').val();
            if(red != "Seleccione"){
                var datos = {red : red, origen : origen}; $('#idEstacion').html("<option>Cargando...</option>");
                $.post('listarRedes.php', datos, function(data) {  $('#idEstacion').html(data); });
            }else{ alert("Debe elegir una estacion"); }
        }
        function obtenerVariable(){
            var estacion = $('#idEstacion').val();
            if(estacion != "Seleccione"){
                var datos = {idEstacion : estacion}; $('#idVariable').html("<option>Cargando...</option>");
                $.post('listarVariables.php', datos, function(data) { $('#idVariable').html(data); });
            }else{ alert("Debe elegir una estacion"); }
        }
        function obtenerRiesgo(){
            var estacion = $('#idEstacion').val();
            var variable = $('#idVariable').val();
            if(estacion != "Seleccione"){
                if(variable != "Seleccione"){
                    var datos = {idEstacion : estacion, idVariable : variable}; $('#idRiesgo').html("<option>Cargando...</option>");
                    $.post('listarRiesgos.php', datos, function(data) { $('#idRiesgo').html(data); });
                }else{ alert("Debe elegir una variable"); }
            }else{ alert("Debe elegir una estacion"); }
        }
    </script>
</head>
<body>
    <section><h1>Bienvenido <?php echo $nombreUsuario ?></h1><a href='cierre.php'>Cerrar sesion</a></section>
    <section id="main" class="column">
        <ul class='toggle'>
            <li class='icn_categories'><a href='menu.php'>Presentación</a></li>
            <li class='icn_categories'><a>Administracion de auditoria</a></li>
            <li class='icn_categories'><a href='administradorFRiesgos.php'>- Administracion de Riesgos de filtrado</a></li>
            <li class='icn_categories'><a href='administradorFParametros.php'>- Administracion de Parámetros de filtrado</a></li>
            <li class='icn_categories'><a>Consultas de auditoria</a></li>
            <li><a href='formulario.php'>- Auditoria a filtros</a></li>
            <li><a href='diferencias.php'>- Auditoria de calidad de datos(calculo de diferencias)</a></li>
            <li class='icn_categories'><a>Reportes</a></li>
            <li><a href='reporteRiesgo.php'>- Parámetros de riesgos</a></li>
            <li><a href='reporteFiltro.php'>- Parámetros de filtros</a></li>
        </ul>