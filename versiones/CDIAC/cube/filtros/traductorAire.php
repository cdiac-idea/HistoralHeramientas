<?php
session_start();
require_once("procesoAire.php"); // Se incluye el archivo de filtro
require_once("../conexion/conexiondwh.php");//Se incluye la conexión con la bodega
require_once("migrarAire.php"); // Se incluyen las funciones de migración


# Se reciben la red y la estación y el archivo diligenciados en el formulario inicial, se reciben por el metodo post
$red = $_POST["red"];
$estacion = $_POST["estacion"];
$archivo = $_FILES["archivo"]["name"];	

#se guardan en una variable de sesión
$_SESSION["red"] = $red;
$_SESSION["estacion"] = $estacion;
$_SESSION["archivo"] = $archivo;					

#SE BORRAN LOS DATOS QUE HAYAN EN LA TABLA CENTRAL -#| 
$delete_table = "DROP TABLE centralAire";				#|
$rdelete_table = @pg_query($delete_table);			#|
$delete_correcciones = "delete from correcciones";  #|
$e_de_correcciones = pg_query($delete_correcciones);#|
#---------------------------------------------------#|

#Se agrega el encabezado en la tabla correcciones para lo que será el reporte de deteccion de errores ---
$encabezado = "INSERT into correcciones (id_correccion,fecha,hora,estacion,posicion,variable,valor_error,observacion_error, valor_corregido, tipo_correccion_aplicado, fecha_sk, tiempo_sk, estacion_sk) values (0,'fecha','hora','estacion','posicion_en_el_archivo','variable','valor_error','Obervacion Error', 'valor_corregido', 'tipo_correccion_aplicado','fecha_sk', 'tiempo_sk', 'estacion_sk')";
$r_encabezado = pg_query($encabezado);
#-----------------------------------------------------------------------------------------------------------------------------------------------------------------


upload_file("datos",".csv"); # Se carga el archivo llamando la funcion upload_file

$fp = fopen ( "../backups/datos.csv" , "r" );  // abre el archivo llamado backups.csv
# analiza la línea que lee para buscar campos en formato CSV, devolviendo un array que contiene los campos leídos.
# el primer parametro indica el archivosobre el que se trabajará
# el segundo es opcional e indica la longitud máxima de la línea
# el tercer parametro indica el tipo de separador que se usarán entre cada dato, en este caso se usa ; por tratarse de un archivo csv
$data = fgetcsv ( $fp , 1000, ";"); 
$numero = count($data); // indica el número de columnas que contiene el archivo a evaluar


# Se consulta el id de de la estación llamado estacion_sk dentro la bodega de datos
$posicion = "SELECT estacion_sk from station_dim where estacion = '$estacion'";
$r_posicion = pg_query($posicion);
$v_posicion = pg_fetch_array($r_posicion);

# Se almacena en la variable $estacion_sk la estacion_sk
$estacion_sk = $v_posicion['estacion_sk']; 

# Se llama la función crear_central() que permite la creación de la tabla temporal donde se llevará a cabo el proceso de filtrado
crear_central($data,$numero,$estacion);

# Se llama la función inicial() que ejecuta la el proceso de filtrado en el archivo filtro_optimo_1_13
inicial($estacion);

#ejecuta la función migrar que lleva los datos filtrados de la tabla central a la fact_table que es la tabla de almacenamiento principal
migrar_inicial($estacion_sk);

#fclose da fin al archivo al manejo del archivo csv
fclose ( $fp ); 

#-------------------------------------------------------------------------------#
#La funcion crear central crea la tabla central que será la tabla temporal      #
#donde se llevan los datos tomados del archivo csv y se aplica posteriormente   #
#el proceso de filtrado, se reciben 3 parametros que son:						#
#  1- el conjunto de datos recuperados del archivo csv							#
#  2- el número de columnas que contiene el archivo csv							#
#  3- el nombre de la estación titular de los datos a evaluar					#
#-------------------------------------------------------------------------------#
function crear_central($arreglo,$numero,$estacion){

$i=0; // acumulador, que llevará registro de la columna que se está creando 

while ($i < $numero ) { // mientras el acumulador sea menor al número de columnas

	$variables = "SELECT distinct (variables) from variables where variable_excel = 'Calidad del aire' "; // Se consultan las variables que se están manejando hasta el momento en todas las estaciones
	$e_variables = pg_query($variables);

	$bandera = 0; // se inicializa una variable bandera en cero	


# empieza a comparar si la columna $i es igual a alguna de esas columnas
if($arreglo[$i] == 'fecha' || $arreglo[$i] == 'hora'){

		if ($i == 0){ // si la columna recibida es igual a alguna de las de arriba entonces pregunta si $i es igual a 0 es decir si se va a ingresar apenas la primer columna
			// si se va a ingresar la primer columna entonces se crea la tabla central con esa primer columna
			$pg_tabla = "CREATE TABLE centralAire 
    	(
    		{$arreglo[$i]} character varying
    	)";
		$resultado_tabla = pg_query($pg_tabla);
		}
	
		else // si no se va a ingresar la primer columna es decir $i es diferente de 0 entonces se actualiza la tabla central insertando esta nueva columna
		{
			$add_registro = "ALTER TABLE centralAire ADD COLUMN {$arreglo[$i]} character varying";
			$resultado_add_registro = pg_query($add_registro);
		}
		$bandera = 1; // y se indica que la variable bandera es igual a 1 es decir que ya termina la iteración del ciclo para que no busque más el valor y se prosigue a la siguiente columna
	}

	# empieza a comparar si la columna $i es igual a alguna de esas columnas
if($arreglo[$i] == 'Date'){

		if ($i == 0){ // si la columna recibida es igual a alguna de las de arriba entonces pregunta si $i es igual a 0 es decir si se va a ingresar apenas la primer columna
			// si se va a ingresar la primer columna entonces se crea la tabla central con esa primer columna
			$pg_tabla = "CREATE TABLE centralAire 
    	(
    		fecha character varying
    	)";
		$resultado_tabla = pg_query($pg_tabla);
		}
	
		else // si no se va a ingresar la primer columna es decir $i es diferente de 0 entonces se actualiza la tabla central insertando esta nueva columna
		{
			$add_registro = "ALTER TABLE centralAire ADD COLUMN fecha character varying";
			$resultado_add_registro = pg_query($add_registro);
		}
		$bandera = 1; // y se indica que la variable bandera es igual a 1 es decir que ya termina la iteración del ciclo para que no busque más el valor y se prosigue a la siguiente columna
	}

	if($arreglo[$i] == 'Time'){

		if ($i == 0){ // si la columna recibida es igual a alguna de las de arriba entonces pregunta si $i es igual a 0 es decir si se va a ingresar apenas la primer columna
			// si se va a ingresar la primer columna entonces se crea la tabla central con esa primer columna
			$pg_tabla = "CREATE TABLE centralAire 
    	(
    		hora character varying
    	)";
		$resultado_tabla = pg_query($pg_tabla);
		}
	
		else // si no se va a ingresar la primer columna es decir $i es diferente de 0 entonces se actualiza la tabla central insertando esta nueva columna
		{
			$add_registro = "ALTER TABLE centralAire ADD COLUMN hora character varying";
			$resultado_add_registro = pg_query($add_registro);
		}
		$bandera = 1; // y se indica que la variable bandera es igual a 1 es decir que ya termina la iteración del ciclo para que no busque más el valor y se prosigue a la siguiente columna
	}
	if($arreglo[$i] == 'PM2,5'){

		if ($i == 0){ // si la columna recibida es igual a alguna de las de arriba entonces pregunta si $i es igual a 0 es decir si se va a ingresar apenas la primer columna
			// si se va a ingresar la primer columna entonces se crea la tabla central con esa primer columna
			$pg_tabla = "CREATE TABLE centralAire 
    	(
    		pm2_5 character varying
    	)";
		$resultado_tabla = pg_query($pg_tabla);
		}
	
		else // si no se va a ingresar la primer columna es decir $i es diferente de 0 entonces se actualiza la tabla central insertando esta nueva columna
		{
			$add_registro = "ALTER TABLE centralAire ADD COLUMN pm2_5 character varying";
			$resultado_add_registro = pg_query($add_registro);
		}
		$bandera = 1; // y se indica que la variable bandera es igual a 1 es decir que ya termina la iteración del ciclo para que no busque más el valor y se prosigue a la siguiente columna
	}



if ($bandera == 0){ // si hasta el momento no se ha encontrado la variable similar haga
	

	while ($f_variables  = pg_fetch_array($e_variables)) { // mientras recorre el arreglo de variables
	# pregunto si son iguales a alguna del arreglo de las variables
		
		$variableminus = strtolower($arreglo[$i]);#CONVERTIR EN MINUSCULAS
		if ($f_variables['variables'] == $variableminus){
		
		
		if ($i == 0){
			
			$pg_tabla = "CREATE TABLE centralAire
    		(
    		{$variableminus} character varying
    		)";
			$resultado_tabla = pg_query($pg_tabla);
		}
	
		else
		
			{
				$add_registro = "ALTER TABLE centralAire ADD COLUMN {$variableminus} character varying";
				$resultado_add_registro = pg_query($add_registro);
			}
			$bandera = 1;	
		}
		else{
		
	}
		}
}

		$i++; // incrementa a la siguiente columna
	
}
# se invoca la funcion subir_datos()
subir_datos();
//convertir_24_a_0();
# se invoca la funcion agregar_columnas()
agregar_columnas($arreglo,$estacion);

}
		


#----------------------------------------------------------------------------------------------
# La función subir datos se encarga de cargar en la tabla central los datos almacenados en el archivo csv
#----------------------------------------------------------------------------------------------
function subir_datos(){

# se invoca la función elimino_fila();
elimino_fila();

$pg_carga_datos = "COPY centralAire from '/var/www/cube/backups/datos.csv' WITH DELIMITER AS ';'";
$resultado_carga_datos = pg_query($pg_carga_datos);
if($resultado_carga_datos == false){
	header("Location: ../index.php/mensaje_error_carga"); // si hubo problemas para cargar los datos en la tabla central se redirige a una  página que contiene el mensaje detallado del error
}

# Se borran todas aquellas filas de datos que no tengan una fecha, ya que estos datos no son valederos
/*$borro_vacio = "DELETE from centralAire where fecha is null;";
$r_borro_vacio = pg_query($borro_vacio);
$borro_vacio = "DELETE from centralAire where fecha = '';";
$r_borro_vacio = pg_query($borro_vacio);
*/
}




#--------------------------------------------------------------------------------------- #
# la función upload_file() sube el archivo elegido por el usuario a la carpeta backups   #
# recibe por parametros:															     #
# 1- nombre del archivo que será datos 													 #
# 2- Extension del archivo que será .csv                                                 #
#----------------------------------------------------------------------------------------#

 function upload_file($nombre, $extension){
  $archi = $_FILES["archivo"]["tmp_name"];
  $destino = "../backups/".$nombre.$extension;
  $_SESSION["archivo"] = $archi;

  move_uploaded_file($archi,$destino);  # mueve el archivo al destino destro de la carpeta backups
}

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

function agregar_columnas($data,$estacion){
 if (!in_array("fecha_sk", $data)) {
	$add_registro = "ALTER TABLE centralAire ADD COLUMN fecha_sk character varying";
			$resultado_add_registro = pg_query($add_registro);
}
if (!in_array("tiempo_sk", $data)) {
	$add_registro = "ALTER TABLE centralAire ADD COLUMN tiempo_sk character varying";
			$resultado_add_registro = pg_query($add_registro);
}
if (!in_array("estacion_sk", $data)) {
	$add_registro = "ALTER TABLE centralAire ADD COLUMN estacion_sk character varying";
			$resultado_add_registro = pg_query($add_registro);
}
$add_registro = "ALTER TABLE centralAire ADD COLUMN registro serial";
$resultado_add_registro = pg_query($add_registro);

//$add_observaciones = "ALTER TABLE central ADD COLUMN observaciones character varying";
//$resultado_add_registro = pg_query($add_observaciones);



}

#--------------------------------------------------------------------------------------- #
# la función elimino_fila() elimina el encabezado del archivo                            #
#----------------------------------------------------------------------------------------#
function elimino_fila(){
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

?>