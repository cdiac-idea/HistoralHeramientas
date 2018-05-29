<?php	
	//inicio de html y parte del menu ademas de funciones con las consultas sql
	
	include('../bd/base/inicioSql.php');

	if($_POST){
		$tabla = array_key_exists('idTabla', $_POST) ? $_POST['idTabla'] : null;
		$idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
		$idanio1 = array_key_exists('idAno1', $_POST) ? $_POST['idAno1'] : null;
		$idanio2 = array_key_exists('idAno2', $_POST) ? $_POST['idAno2'] : null;
		$idMes1 = array_key_exists('idMes1', $_POST) ? $_POST['idMes1'] : null;
		$idMes2 = array_key_exists('idMes2', $_POST) ? $_POST['idMes2'] : null;
		$variable = array_key_exists('idVariable', $_POST) ? $_POST['idVariable'] : null;

		if ($tabla==null) {
			$dia = getDia($idEstacion, $idanio1, $idanio2, $idMes1, $idMes2);
		}else{
			$dia = getDiaAire($idEstacion, $idanio1, $idanio2, $idMes1, $idMes2, $variable);
		}
		echo "<option>Seleccione</option>";
		if($dia != null){
			foreach ($dia as $value) {
				echo "<option value='".$value["nombre"]."' >".$value["nombre"]."</option>";
			}
		}else{
			echo "<option>NO HAY VALORES</option>";
		}
	}
	
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
	include('../bd/base/finSql.php');
?>