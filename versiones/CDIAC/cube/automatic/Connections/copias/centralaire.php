<?php
require_once("conexiondwh.php");

$central = "SELECT * from centralaire order by registro";
$e_central = pg_query($central);
$r_central = pg_num_rows($e_central);
echo($r_central);
?>
    <table border=1>
          <tr>
    <th>fecha</th>
    <th>hora</th>
    <th>so2</th>
    <th>o3</th>
    <th>co</th>
    <th>fecha_sk</th>
    <th>tiempo_sk</th>
    <th>estacion_sk</th>
    <th>registro</th>
    
  </tr>

<?php

while ($f_c = pg_fetch_array($e_central)) {
    ?>

       
        <tr>
                 <td> <?php  echo($f_c['fecha']); ?> </td>
                <td> <?php  echo($f_c['hora']); ?> </td>
               <td> <?php  echo($f_c['so2']); ?> </td>
              <td> <?php  echo($f_c['o3']); ?> </td>
             <td> <?php  echo($f_c['co']); ?> </td>
            <td> <?php  echo($f_c['fecha_sk']); ?> </td>
           <td> <?php  echo($f_c['tiempo_sk']); ?> </td>
          <td> <?php  echo($f_c['estacion_sk']); ?> </td>
         <td> <?php  echo($f_c['registro']); ?> </td>

        </tr>

    
<?php

}
?>

</table>