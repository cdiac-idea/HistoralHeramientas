<?php	
    include('soporte/funciones.php');
    if($_POST){
        $idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
        $riesgos = listarVariable($idEstacion);
        #echo "<option>Seleccione</option>";
        if($riesgos){
            foreach ($riesgos as $value) {
                echo "<option value='".$value."' >".$value."</option>";
            }
        }else{ echo "<option>NO HAY VALORES</option>"; }
    }
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('base/finSql.php');
?>