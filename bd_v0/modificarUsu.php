<?php
	//inicio de html y parte del menu ademas de funciones con las consultas sql
	include('base/inicio.php');
	if ($_POST) {
		$bandera = array_key_exists('bandera', $_POST) ? $_POST['bandera'] : null;
		if ($bandera == null || $bandera == "null") {
			$idUsuario =  array_key_exists('usuModificar',$_POST) ? $_POST['usuModificar'] : null;
			if ($idUsuario > 1) {
				$idNombre = array_key_exists('nombre', $_POST) ? $_POST['nombre'] : null;
				$idApellido = array_key_exists('apellido', $_POST) ? $_POST['apellido'] : null;
				$idCedula = array_key_exists('cedula', $_POST) ? $_POST['cedula'] : null;
				$idDependencia = array_key_exists('dependencia', $_POST) ? $_POST['dependencia'] : null;
				$idCargo = array_key_exists('cargo', $_POST) ? $_POST['cargo'] : null;
				$idRol = array_key_exists('rol', $_POST) ? $_POST['rol'] : null;
				modUsu($idUsuario, $idNombre, $idApellido, $idCedula, $idDependencia, $idCargo, $idRol);
			}
		}
	}
?>
<h4 class="alert_info">Modificar Usuario</h4><br>
<center>
<table>
	<tr>
		<td>
			<form action="modificarUsu.php" method="post" >
				<table>
					<tr>
						<td>
							<input type="hidden" value="modificar" name="bandera" id="bandera">
							<select multiple name="usuarios" id="usuarios" style='width: 500; height: 300px'><!--mirar tamaño-->
								<?php
								$sql = "SELECT id_usuario, nombre, apellido, cedula, descripcion 
										FROM rol, usuario 
										WHERE usuario.id_rol_usu=rol.id_rol AND usuario.id_usuario != ".$usuario;
									if ($perfil == 3) {
										$sql .= " AND (usuario.id_rol_usu=3 OR usuario.id_rol_usu=4)";
									}
									if ($perfil == 5) {
										$sql .= " AND (usuario.id_rol_usu=5 OR usuario.id_rol_usu=6)";
									}
									$sql .= "ORDER BY 1";
									$arreglo_usuarios = $objDatos->executeQuery($sql);
									if ($arreglo_usuarios) {
										foreach ($arreglo_usuarios as $value) {
											echo '<option value="'.$value['id_usuario'].'">'.$value['nombre'].' '.$value['apellido'].' '.$value['cedula'].' '.$value['descripcion'].'</option>';
										}
									}else{
										echo '<option>NO HAY VALORES</option>';
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<center>
								<input id="boton" type="submit" value="Buscar"/>
							</center>
						</td>
					</tr>
				</table>
			</form>
		</td>
		<td>
			<?php
			if ($_POST) {
				$bandera = array_key_exists('bandera', $_POST) ? $_POST['bandera'] : null;
				if ($bandera != null) {
					$idUsuario =  array_key_exists('usuarios',$_POST) ? $_POST['usuarios'] : null;
					if ($idUsuario > 1) {
						echo "<input type='hidden' value='null' name='bandera' id='bandera'>";
						echo "<form action=modificarUsu.php method='post'>";
						$sql= "SELECT nombre, apellido, cedula, dependencia, cargo, id_rol_usu, nombre_usuario, MD5(contrasenia) as clave
								FROM usuario 
								WHERE id_usuario=".$idUsuario;
						$arreglo_usuario = $objDatos->executeQuery($sql);
						if ($arreglo_usuario) {	
							echo "<table>
							<tr><td><input  name='usuModificar' id='usuModificar' type='hidden' value='$idUsuario'></td></tr>
							<tr><td>Nombre: </td><td><input id='datos'  type='text' name='nombre' id='nombre' value='".$arreglo_usuario[0]['nombre']."'/></td></tr>
							<tr><td>Apellido: </td><td><input id='datos'  type='text' name='apellido' id='apellido' value='".$arreglo_usuario[0]['apellido']."' /></td></tr>
							<tr><td>Cedula: </td><td><input id='datos'  type='text' name='cedula' id='cedula' value='".$arreglo_usuario[0]['cedula']."' /></td></tr>
							<tr><td>Dependencia: </td><td><input id='datos'  type='text' name='dependencia' id='dependencia' value='".$arreglo_usuario[0]['dependencia']."' /></td></tr>
							<tr><td>Cargo: </td><td><input id='datos'  type='text' name='cargo' id='cargo' value='".$arreglo_usuario[0]['cargo']."' /></td></tr>
							<tr><td>Rol:</td><td>
							<select name='rol' id='rol'>
							<option>Seleccione</option>";
							$sql = "SELECT id_rol, descripcion FROM rol";
							$arreglo_rol = $objDatos->executeQuery($sql);
							if ($arreglo_rol) {
								foreach ($arreglo_rol as $value) {
									if ($value['id_rol']==$arreglo_usuario[0]['id_rol_usu']) {
										echo '<option value="'.$value['id_rol'].'" selected>'.$value['descripcion'].'</option>';
									}else{
										echo '<option value="'.$value['id_rol'].'">'.$value['descripcion'].'</option>';
									}
								}
							}else{
								echo '<option>NO HAY VALORES</option>';
							}
							echo "</select>";
							if ($perfil==1) {
								echo "<tr><td>Nombre Usuario: </td><td><input id='datos'  type='text' name='nameUsu' id='nameUsu' value='".$arreglo_usuario[0]['nombre_usuario']."' /></td></tr>";
								#echo "<tr><td>Contraseña: </td><td><input id='datos'  type='text' name='clave' id='clave' value='".$arreglo_usuario[0]['clave']."' /></td></tr>";
							}
							echo "</td></tr>
							<tr><td><br><br><br><br></td></tr>
							<tr>
							<td colspan = 2 >
							<center>
							<input id='boton' type='submit' value='Modificar'/>
							<input id='boton' type='reset' value='Limpiar'/>
							</center>
							</td>
							</tr>
							</table>
							</form>";
						}
					}else{
						echo "<h3>Debe elejir un usuario para ser modificado</h3>";
					}
				}
			}
			?>
		</td>
	</tr>
</table>
<?php
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
	include('base/fin.php');
?>