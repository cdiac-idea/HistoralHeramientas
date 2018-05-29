<?php //sin
require_once("../../../conexion/conexiondwh.php"); // Se incluye la conexión con el servidor

//$borroficial = "UPDATE tablas set dato_actual = '2015-08-22', hora_actual = '14:26:23' where id_tabla = 1";
//pg_query($borroficial);




$central = "SELECT * from confiabilidad_aire order by estacion_sk";
$e_central = pg_query($central);
$n_central = pg_num_rows($e_central);
echo($n_central);
?>
<table border=1>



<tr>
    <th>estacion_sk</th>
    <th>fecha_sk</th>
    <th>nombre_tabla</th>
    <th>total_entrante_so2</th>
    <th>total_buenos_so2</th>
    <th>soporte_so2</th> 
    <th>confianza_so2</th>
        <th>total_entrante_co</th>
    <th>total_buenos_co</th>
    <th>soporte_co</th> 
    <th>confianza_co</th>
        <th>total_entrante_o3</th>
    <th>total_buenos_o3</th>
    <th>soporte_o3</th> 
    <th>confianza_o3</th>
        <th>total_entrante_pm10</th>
    <th>total_buenos_pm10</th>
    <th>soporte_pm10</th> 
    <th>confianza_pm10</th>
            <th>total_entrante_pm2_5</th>
    <th>total_buenos_pm2_5</th>
    <th>soporte_pm2_5</th> 
    <th>confianza_pm2_5</th>

  </tr>

<?php

while ($f_c = pg_fetch_array($e_central)) {
    ?>


    
       
        <tr>
                 <td> <?php  echo($f_c['estacion_sk']); ?> </td>
                <td> <?php  echo($f_c['fecha_sk']); ?> </td>
               <td> <?php  echo($f_c['nombre_tabla']); ?> </td>
              <td> <?php  echo($f_c['total_entrante_so2']); ?> </td>
             <td> <?php  echo($f_c['total_buenos_so2']); ?> </td>
            <td> <?php  echo($f_c['soporte_so2']); ?> </td>
            <td> <?php  echo($f_c['confianza_so2']); ?> </td>
            <td> <?php  echo($f_c['total_entrante_co']); ?> </td>
                            <td> <?php  echo($f_c['total_buenos_co']); ?> </td>
                <td> <?php  echo($f_c['soporte_co']); ?> </td>
               <td> <?php  echo($f_c['confianza_co']); ?> </td>
              <td> <?php  echo($f_c['total_entrante_o3']); ?> </td>
             <td> <?php  echo($f_c['total_buenos_o3']); ?> </td>
            <td> <?php  echo($f_c['soporte_o3']); ?> </td>
            <td> <?php  echo($f_c['confianza_o3']); ?> </td>
            <td> <?php  echo($f_c['total_entrante_pm10']); ?> </td>
                            <td> <?php  echo($f_c['total_buenos_pm10']); ?> </td>
                <td> <?php  echo($f_c['soporte_pm10']); ?> </td>
               <td> <?php  echo($f_c['confianza_pm10']); ?> </td>
              <td> <?php  echo($f_c['total_entrante_pm2_5']); ?> </td>
             <td> <?php  echo($f_c['total_buenos_pm2_5']); ?> </td>
            <td> <?php  echo($f_c['soporte_pm2_5']); ?> </td>
            <td> <?php  echo($f_c['confianza_pm2_5']); ?> </td>

        </tr>

    
<?php
}
?>
</table>

