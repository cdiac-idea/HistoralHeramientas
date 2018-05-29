<?php
    //inicio de html y parte del menu ademas de funciones con las consultas sql
    include('soporte/inicio.php'); include('soporte/funciones.php'); 
    $mensaje="Falla en guardar cambios, por favor intentar mas tarde";
    if ($_POST['Riesgos']) {
        $idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
        $idVariable = array_key_exists('idVariable', $_POST) ? $_POST['idVariable'] : null;
        $riesgo = array_key_exists('riesgo', $_POST) ? $_POST['riesgo'] : null;
        $mensaje = asignarRiesgo($idEstacion, $idVariable, $riesgo);
    }
?>
<h4>Administración de riesgos para sistema de filtración de datos</h4><br> 
<h4><?php echo $mensaje?></h4><br>  
<?php
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('soporte/fin.php');
?>