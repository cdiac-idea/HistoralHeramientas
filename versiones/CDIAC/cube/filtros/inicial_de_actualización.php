<?

require_once("../conexion/conexiondwh.php");

 $actualizoAcero = "UPDATE basedatos set filtrada = 0 ";
 pg_query($actualizoAcero);

  $actualizoAcero = "UPDATE tablas set filtrada = 0 ";
 pg_query($actualizoAcero);

 $actualizoAcero = "UPDATE tablas set activa = 1 ";
 pg_query($actualizoAcero);

 header("Location: traductor_cron.php");

?>