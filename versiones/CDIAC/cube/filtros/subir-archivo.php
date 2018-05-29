<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
foreach ($_FILES["archivo"] as $key => $value) {
	echo"propiedad: $key  --- Valor: $value<br/>";
}
?>
<script>
function leer_pais()
    {
    // obteniendo el valor del elemento
    var pais = document.getElementById("red").value;
    alert(pais);
    }
</script>
<?php
/*
	$archivo = $_FILES["archivo"]["tmp_name"];
	$nombre = "datos";
	$extension = ".csv";
	$destino = "../backups/".$nombre.$extension;


	move_uploaded_file($archivo,$destino);
	//header("Location: filtros_all.php");
*/

?>