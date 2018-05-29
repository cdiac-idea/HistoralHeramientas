<?php

    include('../bd/base/inicioSql.php');

    if ($_POST) {
        $idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
        $idAno1 = array_key_exists('idAnio1', $_POST) ? $_POST['idAnio1'] : null;
        $idAno2 = array_key_exists('idAnio2', $_POST) ? $_POST['idAnio2'] : null;
        $idMes1 = array_key_exists('idMes1', $_POST) ? $_POST['idMes1'] : null;
        $idMes2 = array_key_exists('idMes2', $_POST) ? $_POST['idMes2'] : null;
        $idDia1 = array_key_exists('idDia1', $_POST) ? $_POST['idDia1'] : null;
        $idDia2 = array_key_exists('idDia2', $_POST) ? $_POST['idDia2'] : null;

        $variables = countVariable($idEstacion, $idAno1, $idAno2, $idMes1, $idMes2, $idDia1, $idDia2);
        //echo var_dump($variables);
        if($variables[0]['precipitacion'] > 0) {
            echo "<input type='checkbox' name='idPrecipitacion' id='idPrecipitacion' value = 'precipitacion' />Precipitacion<br>";
        }
        if($variables[0]['temperatura'] > 0) {
            echo "<input type='checkbox' name='idTemperatura' id='idTemperatura' value = 'temperatura'/>Temperatura<br>";
        }
        if($variables[0]['temperatura_max'] > 0) {
            echo "<input type='checkbox' name='idTemperatura_max' id='idTemperatura_max' value = 'temperatura_max'/>Temperatura Maxima<br>";
        }
        if($variables[0]['temperatura_min'] > 0) {
            echo "<input type='checkbox' name='idTemperatura_min' id='idTemperatura_min' value = 'temperatura_min'/>Temperatura Minima<br>";
        }
        if($variables[0]['temperatura_med'] > 0) {
            echo "<input type='checkbox' name='idTemperatura_med' id='idTemperatura_med' value = 'temperatura_med'/>Temperatura Media<br>";
        }
        if($variables[0]['brillo'] > 0) {
            echo "<input type='checkbox' name='idBrillo' id='idBrillo' value = 'brillo'/>Brillo<br>";
        }
        if($variables[0]['humedad_relativa'] > 0) {
            echo "<input type='checkbox' name='idHumedad_relativa' id='idHumedad_relativa' value = 'humedad_relativa'/>Humedad Relativa<br>";
        }
        if($variables[0]['nivel'] > 0) {
            echo "<input type='checkbox' name='idNivel' id='idNivel' value = 'nivel'/>Nivel<br>";
        }
        if($variables[0]['caudal'] > 0) {
            echo "<input type='checkbox' name='idCaudal' id='idCaudal' value = 'caudal'/>Caudal<br>";
        }
        if($variables[0]['velocidad_viento'] > 0) {
            echo "<input type='checkbox' name='idVelocidad_viento' id='idVelocidad_viento' value = 'velocidad_viento'/>Velocidad Viento<br>";
        }
        if($variables[0]['direccion_viento'] > 0) {
            echo "<input type='checkbox' name='idDireccion_viento' id='idDireccion_viento' value = 'direccion_viento'/>Direccion Viento<br>";
        }
        if($variables[0]['presion_barometrica'] > 0) {
            echo "<input type='checkbox' name='idPresion_barometrica' id='idPresion_barometrica' value = 'presion_barometrica'/>Presion Barometrica<br>";
        }
        if($variables[0]['evapotranspiracion'] > 0) {
            echo "<input type='checkbox' name='idEvapotranspiracion' id='idEvapotranspiracion' value = 'evapotranspiracion'/>Evapotranspiracion<br>";
        }
        if($variables[0]['radiacion_solar'] > 0) {
            echo "<input type='checkbox' name='idRadiacion_solar' id='idRadiacion_solar' value = 'radiacion_solar'/>Radiacion Solar<br>";
        }
    }


    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('../bd/base/finSql.php');
?>
