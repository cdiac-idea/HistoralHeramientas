<?php //sin
require_once("conexion2.php");

$central = "SELECT * from confiabilidad order by fecha_sk";
$e_central = pg_query($central);
$n_centra = pg_num_rows($e_central);


?>
<table border=1>
          <tr>
  <th> estacion_sk</th>
  <th>fecha_sk </th>
  <th>total_entrante_precipitacion </th>
  <th>total_buenos_precipitacion </th>
  <th>soporte_precipitacion </th>
  <th>confianza_precipitacion </th>
  <th>total_entrante_temperatura </th>
  <th>total_buenos_temperatura </th>
  <th>soporte_temperatura </th>
  <th>confianza_temperatura </th>
  <th>total_entrante_brillo </th>
  <th>total_buenos_brillo </th>
  <th>soporte_brillo </th>
  <th>confianza_brillo </th>
  <th>total_entrante_humedad_relativa </th>
  <th>total_buenos_humedad_relativa</th>
  <th>soporte_humedad_relativa </th>

  <th>confianza_humedad_relativa </th>
  <th>total_entrante_nivel </th>
  <th>total_buenos_nivel </th>
  <th>soporte_nivel </th>
  <th>confianza_nivel </th>
  <th>total_entrante_caudal </th>
  <th>total_buenos_caudal </th>
  <th>soporte_caudal </th>
  <th>confianza_caudal </th>
  <th>total_entrante_velocidad_viento </th>
  <th>total_buenos_velocidad_viento </th>
  <th>soporte_velocidad_viento </th>
  <th>confianza_velocidad_viento </th>
  <th>total_entrante_direccion_viento </th>
  <th>total_buenos_direccion_viento </th>

  <th>soporte_direccion_viento </th>
  <th>confianza_direccion_viento </th>
  <th>total_entrante_presion_barometrica </th>
  <th>total_buenos_presion_barometrica </th>
  <th>soporte_presion_barometrica </th>
  <th>confianza_presion_barometrica </th>
  <th>total_entrante_evapotranspiracion </th>
  <th>total_buenos_evapotranspiracion </th>
  <th>soporte_evapotranspiracion </th>
  <th>confianza_evapotranspiracion </th>
  <th>total_entrante_radiacion_solar </th>
  <th>total_buenos_radiacion_solar </th>
  <th>soporte_radiacion_solar </th>
  <th>confianza_radiacion_solar </th>
    
  </tr>

<?php

while ($f_c = pg_fetch_array($e_central)) {
    ?>


    
       
        <tr>
                 <td> <?php  echo($f_c['estacion_sk']); ?> </td>
                <td> <?php  echo($f_c['fecha_sk']); ?> </td>
               <td> <?php  echo($f_c['total_entrante_precipitacion']); ?> </td>
              <td> <?php  echo($f_c['total_buenos_precipitacion']); ?> </td>
             <td> <?php  echo($f_c['soporte_precipitacion']); ?> </td>
            <td> <?php  echo($f_c['confianza_precipitacion']); ?> </td>
           <td> <?php  echo($f_c['total_entrante_temperatura']); ?> </td>
          <td> <?php  echo($f_c['total_buenos_temperatura']); ?> </td>
         <td> <?php  echo($f_c['soporte_temperatura']); ?> </td>
          <td> <?php  echo($f_c['confianza_temperatura']); ?> </td>
           <td> <?php  echo($f_c['total_entrante_brillo']); ?> </td>
            <td> <?php  echo($f_c['total_buenos_brillo']); ?> </td>
             <td> <?php  echo($f_c['soporte_brillo']); ?> </td>
              <td> <?php  echo($f_c['confianza_brillo']); ?> </td>
               <td> <?php  echo($f_c['total_entrante_humedad_relativa']); ?> </td>
                <td> <?php  echo($f_c['total_buenos_humedad_relativa']); ?> </td>
                 <td> <?php  echo($f_c['soporte_humedad_relativa']); ?> </td>
                <td> <?php  echo($f_c['confianza_humedad_relativa']); ?> </td>
                 <td> <?php  echo($f_c['total_entrante_nivel']); ?> </td>
                 <td> <?php  echo($f_c['total_buenos_nivel']); ?> </td>
                 <td> <?php  echo($f_c['soporte_nivel']); ?> </td>
                 <td> <?php  echo($f_c['confianza_nivel']); ?> </td>
                 <td> <?php  echo($f_c['total_entrante_caudal']); ?> </td>
                 <td> <?php  echo($f_c['total_buenos_caudal']); ?> </td>
                 <td> <?php  echo($f_c['soporte_caudal']); ?> </td>
                 <td> <?php  echo($f_c['confianza_caudal']); ?> </td>
                 <td> <?php  echo($f_c['total_entrante_velocidad_viento']); ?> </td>
                 <td> <?php  echo($f_c['total_buenos_velocidad_viento']); ?> </td>
                 <td> <?php  echo($f_c['soporte_velocidad_viento']); ?> </td>
                 <td> <?php  echo($f_c['confianza_velocidad_viento']); ?> </td>
                 <td> <?php  echo($f_c['total_entrante_direccion_viento']); ?> </td>
                 <td> <?php  echo($f_c['total_buenos_direccion_viento']); ?> </td>
                 <td> <?php  echo($f_c['soporte_direccion_viento']); ?> </td>
                 <td> <?php  echo($f_c['confianza_direccion_viento']); ?> </td>
                 <td> <?php  echo($f_c['total_entrante_presion_barometrica']); ?> </td>
                 <td> <?php  echo($f_c['total_buenos_presion_barometrica']); ?> </td>
                 <td> <?php  echo($f_c['soporte_presion_barometrica']); ?> </td>
                 <td> <?php  echo($f_c['confianza_presion_barometrica']); ?> </td>
                 <td> <?php  echo($f_c['total_entrante_evapotranspiracion']); ?> </td>
                 <td> <?php  echo($f_c['total_buenos_evapotranspiracion']); ?> </td>
                 <td> <?php  echo($f_c['soporte_evapotranspiracion']); ?> </td>
                 <td> <?php  echo($f_c['confianza_evapotranspiracion']); ?> </td>
                 <td> <?php  echo($f_c['total_buenos_radiacion_solar']); ?> </td>
                 <td> <?php  echo($f_c['soporte_radiacion_solar']); ?> </td>
                 <td> <?php  echo($f_c['confianza_radiacion_solar']); ?> </td>

        </tr>

    
<?php
}
?>
<!--</table>-->