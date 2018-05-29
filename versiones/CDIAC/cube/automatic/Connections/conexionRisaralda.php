<?php
#CONEXION A LA BODEGA DE DATOS
require_once("conexiondwh.php");


#SE BORRAN LOS DATOS QUE HAYAN EN LA TABLA CENTRAL Y LA TABLA CORRECCIONES##########
$delete_table = "DROP TABLE central";
$rdelete_table = @pg_query($delete_table);


$delete_correcciones = "delete from correcciones";
$e_de_correcciones = pg_query($delete_correcciones);
/*if($e_de_correcciones){
	echo "si";
}*/

$encabezado = "INSERT into correcciones (fecha,hora,estacion,posicion,variable,valor_error,observacion_error, valor_corregido, tipo_correccion_aplicado) values ('fecha','hora','estacion','posicion_en_el_archivo','variable','valor_error','Obervacion Error', 'valor_corregido', 'tipo_correccion_aplicado')";
$r_encabezado = pg_query($encabezado);
/*if($r_encabezado){
	echo "si";
}*/
############


#SELECCIONA TODA LA INFORMACIÓN DE LA TABLA BASE DE DATOS SE ENCUENTRAN LOS DATOS DE CADA BASE DE DATOS
$consulta_bases = "SELECT * from basedatos limit 1";
$e_consulta_bases = pg_query($consulta_bases);

#RECORRE CADA BASE DE DATOSS
while($f_consulta_bases = pg_fetch_array($e_consulta_bases)){

	$usuario = $f_consulta_bases['usuario'];  // GUARDA EN $usuario EL USUARIO DE CADA BASE DE DATOS
	$password = $f_consulta_bases['contrasenia']; // GUARDA EN $password LA CONTRASEÑA DE CADA BASE DE DATOS
	$bd = $f_consulta_bases['nombrebasedatos']; // GUARDA EN $bd EL NOMBRE DE LA BASE DE DATOS DE CADA BASE DE DATOS

	$dbr = conectarse($usuario,$password,$bd);

	$con_tablas = "SELECT * from tablas where id_basedatos = $f_consulta_bases[id_basedatos] and dato_actual != '' and hora_actual != '' limit 1"; //OBTENGO RISARALDA
	$e_con_tablas = pg_query($con_tablas);
	
	while ($f_con_tablas = pg_fetch_array($e_con_tablas)) {

		$variables = "SELECT distinct (varible_database) from variable ";
		$e_variables = pg_query($variables);

		$variablesN = "SELECT distinct (nombre) from variable ";
		$e_variablesN = pg_query($variablesN);

		$cons = "SHOW COLUMNS from $f_con_tablas[nombre_tabla]";
		$ejecuto = mysqli_query($dbr,$cons);
		$numero = mysqli_num_rows($ejecuto);

		#RECUPERO LA ULTIMA FECHA FILTRADA
		echo($f_con_tablas['nombre_tabla']);
		$ultima_fecha_filtrada = "SELECT dato_actual from tablas where nombre_tabla = '$f_con_tablas[nombre_tabla]'";
		$e_ultima_fecha_filtrada = pg_query($ultima_fecha_filtrada);
		$f_ultima_fecha_filtrada = pg_fetch_array($e_ultima_fecha_filtrada);

		#RECUPERO LA ULTIMA HORA FILTRADA
		$ultima_hora_filtrada = "SELECT hora_actual from tablas where nombre_tabla = '$f_con_tablas[nombre_tabla]'";
		$e_ultima_hora_filtrada = pg_query($ultima_hora_filtrada);
		$f_ultima_hora_filtrada = pg_fetch_assoc($e_ultima_hora_filtrada);

		$fecha = $f_ultima_fecha_filtrada['dato_actual'];
		echo($fecha);
		echo "<br>";
		$hora = $f_ultima_hora_filtrada['hora_actual'];
		echo($hora);


		if($numero > 0){
				$i=0;

				
					while ($fila = mysqli_fetch_array($ejecuto) and $i < $numero){

					$bandera = 0;
					$field=$fila['Field'];
					echo($field);
					echo "<br>";


					if($field == 'fecha' || $field == 'hora'){
						echo("si");
					if ($i == 0){

						$pg_tabla = "CREATE TABLE central( {$field} character varying )";
						$resultado_tabla = pg_query($pg_tabla);

					
					}
	
					else
					{
						$add_registro = "ALTER TABLE central ADD COLUMN {$field} character varying";
						$resultado_add_registro = pg_query($add_registro);						
					}

					$bandera = 1;

					}


					elseif($field == 'evapotranspiracion_real' || $field == 'direccion_viento' || $field == 'nivel' || $field == 'presion_barometrica' || $field == 'radiacion_solar' || $field == 'Caudal' || $field == 'velocidad_viento' || $field == 'humedad_relativa' || $field == 'precipitacion_real' || $field == 'temperatura'){
						echo("si");
					if ($i == 0){

						$pg_tabla = "CREATE TABLE central( {$field} character varying )";
						$resultado_tabla = pg_query($pg_tabla);
					}
	
					else
					{
						$add_registro = "ALTER TABLE central ADD COLUMN {$field} character varying";
						$resultado_add_registro = pg_query($add_registro);
						
					}
					$bandera = 1;

					}


					elseif($field == 'evapo_real' || $field == 'direccion' || $field == 'presion' || $field == 'radiacion' || $field == 'caudal' || $field == 'velocidad' || $field == 'humedad' || $field == 'precipitacion_real'){
						$variableDexcel = "SELECT nombre from variable where varible_database = '$field'";
  						$e_variableDexcel = pg_query(($variableDexcel));
  						$fco = pg_fetch_array($e_variableDexcel);

					if ($i == 0){

						$pg_tabla = "CREATE TABLE central( {$fco['nombre']} character varying )";
						$resultado_tabla = pg_query($pg_tabla);
					}
	
					else
					{
						$add_registro = "ALTER TABLE central ADD COLUMN {$fco['nombre']} character varying";
						$resultado_add_registro = pg_query($add_registro);
						
					}
					$bandera = 1;

					}

					$i++;
				}


		}
		else{
			echo("LO SENTIMOS ESA TABLA ESTA VACIA NO TIENE COLUMNAS");
		}

	agregar_columnas();
	
	agregar($f_con_tablas['nombre_tabla'],$dbr,$f_ultima_fecha_filtrada['dato_actual'],$f_ultima_hora_filtrada['hora_actual']);

	}

}





function conectarse($usuario,$password,$bd)
{
	$servidor="172.23.177.60";

	$conectar = new mysqli($servidor,$usuario,$password,$bd) or die("No se pudo conectar al servidor de base de datos Mysql");
	return $conectar;
}


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

function agregar($tabla,$dbr,$fecha_actual,$hora_actual){

$cons = "SHOW COLUMNS from $tabla";
		$ejecuto = mysqli_query($dbr,$cons);
		$numero = mysqli_num_rows($ejecuto);

		$recuperacionFecha = "SELECT fecha from $tabla where fecha >= '$fecha_actual' and hora > '$hora_actual' limit 100";
					$e_recuperacionF = mysqli_query($dbr,$recuperacionFecha);
					$n_recuperacionF = mysqli_num_rows($e_recuperacionF);
					
					//echo($n_recuperacionF);
											// HASTA ACÁ LEE 100
					


						
					  // HASTA ACÁ FUNCIONA EL $I Y EL $J
						while ($fila = mysqli_fetch_array($ejecuto)){
							$field=$fila['Field']; // si lee la columna
							echo "<br>";
						echo ($field);
							$i=0;
							
							while($i<$n_recuperacionF){
							$j = $i+1;
						#selecciono el dato de la columna $field con limit 1 y offset $i
						$SelectDate = "SELECT $field from $tabla where fecha >= '$fecha_actual' and hora > '$hora_actual' limit 1 offset $i";
						$exe_Select_Date = mysqli_query($dbr,$SelectDate);
						$fetch_Select_Date = mysqli_fetch_assoc($exe_Select_Date);
						echo "<br>";
						echo ($fetch_Select_Date[$field]);
						# y pregunto si en la tabla central existe registro con numero $i .
						$ExistInCentral = "SELECT * from central where registro = $j";
						$exe_ExistInCentral = pg_query($ExistInCentral);
						$fetch_Exist = pg_fetch_array($exe_ExistInCentral);
						$RowsInCentral = pg_num_rows($exe_ExistInCentral);
						echo "<br>";
						echo ($fetch_Exist['registro']);
						$variableDexcel = "SELECT nombre from variable where varible_database = '$field'";
  						$e_variableDexcel = pg_query(($variableDexcel));
  						$nameOnCentral = pg_fetch_array($e_variableDexcel);
  						
						# si no existe, se aplica insertar, si existe entonces se actualiza donde fecha es igual a (select fecha en la posicion $i);
						if($RowsInCentral != 0){

							if($nameOnCentral['nombre']){
								echo "existe fecha";
									#UPDATE en central donde el nombre de la columna es igual a $nameOnCentral
							
									$updateRow = "UPDATE central set $nameOnCentral[nombre] = '{$fetch_Select_Date[$field]}' where registro = $j";
									$Exe_updateRow = pg_query($updateRow);
							
							}
							else{
								if($field == 'fecha'){
								$updateRow = "UPDATE central set fecha = '{$fetch_Select_Date[$field]}' where registro = $j";
									$Exe_updateRow = pg_query($updateRow);
								}
								elseif($field == 'hora'){
								$updateRow = "UPDATE central set hora = '{$fetch_Select_Date[$field]}' where registro = $j";
									$Exe_updateRow = pg_query($updateRow);
								}

							}
						
						}
						else{
							echo "INSERTÓ";
							#INSERT en central donde el nombre de la columna es igual a $nameOnCentral
							$InsertRow = " INSERT INTO central ($field) values ('{$fetch_Select_Date[$field]}')";
									$Exe_insertRow = pg_query($InsertRow);
						}
						#
						$i++;
					}
					
					}


}







?>