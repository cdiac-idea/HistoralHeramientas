<?php	
	//inicio de html y parte del menu ademas de funciones con las consultas sql

	include('../bd/base/inicioSql.php');

	if($_POST){
		$tabla = array_key_exists('idTabla', $_POST) ? $_POST['idTabla'] : null;
		$idEstacion = array_key_exists('idEstacion', $_POST) ? $_POST['idEstacion'] : null;
		$idanio1 = array_key_exists('idAno1', $_POST) ? $_POST['idAno1'] : null;
		$idanio2 = array_key_exists('idAno2', $_POST) ? $_POST['idAno2'] : null;
		$variable = array_key_exists('variable', $_POST) ? $_POST['variable'] : null;
		if ($tabla==null) {
			$mes = getMes($idEstacion, $idanio1, $idanio2);
		}else{
			#$sql1 = "SELECT variable_fact as atributo FROM variable WHERE id_variable=".$variable;
			#$variable = $objDatos->executeQuery($sql1);
			#$variable = $variable[0]['atributo'];
			$mes = getMesAire($idEstacion, $idanio1, $idanio2, $variable);
			#$mes = getMesAire($idEstacion, $idanio1, $idanio2);
			#echo "<option>$mes</option>";
		}
		echo "<option>Seleccione</option>";
		if($mes != null){
			foreach ($mes as $value) {
				echo "<option value='".$value["num"]."' >".$value["nombre"]."</option>";
			}
		}else{
			echo "<option>NO HAY VALORES</option>";
		}
	}

	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
	include('../bd/base/finSql.php');
?>