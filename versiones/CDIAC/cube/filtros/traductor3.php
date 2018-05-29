<?php
$estacionElegida = 'est_marquetalia';

require_once("filtro_optimo1_13.php"); // Se incluye el archivo de filtro
require_once("../conexion/conexiondwh.php"); //Se incluye la conexión con la bodega
require_once("migrarBD.php"); // Se incluyen las funciones de migración
require_once("confianza_datos.php");

#SE BORRAN LOS DATOS QUE HAYAN EN LA TABLA CENTRAL -#|
$delete_table = "DROP TABLE central";				#|
$rdelete_table = @pg_query($delete_table);			#|
#---------------------------------------------------#|

#SE BORRAN LOS DATOS QUE HAYAN EN LA TABLA CORRECCIONES -#|
$delete_correcciones = "delete from correcciones";       #|
$e_de_correcciones = pg_query($delete_correcciones);     #|
#--------------------------------------------------------#|

#Se agrega el encabezado en la tabla correcciones para lo que será el reporte de deteccion de errores ---
$encabezado = "INSERT into correcciones (fecha,hora,estacion,posicion,variable,valor_error,observacion_error, valor_corregido, tipo_correccion_aplicado) values ('fecha','hora','estacion','posicion_en_el_archivo','variable','valor_error','Obervacion Error', 'valor_corregido', 'tipo_correccion_aplicado')";
$r_encabezado = pg_query($encabezado);


$id_BaseDatos = "SELECT * from tablas where nombre_tabla = '$estacionElegida'";
$e_idBaseDatos = pg_query($id_BaseDatos);
$f_idBaseDatos = pg_fetch_array($e_idBaseDatos);


//echo "nombre tabla = ";
//echo ($f_idBaseDatos['nombre_tabla']);
#-----------------------------------------------------------------------------------------------------------------------------------------------------------------

#SELECCIONA TODA LA INFORMACIÓN DE LA TABLA BASE DE DATOS SE ENCUENTRAN LOS DATOS DE CADA BASE DE DATOS
$consulta_bases = "SELECT * from basedatos where id_basedatos = $f_idBaseDatos[id_basedatos]"; #!! QUITAR EL OFFSET PARA TOMAR TODAS LAS BASES DE DATOS, acá solo toma la primera base para efectos de pruebas
$e_consulta_bases = pg_query($consulta_bases);
$f_consulta_bases = pg_fetch_array($e_consulta_bases);
#-----------------------------------------------------------------------------------------------------------------------------------------------------------------



#RECORRE CADA BASE DE DATOS
//while($f_consulta_bases = pg_fetch_array($e_consulta_bases)){
	
	$usuario = $f_consulta_bases['usuario'];  // GUARDA EN $usuario EL USUARIO DE CADA BASE DE DATOS
	$password = $f_consulta_bases['contrasenia']; // GUARDA EN $password LA CONTRASEÑA DE CADA BASE DE DATOS
	$bd = $f_consulta_bases['nombrebasedatos']; // GUARDA EN $bd EL NOMBRE DE LA BASE DE DATOS DE CADA BASE DE DATOS

	$dbr = conectarse($usuario,$password,$bd); # establece conexión con el servidor de adquisición de datos

	#Se seleccionan todas las estaciones asociadas a la base de datos consultada almacenadas en la tabla 'tablas' ----------------------
	//$con_tablas = "SELECT * from tablas where id_basedatos = $f_consulta_bases[id_basedatos] order by id_tabla limit 1 "; //OBTENGO La primera por cuestion de pruebas
	//$e_con_tablas = pg_query($con_tablas);
	#-----------------------------------------------------------------------------------------------------------------------------------
	
	//while ($f_idBaseDatos) {

		# Muestra el conjunto de variables y demas columnas que trae la estación consultada #|
		$cons = "SHOW COLUMNS from $estacionElegida";							#|
		$ejecuto = mysqli_query($dbr,$cons);												#|
		$numero = mysqli_num_rows($ejecuto); #número de columnas que tiene la estación   	#|
		#-----------------------------------------------------------------------------------#|

		#RECUPERO LA ULTIMA FECHA FILTRADA DE LA TABLA CONSULTADA -----------------------------------------------------#|
		$ultima_fecha_filtrada = "SELECT dato_actual from tablas where nombre_tabla = '$f_idBaseDatos[nombre_tabla]'";  #|
		$e_ultima_fecha_filtrada = pg_query($ultima_fecha_filtrada);						                           #|
		$f_ultima_fecha_filtrada = pg_fetch_array($e_ultima_fecha_filtrada);										   #|
		$fecha = $f_ultima_fecha_filtrada['dato_actual']; #en $fecha se almacena la última fecha filtrada			   #|
		#--------------------------------------------------------------------------------------------------------------#|

		#RECUPERO LA ULTIMA HORA FILTRADA -------------------------------------------------- --------------------------#|
		$ultima_hora_filtrada = "SELECT hora_actual from tablas where nombre_tabla = '$f_idBaseDatos[nombre_tabla]'";   #|
		$e_ultima_hora_filtrada = pg_query($ultima_hora_filtrada);							                           #|
		$f_ultima_hora_filtrada = pg_fetch_assoc($e_ultima_hora_filtrada);											   #|
		$hora = $f_ultima_hora_filtrada['hora_actual'];	#en $hora se almacena la última hora filtrada				   #|
		#--------------------------------------------------------------------------------------------------------------#|

		#---------------------------------------------------------------------------------------------#
		// Se pretende crear la tabla central con las columnas que están en la estación consultada    #
		// por lo que vamos a consultar el nombre de esas columnas y consultar si son identificadas	  #
		// en la base de datos 																		  #
		#---------------------------------------------------------------------------------------------#

		if($numero > 0){ #Si el número de columnas que tiene la estación es mayor a 0 haga lo siguiente

				$i=0; #variable bandera inicializada en 0 para saber el número de columnas agregadas a la tabla central

					while ($fila = mysqli_fetch_array($ejecuto)){ #mientras hayan columnas para agregar haga

						//$bandera = 0;
						$field=$fila['Field'];

						if($field == 'fecha' || $field == 'hora'){
							if ($i == 0){
								$pg_tabla = "CREATE TABLE central( {$field} character varying )"; # Si no se han agregado antes columnas se crea la tabla con la primer columna
								$resultado_tabla = pg_query($pg_tabla);					
							}
							else
							{
								$add_registro = "ALTER TABLE central ADD COLUMN {$field} character varying"; # Si ya se han agregado antes columnas se actualiza la tabla con la columna
								$resultado_add_registro = pg_query($add_registro);
							}
							//$bandera = 1;
						}


						elseif($field == 'direccion_viento' || $field == 'nivel' || $field == 'presion_barometrica' || $field == 'radiacion_solar' || $field == 'Caudal' || $field == 'velocidad_viento' || $field == 'humedad_relativa' || $field == 'temperatura'){
					
							if ($i == 0){
								$pg_tabla = "CREATE TABLE central( {$field} character varying )"; # Si no se han agregado antes columnas se crea la tabla con la primer columna
								$resultado_tabla = pg_query($pg_tabla);
							}
							else
							{
								$add_registro = "ALTER TABLE central ADD COLUMN {$field} character varying";  # Si ya se han agregado antes columnas se actualiza la tabla con la columna
								$resultado_add_registro = pg_query($add_registro);
							}
							//$bandera = 1;
						}

						elseif($field == 'precipitacion_real'){
						
							if ($i == 0){
								$pg_tabla = "CREATE TABLE central( precipitacion character varying )"; # Si no se han agregado antes columnas se crea la tabla con la primer columna
								$resultado_tabla = pg_query($pg_tabla);
							}
							else
							{
								$add_registro = "ALTER TABLE central ADD COLUMN precipitacion character varying"; # Si ya se han agregado antes columnas se actualiza la tabla con la columna
								$resultado_add_registro = pg_query($add_registro);
							}
							//$bandera = 1;
						}

						elseif($field == 'evapotranspiracion_real' || $field == 'evapo_real'){
							
							if ($i == 0){
								$pg_tabla = "CREATE TABLE central( evapotranspiracion character varying )"; # Si no se han agregado antes columnas se crea la tabla con la primer columna
								$resultado_tabla = pg_query($pg_tabla);
							}
							else
							{
								$add_registro = "ALTER TABLE central ADD COLUMN evapotranspiracion character varying"; # Si ya se han agregado antes columnas se actualiza la tabla con la columna
								$resultado_add_registro = pg_query($add_registro);
							}
						//$bandera = 1;
						}


						elseif($field == 'direccion' || $field == 'presion' || $field == 'radiacion' || $field == 'caudal' || $field == 'velocidad' || $field == 'humedad' || $field == 'precipitacion_real'){
							$variableDexcel = "SELECT nombre from variable where varible_database = '$field'";
  							$e_variableDexcel = pg_query(($variableDexcel));
  							$fco = pg_fetch_array($e_variableDexcel);

							if ($i == 0){
								$pg_tabla = "CREATE TABLE central( {$fco['nombre']} character varying )";  # Si no se han agregado antes columnas se crea la tabla con la primer columna
								$resultado_tabla = pg_query($pg_tabla);
							}
							else
							{
								$add_registro = "ALTER TABLE central ADD COLUMN {$fco['nombre']} character varying"; # Si ya se han agregado antes columnas se actualiza la tabla con la columna
								$resultado_add_registro = pg_query($add_registro);
							}
					//$bandera = 1;
						}

					$i++;
				}


		}
		else{
			echo("LO SENTIMOS ! :( No recibimos ningún dato de la estación"); # Mensaje en caso de que no se lean columnas de la estación.
		}

	agregar_columnas(); # Se llama la función agregar columnas

	
	#--Se llama la función agregar() con los siguientes parámetros:---#
	// 1- nombre de la estación 									 //
	// 2- conexion                                                   //
	// 3- ultima fecha filtrada                                      //
	// 4- ultima hora filtrada                                       //
	# ----------------------------------------------------------------#
	agregar($f_idBaseDatos['nombre_tabla'],$dbr,$fecha,$hora);
	
	$estacion = $f_idBaseDatos['estacion'];
	//echo($estacion);
	//$u = "UPDATE central set precipitacion_real = '-' where registro = 10";
	//$pg = pg_query($u);
	$posicion = "SELECT estacion_sk from station_dim where estacion = '$estacion'";
	$r_posicion = pg_query($posicion);
	$v_posicion = pg_fetch_array($r_posicion);

	$parcial = $v_posicion['estacion_sk']; 
		
	inicial($estacion); // se llama la funcion inicial del archivo filtro_optimo que lo que hace es el proceso de filtrado
	//migrar_inicial($parcial);
	//calculo_entrantes();
	//insertar_errores();

	$consultoUfecha = "SELECT fecha from central order by registro desc limit 1";
	$e_UltimoRegistroFecha = pg_query($consultoUfecha);
	#LO GUARDO EN Arreglo-VARIABLE $nuevaFecha
	$nuevaFecha = pg_fetch_array($e_UltimoRegistroFecha);

	
	$ConsultoUhora = "SELECT hora from central order by registro desc limit 1";
	$e_UltimoRegistroHora = pg_query($ConsultoUhora);
	#LO GUARDO EN Arreglo-VARIABLE $nuevaFecha
	$nuevaHora = pg_fetch_array($e_UltimoRegistroHora);


	/*echo($f_idBaseDatos['nombre_tabla']);
	echo "<br>";
	echo($nuevaFecha['fecha']);
		echo "<br>";
	echo($nuevaHora['hora']);*/
	actualizar_fechaYhora($f_idBaseDatos['nombre_tabla'],$nuevaFecha['fecha'],$nuevaHora['hora']);

	//}
//}



function actualizar_fechaYhora($tabla,$Nfecha,$Nhora){
//echo($Nhora);
$updateFecha = "UPDATE tablas set dato_actual = '$Nfecha' where nombre_tabla = '$tabla'";
$e_update = pg_query($updateFecha);
$updateHora = "UPDATE tablas set hora_actual = '$Nhora' where nombre_tabla = '$tabla'";
$e_updateh = pg_query($updateHora);
#ACTUALIZO EL CAMPO DE DATO_ACTUAL EN LA TABLA TABLAS el registro $tabla CON EL VALOR de $Nfecha y $Nhora

}

# -----------------------------------------------------------------------------------------------#
// La función agregar_columnas() lo que hace es agregar a la tabla central de la bodega de datos //
// unas columnas que se ultilizan en el proceso, como fecha sk, tiempo sk, estacion sk registro  //
// y observaciones.																			     //
# -----------------------------------------------------------------------------------------------#
function agregar_columnas(){

	$add_registro = "ALTER TABLE central ADD COLUMN fecha_sk character varying";
	$resultado_add_registro = pg_query($add_registro);

	$add_registro = "ALTER TABLE central ADD COLUMN tiempo_sk character varying";
	$resultado_add_registro = pg_query($add_registro);

	$add_registro = "ALTER TABLE central ADD COLUMN estacion_sk character varying";
	$resultado_add_registro = pg_query($add_registro);

	$add_registro = "ALTER TABLE central ADD COLUMN registro serial";
	$resultado_add_registro = pg_query($add_registro);

	$add_observaciones = "ALTER TABLE central ADD COLUMN observaciones character varying";
	$resultado_add_registro = pg_query($add_observaciones);
}

# -----------------------------------------------------------------------------------------------#
// La función agregar lo que hace es agregar a la tabla central de la bodega de datos //
// unas columnas que se ultilizan en el proceso, como fecha sk, tiempo sk, estacion sk registro  //
// y observaciones.																			     //
# -----------------------------------------------------------------------------------------------#
function agregar($tabla,$dbr,$fecha_actual,$hora_actual){

# Muestra las columnas asociadas a la estación ----------------#
$cons = "SHOW COLUMNS from $tabla";			                   #
$ejecuto = mysqli_query($dbr,$cons);						   # 
$numero = mysqli_num_rows($ejecuto); #número total de columnas #
#--------------------------------------------------------------#

#Selecciona todas las fechas que son posteriores a la fecha del último campo evaluado --------------------------------#
# 
$recuperacionFecha = "SELECT fecha,hora from $tabla where hora > '$hora_actual' and fecha = '$fecha_actual' order by fecha, hora limit 100";
$e_recuperacionF = mysqli_query($dbr,$recuperacionFecha);
$n_recuperacionF = mysqli_num_rows($e_recuperacionF); #Número de fechas resultantes

$recuperacionFecha2 = "SELECT fecha,hora from $tabla where fecha > '$fecha_actual' order by fecha, hora limit 0";
$e_recuperacionF2 = mysqli_query($dbr,$recuperacionFecha2);
$n_recuperacionF2 = mysqli_num_rows($e_recuperacionF2); #Número de fechas resultantes


#----------------------------------------------------------------------------------------------------------------------#

while ($fechaYhora = mysqli_fetch_array($e_recuperacionF)){ #Mientras hayan columnas qué recorrer haga
	
	$comprueboEnCentral = "SELECT fecha,hora from central where fecha = '$fechaYhora[fecha]' and hora = '$fechaYhora[hora]'"; #!! Se toman las primeras 100 fechas en motivo de prueba
	$e_comprueboEnCentral = pg_query($comprueboEnCentral);
	$n_comprueboEnCentral = pg_num_rows($e_comprueboEnCentral); #Número de fechas resultantes

	//echo($n_comprueboEnCentral);
	if ($n_comprueboEnCentral == 0){
	$insertFechaYHora = "INSERT INTO central (fecha,hora) values ('$fechaYhora[fecha]','$fechaYhora[hora]')";
	$e_insertFechaYHora = pg_query($insertFechaYHora);
}
}

while ($fechaYhora2 = mysqli_fetch_array($e_recuperacionF2)){ #Mientras hayan columnas qué recorrer haga
	
	$comprueboEnCentral2 = "SELECT fecha,hora from central where fecha = '$fechaYhora2[fecha]' and hora = '$fechaYhora2[hora]'"; #!! Se toman las primeras 100 fechas en motivo de prueba
	$e_comprueboEnCentral2 = pg_query($comprueboEnCentral2);
	$n_comprueboEnCentral2 = pg_num_rows($e_comprueboEnCentral2); #Número de fechas resultantes

	
	if ($n_comprueboEnCentral2 == 0){
	$insertfechaYhora2 = "INSERT INTO central (fecha,hora) values ('$fechaYhora2[fecha]','$fechaYhora2[hora]')";
	$e_insertFechaYHora = pg_query($insertfechaYhora2);
}
}

while ($columna = mysqli_fetch_array($ejecuto)){ #Mientras hayan columnas qué recorrer haga
	$field=$columna['Field']; // si lee la columna

	$variableDexcel = "SELECT nombre from variable where varible_database = '$field'";
  	$e_variableDexcel = pg_query(($variableDexcel));
  	$nameOnCentral = pg_fetch_array($e_variableDexcel);

	if ($field != 'fecha' and $field != 'hora' and $nameOnCentral['nombre'] != null){
		//echo($field);
		//echo "<br>";
		$i=0;
			while($i<$n_recuperacionF){
				$j = $i+1;

				$fechayhoraPorRegistro = "SELECT fecha,hora from central where registro = $j";
				$e_fechayhoraPorRegistro = pg_query($fechayhoraPorRegistro);
				$f_fechayhoraPorRegistro = pg_fetch_array($e_fechayhoraPorRegistro);

				$SelectCamp = "SELECT $field from $tabla where fecha = '$f_fechayhoraPorRegistro[fecha]' and hora = '$f_fechayhoraPorRegistro[hora]'"; #selecciono el dato de la columna $field uno por uno con el limit y el offsset 
				$exe_Select_Camp = mysqli_query($dbr,$SelectCamp);
				$fetch_Select_Camp = mysqli_fetch_assoc($exe_Select_Camp);

				$UpdateCentral = "UPDATE central set $nameOnCentral[nombre] = '{$fetch_Select_Camp[$field]}' where fecha = '$f_fechayhoraPorRegistro[fecha]' and hora = '$f_fechayhoraPorRegistro[hora]'";
				$e_UpdateCentral = pg_query($UpdateCentral);

				$i++;

			}
		$k=$i;
			while($k < $n_recuperacionF + $n_recuperacionF2){
				$l = $k+1;

				$fechayhoraPorRegistro2 = "SELECT fecha,hora from central where registro = $l";
				$e_fechayhoraPorRegistro2 = pg_query($fechayhoraPorRegistro2);
				$f_fechayhoraPorRegistro2 = pg_fetch_array($e_fechayhoraPorRegistro2);

				$SelectCamp2 = "SELECT $field from $tabla where fecha = '$f_fechayhoraPorRegistro2[fecha]' and hora = '$f_fechayhoraPorRegistro2[hora]'"; #selecciono el dato de la columna $field uno por uno con el limit y el offsset 
				$exe_Select_Camp2 = mysqli_query($dbr,$SelectCamp2);
				$fetch_Select_Camp2 = mysqli_fetch_assoc($exe_Select_Camp2);

				$UpdateCentral2 = "UPDATE central set $nameOnCentral[nombre] = '{$fetch_Select_Camp2[$field]}' where fecha = '$f_fechayhoraPorRegistro2[fecha]' and hora = '$f_fechayhoraPorRegistro2[hora]'";
				$e_UpdateCentral2 = pg_query($UpdateCentral2);

				$k++;

			}
	
	}

}

}

# ------------------------------------------------------------------------------------------------------------------------#
// La funcion conectarse() permite la conexion con el servidor de datos de adquisicion, con 3 parametros, los siguientes://
// 1. el usuario de la basse de datos del servidor especificado internamente											 //
// 2. la contraseña de la base de enchant_dict_add_to_session(dict, word)												 //
// 3. el nombre de la base de datos 																					 //
#-------------------------------------------------------------------------------------------------------------------------#
function conectarse($usuario,$password,$bd)
{
	$servidor="172.23.177.60";

	$conectar = new mysqli($servidor,$usuario,$password,$bd) or die("No se pudo conectar al servidor de base de datos Mysql");
	return $conectar;
}




?>