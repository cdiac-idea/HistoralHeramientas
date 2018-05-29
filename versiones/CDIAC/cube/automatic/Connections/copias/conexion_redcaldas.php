<?php //sin
require_once("../../../conexion/conexionyarumos.php"); // Se incluye la conexión con el servidor

$ohno = "DELETE from fact_table where estacion_sk = '36'";
$e_ohno = pg_query($ohno);
/*$r = "select column_name
from information_schema.columns
where table_name = 'usuario'";
$e = pg_query($r);

while ($f = pg_fetch_array($e)) {
  echo($f['column_name']);
  echo "<br>";
}

$central = "SELECT * from usuario";

$e_central = pg_query($central);

while ($f_c = pg_fetch_array($e_central)) {
echo($f_c['contrasenia']);
echo "<br>";

}
*/

$borro_de_fact = "SELECT count(estacion_sk) as cantidad FROM fact_table where estacion_sk = '36'";
$e_b = pg_query($borro_de_fact);
$f_b = pg_fetch_array($e_b);
echo($f_b['cantidad']);

/*$fecha_fact = "SELECT fecha_sk,tiempo_sk FROM fact_table where estacion_sk = '19' group by fecha_sk, tiempo_sk order by (fecha_sk, tiempo_sk)";
$e_ba = pg_query($fecha_fact);
while ($f_ba = pg_fetch_array($e_ba)){
echo($f_ba['fecha_sk']); 
echo "::::";
echo($f_ba['tiempo_sk']);
echo "<br>";
}*/
/*
$central = "SELECT * from central2 order by registro";

$e_central = pg_query($central);

while ($f_c = pg_fetch_array($e_central)) {
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
 
    </table>
<?php
}*/
?>