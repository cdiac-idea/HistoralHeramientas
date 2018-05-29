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
		$tabla = array_key_exists('idTabla', $_POST) ? $_POST['idTabla'] : null;
		$variable = array_key_exists('idVariable', $_POST) ? $_POST['idVariable'] : null;
		$idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;

		if ($tabla==null) {
			$anios = getAno($idEstacion);
		}else{
			/*$objDatos = new clsDatos();
			$sql = "SELECT variable_fact FROM variable WHERE id_variable=".$variable;
			$variable = $objDatos->executeQuery($sql);
			$variable = $variable[0]['variable_fact'];
			echo "<option>$variable</option>";*/
			$anios = getAnoAire($idEstacion, $variable);
		}
		echo "<option>Seleccione</option>";
		if($anios != null){
			foreach ($anios as $value) {
				echo "<option value='".$value["nombre"]."' >".$value["nombre"]."</option>";
			}
		}else{
			echo "<option>NO HAY VALORES</option>";
		}
	}

	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
	include('base/finSql.php');
?>