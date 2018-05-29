<?php
	//inicio de html y parte del menu ademas de funciones con las consultas sql
	include('base/inicio.php');
	if ($_POST) {
		$idNombre = array_key_exists('nombre', $_POST) ? $_POST['nombre'] : null;
		$idApellido = array_key_exists('apellido', $_POST) ? $_POST['apellido'] : null;
		$idCedula = array_key_exists('cedula', $_POST) ? $_POST['cedula'] : null;
		$idDependencia = array_key_exists('dependencia', $_POST) ? $_POST['dependencia'] : null;
		$idCargo = array_key_exists('cargo', $_POST) ? $_POST['cargo'] : null;
		$idRol = array_key_exists('rol', $_POST) ? $_POST['rol'] : null;
		$idNomb_usuario = array_key_exists('nomb_usuario', $_POST) ? $_POST['nomb_usuario'] : null;
		$idClave = array_key_exists('clave', $_POST) ? $_POST['clave'] : null;

		crearUsu($idNombre, $idApellido, $idCedula, $idDependencia, $idCargo, $idRol, $idNomb_usuario, $idClave);

	}
?>
<h4 class="alert_info">Crear Usuario</h4><br>
<center>
	<form action="crearUsu.php" method="post" onsubmit="return validacion()">
		<table>
			<tr><th colspan = 2 >Creacion de Usuarios</th></tr>
			<tr><td><br><br></td></tr>
			<tr><td>Nombre: </td><td><input  id="datos" type="text" name="nombre" id="nombre"/></td></tr>
			<tr><td>Apellido: </td><td><input id="datos" type="text" name="apellido" id="apellido"/></td></tr>
			<tr><td>Cedula: </td><td><input id="datos" type="text" name="cedula" id="cedula"/></td></tr>
			<tr><td>Dependencia: </td><td><input id="datos" type="text" name="dependencia" id="dependencia"/></td></tr>
			<tr><td>Cargo: </td><td><input id="datos" type="text" name="cargo" id="cargo"/></td></tr>
			<tr><td>Rol:</td><td>
				<select name="rol" id="rol">
					<option>Seleccione</option> 
                    <?php
                    	$sql = "SELECT id_rol, descripcion FROM rol";
                    	if ($perfil == 3) {
                    		$sql .= " WHERE id_rol=3 OR id_rol=4";
                    	}
                    	if ($perfil == 5) {
                    		$sql .= " WHERE id_rol=5 OR id_rol=6";
                    	}
						$arreglo_rol = $objDatos->executeQuery($sql);
						if ($arreglo_rol) {
							foreach ($arreglo_rol as $value) {
                            	echo '<option value="'.$value['id_rol'].'">'.$value['descripcion'].'</option>';
                    		}
                        }else{
                            echo '<option>NO HAY VALORES</option>';
                        }
                    ?>
				</select>
			</td></tr>
			<tr><td>Nombre de usuario: </td><td><input id="datos" type="text" name="nomb_usuario" id="nomb_usuario"/></td></tr>
			<tr><td>Contraseña: </td><td><input id="datos" type="text" name="clave" id="clave"/></td></tr>
			<tr><td><br><br></td></tr>
			<tr>
				<td colspan = 2 >
					<center>
						<input id="boton" type="submit" value="Crear"/>
						<input id="boton" type="reset" value="Limpiar"/>
					</center>
				</td>
			</tr>
		</table>
<?php
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
	include('base/fin.php');
?>