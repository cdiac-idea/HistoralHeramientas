<?php
    //inicio de html y parte del menu ademas de funciones con las consultas sql
    include('soporte/inicio.php'); include('soporte/funciones.php');
    if($_POST){
        $idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
        $idVariable = array_key_exists('idVariable', $_POST) ? $_POST['idVariable'] : null;
        $nombreEstacion = nombreEstacion($idEstacion);
        $nombreRiesgo = listaVariables($idEstacion, $idVariable);
    }
?>
<label>Estación: <?php echo $nombreEstacion;?></label><br>
<label>Variable: <?php echo $idVariable;?></label><br>
<label>Parámetros: <br><?php echo $nombreRiesgo;?></label><br><br>
<?php
//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('soporte/fin.php');
?>