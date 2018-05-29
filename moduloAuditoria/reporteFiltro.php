<?php
    //inicio de html y parte del menu ademas de funciones con las consultas sql
    include('soporte/inicio.php'); include('soporte/funciones.php'); $estacionHtml = "<option>Seleccione</option>"; $listaEstaciones=listRed();
    if ($listaEstaciones) { foreach ($listaEstaciones as $value) {$estacionHtml .= "<option value='".$value['red']."'>".$value['red']."</option>";}
    }else{ $estacionHtml .= "<option>NO HAY VALORES</option>"; }
    $riesgo = ""; $listaRiesgo=listRiesgo();
?>
<h4>Administración de riesgos para sistema de filtración de datos</h4><br> 
<center>
<form action = "reporteF.php" method ="post" >
    <label>Consultar los <b>filtros</b> aplicados a la estación y variable elegida.</label><br><br><br>
    <label>Seleccione la Red:</label><select name="red" id="red" onchange="obtenerEstacion();"><?php echo $estacionHtml; ?></select><br><br>
    <label>Seleccione la Estacion:</label><select name="idEstacion" id="idEstacion" onchange="obtenerVariable();"><option>Seleccione</option></select><br><br>
    <label>Seleccione la variable:</label><select name="idVariable" id="idVariable" ><option>Seleccione</option></select><br><br>
    <input id="boton" name="Enviar"  type="submit" value="Consultar"/> 
<?php
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('soporte/fin.php');
?>