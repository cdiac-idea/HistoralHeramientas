<?php 
pg_connect ("user = postgres password=%froac$ port=5432 dbname= idea_dwh_db_pruebascube host=froac.manizales.unal.edu.co");

leer_encabezado();


 function comparacion($encabezado, $i){

 
 if ($encabezado == 'fecha'){
 	leer_columna($i,'fecha');
 	 	
 }
 elseif($encabezado == 'hora'){
    leer_columna($i,'hora');
 }
 elseif ($encabezado == 'precipitacion' ||  $encabezado == ' Precipitacion(mm) ') {
 	leer_columna($i,'precipitacion');
 }
 elseif ($encabezado == 'temperatura' || $encabezado == ' Temperatura(ºC) ') {
 	leer_columna($i,'temperatura');
 }
 elseif ($encabezado == 'brillo') {
 	leer_columna($i,'brillo');
 }
 elseif ($encabezado == 'humedad_relativa' || $encabezado == ' Humedad(%) ') {
 	leer_columna($i,'humedad_relativa');
 }
 elseif ($encabezado == 'nivel' || $encabezado == 'Nivel (m)') {
 	leer_columna($i,'nivel');
 }
 elseif ($encabezado == 'caudal' || $encabezado == 'Caudal (l/s)') {
 	leer_columna($i,'caudal');
 }
 elseif ($encabezado == 'velocidad_viento' || $encabezado == ' Velocidad(m/s) ') {
 	leer_columna($i,'velocidad_viento');
 }
 elseif ($encabezado == 'direccion_viento' || $encabezado == ' Direccion(º) ')  {
 	leer_columna($i,'direccion_viento');
 }
 elseif ($encabezado == 'presion_barometrica' || $encabezado == ' Presion(mmHg) ') {
 	leer_columna($i,'presion_barometrica');
 }
 elseif ($encabezado == 'evapotranspiracion' || $encabezado == ' Evapotranspiracion(mm) ') {
 	leer_columna($i,'evapotranspiracion');
 }
  elseif ($encabezado == 'radiacion_solar' || $encabezado == ' Radiacion(W/m^2) ') {
 	leer_columna($i,'radiacion_solar');
 }


}

#----------------------------------------------------------------------------------------


#----------------------------------------------------------------------------------------



function leer_columna($i,$variable){
	
$fp = fopen ( "archivos prueba/estacion_otra.csv" , "r" ); 


$t = 0;


while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) { // Mientras hay líneas que leer...


if($i == 0){
	$insercion="INSERT into central ($variable) values ('{$data[$i]}')";
	$ejecucionInsercion = pg_query($insercion);
}
elseif ($i==1) {                                 # ACAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
$regist = "SELECT registro from central limit 1 offset $t" ;
$ejecuto = pg_query($regist);
$uno = "SELECT registro FROM central ";
	$e_uno = pg_query($uno);
	$f_uno = pg_fetch_array($e_uno);
	$ar = $f_uno['registro'];
	echo($ar);
	echo "<br>";

$actualizacion = "UPDATE central set $variable = '{$data[$i]}' where registro = $ar";
$ejecucion = pg_query($actualizacion);
}

// Muestra todos los campos de la fila actual 
# INSERTA EN TABLA CENTRAL
$t++;
}
return ($data[$i]);

echo "<br><br>";
 

fclose ( $fp ); 
}


## si se desea conocer el encabezado

function leer_encabezado(){

$fp = fopen ( "archivos prueba/estacion_otra.csv" , "r" ); 
$data = fgetcsv ( $fp , 1000 , ";" );
$numero = count($data);
for ($i=0; $i < $numero;$i++){
	
	comparacion($data[$i], $i);
}

fclose ( $fp ); 
}
?>