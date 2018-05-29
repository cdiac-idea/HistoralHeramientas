<?php
require_once("../../../conexion/conexion2.php");

$central = "SELECT * from variables_aire";
$e_central = pg_query($central);
$n_central = pg_num_rows($e_central);

?>
    <table border=1>
          <tr>
  <th>estacion_sk</th>
  <th>fecha_sk</th>
  <th>tiempo_sk</th>
  <th>observa_pesipitacion</th>
 
    
  </tr>

<?php

while ($f_c = pg_fetch_array($e_central)) {
    ?>

       
        <tr>
                  <td> <?php  echo var_dump($f_c['estacion_sk']); ?> </td>
                <td> <?php  echo($f_c['fecha_sk']); ?> </td>
                <td> <?php  echo($f_c['tiempo_sk']); ?> </td>
                  <td> <?php  echo($f_c['observa_pesipitacion']); ?> </td>
             

        </tr>

    
<?php

}
?>
