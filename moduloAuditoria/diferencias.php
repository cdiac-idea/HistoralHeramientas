<?php
    //inicio de html y parte del menu ademas de funciones con las consultas sql
    include('soporte/inicio.php'); include('soporte/funciones.php');
    $estacionHtml = "<option>Seleccione</option>"; 
    $estacionHtml .= "<option>Caldas</option><option>Manizales</option>"; 
    /*$listaEstaciones=listRed();
    if ($listaEstaciones) {
        foreach ($listaEstaciones as $value) { $estacionHtml .= "<option value='".$value['red']."'>".$value['red']."</option>"; }
    }else{ $estacionHtml .= "<option>NO HAY VALORES</option>"; }*/
?>
<h4>Consulta de auditoria a los filtros parametrizados en la Bodega de datos</h4><br>
<center>
    <form action = "resultadosDiferencia.php"  target="_blank" method ="post" >
        <label>Seleccione la Red:</label>
        <select name="red" id="red" onchange="obtenerEstacion('auditoria');"><?php echo $estacionHtml; ?></select><br><br>
        <label>Seleccione la Estacion:</label>
        <select name="idEstacion" id="idEstacion" ><option>Seleccione</option><!--?php echo $estacionHtml; ?--></select><br><br>
        <input id="boton" name = "consultar" type = "submit" value = "Consultar"/>
        <input id="boton" name = "reiniciarCons" type = "reset" value = "Reiniciar Consulta"/>   
<?php
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('soporte/fin.php');
?>