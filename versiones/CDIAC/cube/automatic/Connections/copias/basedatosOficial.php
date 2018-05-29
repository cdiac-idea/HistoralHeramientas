<?php //sin
require_once("conexion2.php"); // Se incluye la conexión con el servidor

$central = "SELECT * from basedatos order by id_basedatos";
$e_central = pg_query($central);
$n_central = pg_num_rows($e_central);
echo($n_central);
?>
<table border=1>
          <tr>
    <th>id_basedatos</th>
    <th>usuario</th>
    <th>red</th>
    <th>nombrebasedatos</th>
    <th>contrasenia</th>
    <th>activa</th>
    <th>filtrada</th>

  </tr>

<?php

while ($f_c = pg_fetch_array($e_central)) {
    ?>


    
       
        <tr>
                 <td> <?php  echo($f_c['id_basedatos']); ?> </td>
                <td> <?php  echo($f_c['usuario']); ?> </td>
               <td> <?php  echo($f_c['red']); ?> </td>
              <td> <?php  echo($f_c['nombrebasedatos']); ?> </td>
             <td> <?php  echo($f_c['contrasenia']); ?> </td>
            <td> <?php  echo($f_c['activa']); ?> </td>
            <td> <?php  echo($f_c['filtrada']); ?> </td>
        </tr>

    
<?php
}
?>
</table>

