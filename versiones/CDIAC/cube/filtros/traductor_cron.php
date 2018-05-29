<?php

require_once("filtro_optimo1_16.php"); // Se incluye el archivo de filtro
require_once("../conexion/conexiondwh.php"); //Se incluye la conexión con la bodega
require_once("migrarBD.php"); // Se incluyen las funciones de migración
require_once("confianza_datos.php");


 crear_central();
#SE BORRAN LOS DATOS QUE HAYAN EN LA TABLA CORRECCIONES -#|
$delete_correcciones = "delete from correcciones";       #|
$e_de_correcciones = pg_query($delete_correcciones);     #|
#--------------------------------------------------------#|

#Se agrega el encabezado en la tabla correcciones para lo que será el reporte de deteccion de errores ---
$encabezado = "INSERT into correcciones (fecha,hora,estacion,posicion,variable,valor_error,observacion_error, valor_corregido, tipo_correccion_aplicado) values ('fecha','hora','estacion','posicion_en_el_archivo','variable','valor_error','Obervacion Error', 'valor_corregido', 'tipo_correccion_aplicado')";
$r_encabezado = pg_query($encabezado);

$id_BaseDatos = "SELECT * from tablas where filtrada = 0 order by id_tabla limit 1";
$e_idBaseDatos = pg_query($id_BaseDatos);
$f_idBaseDatos = pg_fetch_array($e_idBaseDatos);

#SELECCIONA TODA LA INFORMACIÓN DE LA TABLA BASE DE DATOS SE ENCUENTRAN LOS DATOS DE CADA BASE DE DATOS
$consulta_bases = "SELECT * from basedatos where id_basedatos = $f_idBaseDatos[id_basedatos] and activa = 1 and filtrada = 0 "; #!! QUITAR EL OFFSET PARA TOMAR TODAS LAS BASES DE DATOS, acá solo toma la primera base para efectos de pruebas
$e_consulta_bases = pg_query($consulta_bases);
$f_consulta_bases = pg_fetch_array($e_consulta_bases);
#-----------------------------------------------------------------------------------------------------------------------------------------------------------------


#--------------------------------------------------------------------------------------------------------

	$usuario = $f_consulta_bases['usuario'];  // GUARDA EN $usuario EL USUARIO DE CADA BASE DE DATOS
	$password = $f_consulta_bases['contrasenia']; // GUARDA EN $password LA CONTRASEÑA DE CADA BASE DE DATOS
	$bd = $f_consulta_bases['nombrebasedatos']; // GUARDA EN $bd EL NOMBRE DE LA BASE DE DATOS DE CADA BASE DE DATOS

	$dbr = conectarse($usuario,$password,$bd); # establece conexión con el servidor de adquisición de datos

	#-----------------------------------------------------------------------------------------------------------------------------------

		$tabla = $f_idBaseDatos['nombre_tabla'];

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



########################################################################################
		obtener_datos($tabla,$dbr,$fecha,$hora);
########################################################################################

		$estacion = $f_idBaseDatos['estacion'];
		
		$posicion = "SELECT estacion_sk from station_dim where estacion = '$estacion'";
		$r_posicion = pg_query($posicion);
		$v_posicion = pg_fetch_array($r_posicion);

		$parcial = $v_posicion['estacion_sk']; 



  			inicial($estacion); // se llama la funcion inicial del archivo filtro_optimo que lo que hace es el proceso de filtrado
			migrar_inicial($parcial);
			calculo_entrantes();
			insertar_errores();
			actualizo_filtrada($f_idBaseDatos['id_tabla']);

			$consultoUfecha = "SELECT fecha from central order by registro desc limit 1";
			$e_UltimoRegistroFecha = pg_query($consultoUfecha);
			#LO GUARDO EN Arreglo-VARIABLE $nuevaFecha
			$nuevaFecha = pg_fetch_array($e_UltimoRegistroFecha);

			
			$ConsultoUhora = "SELECT hora from central order by registro desc limit 1";
			$e_UltimoRegistroHora = pg_query($ConsultoUhora);
			#LO GUARDO EN Arreglo-VARIABLE $nuevaFecha
			$nuevaHora = pg_fetch_array($e_UltimoRegistroHora);


			actualizar_fechaYhora($f_idBaseDatos['nombre_tabla'],$nuevaFecha['fecha'],$nuevaHora['hora']);

function actualizo_filtrada($tabla){
$upd_filtrada = "UPDATE tablas set filtrada = 1 where id_tabla = $tabla";
pg_query($upd_filtrada);
}

function actualizar_fechaYhora($tabla,$Nfecha,$Nhora){
		//echo($Nhora);
	if ($Nfecha != null and $tabla != null){
		$updateFecha = "UPDATE tablas set dato_actual = '$Nfecha' where nombre_tabla = '$tabla'";
		$e_update = pg_query($updateFecha);
	}
	if ($Nhora != null and $tabla != null){
		$updateHora = "UPDATE tablas set hora_actual = '$Nhora' where nombre_tabla = '$tabla'";
		$e_updateh = pg_query($updateHora);

		}
		#ACTUALIZO EL CAMPO DE DATO_ACTUAL EN LA TABLA TABLAS el registro $tabla CON EL VALOR de $Nfecha y $Nhora

}

	function conectarse($usuario,$password,$bd)
	{
	$servidor="172.23.177.60";

	$conectar = new mysqli($servidor,$usuario,$password,$bd) or die("No se pudo conectar al servidor de base de datos Mysql");
	return $conectar;
	}

		function crear_central(){
	
	// elimino la central anterior
	
	$delete_table = "DROP TABLE central";				#|
	$rdelete_table = @pg_query($delete_table);	

	// creo la tabla central

	$crear_central = "CREATE TABLE central
		(
		  fecha character varying,
		  hora character varying,
		  estacion_sk character varying,
		  fecha_sk character varying,
		  tiempo_sk character varying,
		  precipitacion character varying,
		  temperatura character varying,
		  brillo character varying,
		  humedad_relativa character varying,
		  nivel character varying,
		  caudal character varying,
		  velocidad_viento character varying,
		  direccion_viento character varying,
		  presion_barometrica character varying,
		  evapotranspiracion character varying,
		  radiacion_solar character varying,
		  registro serial NOT NULL,
		  observaciones character varying
		)
		WITH (
		  OIDS=FALSE
		);
		ALTER TABLE central
		  OWNER TO postgres;";
	$e_crear_central = pg_query($crear_central);	  

}

	function obtener_datos($tabla,$dbr,$fecha,$hora){


			// obtenemos las variables de una estacion dada 

			$variables = "SELECT nombre,varible_database from variable where tipologia = 'Clima'";
			$e_variables = pg_query($variables);

			$arreglo = "fecha, hora,";

			$arreglo_variables_db ="fecha, hora,";

			while ($f_variables = pg_fetch_assoc($e_variables)) {
				
				$var =$f_variables['nombre'];
				$var_db =$f_variables['varible_database'];

				// evaluacion de la existencia de las columnas en la tabla repositora

				$consu = "SELECT '$tabla' FROM INFORMATION_SCHEMA.COLUMNS AS columna where columna.column_name = '$var_db'";
				$e_consu = mysqli_query($dbr,$consu);
				$c_consu = mysqli_num_rows($e_consu);

				if ($c_consu != 0) {

					$arreglo .= "$var,";

					$arreglo_variables_db  .= "$var_db,";
				}
					
			}
			$arreglo[strlen($arreglo)-1] = ' ';

			$arreglo_variables_db[strlen($arreglo_variables_db)-1] = ' ';

			
			$consulta = "SELECT $arreglo_variables_db from $tabla where fecha = '$fecha'  and  hora > '$hora' order by fecha, hora"; 
			$e_consulta = mysqli_query($dbr,$consulta);
			$n_consuta = mysqli_num_rows($e_consulta);

			//echo($n_consuta);
			//echo "<br>";

			while ($f_consulta = mysqli_fetch_assoc($e_consulta)) { // es muy importante ejecutar con assoc y no con array

			$str = "insert into central (".$arreglo ;

			    $str[strlen($str)-1] = ')';
			    $str .= " values (";
			    reset($f_consulta);
			    while(list($name,$value) = each($f_consulta)) {  

			        if(is_string($value))
			            $str .= "'$value',";
			        else if (is_null($value))
			        	$str .= "'',";
			        else
			            $str .= "$value,";
			    }
			    $str[strlen($str)-1] = ')';
			    $str .= ";"    ;	

			    //echo($str);
			    //echo "<br>";
			    $ejecuto = pg_query($str);
				}

############################# senda parte del insert ##################


				// aqui se pondria el limit
			$consulta2 = "SELECT $arreglo_variables_db from $tabla where fecha > '$fecha' order by fecha, hora limit 1000"; 
			$e_consulta2 = mysqli_query($dbr,$consulta2);
			$n_consuta2 = mysqli_num_rows($e_consulta2);

			//echo($n_consuta2);
			//echo "<br>";

			while ($f_consulta2 = mysqli_fetch_assoc($e_consulta2)) { // es muy importante ejecutar con assoc y no con array

			$str2 = "insert into central (".$arreglo ;

			    $str2[strlen($str2)-1] = ')';
			    $str2 .= " values (";
			    reset($f_consulta2);
			    while(list($name2,$value2) = each($f_consulta2)) {  

			        if(is_string($value2))
			            $str2 .= "'$value2',";
			        else if (is_null($value2))
			        	$str2 .= "'',";
			        else
			            $str2 .= "$value2,";
			    }
			    $str2[strlen($str2)-1] = ')';
			    $str2 .= ";"    ;	

			    //echo($str2);
			    //echo "<br>";
			    $ejecuto2 = pg_query($str2);
				}

				//$elimino_inecesarias ="DELETE FROM central where hora <= '$hora' and fecha = '$fecha'";
				//$e_elimino_innecesarias = pg_query($elimino_inecesarias);
	}
?>

<!DOCTYPE html>
<html>
<body onload="myFunction()">

<script language="javascript">
function myFunction() {

	<?php
	$consultoNumeroDatos = "SELECT count (estacion_sk) as cantidad from central where estacion_sk = $parcial";
	$e_conteo = pg_query($consultoNumeroDatos);
	$f_conteo = pg_fetch_array($e_conteo);
	$cantidadSubidos = (double)$f_conteo['cantidad'];

	if ($cantidadSubidos > 100){
		echo($cantidadSubidos);
	?>
	location.reload();
	<?php
}
	?>
    
}
</script>

</body>
</html>