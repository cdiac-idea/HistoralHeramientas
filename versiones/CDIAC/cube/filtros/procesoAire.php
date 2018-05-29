<?php
require_once("tiempo_sk.php"); # Se incluye el archivo tiempo_sk
require_once("fecha_sk.php"); # Se incluye el archivo fecha_sk

//CONEXIÓN CON LA BODEGA DE DATOS
// ##################################################################################################################
//if (!$pg_servidor = @pg_connect (" user = postgres password=%froac$ port=5432 dbname=idea_dwh_db_pruebascube host=froac.manizales.unal.edu.co"))

if (!$pg_servidor = @pg_connect (" user = postgres password=%froac$ port=5432 dbname=idea_dwh_db_pruebascube host=froac.manizales.unal.edu.co"))
{  
  header("Location: ../index.php/mensaje_error_conexion");
}
// ##################################################################################################################


# ------------------------------------------------------------------------------------------------#
//La funcion inicial recibe como parametro la estacion preteneciente a los datos a evaluar,
// esta función es casi que la más importante en el proceso de la filtración porque 
// contiene el procedimiento centralaire que evalúa los datos, los detecta los corrige y llama a los
// datos a ser migrados.
# ------------------------------------------------------------------------------------------------#
function inicial($estacion){

$alguno = variablesppb();

borrar_datos_informativos(); 

$valor_maximo = "SELECT registro from centralaire"; # se consulta el total de registros de la tabla centralaire
$r_valor_maximo = pg_query($valor_maximo);
$cantidad_maxima = pg_num_rows($r_valor_maximo);


  ########## SE INSERTA ESTACION_SK ####################################################

$posicion = "SELECT estacion_sk from station_dim where estacion = '$estacion'"; # Se recupera el identificador de la estación llamado estacion_sl
$r_posicion = pg_query($posicion);
$v_posicion = pg_fetch_array($r_posicion);

$estacion_sk = $v_posicion['estacion_sk'];   # el identificador se almacena en la variable $estacion_sk

$estacion_sk_a_centralaire = "UPDATE centralaire set estacion_sk = $estacion_sk"; # se actualiza la tabla centralaire con la estacion_sk
$ejecuto_agregamos = pg_query($estacion_sk_a_centralaire);

  ########## SE INSERTA FECHA_SK ####################################################
     $cantidad_fechas_distintas = "SELECT DISTINCT fecha FROM centralaire order by fecha"; # se obtiene el total de fechas diferentes
    $e_cant_fech_dist = pg_query($cantidad_fechas_distintas);
    
    while($a_cant_fech_dist = pg_fetch_array($e_cant_fech_dist)){
      $c_fecha_pos = $a_cant_fech_dist["fecha"];
      $fecha_sk = obtener_fecha_sk_aire($c_fecha_pos); # se invoca la función obtener_fecha_sk() que está en fecha_sk.php y esta retorna la fecha_sk de la fecha consultada
      
      if($fecha_sk == 0 or $fecha_sk == null){

          $fecha_sk = obtener_fecha_sk_arch($c_fecha_pos); # se invoca la función obtener_fecha_sk() que está en fecha_sk.php y esta retorna la fecha_sk de la fecha consultada
          
          if($fecha_sk == 0 or $fecha_sk == null){
            $fecha_sk = obtener_fecha_sk($c_fecha_pos);

             
            $actualizar = "UPDATE centralaire SET fecha_sk = '$fecha_sk' where fecha = '$c_fecha_pos'"; # se actualiza el campo de fecha_sk de la tabla central
            $e_fecha_pos = pg_query($actualizar);
          }
          else{
            $actualizar = "UPDATE centralaire SET fecha_sk = '$fecha_sk' where fecha = '$c_fecha_pos'"; # se actualiza el campo de fecha_sk de la tabla central
            $e_fecha_pos = pg_query($actualizar);
          }
      }
      else {
        
          $actualizarfecha = "UPDATE centralaire SET fecha_sk = '$fecha_sk' where fecha = '$c_fecha_pos'"; # se actualiza el campo de fecha_sk de la tabla central
          $e_fecha_pos = pg_query($actualizarfecha);
        }
    }

######## SE CORRIGEN LOS 24:00:00 ############################################################

    convertir_24_a_0();
#FULL#
######## SE INSERTA TIEMPO_SK ##############################################################

    $cantidad_hora_distintas = "SELECT DISTINCT hora FROM centralaire order by hora"; # se obtiene el total de horas diferentes
    $e_cant_hora_dist = pg_query($cantidad_hora_distintas);

    while($a_cant_hora_dist = pg_fetch_array($e_cant_hora_dist)){
      $c_hora_pos = $a_cant_hora_dist["hora"];

      $tiempo_sk = obtener_tiempo_sk($c_hora_pos);# se invoca la función obtener_tiempo_sk() que está en tiempo_sk.php y esta retorna el tiempo_sk de la hora consultada
     

      $actualizar2 = "UPDATE centralaire SET tiempo_sk = '$tiempo_sk' where hora = '$c_hora_pos'"; # se actualiza el campo de tiempo_sk de la tabla central
      $e_hora_pos = pg_query($actualizar2);
    }

    $consulta_variables="SELECT variables from variables where estacion_sk = $estacion_sk order by variables "; #se consulta para obtener el número de variable de una estación
    $res_variables = pg_query($consulta_variables);  

    while ($fetch_variables = pg_fetch_array($res_variables)){ # Mientras recorre las variables haga
        $nombre_variable = $fetch_variables['variables']; # en $nombre_variable se almacena el nombre de la variable

        # Valor minimo
    $minimo="SELECT minimo from variables where estacion_sk = $estacion_sk and variables = '$nombre_variable' order by variables"; # Se identifica el valor mínimo permitido para esa variable en esa estación
    $r_minimo = pg_query($minimo); 
    $v_minimo = pg_fetch_array($r_minimo);

    $p_minimo = $v_minimo['minimo']; # el valor mínimo se almacena en la variable $p_minimo

    
      # Valor maximo 
    $maximo="SELECT maximo from variables where estacion_sk = $estacion_sk and variables = '$nombre_variable' order by variables"; # Se identifica el valor máximo permitido para esa variable en esa estación
    $r_maximo = pg_query($maximo); 
    $v_maximo = pg_fetch_array($r_maximo);

    $p_maximo = $v_maximo['maximo']; # el valor máximo se almacena en la variable $p_maximo

      #variacion
    $diferencia="SELECT diferencia_anterior from variables where estacion_sk = $estacion_sk and variables = '$nombre_variable' order by variables"; # Se identifica el valor de variación maximo permitido para esa variable en esa estación
    $r_diferencia = pg_query($diferencia); 
    $v_diferencia = pg_fetch_array($r_diferencia); 

    $p_diferencia = $v_diferencia['diferencia_anterior'];  # la diferencia máxmima permitida se almacena en la variable $p_diferencia

      #tipo correccion
    $consulta_correccion="SELECT tipo_correccion from variables where estacion_sk = $estacion_sk and variables = '$nombre_variable' order by variables"; # Se identifica el tipo de corrección que se le debe aplicar a esa variable en esa estación
    $resultado_correcion = pg_query($consulta_correccion);
    $row_correccion = pg_fetch_array($resultado_correcion);  

    $tipo_correccion = $row_correccion['tipo_correccion']; # el tipo de correccion para la variable en esa estacion se almacena en la variable $tipo_correccion


    #######################################################
   
    deteccion($estacion, $estacion_sk, $nombre_variable, $p_minimo, $p_maximo, $tipo_correccion, $p_diferencia);

    #######################################################
    }


    conversion_de_tipo($alguno);


  }




function convertir_24_a_0(){

$fecha = "SELECT fecha,registro from centralaire where hora = '24:00:00'";
$e_fecha = pg_query($fecha);

while ($f_fecha = pg_fetch_array($e_fecha)) {

  $registro = $f_fecha['registro'];
  $fecha_sk = obtener_fecha_sk_arch($f_fecha['fecha']);
  $fecha_sk_actual = ((double)$fecha_sk) + 1;

  $porcion = "SELECT * from date_dim where fecha_sk = '$fecha_sk_actual'";
  $e_porcion = pg_query($porcion);
  $f_porcion = pg_fetch_array($e_porcion);
  if ($f_porcion['dia'] < 10 ){
    $dia = "0".$f_porcion['dia'];
  }
  else{
  $dia = $f_porcion['dia'];
  }

  if ($f_porcion['mes'] < 10 ){
    $mes = "0".$f_porcion['mes'];
  }
  else{
  $mes = $f_porcion['mes'];
  }
  $anio = $f_porcion['año'];
  $cadenaFecha = $dia."/".$mes."/".$anio;
  

$_24 = "UPDATE centralaire set tiempo_sk = (select tiempo_sk from time_dim where tiempo = '00:00:00'), fecha_sk = '$fecha_sk_actual', fecha = '$cadenaFecha', hora = '00:00:00' where registro = '$registro'";
$e_24 = pg_query($_24);
}

}


function deteccion($estacion, $estacion_sk, $nombre_variable, $p_minimo, $p_maximo, $tipo_correccion, $p_diferencia){

 $minimoYmaximo = "SELECT minimo, maximo from variables where variables = '$nombre_variable'";
 $e_minimoYmaximo = pg_query($minimoYmaximo);
 $f_minimoYmaximo = pg_fetch_array($e_minimoYmaximo);
 $minimo = $f_minimoYmaximo['minimo'];
 $maximo = $f_minimoYmaximo['maximo'];


  if($nombre_variable == 'so2' || $nombre_variable == 'SO2' || $nombre_variable == 'o3' || $nombre_variable == 'O3'){

  $span = "SELECT fecha, hora, fecha_sk, tiempo_sk,registro from centralaire where $nombre_variable = 'Span'";
    $e_span = pg_query($span);
    $sk_de_las_once = "SELECT tiempo_sk from time_dim where tiempo = '23:00:00'";
    $e_sk_de_las_once = pg_query($sk_de_las_once);
    $f_sk_de_las_once = pg_fetch_array($e_sk_de_las_once);
    

    while ($f_span = pg_fetch_array($e_span)) {

      
      $tiempo_enNumero = (double)$f_span['tiempo_sk'];
      $fecha_enNumero = (double)$f_span['fecha_sk'];
      
        # Borrar datos de una hora despues teniendo como parametros la fecha y la hora, Y  también borrar dato SPAN
      if ($tiempo_enNumero < $f_sk_de_las_once['tiempo_sk']){ #82801 tiempo_sk de 11 de la noche (23:00:00)
       
        $tope = $tiempo_enNumero+3600;


        $entre_span = "SELECT * from centralaire where fecha_sk = '$f_span[fecha_sk]' and tiempo_sk IN (SELECT tiempo_sk from centralaire where CAST(tiempo_sk AS float) > $tiempo_enNumero and CAST(tiempo_sk AS float) <= $tope)";
        $e_entre_span = pg_query($entre_span);

        while($f_entre_span = pg_fetch_array($e_entre_span)){

          #Reporto en correcciones el error ::::::
          $ingresoCorrecciones = "INSERT INTO correcciones (fecha, hora, estacion, posicion, variable, valor_error, observacion_error, valor_corregido, tipo_correccion_aplicado, estacion_sk, fecha_sk, tiempo_sk) values ('$f_entre_span[fecha]','$f_entre_span[hora]','$estacion', '$f_entre_span[registro]','SO2, O3, CO', 'Dentro de hora de Span', 'Estabilizando', 'Datos medidos eliminados', 'Ninguno', '$estacion_sk', '$f_entre_span[fecha_sk]', '$f_entre_span[tiempo_sk]')";
          pg_query($ingresoCorrecciones);
          #::::::::::::::::::::::::::::::::::::::


          $borro_datos_mayor_A_Hora = "DELETE from centralaire where registro = '$f_entre_span[registro]'";
          pg_query($borro_datos_mayor_A_Hora);
       }
      }
      else{


      $nueva_fecha = (double)$f_span['fecha_sk']+1;
      $fecha_nueva_enNumero = (double)$nueva_fecha;
        $base = $tiempo_enNumero-82800;


        $entre_span2 = "SELECT * from centralaire where fecha_sk = '$f_span[fecha_sk]' and tiempo_sk IN (SELECT tiempo_sk from centralaire where CAST(fecha_sk AS float) = $fecha_enNumero and CAST(tiempo_sk AS float) > $tiempo_enNumero)";
        $e_entre_span2 = pg_query($entre_span2);

         while($f_entre_span2 = pg_fetch_array($e_entre_span2)){

          #Reporto en correcciones el error ::::::
          $ingresoCorrecciones2 = "INSERT INTO correcciones (fecha, hora, estacion, posicion, variable, valor_error, observacion_error, valor_corregido, tipo_correccion_aplicado, estacion_sk, fecha_sk, tiempo_sk) values ('$f_entre_span2[fecha]','$f_entre_span2[hora]','$estacion', '$f_entre_span2[registro]','SO2, O3, CO', 'Dentro de hora de Span', 'Estabilizando', 'Datos medidos eliminados', 'Ninguno', '$estacion_sk', '$f_entre_span2[fecha_sk]', '$f_entre_span2[tiempo_sk]')";
          pg_query($ingresoCorrecciones2);
          #::::::::::::::::::::::::::::::::::::::

          $borro_datos_mayor_A_Hora = "DELETE from centralaire where registro = '$f_entre_span2[registro]'";
          pg_query($borro_datos_mayor_A_Hora);

       }

        $entre_span3 = "SELECT * from centralaire where fecha_sk = '$nueva_fecha' and tiempo_sk IN (SELECT tiempo_sk from centralaire where CAST(fecha_sk AS float) = $nueva_fecha and CAST(tiempo_sk AS float) <= $base)";
        $e_entre_span3 = pg_query($entre_span3);

         while($f_entre_span3 = pg_fetch_array($e_entre_span3)){

          #Reporto en correcciones el error ::::::
          $ingresoCorrecciones3 = "INSERT INTO correcciones (fecha, hora, estacion, posicion, variable, valor_error, observacion_error, valor_corregido, tipo_correccion_aplicado, estacion_sk, fecha_sk, tiempo_sk) values ('$f_entre_span3[fecha]','$f_entre_span3[hora]','$estacion', '$f_entre_span3[registro]','SO2, O3, CO', 'Dentro de hora de Span', 'Estabilizando', 'Datos medidos eliminados', 'Ninguno', '$estacion_sk', '$f_entre_span3[fecha_sk]', '$f_entre_span3[tiempo_sk]')";
          pg_query($ingresoCorrecciones3);
          #::::::::::::::::::::::::::::::::::::::

          $borro_datos_mayor_A_Hora = "DELETE from centralaire where registro = '$f_entre_span3[registro]'";
          pg_query($borro_datos_mayor_A_Hora);

     
       }

      }

    }
  }
  if ($nombre_variable != 'pm10' and $nombre_variable != 'PM10' and $nombre_variable != 'pm2_5' and $nombre_variable != 'PM2_5'){
  
   $errores = "SELECT registro, $nombre_variable, fecha, hora, fecha_sk, tiempo_sk from centralaire where $nombre_variable = 'Samp<' or $nombre_variable = 'InVld' or $nombre_variable = 'RS232' or $nombre_variable = 'OffScan' or $nombre_variable = 'Zero' or $nombre_variable = 'Span' or $nombre_variable = '-' or CAST($nombre_variable AS float) > $maximo or CAST($nombre_variable AS float) < $minimo";
   $e_errores = pg_query($errores);

   while ($f_errores = pg_fetch_array($e_errores)) {

   
    $dato = (double) $f_errores[$nombre_variable];
   

    if ($dato < $minimo and ($nombre_variable == 'so2' || $nombre_variable == 'SO2')){

      #Reporto en correcciones el error ::::::
        $inserto_datos_mayor_A_Hora = "INSERT INTO correcciones (fecha, hora, estacion, posicion, variable, valor_error, observacion_error, valor_corregido, tipo_correccion_aplicado, estacion_sk, fecha_sk, tiempo_sk) values ('$f_errores[fecha]','$f_errores[hora]','$estacion', '$f_errores[registro]','$nombre_variable', '$dato', 'Menor al mínimo permitido', '0', '$tipo_correccion', '$estacion_sk', '$f_errores[fecha_sk]', '$f_errores[tiempo_sk]')";
        pg_query($inserto_datos_mayor_A_Hora);
      #::::::::::::::::::::::::::::::::::::::

        $elimino_dato_malo = "UPDATE centralaire set $nombre_variable = '0' where registro = $f_errores[registro]";
      $e_elimino_dato_malo = pg_query($elimino_dato_malo);
    }
    else{
      $var = '';
      $valor = (string) $var;

      #Reporto en correcciones el error ::::::
        $inserto_datos_mayor_A_Hora = "INSERT INTO correcciones (fecha, hora, estacion, posicion, variable, valor_error, observacion_error, valor_corregido, tipo_correccion_aplicado, estacion_sk, fecha_sk, tiempo_sk) values ('$f_errores[fecha]','$f_errores[hora]','$estacion', '$f_errores[registro]','$nombre_variable', '{$f_errores[$nombre_variable]}', 'Valor entrante No valido', 'null', 'convertir a Null', '$estacion_sk', '$f_errores[fecha_sk]', '$f_errores[tiempo_sk]')";
        pg_query($inserto_datos_mayor_A_Hora);
      #::::::::::::::::::::::::::::::::::::::

      $elimino_dato_malo = "UPDATE centralaire set $nombre_variable = null where registro = $f_errores[registro]";
      $e_elimino_dato_malo = pg_query($elimino_dato_malo);
    }

   }

  }
}
# La función horaMilitar() recibe un número de horas a cambiar a militar y finalmente las convierte

function horaMilitar($cantidad_maxima){

  for ($x=1; $x<=$cantidad_maxima;$x++){
    $consultinia = "SELECT hora from centralaire where registro = $x order by hora";
    $e_consultinia = pg_query($consultinia);
    $r_consultinia = pg_fetch_array($e_consultinia);
    $lista= cambiarAMilitar($r_consultinia["hora"]); #se invoca la funcion cambiarAMilitar() que está dentro del archivo fecha_sk
    $actualizar = "UPDATE centralaire set hora = '$lista' where registro = $x";
    $e_actualizar = pg_query($actualizar);
  }

}


function variablesppb(){

$variable = "SELECT nombre from variable where nombre = 'so2' or nombre = 'co' or nombre = 'o3'";
$e_variable = pg_query($variable);

$array = array();
while($variables = pg_fetch_array($e_variable)){
$nombre_variable = $variables['nombre'];

$conviertoppb = "SELECT count($nombre_variable) as cantidad from centralaire where $nombre_variable = 'ppb'";
$ejecutoppb = pg_query($conviertoppb);
$f_ejecutoppb = pg_fetch_array($ejecutoppb);

$conviertoppm = "SELECT count($nombre_variable) as cantidad from centralaire where $nombre_variable = 'ppm'";
$ejecutoppm = pg_query($conviertoppm);
$f_ejecutoppm = pg_fetch_array($ejecutoppm);


if ($f_ejecutoppb['cantidad'] > 0 and $f_ejecutoppm['cantidad'] == 0) {
$array[] = $nombre_variable;
}

}
return $array;
}


function conversion_de_tipo($arreglo){

$tama = sizeof($arreglo);

$i=0;
while ($i<$tama) {
  $variable = current($arreglo); //La función current() simplemente devuelve el valor del elemento del array que está siendo apuntado por el puntero interno
    

    $selecciono_columna = "SELECT $variable,registro FROM centralaire";
    $seleccion_columna = pg_query($selecciono_columna);

    while($arreglo_columna = pg_fetch_array($seleccion_columna)){
    if (!is_null($arreglo_columna[$variable])){
      $ppm = (double)$arreglo_columna[$variable]/1000;
      $actualizo = "UPDATE centralaire set $variable = $ppm where registro = $arreglo_columna[registro]";    
      $e_actualizo = pg_query($actualizo);
    }
  }

  next($arreglo);
  $i++;
}

}

function borrar_datos_informativos(){
$elimino = "DELETE from centralaire where fecha IN (SELECT fecha from centralaire where fecha = '_' or fecha = '' or fecha = ' ' or fecha = null or fecha = 'Min' or fecha = 'Date' or fecha = 'Time' or fecha = 'Max' or fecha = 'AVG' or fecha = 'Num' or fecha = 'STD' OR fecha = 'Data[%]');
";
pg_query($elimino);
}

?>