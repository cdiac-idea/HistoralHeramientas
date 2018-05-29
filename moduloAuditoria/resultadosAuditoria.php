<?php
    //inicio de html y parte del menu ademas de funciones con las consultas sql
    include('soporte/inicio.php'); include('soporte/funciones.php');
    if($_POST){
        $idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
        $idVariable = array_key_exists('idVariable', $_POST) ? $_POST['idVariable'] : null;
        $idRiesgo   = array_key_exists('idRiesgo', $_POST)   ? $_POST['idRiesgo']   : null;
        $nombreRiesgo = nombreRiesgo($idRiesgo);
        $nombreEstacion = nombreEstacion($idEstacion);
        $cantidad = auditar($idEstacion, $idVariable, $idRiesgo);
        $tam=count($cantidad);
        if($tam>0){ $mensaje="Se detectaron un total de ".$tam." datos erroneos.";
        }else{ $mensaje="No se encontraron datos erroneos."; }
        $tabla="<table border=2><tr><th>Fecha</th><th>Tiempo</th><th>".$idVariable."</th></tr>";
        foreach ($cantidad as $value){ $tabla.="<tr><td>".$value['fecha']."</td><td>".$value['tiempo']."</td><td>".$value['dato']."</td></tr>"; }
        $tabla.="</table>";
    }
?>
<label>Estación: <?php echo $nombreEstacion;?></label><br>
<label>Variable: <?php echo $idVariable;?></label><br>
<label>Riesgo: <?php echo $nombreRiesgo;?></label><br><br>
<label><?php echo $mensaje;?></label>
<div><?php echo $tabla;?></div>
<?php
//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('soporte/fin.php');
?>