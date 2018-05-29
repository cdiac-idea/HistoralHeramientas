<?php //sin
require_once("conexion2.php"); // Se incluye la conexión con el servidor

$central = "SELECT * from fact_table order by estacion_sk";
$e_central = pg_query($central);
$n_central = pg_num_rows($e_central);

echo($n_central);

?>
<table border=1>
    
    <tr>
    <th>radiacion_solar</th>
    <th>evapotranspiracion</th>
    <th>presion_barometrica</th>
    <th>direccion_viento</th>
    <th>velocidad_viento</th>
    <th>caudal</th>
    <th>nivel</th>
    <th>humedad_relativa</th>
    <th>brillo</th>
    <th>temperatura_med</th>
    <th>temperatura_min</th>
    <th>temperatura_max</th>
    <th>temperatura</th>
    <th>precipitacion</th>
    <th>tiempo_sk</th>
    <th>fecha_sk</th>
    <th>estacion_sk</th>
    
  </tr>

<?php

while ($f_c = pg_fetch_array($e_central)) {
    ?>
       
        <tr>
                

               <td> <?php  echo($f_c['radiacion_solar']); ?> </td>
                <td> <?php  echo($f_c['evapotranspiracion']); ?> </td>
                <td> <?php  echo($f_c['presion_barometrica']); ?> </td>
                <td> <?php  echo($f_c['direccion_viento']); ?> </td>
                <td> <?php  echo($f_c['velocidad_viento']); ?> </td>
                <td> <?php  echo($f_c['caudal']); ?> </td>
                <td> <?php  echo($f_c['nivel']); ?> </td>
                <td> <?php  echo($f_c['humedad_relativa']); ?> </td>
                <td> <?php  echo($f_c['brillo']); ?> </td>
                <td> <?php  echo($f_c['temperatura_med']); ?> </td>
                <td> <?php  echo($f_c['temperatura_min']); ?> </td>
                <td> <?php  echo($f_c['temperatura_max']); ?> </td>
                <td> <?php  echo($f_c['temperatura']); ?> </td>
                <td> <?php  echo($f_c['precipitacion']); ?> </td>
                <td> <?php  echo($f_c['tiempo_sk']); ?> </td>
                <td> <?php  echo($f_c['fecha_sk']); ?> </td>
                <td> <?php  echo($f_c['estacion_sk']); ?> </td>

        </tr>

    
<?php
}


?>
</table>