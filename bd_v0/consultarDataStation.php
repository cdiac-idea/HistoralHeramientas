<?php	
	//inicio de html y parte del menu ademas de funciones con las consultas sql

	session_start();
	$nombreUsuario = $_SESSION['nombreUsuario'];
	$perfil = $_SESSION['perfil'];
	$usuario = $_SESSION['idUsu'];
	/*
	global $perfil;
	*/
	include('base/inicioSql.php');

	if($_POST){
		$variable = array_key_exists('idVariable', $_POST) ? $_POST['idVariable'] : null;
		//$variable = 173;
		$variable = getEstacionVarAire($variable);
		#echo "<option>$variable</option>";
		echo "<option>Seleccione</option>";
		if($variable != null){
			foreach ($variable as $value) {
				echo "<option value='".$value["id"]."' >".$value["nombre"]." - ".$value["municipio"]."</option>";
			}
		}else{
			echo "<option>NO HAY VALORES</option>";
		}
	}

	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
	include('base/finSql.php');
?>