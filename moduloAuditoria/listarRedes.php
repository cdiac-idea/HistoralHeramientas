<?php	
    include('soporte/funciones.php');
    if($_POST){
        $red = array_key_exists('red', $_POST) ? $_POST['red'] : null;
        $origen = array_key_exists('origen', $_POST) ? $_POST['origen'] : null;
        $red = listEstaciones($red, $origen);
        #echo "<option>Seleccione</option>";
        if($red){
            foreach ($red as $value) {
                echo "<option value='".$value["id"]."'>".$value["nombre"]." - ".
                        $value["municipio"]." - ".$value["tipo"]."</option>";
            }
        }else{ echo "<option>NO HAY VALORES</option>"; }
    }
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('base/finSql.php');
?>