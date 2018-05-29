<?php
/* En los encabezados indicamos que se trata de un archivo csv y en el nombre de archivo le ponemos la extensión csv.            */
header('Content-type: text/csv');
header('Content-Disposition: inline; filename=reporte.csv');
function generarReporte($cabeza, $result, $separador, $saltoLinea){
    $str = $cabeza.$saltoLinea;
    foreach ($result as $value) {
        foreach ($value as $field) { $str .= $field.$separador; }
        #$str = rtrim($str, $separador); //Elimina la última coma que sobra
        $str .= $saltoLinea; //Agrega el salto de línea de la fila
    }
    $str = rtrim($str, $saltoLinea); //Elimina el último salto de linea que sobra
    return $str;
}
if($_POST){	//inicio de html y parte del menu ademas de funciones con las consultas sql
    require_once("../configuracion/clsBD.php");
    $objDatos = new clsDatos();
    $string_array = array_key_exists('datos', $_POST) ? $_POST["datos"] : null;
    $cabeza = array_key_exists('titulos', $_POST) ? $_POST["titulos"] : null;
    $result = $objDatos->executeQuery($string_array);
    echo generarReporte($cabeza, $result, ";", "\n");
}

?>