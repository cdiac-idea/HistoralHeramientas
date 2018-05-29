  
    <?php
    require_once("../conexion/conexion.php");

    $consulto_columna_direccion = "SELECT direccion_viento,registro from central";
    $e_consulta_columna_direccion = pg_query($consulto_columna_direccion);

    while ($f_consulto_columna_direccion = pg_fetch_array($e_consulta_columna_direccion)){
        if (!is_numeric($f_consulto_columna_direccion['direccion_viento'])){

            $dos = (double)$f_consulto_columna_direccion['direccion_viento'];
        
            $actualizo = "UPDATE central set direccion_viento = $dos where registro = $f_consulto_columna_direccion[registro]";
            $pg_query = pg_query($actualizo);

            }
           
        }

    $consulto_columna_humedad = "SELECT humedad_relativa,registro from central";
    $e_consulta_columna_humedad = pg_query($consulto_columna_humedad);

    while ($f_consulto_columna_humedad = pg_fetch_array($e_consulta_columna_humedad)){
        if (!is_numeric($f_consulto_columna_humedad['humedad_relativa'])){

            $dos = (double)$f_consulto_columna_humedad['humedad_relativa'];
        
            $actualizo = "UPDATE central set humedad_relativa = $dos where registro = $f_consulto_columna_humedad[registro]";
            $pg_query = pg_query($actualizo);

            }
           
        }
        
    


    ?>
