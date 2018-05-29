<?php
require_once("conexiondwh.php");

//actualizo_tablas_variables.php

//$Dw = "DELETE from variables where variables = 'radiacion_solar' and estacion_sk = 30";
//$e = pg_query($Dw);

/*
  $consulta_variables="SELECT variables from variables where estacion_sk = 1 order by variables "; #se consulta para obtener el número de variable de una estación
  $res_variables = pg_query($consulta_variables);

  while ($fetch_variables = pg_fetch_array($res_variables)){ 
  	echo($fetch_variables['variables']);
  	echo "<br>";
  }
*/
//$variables_velocidad ="INSERT INTO variables values (2,'Camping La Palmera - Río Risaralda','velocidad_viento', null, null, null, default, ' Velocidad(m/s) ', null)";
//pg_query($variables_velocidad);
//$variables_direccion ="INSERT INTO variables values (2,'Camping La Palmera - Río Risaralda','direccion_viento', null, null, null, default, ' Direccion(º) ', null)";
//pg_query($variables_direccion);
//$variables_presion ="INSERT INTO variables values (30,'Quebrada San Luis - Ruta 30','presion_barometrica', null, null, null, default, ' Presion(mmHg) ', 'promedio')";
//pg_query($variables_presion);
//$variables_humedad ="INSERT INTO variables values (16,'Salamina - CHEC','humedad_relativa', null, null, null, default, '_Humedad(%)', 'promedio')";
//pg_query($variables_humedad);
//$variables_radiacion ="INSERT INTO variables values (30,'Quebrada San Luis - Ruta 30','radiacion_solar', null, null, null, default, ' Radiacion(W/m^2) ', 'promedio')";
//pg_query($variables_radiacion);
$variables_velocidad ="UPDATE variables set estacion_sk = 32 , estacion = 'Cisne - Santa Isabel' where id_variable_estacion = 343 ";
pg_query($variables_velocidad);
/*
$variables_nivel0 ="INSERT INTO variables values (36,'Río Rioclaro','radiacion_solar', null, null, null, default, ' Radiacion(W/m^2) ', null)";
pg_query($variables_nivel0);
$variables_caudal1 ="INSERT INTO variables values (36,'Río Rioclaro','precipitacion', 0, null, null, default, ' Precipitacion(mm) ', null)";
pg_query($variables_caudal1);
$variables_nivel2 ="INSERT INTO variables values (36,'Río Rioclaro','temperatura', 8, 20, 5, default, ' Temperatura(ºC) ', null)";
pg_query($variables_nivel2);
$variables_caudal3 ="INSERT INTO variables values (36,'Río Rioclaro','nivel', null, null, null, default, 'Nivel (m)', null)";
pg_query($variables_caudal3);
$variables_nivel4 ="INSERT INTO variables values (36,'Río Rioclaro','caudal', null, null, null, default, 'Caudal (l/s)', null)";
pg_query($variables_nivel4);
$variables_caudal5 ="INSERT INTO variables values (36,'Río Rioclaro','humedad_relativa', null, null, null, default, '_Humedad(%)', null)";
pg_query($variables_caudal5);
$variables_nivel6 ="INSERT INTO variables values (36,'Río Rioclaro','velocidad_viento', null, null, null, default, ' Velocidad(m/s) ', null)";
pg_query($variables_nivel6);
$variables_caudal7 ="INSERT INTO variables values (36,'Río Rioclaro','direccion_viento', null, null, null, default, ' Direccion(º) ', null)";
pg_query($variables_caudal7);
$variables_nivel8 ="INSERT INTO variables values (36,'Río Rioclaro','presion_barometrica', null, null, null, default, ' Presion(mmHg) ', null)";
pg_query($variables_nivel8);
$variables_caudal9 ="INSERT INTO variables values (36,'Río Rioclaro','evapotranspiracion', null, null, null, default, ' Evapotranspiracion(mm) ', null)";
pg_query($variables_caudal9);

*/
/*$variables_evapotrans ="INSERT INTO variables values (30,'Río Pensilvania - Microcentral','evapotranspiracion', null, null, null, default, ' Evapotranspiracion(mm) ', 'dato_anterior')";
pg_query($variables_evapotrans);*/
//$variables_evapotrans ="UPDATE variables set variable_excel = ' Evapotranspiracion(mm) ' where estacion_sk = 2";
//pg_query($variables_evapotrans);



/*$tablas_variable1 = "INSERT INTO tablasxvariable values (default,1,167)";
pg_query($tablas_variable1);
$tablas_variable2 = "INSERT INTO tablasxvariable values (default,1,164)";
pg_query($tablas_variable2);

$esta_var = "INSERT INTO esta_var values (default,1,168,null)";
pg_query($esta_var);*/



?>