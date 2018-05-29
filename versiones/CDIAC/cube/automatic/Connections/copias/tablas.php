<?php //sin
require_once("../../../conexion/conexion2.php"); // Se incluye la conexión con el servidor

//$borroficial = "UPDATE tablas set dato_actual = '2015-08-22', hora_actual = '14:26:23' where id_tabla = 1";
//pg_query($borroficial);




$central = "SELECT * from tablas order by id_tabla";
$e_central = pg_query($central);
$n_central = pg_num_rows($e_central);
echo($n_central);
?>
<table border=1>
          <tr>
    <th>id_tabla</th>
    <th>estacion</th>
    <th>nombre_tabla</th>
    <th>dato_actual</th>
    <th>id_basedatos</th>
    <th>hora_actual</th>  
    <th>activa</th>
    <th>filtrada</th>   
  </tr>

<?php

while ($f_c = pg_fetch_array($e_central)) {
    ?>


    
       
        <tr>
                 <td> <?php  echo($f_c['id_tabla']); ?> </td>
                <td> <?php  echo($f_c['estacion']); ?> </td>
               <td> <?php  echo($f_c['nombre_tabla']); ?> </td>
              <td> <?php  echo($f_c['dato_actual']); ?> </td>
             <td> <?php  echo($f_c['id_basedatos']); ?> </td>
            <td> <?php  echo($f_c['hora_actual']); ?> </td>
            <td> <?php  echo($f_c['activa']); ?> </td>
            <td> <?php  echo($f_c['filtrada']); ?> </td>
        </tr>

    
<?php
}
?>
</table>

