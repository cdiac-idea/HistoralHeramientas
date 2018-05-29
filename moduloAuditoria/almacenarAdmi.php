<?php
    //inicio de html y parte del menu ademas de funciones con las consultas sql
    include('soporte/inicio.php'); include('soporte/funciones.php'); 
    $mensaje="Falla en guardar cambios, por favor intentar mas tarde";
    if ($_POST['Filtrado']) {
        $idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
        $idVariable = array_key_exists('idVariable', $_POST) ? $_POST['idVariable'] : null;
        $maximo = array_key_exists('maximo', $_POST) ? $_POST['maximo'] : null;
        $minimo = array_key_exists('minimo', $_POST) ? $_POST['minimo'] : null;
        $diferencia = array_key_exists('diferencia', $_POST) ? $_POST['diferencia'] : null;
        $aplica = array_key_exists('aplica', $_POST) ? $_POST['aplica'] : null;
        $mensaje = parametrosFiltros($idEstacion, $idVariable, $maximo, $minimo, $diferencia, $aplica);
    }
?>
<h4>Administración de riesgos para sistema de filtración de datos</h4><br> 
<h4><?php echo $mensaje?></h4><br>  
<?php
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('soporte/fin.php');
?>