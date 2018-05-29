<?php
	$archivo = $_FILES["cargar_archivo_frm"]["tmp_name"];
	echo "vamos por el primero";
	$destino = "../backups".$_FILES["cargar_archivo_frm"]["name"];


	move_uploaded_file($archivo,$destino);
	echo "archivo subido"


?>