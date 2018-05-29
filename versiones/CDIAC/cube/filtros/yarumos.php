<?php

require_once("../conexion/conexionyarumos.php");//Se incluye la conexión con la bodega

# se invoca la funcion subir_datos()
subir_datos();

function subir_datos(){

# se invoca la función elimino_fila();
//elimino_fila();

$pg_carga_datos = "COPY fact_table from '/var/www/cube/backups/bdabd_5.csv' DELIMITER ';' CSV";
$resultado_carga_datos = pg_query($pg_carga_datos);
if($resultado_carga_datos == false){
	//header("Location: ../index.php/mensaje_error_carga"); // si hubo problemas para cargar los datos en la tabla central se redirige a una  página que contiene el mensaje detallado del error
}


}

#--------------------------------------------------------------------------------------- #
# la función upload_file() sube el archivo elegido por el usuario a la carpeta backups   #
# recibe por parametros:															     #
# 1- nombre del archivo que será datos 													 #
# 2- Extension del archivo que será .csv                                                 #
#----------------------------------------------------------------------------------------#


#--------------------------------------------------------------------------------------- #
# la función agregar_columnas() agrega a la tabla central otras columnas necesarias para #
# el proceso como son: 																	 #
# 	- fecha_sk: el id de la fecha del dato.                                              #
#	- tiempo_sk: el id de la hora del dato.                                              #
#	- estacion_sk: el id de la estacion.                                                 #
# recibe por parametros:															     #
# 1- el conjunto de datos recuperados del archivo csv									 #
# 2- Estacion asociada                                                                   #
#----------------------------------------------------------------------------------------#


#--------------------------------------------------------------------------------------- #
# la función elimino_fila() elimina el encabezado del archivo                            #
#----------------------------------------------------------------------------------------#
/*function elimino_fila(){
	$archivo = '../backups/datos.csv';  
    if(file_exists($archivo)) {  
        $file = fopen($archivo,'r');  
        while(!feof($file)) {   
            $name = fgets($file);  
            $lineas[] = $name;  
        }  
        fclose($file);  

        // Todas las lineas quedan almacenadas en $lineas  
        unset($lineas[0]);  
        $lineas = array_values($lineas);  
        //print_r($lineas);
        // GUARDAMOS  
        $file = fopen($archivo, "w");  
        foreach( $lineas as $linea ) {  
            fwrite( $file, $linea );  
        }   
        fclose( $file ); 
    } 
}
*/


//header("Location: ../index.php/mensaje_filtrados"); # Redirige al mensaje enhorabuena
?>