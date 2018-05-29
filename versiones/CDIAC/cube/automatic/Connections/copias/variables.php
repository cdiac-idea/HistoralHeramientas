<?php
require_once("../../../conexion/conexiondwh.php");

$central = "SELECT * from variables order by estacion_sk";
$e_central = pg_query($central);
$r_central = pg_num_rows($e_central);
echo($r_central);
?>
    <table border=1>
          <tr>
    <th>estacion_sk</th>
    <th>estacion</th>
    <th>variables</th>
    <th>minimo</th>
    <th>maximo</th>
    <th>diferencia_anterior</th>
    <th>id_variable_estacion</th>
    <th>variable_excel</th>
    <th>tipo_correccion</th>
    
  </tr>

<?php

while ($f_c = pg_fetch_array($e_central)) {
    ?>

       
        <tr>
                 <td> <?php  echo($f_c['estacion_sk']); ?> </td>
                <td> <?php  echo($f_c['estacion']); ?> </td>
               <td> <?php  echo($f_c['variables']); ?> </td>
              <td> <?php  echo($f_c['minimo']); ?> </td>
             <td> <?php  echo($f_c['maximo']); ?> </td>
            <td> <?php  echo($f_c['diferencia_anterior']); ?> </td>
           <td> <?php  echo($f_c['id_variable_estacion']); ?> </td>
          <td> <?php  echo($f_c['variable_excel']); ?> </td>
         <td> <?php  echo($f_c['tipo_correccion']); ?> </td>

        </tr>

    
<?php

}
?>

</table>