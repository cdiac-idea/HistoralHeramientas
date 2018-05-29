<?php
session_start();
require_once("../../conexion/conexiondwh.php");
$x = $_SESSION['x'];
echo($x);
$estacion_sk=$_SESSION['esta_sk'];
//echo($x);
echo "<br>";
//$var = $_POST['check2'];

//echo($var);

   $nchecks=$x;
   for($i=0;$i<$nchecks;$i++)
   {
       $nombre="check$i";
       if(isset($_POST[$nombre])){
       	echo "Se presiono el $nombre<br>";
       	$vari = "SELECT id_variable, nombre from variable where id_variable not in (select id_variable from esta_var where estacion_sk='$estacion_sk') limit 1 offset $i";
        $e_vari = pg_query($vari);
        $r_vari = pg_fetch_array($e_vari);
        $id_variable = $r_vari['id_variable'];
        echo "<br>";
        $nombre = $r_vari['nombre'];
        echo "<br>";
        #INSERTAR
        $insertar = "INSERT INTO esta_var (estacion_sk, id_variable, deteccion) values ($estacion_sk, $id_variable,0)";
        $e_insert = pg_query($insertar);
       }
   }
header('Location: ../agregar_list.php');
?>