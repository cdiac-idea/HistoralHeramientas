<?php
require_once("conexiondwh.php");


$central = "SELECT * from correcciones";
$e_central = pg_query($central);
?>
     <table border=1>
          <tr>
    <th>id_correccion</th>
    <th>fecha</th>
    <th>hora</th>
    <th>estacion</th>
    <th>posicion</th>
    <th>variable</th>
    <th>valor_error</th>
    <th>observacion_error</th>
    <th>valor_corregido</th>
    <th>tipo_correccion_aplicado</th>
    <th>fecha_sk</th>
    <th>tiempo_sk</th>
    <th>estacion_sk</th>
   </tr>

<?php

while ($f_c = pg_fetch_array($e_central)) {
    ?>

       
        <tr>
                 <td> <?php  echo($f_c['id_correccion']); ?> </td>
                <td> <?php  echo($f_c['fecha']); ?> </td>
               <td> <?php  echo($f_c['hora']); ?> </td>
              <td> <?php  echo($f_c['estacion']); ?> </td>
             <td> <?php  echo($f_c['posicion']); ?> </td>
            <td> <?php  echo($f_c['variable']); ?> </td>
           <td> <?php  echo($f_c['valor_error']); ?> </td>
          <td> <?php  echo($f_c['observacion_error']); ?> </td>
         <td> <?php  echo($f_c['valor_corregido']); ?> </td>
          <td> <?php  echo($f_c['tipo_correccion_aplicado']); ?> </td>
            <td> <?php  echo($f_c['fecha_sk']); ?> </td>
               <td> <?php  echo($f_c['tiempo_sk']); ?> </td>
                 <td> <?php  echo($f_c['estacion_sk']); ?> </td>
         
        </tr>

    
<?php

}
?>

</table>