<?php	
    include('soporte/funciones.php');
    if($_POST){
        $idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
        $idVariable = array_key_exists('idVariable', $_POST) ? $_POST['idVariable'] : null;
        $riesgos = listarRiesgos($idEstacion, $idVariable);
        #echo "<option>Seleccione</option>";
        if($riesgos){
            foreach ($riesgos as $value) {
                echo "<option value='".$value["id"]."' >".$value["descripcion"]."</option>";
            }
        }else{ echo "<option>NO HAY VALORES</option>"; }
    }
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('base/finSql.php');
?>