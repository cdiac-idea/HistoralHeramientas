<?php //sin
require_once("conexiondwh.php"); // Se incluye la conexión con el servidor

$central = "SELECT * from fact_aire order by estacion_sk";
$e_central = pg_query($central);
$n_central = pg_num_rows($e_central);


?>
<table border=1>
    
    <tr>
    <th>estacion_sk</th>
    <th>fecha_sk</th>
    <th>tiempo_sk</th>
    <th>so2_local_ppt</th>
    <th>so2_local_ugm3</th>
    <th>so2_estan_ugm3</th>
    <th>co_local_ppt</th>
    <th>co_local_ugm3</th>
    <th>co_estan_ugm3</th>
    <th>o3_local_ppt</th>
    <th>o3_local_ugm3</th>
    <th>o3_estan_ugm3</th>
    <th>pm10</th>
    <th>pm2_5</th>
    
  </tr>

<?php

while ($f_c = pg_fetch_array($e_central)) {
    ?>
       
        <tr>
                

               <td> <?php  echo($f_c['estacion_sk']); ?> </td>
                <td> <?php  echo($f_c['fecha_sk']); ?> </td>
                <td> <?php  echo($f_c['tiempo_sk']); ?> </td>
                <td> <?php  echo($f_c['so2_local_ppt']); ?> </td>
                <td> <?php  echo($f_c['so2_local_ugm3']); ?> </td>
                <td> <?php  echo($f_c['so2_estan_ugm3']); ?> </td>
                <td> <?php  echo($f_c['co_local_ppt']); ?> </td>
                <td> <?php  echo($f_c['co_local_ugm3']); ?> </td>
                <td> <?php  echo($f_c['co_estan_ugm3']); ?> </td>
                <td> <?php  echo($f_c['o3_local_ppt']); ?> </td>
                <td> <?php  echo($f_c['o3_local_ugm3']); ?> </td>
                <td> <?php  echo($f_c['o3_estan_ugm3']); ?> </td>
                <td> <?php  echo($f_c['pm10']); ?> </td>
                <td> <?php  echo($f_c['pm2_5']); ?> </td>

        </tr>

    
<?php
}


?>
</table>