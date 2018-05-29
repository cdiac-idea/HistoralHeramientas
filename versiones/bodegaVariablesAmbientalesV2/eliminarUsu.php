<?php
	//inicio de html y parte del menu ademas de funciones con las consultas sql
	include('base/inicio.php');
	#include("base/inicioSql.php");
	if ($_POST) {
		$idUsuario = array_key_exists('usuarios', $_POST) ? $_POST['usuarios'] : null;

		eliminaUsu($idUsuario);
	}
?>
<h4 class="alert_info">Eliminar Usuario</h4><br>
<center>
	<form action="eliminarUsu.php" method="post">
		<select multiple name="usuarios" id="usuarios" style='width: 500; height: 300px'>
			<?php
				$sql = "SELECT id_usuario, nombre, apellido, cedula, descripcion FROM rol, usuario 
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
		<br><br>
		<input id="boton" type="submit" value="Eliminar"/>

<?php
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
	include('base/fin.php');
?>