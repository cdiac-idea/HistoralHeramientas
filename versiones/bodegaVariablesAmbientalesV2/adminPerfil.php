<?php
	//inicio de html y parte del menu ademas de funciones con las consultas sql
	include('base/inicio.php');
	require_once("configuracion/clsBD.php");
	$objUsuar = new clsDatos();

	if ($_POST) {
		$idNombre = array_key_exists('nombre', $_POST) ? $_POST['nombre'] : null;
		$idApellido = array_key_exists('apellido', $_POST) ? $_POST['apellido'] : null;
		$idCedula = array_key_exists('cedula', $_POST) ? $_POST['cedula'] : null;
		$iddependencia = array_key_exists('dependencia', $_POST) ? $_POST['dependencia'] : null;
		$idcargo = array_key_exists('cargo', $_POST) ? $_POST['cargo'] : null;
		$idClave = array_key_exists('clave', $_POST) ? $_POST['clave'] : null;

		$sql= "UPDATE usuario SET id_usuario=".$usuario;
		if ($idNombre != null) {$sql .= ", nombre='$idNombre'";}
		if ($idApellido != null) {$sql .= ", apellido='$idApellido'";}
		if ($idCedula != null) {$sql .= ", cedula=".$idCedula;}
		if ($iddependencia != null) {$sql .= ", dependencia='$iddependencia'";}
		if ($idcargo != null) {$sql .= ", cargo='$idcargo'";}
		if ($idClave != null) {$sql .= ", contrasenia=MD5('$idClave')";}
		$sql .= " WHERE id_usuario=".$usuario;
		$objUsuar->operacionesCrud($sql);

		echo "<meta http-equiv='refresh' content='0;url=adminPerfil.php' />";
	}
?>
<h4 class="alert_info">Datos personales</h4><br>
<form action="adminPerfil.php" method="POST" onsubmit="return validacion()">
	<center>
		<table>
			<tr><th colspan = 2 >Actualizar datos personales</th></tr>
			<tr><td><br></td></tr>
			<tr><td>Nombre: </td><td><input class="datos" type="text" name="nombre" id="nombre" value="<?php echo $arreglo_datos['nombre'];?>"   /></td></tr>
			<tr><td>Apellido: </td><td><input class="datos" type="text" name="apellido" id="apellido" value="<?php echo $arreglo_datos['apellido'];?>"   /></td></tr>
			<tr><td>Cedula: </td><td><input class="datos" type="text" name="cedula" id="cedula" value="<?php echo $arreglo_datos['cedula'];?>"   /></td></tr>
			<tr><td>Dependencia: </td><td><input class="datos" type="text" name="dependencia" id="dependencia" value="<?php echo $arreglo_datos['dependencia'];?>"   /></td></tr>
			<tr><td>Cargo: </td><td><input class="datos" type="text" name="cargo" id="cargo" value="<?php echo $arreglo_datos['cargo'];?>"   /></td></tr>
			<tr><td>Nueva Contraseña: </td><td><input class="datos" type="password" name="clave" id="clave" /></td></tr>
			<tr><td><br></td></tr>
			<tr>
				<td colspan = 2 >
					<center>
						<input id="boton" type="submit" value="Guardar"/>
						<input id="boton" type="reset" value="Limpiar"/>
					</center>
				</td>
			</tr>
		</table>
<?php
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
	include('base/fin.php');
?>