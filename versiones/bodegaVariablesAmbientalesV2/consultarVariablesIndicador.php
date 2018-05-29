<?php
    //inicio de html y parte del menu ademas de funciones con las consultas sql
    
    session_start();
    $nombreUsuario = $_SESSION['nombreUsuario'];
    $perfil = $_SESSION['perfil'];
    $usuario = $_SESSION['idUsu'];
    
    include('base/inicioSql.php');

    if ($_POST) {
        $idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
        $idAno1 = array_key_exists('idAnio1', $_POST) ? $_POST['idAnio1'] : null;
        $idAno2 = array_key_exists('idAnio2', $_POST) ? $_POST['idAnio2'] : null;
        $idMes1 = array_key_exists('idMes1', $_POST) ? $_POST['idMes1'] : null;
        $idMes2 = array_key_exists('idMes2', $_POST) ? $_POST['idMes2'] : null;
        $idDia1 = array_key_exists('idDia1', $_POST) ? $_POST['idDia1'] : null;
        $idDia2 = array_key_exists('idDia2', $_POST) ? $_POST['idDia2'] : null;

        $variables = countVariable($idEstacion, $idAno1, $idAno2, $idMes1, $idMes2, $idDia1, $idDia2);
        if($variables[0]['precipitacion'] > 0) {
            echo "<input type='checkbox' name='Ppt' id='Ppt' value='3'/>Ppt  Precipitación (total diario y percentil 95)<br><!--pagina 8-->";
            #if ($perfil<5) {
                echo "<input type='checkbox' name='A25' id='A25' value='4'/>Ppt.Ac-A25  Lluvia acumulada <br> <!--pagina 12-->";
            #}
        }
        if($variables[0]['temperatura'] > 0 || $variables[0]['temperatura_max'] > 0 || $variables[0]['temperatura_min'] > 0 || $variables[0]['temperatura_med'] > 0) {
            echo "<input type='checkbox' name='TEMP' id='TEMP' value='1'/>TEMP  Temperatura (percentil 95, promedio, máxima y mínima)<br><!--pagina 1-->";
            echo "<input type='checkbox' name='RANGO-TEMP' id='RANGO-TEMP' value='2'/>RANGO-TEMP  Amplitud o rango de temperatura<br><!--pagina 5-->";
        }
        if($variables[0]['precipitacion'] > 0 && $variables[0]['temperatura'] > 0 ) {
            echo "<input type='checkbox' name='I-ARIDEZ' id='I-ARIDEZ' value='11'/>I-ARIDEZ  Índice de Aridez <br> <!--pagina 12-->";
        }
        if($variables[0]['humedad_relativa'] > 0) {
            echo "<input type='checkbox' name='HRm-HRmm' id='HRm-HRmm' value='6'/>HRm-HRmm  Humedad relativa (promedios mensual y mensual multianual)<br><!--pagina 19-->";
        }
        if($variables[0]['temperatura'] > 0 && $variables[0]['humedad_relativa'] > 0 && $variables[0]['velocidad_viento'] > 0) {
            echo "<input type='checkbox' name='CONFORT-T' id='CONFORT-T' value='9'/>CONFORT-T Confort térmico <br> <!--pagina 26-->";
        }
        if($variables[0]['velocidad_viento'] > 0 && $variables[0]['direccion_viento'] > 0) {
            echo "<input type='checkbox' name='DVV' id='DVV' value='5'/>DVV  Dirección y velocidad del viento (promedios mensual y mensual multianual)<br><!--pagina 15-->";
        }
        /*if($variables[0]['presion_barometrica'] > 0) {
            echo "<input type='checkbox' name='Pbm-Pbmm' id='Pbm-Pbmm' value='8'/>Pbm-Pbmm  Presión barométrica (promedios mensual y mensual multianual)<br><!--pagina 24-->";
        }*/
        if($variables[0]['radiacion_solar'] > 0) {
            echo "<input type='checkbox' name='RS' id='RS' value='7'/>RS  Radiación solar (promedios mensual y mensual multianual)<br><!--pagina 21-->";
        }
    }

    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('base/finSql.php');
?>
