<?php
require_once("conexiondwh.php");

$central = "SELECT * from central order by (fecha,hora)";
$e_central = pg_query($central);
$r_central = pg_num_rows($e_central);
echo($r_central);
?>
    <table border=1>
          <tr>
    <th>registro</th>
    <th>estacion_sk</th>
    <th>tiempo_sk</th>
    <th>fecha_sk</th>
    <th>nivel</th>
    <th>evapotranspiracion</th>
    <th>radiacion_solar</th>
    <th>precipitacion</th>
    <th>humedad_relativa</th>
    <th>presion_barometrica</th>
    <th>caudal</th>
    <th>direccion_viento</th>
    <th>velocidad_viento</th>
    <th>temperatura</th>
    <th>hora</th>
    <th>fecha</th>
    <th>observaciones</th>
    
  </tr>

<?php

while ($f_c = pg_fetch_array($e_central)) {
    ?>

       
        <tr>
                 <td> <?php  echo($f_c['registro']); ?> </td>
                <td> <?php  echo($f_c['estacion_sk']); ?> </td>
               <td> <?php  echo($f_c['tiempo_sk']); ?> </td>
              <td> <?php  echo($f_c['fecha_sk']); ?> </td>
             <td> <?php  echo($f_c['nivel']); ?> </td>
            <td> <?php  echo($f_c['evapotranspiracion']); ?> </td>
           <td> <?php  echo($f_c['radiacion_solar']); ?> </td>
          <td> <?php  echo($f_c['precipitacion']); ?> </td>
         <td> <?php  echo($f_c['humedad_relativa']); ?> </td>
          <td> <?php  echo($f_c['presion_barometrica']); ?> </td>
           <td> <?php  echo($f_c['caudal']); ?> </td>
            <td> <?php  echo($f_c['direccion_viento']); ?> </td>
             <td> <?php  echo($f_c['velocidad_viento']); ?> </td>
              <td> <?php  echo($f_c['temperatura']); ?> </td>
               <td> <?php  echo($f_c['hora']); ?> </td>
                <td> <?php  echo($f_c['fecha']); ?> </td>
                 <td> <?php  echo($f_c['observaciones']); ?> </td>

        </tr>

    
<?php

}
?>

</table>