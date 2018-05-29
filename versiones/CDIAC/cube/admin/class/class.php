<?php
//error_reporting(E_ERROR | E_PARSE);


class trabajo{

	private $dbh;
	private $n;
	public function __construct(){
		$this->dbh=new PDO ('pgsql:host=froac.manizales.unal.edu.co;port=5432; dbname=idea_dwh_db_pruebascube', "postgres", "%froac$");
		$this->n=array();
	}

	public function get_variables()
	{

	    $consulta = "SELECT estacion_sk from station_dim where red='$_SESSION[red]' and estacion='$_SESSION[estacion]' ";
		foreach ($this->dbh->query($consulta) as $row2) {
		$sql = "SELECT * from variables where estacion_sk=$row2[estacion_sk]";
		foreach ($this->dbh->query($sql) as $row) {
			$this->n[]=$row;

		}

		return $this->n;
		$this->dbh=null;
	}


}

	public function get_noticia_por_id($id){
		$sql="select * from variables where id_variable_estacion = ?;";
		$stmt=$this->dbh->prepare($sql);
		if ($stmt->execute(array($id)))
		{
			while ($row = $stmt->fetch()) {
				$this->n[]=$row;
			}
			return $this->n;
			$this->dbh=null;
		}

	}
	public function get_variable_por_id($id){
		$sql="SELECT * from esta_var where id_esta_var = ?";
		$stmt=$this->dbh->prepare($sql);
		if ($stmt->execute(array($id)))
		{
			while ($row = $stmt->fetch()) {
				$this->n[]=$row;
			}
			return $this->n;
			$this->dbh=null;
		}

	}
	public function edit(){
	
			
		$sql="UPDATE variables set minimo=?,maximo=?,diferencia_anterior=? where id_variable_estacion = ?";
		$stmt=$this->dbh->prepare($sql);


		if(!empty($_POST["min"])){
			$stmt->bindValue(1,$_POST["min"], PDO::PARAM_STR);
		}
		else{
				$stmt->bindValue(1,null);
			}
		if(!empty($_POST["max"])){
			$stmt->bindValue(2,$_POST["max"], PDO::PARAM_STR);
		}
		else{
				$stmt->bindValue(2,null);
		}
		if(!empty($_POST["diferencia"])){
				$stmt->bindValue(3,$_POST["diferencia"], PDO::PARAM_STR);
		}
		else{
				$stmt->bindValue(3,null);
		}
		$stmt->bindValue(4,$_POST["id_variable_estacion"], PDO::PARAM_STR);

		

		$stmt->execute();
		$this->dbh=null;
		header("Location: edit.php?m=2&id=".$_POST["id_variable_estacion"]);

	}

	public function get_interseccion(){


		$sql="SELECT distinct esta_var.id_esta_var,estacion.estacion_sk,esta_var.id_variable,esta_var.deteccion,estacion.nombre_estacion,variable.nombre from esta_var,estacion,variable where deteccion = '0' and variable.id_variable = esta_var.id_variable and estacion.estacion_sk = esta_var.estacion_sk and estacion.nombre_estacion = '$_SESSION[estacion]'";
		foreach ($this->dbh->query($sql) as $row) {
			$this->n[]=$row;
		}
		return $this->n;
		$this->dbh=null;

	}


	public function extraer($id){

		$sql="SELECT esta_var.estacion_sk, estacion.nombre_estacion,variable.nombre, variable.variable_excel, variable.correccion from esta_var , variable, estacion where id_esta_var = ? and esta_var.id_variable = variable.id_variable and esta_var.estacion_sk = estacion.estacion_sk";
		$stmt=$this->dbh->prepare($sql);
		if ($stmt->execute(array($id)))
		{
			while ($row = $stmt->fetch()) {
				$this->n[]=$row;
			}
			return $this->n;
			$this->dbh=null;
		}

	}


	
	public function add(){
		
		$sql="INSERT INTO variables values (?,?,?,?,?,?,default,?,?);";
		$stmt=$this->dbh->prepare($sql);

		if(!empty($_POST["est_sk"])){
		$stmt->bindValue(1,$_POST["est_sk"], PDO::PARAM_STR);
		}
		else{
			$stmt->bindValue(1,null);
		}
		if(!empty($_POST["est"])){
		$stmt->bindValue(2,$_POST["est"], PDO::PARAM_STR);
		}
		else{
			$stmt->bindValue(2,null);
		}

		if(!empty($_POST["var"])){
		$stmt->bindValue(3,$_POST["var"], PDO::PARAM_STR);
		}
		else{
			$stmt->bindValue(3,null);
		}
		if(!empty($_POST["min"])){
			$stmt->bindValue(4,$_POST["min"], PDO::PARAM_STR);
		}
		else{
			$stmt->bindValue(4,null);
		}
		if(!empty($_POST["max"])){
			$stmt->bindValue(5,$_POST["max"], PDO::PARAM_STR);
		}
		else{
			$stmt->bindValue(5,null);	
		}
		if(!empty($_POST["dif"])){
			$stmt->bindValue(6,$_POST["dif"], PDO::PARAM_STR);		
		}
		else{
			$stmt->bindValue(6,null);
		}
		if(!empty($_POST["var_exc"])){
		$stmt->bindValue(7,$_POST["var_exc"], PDO::PARAM_STR);
		}
		else{
			$stmt->bindValue(7,null);
		}
		$stmt->bindValue(8,$_POST["cor"], PDO::PARAM_STR);

		$stmt->execute();
		$this->dbh=null;


		header("Location: add.php?m=2");
		}
	public function actualizar($id){

		$sql="UPDATE esta_var set deteccion= '1' where id_esta_var = '$id'";
		$stmt=$this->dbh->prepare($sql);
		$stmt->execute();
		$this->dbh=null;
	}

	
}

?>