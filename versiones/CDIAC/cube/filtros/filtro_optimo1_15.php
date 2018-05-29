<?php
require_once("tiempo_sk.php"); # Se incluye el archivo tiempo_sk
require_once("fecha_sk.php"); # Se incluye el archivo fecha_sk
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
 
function registro(){
$ordenar = "select * from central order by fecha,hora";
$e_ordenar = pg_query($ordenar);
$i=1;
while ($f_ordenar = pg_fetch_array($e_ordenar)){
  
  $inserto = "UPDATE central set registro = $i where fecha = '$f_ordenar[fecha]' and hora = '$f_ordenar[hora]'";
  $e_inserto = pg_query($inserto);
  $i++;
}
}

# ------------------------------------------------------------------------------------------------#
//La funcion inicial recibe como parametro la estacion preteneciente a los datos a evaluar,
// esta función es casi que la más importante en el proceso de la filtración porque 
// contiene el procedimiento central que evalúa los datos, los detecta los corrige y llama a los
// datos a ser migrados.
# ------------------------------------------------------------------------------------------------#

function inicial($estacion){

  $valor_maximo = "SELECT registro,estacion_sk from central"; # se consulta el total de registros de la tabla central
  $r_valor_maximo = pg_query($valor_maximo);
  $f_valor_maximo = pg_fetch_array($r_valor_maximo);
  $estacion_sk = $f_valor_maximo['estacion_sk'];
  $cantidad_maxima = pg_num_rows($r_valor_maximo);

  horaMilitar($cantidad_maxima); #se ejecuta la función horaMilitar
  registro();

  //si en los datos a evaluar no viene la estacion_sk entonces se calcula
  if ($estacion_sk == null){
  $posicion = "SELECT estacion_sk from station_dim where estacion = '$estacion'"; # Se recupera el identificador de la estación llamado estacion_sl
  $r_posicion = pg_query($posicion);
  $v_posicion = pg_fetch_array($r_posicion);

  $estacion_sk = $v_posicion['estacion_sk'];   # el identificador se almacena en la variable $estacion_sk

  $estacion_sk_a_central = "UPDATE central set estacion_sk = $estacion_sk"; # se actualiza la tabla central con la estacion_sk
  $ejecuto_agregamos = pg_query($estacion_sk_a_central);
  }

  ########## SE INSERTA FECHA_SK ####################################################
    $cantidad_fechas_distintas = "SELECT DISTINCT fecha FROM central order by fecha"; # se obtiene el total de fechas diferentes
    $e_cant_fech_dist = pg_query($cantidad_fechas_distintas);
    
    while($a_cant_fech_dist = pg_fetch_array($e_cant_fech_dist)){
      $c_fecha_pos = $a_cant_fech_dist["fecha"];
      $fecha_sk = obtener_fecha_sk_arch($c_fecha_pos); # se invoca la función obtener_fecha_sk() que está en fecha_sk.php y esta retorna la fecha_sk de la fecha consultada
      
      if($fecha_sk == 0 or $fecha_sk == null){
          $fecha_sk = obtener_fecha_sk($c_fecha_pos); # se invoca la función obtener_fecha_sk() que está en fecha_sk.php y esta retorna la fecha_sk de la fecha consultada
          $actualizar = "UPDATE central SET fecha_sk = '$fecha_sk' where fecha = '$c_fecha_pos'"; # se actualiza el campo de fecha_sk de la tabla central
          $e_fecha_pos = pg_query($actualizar);
      }
      else {      
          $actualizarfecha = "UPDATE central SET fecha_sk = '$fecha_sk' where fecha = '$c_fecha_pos'"; # se actualiza el campo de fecha_sk de la tabla central
          $e_fecha_pos = pg_query($actualizarfecha);
        }
    }

############################################################################################
######## SE INSERTA TIEMPO_SK ##############################################################

    $cantidad_hora_distintas = "SELECT DISTINCT hora FROM central order by hora"; # se obtiene el total de horas diferentes
    $e_cant_hora_dist = pg_query($cantidad_hora_distintas);

    while($a_cant_hora_dist = pg_fetch_array($e_cant_hora_dist)){
      $c_hora_pos = $a_cant_hora_dist["hora"];

      $tiempo_sk = obtener_tiempo_sk($c_hora_pos);# se invoca la función obtener_tiempo_sk() que está en tiempo_sk.php y esta retorna el tiempo_sk de la hora consultada

      $actualizar2 = "UPDATE central SET tiempo_sk = '$tiempo_sk' where hora = '$c_hora_pos'"; # se actualiza el campo de tiempo_sk de la tabla central
      $e_hora_pos = pg_query($actualizar2);
    }


#############################################################################################

  $consulta_variables="SELECT variables from variables where estacion_sk = $estacion_sk order by variables "; #se consulta para obtener el número de variable de una estación
  $res_variables = pg_query($consulta_variables); 
  
  while ($fetch_variables = pg_fetch_array($res_variables)){ # Mientras recorre las variables haga
    $nombre_variable = $fetch_variables['variables'];
 
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


    if ($p_diferencia != null){
      
      $i=1;                             
      $j=$i-2;                                                                                                         
      for ($i,$j; $i<=$cantidad_maxima+1 && $j<=$cantidad_maxima ;$i++,$j++){                                         
        if ($i <= $cantidad_maxima){                                                                                  
          filtro_de_deteccion($estacion,$nombre_variable,$i,$p_minimo,$p_maximo,$p_diferencia);                     
        }                                                                                                               
        if ($i > 3){                                                                                                  
          filtro_correctivo($nombre_variable,$j-1,$j,$j+1,$tipo_correccion);                                         
        }                                                                                                              
      }
    }
    else{
      deteccion($estacion, $estacion_sk, $nombre_variable, $p_minimo, $p_maximo, $tipo_correccion, $p_diferencia);
    }
     



  }


}

#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#La funcion filtro_de_deteccion() recorre los datos y se encarga de detectar valores que no estén dentro de un rango permitido o detectar valores diferentes a un dato numerico
// los parametros que recibe son los siguientes:
// 1. $v_estacion -> nombre de la estación de donde provienen los datos.
// 2. $variable -> el nombre de la variable a la que se le avaluarán los datos
// 3. $dato_a_filtrar -> posición exacta dentro de la tabla que se va a corregir
// 4. $dato_anterior -> posición anterior al dato que se está corrigiendo
// 5. $min -> valor minimo permitido para la variable dada en la estación dada
// 6. $max -> valor máximo permitido para la variable dada en la estación dada
// 6. $max -> diferencia_permitida entre un dato y otro  para la variable dada en la estación dada
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#

function filtro_de_deteccion($v_estacion, $variable, $dato_a_filtrar, $min,$max,$dife){
  $dato_anterior = $dato_a_filtrar-1;

  $consulta_i_antes ="SELECT $variable FROM central WHERE registro = ".$dato_anterior.""; # se consulta el dato anterior al que se evaluará
  $resultado_i_antes = @pg_query($consulta_i_antes);
  $fila_anterior = @pg_fetch_array($resultado_i_antes);

  $consultai="SELECT $variable FROM central WHERE registro = ".$dato_a_filtrar.""; # se consulta el dato al que se evaluará
  $resultado = @pg_query($consultai);
  $row = @pg_fetch_array($resultado);

  $dato_antes = $fila_anterior[$variable]; # se almacena en $dato_antes el dato anterior al evaluado
  $dato_actual = $row[$variable]; # se almacena en $dato_antes el dato anterior al evaluado

  $valor_anterior_numerico = (double)$dato_antes; # se almacena en $valor_anterior el dato anterior al evaluado con una conversión a dato numerico para poder usarlo para operaciones matematicas
  $valor_actual_numerico = (double)$dato_actual; # se almacena en $valor_actual el dato a evaluar con una conversión a dato numerico para poder usarlo para operaciones matematicas

  $variacion = (abs($valor_anterior_numerico-$valor_actual_numerico)); # se almacena en $variacion la diferencia entre el dato anterior al evaluado y el avaluado con la funcion abs que retorna el resultado en valor absoluto

  $fechas_horas_estaciones = "SELECT fecha,hora,fecha_sk,tiempo_sk,estacion_sk from central where registro = ".$dato_a_filtrar."";
  $e_fechas_horas_estaciones = pg_query($fechas_horas_estaciones);
  $f_fechas_horas_estaciones = pg_fetch_array($e_fechas_horas_estaciones);

  $fecha = $f_fechas_horas_estaciones['fecha'];
  $fecha_sk = $f_fechas_horas_estaciones['fecha_sk'];
  $hora = $f_fechas_horas_estaciones['hora'];
  $tiempo_sk = $f_fechas_horas_estaciones['tiempo_sk'];
  $estacion_sk = $f_fechas_horas_estaciones['estacion_sk'];


  if (is_numeric($dato_actual)) { # pregunta si el dato a evaluar ya está convertido a dato numerico
   
    if ($valor_actual_numerico < $min || $valor_actual_numerico > $max){ #pregunta si es menor o mayor al permitido
      $consulta_deteccion = "UPDATE central SET $variable = null WHERE registro = ".$dato_a_filtrar.""; # si es menor o mayor al permitido se actualiza ese campo como valor null
      $resultado_deteccion = pg_query($consulta_deteccion);

      $a_tabla_correcciones = "INSERT into correcciones (fecha,hora,estacion,posicion,variable,valor_error,observacion_error,fecha_sk,tiempo_sk,estacion_sk) values ('$fecha','$hora','$v_estacion','$dato_a_filtrar','$variable','$valor_actual_numerico','Fuera del rango','$fecha_sk','$tiempo_sk','$estacion_sk')"; # y se inserta en la tabla correciones lo sucedido como un dato incosistente detectado
      $ejecuta = pg_query($a_tabla_correcciones);

    }
    elseif ($valor_anterior_numerico != (!is_numeric($valor_anterior_numerico)) && (is_numeric($dife))) { # si está dentro del rango permitido verifica si el dato anterior fue convertido a numerico de forma correcta y si la diferenci permitida tambien esta expresada numericamente
        if($variacion > $dife){ # pregunta si la variacion entre el dato anterior y el evaluado es superior al permitido
          $consulta_deteccion = "UPDATE central SET $variable = null WHERE registro = ".$dato_a_filtrar.""; # si es mayor se actualiza el dato evaluado en null
          $resultado_deteccion = pg_query($consulta_deteccion);

          $a_tabla_correcciones = "INSERT into correcciones (fecha,hora,estacion,posicion,variable,valor_error,observacion_error,fecha_sk,tiempo_sk,estacion_sk) values ('$fecha','$hora','$v_estacion','$dato_a_filtrar','$variable','$valor_actual_numerico','Diferencia excedida','$fecha_sk','$tiempo_sk','$estacion_sk')"; # y se inserta en la tabla correcciones reportando la inconsistencia en el dato
          $ejecuta = pg_query($a_tabla_correcciones);
        }
    }  
  }
  elseif (!is_numeric($dato_actual) || $valor_actual != (is_numeric($dato_actual)) || $dato_actual == '-' || $dato_actual == '') { # pregunta si el dato que llega no es númerico o tiene algunas caracteristicas como '-' o como campo vacio
   
    $consulta_deteccion = "UPDATE central SET $variable = null WHERE registro = ".$dato_a_filtrar.""; # se actualiza ese campo en NULL
    $resultado_deteccion = pg_query($consulta_deteccion);

    $a_tabla_correcciones = "INSERT into correcciones (fecha,hora,estacion,posicion,variable,valor_error,observacion_error,fecha_sk,tiempo_sk,estacion_sk) values ('$fecha','$hora','$v_estacion','$dato_a_filtrar','$variable','$dato_actual','Dato entrante erroneo','$fecha_sk','$tiempo_sk','$estacion_sk')"; # y se inserta en la tabla correcciones reportando la inconsistencia
    $ejecuta = pg_query($a_tabla_correcciones);
  }
  
  }


#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
#La funcion filtro_correctivo() recorre los datos y se encarga de corregir datos en los campos de un solo error consecutivo definidas unas métricas por variable y por estación
// los parametros que recibe son los siguientes:
// 1. $variable -> el nombre de la variable a la que se le avaluarán los datos
// 2. $dato_anterior -> posición anterior al dato que se está corrigiendo
// 3. $dato_a_filtrar -> posición exacta dentro de la tabla que se va a corregir
// 4. $dato_siguiente -> posición siguiente al dato que se está corrigiendo
// 5. $tipo_correccion -> el tipo de correccion que se aplica a la variable y estacion capturadas
#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function filtro_correctivo($variable, $dato_anterior, $dato_a_filtrar, $dato_siguiente, $tipo_correccion){
  
  $consulta_i_antes ="SELECT $variable FROM central WHERE registro = ".$dato_anterior.""; # se consulta el dato anterior al que se evaluará
  $resultado_i_antes = pg_query($consulta_i_antes);
  $fila_anterior = pg_fetch_array($resultado_i_antes);

  $consultai="SELECT $variable FROM central WHERE registro = ".$dato_a_filtrar.""; # se consulta el dato al que se evaluará
  $resultado = pg_query($consultai);
  $row = pg_fetch_array($resultado);

  $consulta_i_despues="SELECT $variable FROM central WHERE registro = ".$dato_siguiente.""; # se consulta el dato siguiente al evaluado
  $resultado_i_despues = pg_query($consulta_i_despues);
  $row_despues = pg_fetch_array($resultado_i_despues);

  if (!is_numeric($row[$variable])) { # pregunta si el dato recibido de la variable es diferente a númerico 
    if(is_numeric($fila_anterior[$variable]) && is_numeric($row_despues[$variable])){ # pregunta si el dato anterior y el siguiente al evaluado son numericos 
      
      if ($tipo_correccion == 'promedio'){ # pregunta si el tipo de correccion es de tipo promedio

        $row_promedio = ((double)$fila_anterior[$variable] + (double)$row_despues[$variable])/2; # calcula el promedio entre el dato anterior y el siguiente
    //$row_promedio_2deci = number_format($row_promedio, 2);
        $consulta_filtrar = "UPDATE central SET $variable = $row_promedio WHERE registro = ".$dato_a_filtrar.""; #actualiza el dato evaluado con el promedio calculado
        $resultado_filtrar = pg_query($consulta_filtrar);

        $actualizo = "UPDATE correcciones SET valor_corregido = $row_promedio WHERE (variable = '$variable') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido con el promedio calculado
        $e_actualizo = pg_query($actualizo);

        $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variable') and (posicion = '$dato_a_filtrar')";  # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando que se aplicó el promedio
        $e_actualizo_t = pg_query($actualizo_tipo);

      }

      elseif ($tipo_correccion == 'diferencia_de_0,2') { # pregunta si el tipo de correccion es de tipo diferencia_de_0,2
        $valor_anterior = (double)$fila_anterior[$variable]; # se convierte el dato anterior a dato numérico
        $valor_actual = (double)$row_despues[$variable]; # se convierte el dato siguiente a dato numérico
        $variacion_d = abs($valor_anterior-$valor_actual); # se verifica el valor de diferencia entre el anterior y el siguiente
        $variacion_2decimales = number_format($variacion_d, 2); # y se convierte la variacion a un formato numerico de dos decimales

        if($variacion_2decimales == 0.20 || $variacion_2decimales == 0.00){ # valida que la variacion entre el anterior y el siguiente sea exactamente de 0,20 o 0,00
          $valor_anterior_2decimales = number_format($valor_anterior, 2); # si es se convierte el dato anterior a un formato numerico de dos decimales
          $consulta_filtrar_precip = "UPDATE central SET $variable = $valor_anterior_2decimales WHERE registro = ".$dato_a_filtrar.""; # y se actualiza el dato evaluado con el mismo dato presentado en el registro anterior
          $resultado_filtrar_precip = pg_query($consulta_filtrar_precip);

          $actualizo = "UPDATE correcciones SET valor_corregido = $valor_anterior_2decimales WHERE (variable = '$variable') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido
          $e_actualizo = pg_query($actualizo);

          $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variable') and (posicion = '$dato_a_filtrar')";  # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando el tipo de correccion aplicado
          $e_actualizo_t = pg_query($actualizo_tipo);
        }
        elseif ($variacion_2decimales > 0.20) { # si la diferencia entre el dato anterior y el siguiente excedio 0,20 haga:
          $observacion_precip = "UPDATE central SET observaciones = 'Ppt acumulada' WHERE registro = ".$dato_siguiente.""; # se actualiza el campo observaciones del dato siguiente con un mensaje 'ppt acumulada' que indica que hubo un valor de exceso y no se modifico corrigió por otro valor
          $resultado_observacion_precip = pg_query($observacion_precip);

          $actualizo = "UPDATE correcciones SET valor_corregido = ' null y Ppt acumulada en observaciones' WHERE (variable = '$variable') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido
          $e_actualizo = pg_query($actualizo);

          $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variable') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando el tipo de correccion aplicado
          $e_actualizo_t = pg_query($actualizo_tipo);
        }

      }
      
      elseif ($tipo_correccion == 'dato_anterior') { # pregunta si el tipo de correccion es de tipo dato_anterior
        $valor_anterior = (double)$fila_anterior[$variable]; # guarda en $valor_anterior el valor anterior al evaluado en formato numérico
        $row_eva_2deci = number_format($valor_anterior, 2); # y lo convierte en formato de 2 decimales
        $consulta_filtrar_eva = "UPDATE central SET $variable = $row_eva_2deci WHERE registro = ".$dato_a_filtrar.""; # acualiza el campo evaluado con el dato anterior como lo indica el tipo de corrección
        $resultado_filtrar_eva = pg_query($consulta_filtrar_eva);

        $actualizo = "UPDATE correcciones SET valor_corregido = $row_eva_2deci WHERE (variable = '$variable') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido
        $e_actualizo = pg_query($actualizo);

        $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variable') and (posicion = '$dato_a_filtrar')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando el tipo de correccion aplicado
        $e_actualizo_t = pg_query($actualizo_tipo);

      }
    }
    
  }

}

function deteccion($estacion, $estacion_sk, $nombre_variable, $minimo, $maximo, $tipo_correccion, $p_diferencia){
  
  #Si $minimo es diferente null y $maximo es diferente de null haga

  if ($minimo != null and $maximo != null){
//CAST($nombre_variable AS float) < $minimo or CAST($nombre_variable AS float) > $maximo or 
    $errores = "SELECT registro, $nombre_variable from central where $nombre_variable = '-' or $nombre_variable is null or $nombre_variable = null or CAST($nombre_variable AS float) < $minimo or CAST($nombre_variable AS float) > $maximo";
    $e_errores = pg_query($errores);
    
    while ($f_errores = pg_fetch_array($e_errores)){

    $updateToNull = "UPDATE central set $nombre_variable = null where registro = $f_errores[registro]";
    $e_updateToNull = pg_query($updateToNull);

    //if($tipo_correccion != ' ' || $tipo_correccion != null || $tipo_correccion != ''){
     if($tipo_correccion != ' ' and $tipo_correccion != '' and $tipo_correccion != null){
    
    correccionSinDiferencia($f_errores['registro'], $f_errores[$nombre_variable], $tipo_correccion, $nombre_variable);
    }
    
   }
  }
  elseif ($minimo != null) {

    $errores = "SELECT registro, $nombre_variable from central where CAST($nombre_variable AS float) < $minimo or $nombre_variable = '-' or $nombre_variable is null or $nombre_variable = null";
    $e_errores = pg_query($errores);
    
    while ($f_errores = pg_fetch_array($e_errores)){

    $updateToNull = "UPDATE central set $nombre_variable = null where registro = $f_errores[registro]";
    $e_updateToNull = pg_query($updateToNull);

    //if($tipo_correccion != ' ' || $tipo_correccion != null || $tipo_correccion != ''){
     if($tipo_correccion != ' ' and $tipo_correccion != '' and $tipo_correccion != null){
    
    correccionSinDiferencia($f_errores['registro'], $f_errores[$nombre_variable], $tipo_correccion, $nombre_variable);
    }
    
   }
    
  }
  elseif ($maximo != null) {
    $errores = "SELECT registro, $nombre_variable from central where CAST($nombre_variable AS float) > $maximo or $nombre_variable = '-' or $nombre_variable is null or $nombre_variable = null";
    $e_errores = pg_query($errores);
    
    while ($f_errores = pg_fetch_array($e_errores)){

    $updateToNull = "UPDATE central set $nombre_variable = null where registro = $f_errores[registro]";
    $e_updateToNull = pg_query($updateToNull);

    //if($tipo_correccion != ' ' || $tipo_correccion != null || $tipo_correccion != ''){
     if($tipo_correccion != ' ' and $tipo_correccion != '' and $tipo_correccion != null){
    
    correccionSinDiferencia($f_errores['registro'], $f_errores[$nombre_variable], $tipo_correccion, $nombre_variable);
    }
    
   }
  }
 
}

function correccionSinDiferencia($registro, $datos_erroneos, $tipo_correccion, $variable){
  echo "<br>";
  echo($variable);
  if($tipo_correccion == 'promedio'){

    $registro_anterior = $registro-1;
    $registro_siguiente = $registro+1;

    $consulta_datoAnterior = "SELECT $variable from central where registro = $registro_anterior";
    $e_consulta_datoAnterior = pg_query($consulta_datoAnterior);
    $dato_anterior = pg_fetch_array($e_consulta_datoAnterior);

    $dato_actual = $datos_erroneos;

    $consulta_datoSiguiente = "SELECT $variable from central where registro = $registro_siguiente";
    $e_consulta_datoSiguiente = pg_query($consulta_datoSiguiente);
    $dato_siguiente = pg_fetch_array($e_consulta_datoSiguiente);

    $promedio = ((double)$dato_anterior[$variable] + (double)$dato_siguiente[$variable])/2; # calcula el promedio entre el dato anterior y el siguiente

    $consulta_filtrar = "UPDATE central SET $variable = $promedio WHERE registro = ".$registro.""; #actualiza el dato evaluado con el promedio calculado
    $resultado_filtrar = pg_query($consulta_filtrar);

    $actualizo = "UPDATE correcciones SET valor_corregido = $promedio WHERE (variable = '$variable') and (posicion = '$registro')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido con el promedio calculado
    $e_actualizo = pg_query($actualizo);

    $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variable') and (posicion = '$registro')";  # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando que se aplicó el promedio
    $e_actualizo_t = pg_query($actualizo_tipo);
  }
  elseif($tipo_correccion == 'diferencia_de_0,2'){
      $registro_anterior = $registro-1;
      $registro_siguiente = $registro+1; 

      $consulta_datoAnterior = "SELECT $variable from central where registro = $registro_anterior";
      $e_consulta_datoAnterior = pg_query($consulta_datoAnterior);
      $dato_anterior = pg_fetch_array($e_consulta_datoAnterior);

      $dato_actual = $datos_erroneos;

      $consulta_datoSiguiente = "SELECT $variable from central where registro = $registro_siguiente";
      $e_consulta_datoSiguiente = pg_query($consulta_datoSiguiente);
      $dato_Siguiente = pg_fetch_array($e_consulta_datoSiguiente);

      if($dato_anterior[$variable] != null and $dato_anterior[$variable] != '' and $dato_Siguiente[$variable] != null and $dato_Siguiente[$variable] != ''){
      $valor_anterior_numerico = (double)$dato_anterior[$variable]; # se convierte el dato anterior a dato numérico
      $valor_Siguiente_numerico = (double)$dato_Siguiente[$variable]; # se convierte el dato siguiente a dato numérico
      $variacion = abs($valor_anterior_numerico-$valor_Siguiente_numerico); # se verifica el valor de diferencia entre el anterior y el siguiente
      $variacion_2decimales = number_format($variacion, 2); # y se convierte la variacion a un formato numerico de dos decimales

      echo "<br>";
      echo ($registro_anterior)." -> ".$registro." -> ".$registro_siguiente; 

      echo "<br>";
      echo ($dato_anterior[$variable])." -> ".$valor_Siguiente_numerico." -> ".$variacion_2decimales; 

      if($variacion_2decimales == 0.20 || $variacion_2decimales == 0.00){ # valida que la variacion entre el anterior y el siguiente sea exactamente de 0,20 o 0,00

        $valor_anterior_2decimales = number_format($valor_anterior_numerico, 2); # si es se convierte el dato anterior a un formato numerico de dos decimales
        $consulta_filtrar = "UPDATE central SET $variable = $valor_anterior_2decimales WHERE registro = ".$registro.""; # y se actualiza el dato evaluado con el mismo dato presentado en el registro anterior
        $resultado_filtrar = pg_query($consulta_filtrar);

        $actualizo = "UPDATE correcciones SET valor_corregido = $valor_anterior_2decimales WHERE (variable = '$variable') and (posicion = '$registro')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido
        $e_actualizo = pg_query($actualizo);

        $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variable') and (posicion = '$registro')";  # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando el tipo de correccion aplicado
        $e_actualizo_t = pg_query($actualizo_tipo);

      }
      elseif ($variacion_2decimales > 0.20) { # si la diferencia entre el dato anterior y el siguiente excedio 0,20 haga:
          
        $observacion_precip = "UPDATE central SET observaciones = 'Ppt acumulada' WHERE registro = ".$registro_siguiente.""; # se actualiza el campo observaciones del dato siguiente con un mensaje 'ppt acumulada' que indica que hubo un valor de exceso y no se modifico corrigió por otro valor
        $resultado_observacion_precip = pg_query($observacion_precip);

          $actualizo = "UPDATE correcciones SET valor_corregido = ' null y Ppt acumulada en observaciones' WHERE (variable = '$variable') and (posicion = '$registro')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido
          $e_actualizo = pg_query($actualizo);

          $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variable') and (posicion = '$registro')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando el tipo de correccion aplicado
          $e_actualizo_t = pg_query($actualizo_tipo);
        }
      }
    }
    elseif ($tipo_correccion == 'dato_anterior') {
      $registro_anterior = $registro-1;
      $registro_siguiente = $registro+1;

      $consulta_datoAnterior = "SELECT $variable from central where registro = $registro_anterior";
      $e_consulta_datoAnterior = pg_query($consulta_datoAnterior);
      $dato_anterior = pg_fetch_array($e_consulta_datoAnterior);

      if($dato_anterior[$variable]){
      $valor_anterior_numerico = (double)$dato_anterior[$variable]; # guarda en $valor_anterior el valor anterior al evaluado en formato numérico
      $dato_anterior_2dec = number_format($valor_anterior_numerico, 2); # y lo convierte en formato de 2 decimales
      
      $consulta_filtrar = "UPDATE central SET $variable = $dato_anterior_2dec WHERE registro = ".$registro.""; # acualiza el campo evaluado con el dato anterior como lo indica el tipo de corrección
      $resultado_filtrar = pg_query($consulta_filtrar);

      $actualizo = "UPDATE correcciones SET valor_corregido = $dato_anterior_2dec WHERE (variable = '$variable') and (posicion = '$registro')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo de valor corregido
      $e_actualizo = pg_query($actualizo);

      $actualizo_tipo = "UPDATE correcciones SET tipo_correccion_aplicado = '$tipo_correccion' WHERE (variable = '$variable') and (posicion = '$registro')"; # y se actualiza la tabla correcciones en el campo donde se detecto el error se actualiza el campo correccion aplicado especificando el tipo de correccion aplicado
      $e_actualizo_t = pg_query($actualizo_tipo);
    }
    }

}
 

?>