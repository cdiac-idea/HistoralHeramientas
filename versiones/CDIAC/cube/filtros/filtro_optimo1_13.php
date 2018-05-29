<?php
require_once("tiempo_sk.php"); # Se incluye el archivo tiempo_sk
require_once("fecha_skarch.php"); # Se incluye el archivo fecha_sk
require_once("confianza_datos.php");

//CONEXIÓN CON LA BODEGA DE DATOS
// ##################################################################################################################
if (!$pg_servidor = @pg_connect (" user = postgres password=%froac$ port=5432 dbname=idea_dwh_db_pruebascube host=froac.manizales.unal.edu.co"))

//if (!$pg_servidor = @pg_connect (" user = postgres password=administrador port=5432 dbname= datawarehouse_idea host=localhost"))
{  
  header("Location: ../index.php/mensaje_error_conexion");
}
// ##################################################################################################################



# La función horaMilitar() recibe un número de horas a cambiar a militar y finalmente las convierte
function horaMilitar($cantidad_maxima){

  for ($x=1; $x<=$cantidad_maxima;$x++){
    $consultinia = "SELECT hora from central where registro = $x order by hora";
    $e_consultinia = pg_query($consultinia);
    $r_consultinia = pg_fetch_array($e_consultinia);
    $lista= cambiarAMilitar($r_consultinia["hora"]); #se invoca la funcion cambiarAMilitar() que está dentro del archivo fecha_sk
    $actualizar = "UPDATE central set hora = '$lista' where registro = $x";
    $e_actualizar = pg_query($actualizar);
  }

}

# ------------------------------------------------------------------------------------------------#
//La funcion inicial recibe como parametro la estacion preteneciente a los datos a evaluar,
// esta función es casi que la más importante en el proceso de la filtración porque 
// contiene el procedimiento central que evalúa los datos, los detecta los corrige y llama a los
// datos a ser migrados.
# ------------------------------------------------------------------------------------------------#
function inicial($estacion){

$valor_maximo = "SELECT registro from central"; # se consulta el total de registros de la tabla central
$r_valor_maximo = pg_query($valor_maximo);
$cantidad_maxima = pg_num_rows($r_valor_maximo);

horaMilitar($cantidad_maxima); #se ejecuta la función horaMilitar

$posicion = "SELECT estacion_sk from station_dim where estacion = '$estacion'"; # Se recupera el identificador de la estación llamado estacion_sl
$r_posicion = pg_query($posicion);
$v_posicion = pg_fetch_array($r_posicion);

$parcial = $v_posicion['estacion_sk'];   # el identificador se almacena en la variable $parcial

$estacion_sk_a_central = "UPDATE central set estacion_sk = $parcial"; # se actualiza la tabla central con la estacion_sk
$ejecuto_agregamos = pg_query($estacion_sk_a_central);

$sql1="SELECT variables from variables where estacion_sk = $parcial order by variables "; #se consulta para obtener el número de variable de una estación
$result1 = pg_query($sql1); 
//$row1 = pg_fetch_array($result1); 
$num_resul1=pg_num_rows($result1);

$x=0;
while ($x < $num_resul1){ # Mientras la variable $x inicializada en 0 sea menor al número de variables haga:
  $sql2="SELECT variables from variables where estacion_sk = $parcial order by variables  limit 1 offset $x"; #recorre cada una de las variables
  $result2 = pg_query($sql2); 
  $row2 = pg_fetch_array($result2);

  $nombre_variable = $row2['variables']; # en $nombre_variable se almacena el nombre de la variable

  $reemplazo = "UPDATE central set $nombre_variable = replace($nombre_variable, ',', '.')"; # se cambian comas por puntos para que en la tabla central se puedan ejecutar las operaciones sin problemas
  $r_reemplazo = pg_query($reemplazo);
  
 
# Valor minimo
  $minimo="SELECT minimo from variables where estacion_sk = $parcial and variables = '$nombre_variable' order by variables"; # Se identifica el valor mínimo permitido para esa variable en esa estación
  $r_minimo = pg_query($minimo); 
  $v_minimo = pg_fetch_array($r_minimo);

  $p_minimo = $v_minimo['minimo']; # el valor mínimo se almacena en la variable $p_minimo

# Valor maximo 
  $maximo="SELECT maximo from variables where estacion_sk = $parcial and variables = '$nombre_variable' order by variables"; # Se identifica el valor máximo permitido para esa variable en esa estación
  $r_maximo = pg_query($maximo); 
  $v_maximo = pg_fetch_array($r_maximo);

  $p_maximo = $v_maximo['maximo']; # el valor máximo se almacena en la variable $p_maximo

#variacion
  $diferencia="SELECT diferencia_anterior from variables where estacion_sk = $parcial and variables = '$nombre_variable' order by variables"; # Se identifica el valor de variación maximo permitido para esa variable en esa estación
  $r_diferencia = pg_query($diferencia); 
  $v_diferencia = pg_fetch_array($r_diferencia); 

  $p_diferencia = $v_diferencia['diferencia_anterior'];  # la diferencia máxmima permitida se almacena en la variable $p_diferencia

#tipo correccion
  $consulta_correccion="SELECT tipo_correccion from variables where estacion_sk = $parcial and variables = '$nombre_variable' order by variables"; # Se identifica el tipo de corrección que se le debe aplicar a esa variable en esa estación
  $resultado_correcion = pg_query($consulta_correccion);
  $row_correccion = pg_fetch_array($resultado_correcion);  

  $tipo_correccion = $row_correccion['tipo_correccion']; # el tipo de correccion para la variable en esa estacion se almacena en la variable $tipo_correccion


#-------------------------------------------------------------------------------------------------------------------##
#--- CICLO PODEROSO, denominado así por ser el ciclo que invoca n veces las funciones de detección y corrección --- //
  $i=1;                                                                                                             //
  $j=$i-2;                                                                                                          //
  for ($i,$j; $i<=$cantidad_maxima+1 && $j<=$cantidad_maxima ;$i++,$j++){                                           //
    if ($i <= $cantidad_maxima){                                                                                    //
    filtro_de_deteccion($estacion,$nombre_variable,$i,$i-1,$p_minimo,$p_maximo,$p_diferencia);                      //
  }                                                                                                                 //
    if ($i > 3){                                                                                                    //
    filtro_correctivo($nombre_variable,$j-1,$j,$j+1,$tipo_correccion);                                              //
  }                                                                                                                 //
  }                                                                                        //
#-------------------------------------------------------------------------------------------------------------------##


  $punto_presion = "UPDATE central set $nombre_variable = replace($nombre_variable, '.', ',')"; # despues de ejecutadas las operaciones se vuelven a convertir los puntos en comas como en un principio con motivo del reporte en archivo plano.
  $r_punto_presion = pg_query($punto_presion);

  $x++;
}


$cantidad_fechas_distintas = "SELECT DISTINCT fecha FROM central order by fecha"; # se obtiene el total de fechas diferentes
$e_cant_fech_dist = pg_query($cantidad_fechas_distintas);
$a_cant_fech_dist = pg_fetch_array($e_cant_fech_dist);
$r_cant_fetch_dist = pg_num_rows($e_cant_fech_dist);


  for($x=0; $x < $r_cant_fetch_dist; $x++){

    $fecha_pos = "SELECT distinct fecha from central order by fecha limit 1 offset $x";
    $e_fecha_pos = pg_query($fecha_pos);
    $r_fecha_pos = pg_fetch_array($e_fecha_pos);
    $c_fecha_pos = $r_fecha_pos["fecha"];

    $fecha_sk = obtener_fecha_sk($c_fecha_pos); # se invoca la función obtener_fecha_sk() que está en fecha_sk.php y esta retorna la fecha_sk de la fecha consultada
    

    if($fecha_sk == 0){
    $fecha_sk = obtener_fecha_skarch($c_fecha_pos); # se invoca la función obtener_fecha_sk() que está en fecha_sk.php y esta retorna la fecha_sk de la fecha consultada
    $actualizar = "UPDATE central SET fecha_sk = '$fecha_sk' where fecha = '$c_fecha_pos'"; # se actualiza el campo de fecha_sk de la tabla central
    $e_fecha_pos = pg_query($actualizar);
    }

    else {
    $actualizar = "UPDATE central SET fecha_sk = '$fecha_sk' where fecha = '$c_fecha_pos'"; # se actualiza el campo de fecha_sk de la tabla central
    $e_fecha_pos = pg_query($actualizar);
    }

    

}


$cantidad_hora_distintas = "SELECT DISTINCT hora FROM central order by hora"; # se obtiene el total de horas diferentes
$e_cant_hora_dist = pg_query($cantidad_hora_distintas);
$a_cant_hora_dist = pg_fetch_array($e_cant_hora_dist);
$r_cant_hora_dist = pg_num_rows($e_cant_hora_dist);

for($x=0; $x < $r_cant_hora_dist; $x++){

    $hora_pos = "SELECT distinct hora from central order by hora limit 1 offset $x";
    $e_hora_pos = pg_query($hora_pos);
    $r_hora_pos = pg_fetch_array($e_hora_pos);
    $c_hora_pos = $r_hora_pos["hora"];

    $tiempo_sk = obtener_tiempo_sk($c_hora_pos);# se invoca la función obtener_tiempo_sk() que está en tiempo_sk.php y esta retorna el tiempo_sk de la hora consultada

    $actualizar2 = "UPDATE central SET tiempo_sk = '$tiempo_sk' where hora = '$c_hora_pos'"; # se actualiza el campo de tiempo_sk de la tabla central
    $e_hora_pos = pg_query($actualizar2);

}

}

#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#La funcion filtro_de_deteccion() recorre los datos y se encarga de detectar valores que no estén dentro de un rango permitido o detectar valores diferentes a un dato numerico
// los parametros que recibe son los siguientes:
// 1. $v_estacion -> nombre de la estación de donde provienen los datos.
// 2. $variables -> el nombre de la variable a la que se le avaluarán los datos
// 3. $dato_a_filtrar -> posición exacta dentro de la tabla que se va a corregir
// 4. $dato_anterior -> posición anterior al dato que se está corrigiendo
// 5. $min -> valor minimo permitido para la variable dada en la estación dada
// 6. $max -> valor máximo permitido para la variable dada en la estación dada
// 6. $max -> diferencia_permitida entre un dato y otro  para la variable dada en la estación dada
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function filtro_de_deteccion($v_estacion, $variables, $dato_a_filtrar, $dato_anterior, $min,$max,$dife){

  $consulta_i_antes ="SELECT $variables FROM central WHERE registro = ".$dato_anterior.""; # se consulta el dato anterior al que se evaluará
  $resultado_i_antes = @pg_query($consulta_i_antes);
  $row_antes = @pg_fetch_array($resultado_i_antes);

  $consultai="SELECT $variables FROM central WHERE registro = ".$dato_a_filtrar.""; # se consulta el dato al que se evaluará
  $resultado = @pg_query($consultai);
  $row = @pg_fetch_array($resultado);

  $antes = $row_antes[$variables]; # se almacena en $antes el dato anterior al evaluado
  $actual = $row[$variables]; # se almacena en $antes el dato anterior al evaluado

  $uno = (double)$antes; # se almacena en $uno el dato anterior al evaluado con una conversión a dato numerico para poder usarlo para operaciones matematicas
  $dos = (double)$actual; # se almacena en $dos el dato a evaluar con una conversión a dato numerico para poder usarlo para operaciones matematicas

  $variacion = (abs($uno-$dos)); # se almacena en $variacion la diferencia entre el dato anterior al evaluado y el avaluado con la funcion abs que retorna el resultado en valor absoluto

  $estacion_sk = "SELECT estacion_sk from station_dim where estacion = '$v_estacion'";
      $r_posicion = pg_query($estacion_sk);
      $v_posicion = pg_fetch_array($r_posicion);

      $sk = $v_posicion['estacion_sk']; # almacenamos el identificador de la estación que se recibió como parametro

      $fecha = "SELECT fecha from central where registro = ".$dato_a_filtrar."";
      $r_fecha = pg_query($fecha);
      $v_fecha = pg_fetch_array($r_fecha); 
      $vfecha = $v_fecha['fecha']; #Se consulta la fecha del registro evaluado y se almacena en $vfecha

      $hora = "SELECT hora from central where registro = ".$dato_a_filtrar."";
      $r_hora = pg_query($hora);
      $v_hora = pg_fetch_array($r_hora);
      $vhora = $v_hora['hora'];#Se consulta la hora del registro evaluado y se almacena en $vhora

      $actualiza2 = "UPDATE central set radiacion_solar = null where radiacion_solar = '-' "; # se actualiza a null todos aquellos campos que presenten un dato en '-' o vacios
      $ejecuto_actualiza2 = pg_query($actualiza2);

  if (is_numeric($actual)) { # pregunta si el dato a evaluar ya está convertido a dato numerico
    
    if ($dos < $min || $dos > $max){ #pregunta si es menor o mayor al permitido
      $consulta_deteccion = "UPDATE central SET $variables = null WHERE registro = ".$dato_a_filtrar.""; # si es menor o mayor al permitido se actualiza ese campo como valor null
      $resultado_deteccion = pg_query($consulta_deteccion);

      $a_tabla_correcciones = "INSERT into correcciones (fecha,hora,estacion,posicion,variable,valor_error,observacion_error) values ('$vfecha','$vhora','$v_estacion','$dato_a_filtrar','$variables','$dos','Fuera del rango')"; # y se inserta en la tabla correciones lo sucedido como un dato incosistente detectado
      $ejecuta = pg_query($a_tabla_correcciones);

    }
    elseif ($uno != (!is_numeric($uno)) && (is_numeric($dife))) { # si está dentro del rango permitido verifica si el dato anterior fue convertido a numerico de forma correcta y si la diferenci permitida tambien esta expresada numericamente
        if($variacion > $dife){ # pregunta si la variacion entre el dato anterior y el evaluado es superior al permitido
          $consulta_deteccion = "UPDATE central SET $variables = null WHERE registro = ".$dato_a_filtrar.""; # si es mayor se actualiza el dato evaluado en null
          $resultado_deteccion = pg_query($consulta_deteccion);

          $a_tabla_correcciones = "INSERT into correcciones (fecha,hora,estacion,posicion,variable,valor_error,observacion_error) values ('$vfecha','$vhora','$v_estacion','$dato_a_filtrar','$variables','$dos','Diferencia excedida')"; # y se inserta en la tabla correcciones reportando la inconsistencia en el dato
          $ejecuta = pg_query($a_tabla_correcciones);
        }
    }    
  }
  elseif (!is_numeric($actual) || $dos != (is_numeric($actual)) || $actual == '-' || $actual == '') { # pregunta si el dato que llega no es númerico o tiene algunas caracteristicas como '-' o como campo vacio
    $consulta_deteccion = "UPDATE central SET $variables = null WHERE registro = ".$dato_a_filtrar.""; # se actualiza ese campo en NULL
    $resultado_deteccion = pg_query($consulta_deteccion);

    $a_tabla_correcciones = "INSERT into correcciones (fecha,hora,estacion,posicion,variable,valor_error,observacion_error) values ('$vfecha','$vhora','$v_estacion','$dato_a_filtrar','$variables','$actual','Dato entrante erroneo')"; # y se inserta en la tabla correcciones reportando la inconsistencia
    $ejecuta = pg_query($a_tabla_correcciones);
  }
}



#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#La funcion filtro_correctivo() recorre los datos y se encarga de corregir datos en los campos de un solo error consecutivo definidas unas métricas por variable y por estación
// los parametros que recibe son los siguientes:
// 1. $variables -> el nombre de la variable a la que se le avaluarán los datos
// 2. $dato_anterior -> posición anterior al dato que se está corrigiendo
// 3. $dato_a_filtrar -> posición exacta dentro de la tabla que se va a corregir
// 4. $dato_siguiente -> posición siguiente al dato que se está corrigiendo
// 5. $tipo_correccion -> el tipo de correccion que se aplica a la variable y estacion capturadas
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#

function filtro_correctivo($variables, $dato_anterior, $dato_a_filtrar, $dato_siguiente, $tipo_correccion){

  $consulta_i_antes ="SELECT $variables FROM central WHERE registro = ".$dato_anterior.""; # se consulta el dato anterior al que se evaluará
  $resultado_i_antes = pg_query($consulta_i_antes);
  $row_antes = pg_fetch_array($resultado_i_antes);

  $consultai="SELECT $variables FROM central WHERE registro = ".$dato_a_filtrar.""; # se consulta el dato al que se evaluará
  $resultado = pg_query($consultai);
  $row = pg_fetch_array($resultado);

  $consulta_i_despues="SELECT $variables FROM central WHERE registro = ".$dato_siguiente.""; # se consulta el dato siguiente al evaluado
  $resultado_i_despues = pg_query($consulta_i_despues);
  $row_despues = pg_fetch_array($resultado_i_despues);



  if (!is_numeric($row[$variables])) { # pregunta si el dato recibido de la variable es númerico 
    if(is_numeric($row_antes[$variables]) && is_numeric($row_despues[$variables])){ # pregunta si el dato anterior y el siguiente al evaluado tambien son numericos 
      if ($tipo_correccion == 'promedio'){ # pregunta si el tipo de correccion es de tipo promedio

        $row_promedio = ((double)$row_antes[$variables] + (double)$row_despues[$variables])/2; # calcula el promedio entre el dato anterior y el siguiente
    //$row_promedio_2deci = number_format($row_promedio, 2);
        $consulta_filtrar = "UPDATE central SET $variables = $row_promedio WHERE registro = ".$dato_a_filtrar.""; #actualiza el dato evaluado con el promedio calculado
        $resultado_filtrar = pg_query($consulta_filtrar);

        $actualizo = "UPDATE correcciones SET valor_corregido = $row_promedio WHERE (variable = '$variables') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido con el promedio calculado
        $e_actualizo = pg_query($actualizo);

        $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variables') and (posicion = '$dato_a_filtrar')";  # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando que se aplicó el promedio
        $e_actualizo_t = pg_query($actualizo_tipo);

      }
      elseif ($tipo_correccion == 'diferencia_de_0,2') { # pregunta si el tipo de correccion es de tipo diferencia_de_0,2
        $uno = (double)$row_antes[$variables]; # se convierte el dato anterior a dato numérico
        $dos = (double)$row_despues[$variables]; # se convierte el dato siguiente a dato numérico
        $variacion_d = abs($uno-$dos); # se verifica el valor de diferencia entre el anterior y el siguiente
        $variacion_2decimales = number_format($variacion_d, 2); # y se convierte la variacion a un formato numerico de dos decimales

        if($variacion_2decimales == 0.20 || $variacion_2decimales == 0.00){ # valida que la variacion entre el anterior y el siguiente sea exactamente de 0,20 o 0,00
          $uno_2decimales = number_format($uno, 2); # si es se convierte el dato anterior a un formato numerico de dos decimales
          $consulta_filtrar_precip = "UPDATE central SET $variables = $uno_2decimales WHERE registro = ".$dato_a_filtrar.""; # y se actualiza el dato evaluado con el mismo dato presentado en el registro anterior
          $resultado_filtrar_precip = pg_query($consulta_filtrar_precip);

          $actualizo = "UPDATE correcciones SET valor_corregido = $uno_2decimales WHERE (variable = '$variables') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido
          $e_actualizo = pg_query($actualizo);

          $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variables') and (posicion = '$dato_a_filtrar')";  # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando el tipo de correccion aplicado
          $e_actualizo_t = pg_query($actualizo_tipo);
        }
        elseif ($variacion_2decimales > 0.20) { # si la diferencia entre el dato anterior y el siguiente excedio 0,20 haga:
          $observacion_precip = "UPDATE central SET observaciones = 'Ppt acumulada' WHERE registro = ".$dato_siguiente.""; # se actualiza el campo observaciones del dato siguiente con un mensaje 'ppt acumulada' que indica que hubo un valor de exceso y no se modifico corrigió por otro valor
          $resultado_observacion_precip = pg_query($observacion_precip);

          $actualizo = "UPDATE correcciones SET valor_corregido = ' null y Ppt acumulada en observaciones' WHERE (variable = '$variables') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido
          $e_actualizo = pg_query($actualizo);

          $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variables') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando el tipo de correccion aplicado
          $e_actualizo_t = pg_query($actualizo_tipo);
        }

      }
      elseif ($tipo_correccion == 'dato_anterior') { # pregunta si el tipo de correccion es de tipo dato_anterior
        $uno = (double)$row_antes[$variables]; # guarda en $uno el valor anterior al evaluado en formato numérico
        $row_eva_2deci = number_format($uno, 2); # y lo convierte en formato de 2 decimales
        $consulta_filtrar_eva = "UPDATE central SET $variables = $row_eva_2deci WHERE registro = ".$dato_a_filtrar.""; # acualiza el campo evaluado con el dato anterior como lo indica el tipo de corrección
        $resultado_filtrar_eva = pg_query($consulta_filtrar_eva);

        $actualizo = "UPDATE correcciones SET valor_corregido = $row_eva_2deci WHERE (variable = '$variables') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido
        $e_actualizo = pg_query($actualizo);

        $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variables') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando el tipo de correccion aplicado
        $e_actualizo_t = pg_query($actualizo_tipo);

      }
    }
    
  }








}

?>