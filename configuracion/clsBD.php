<?php

/***************************************************************************
* pasos conexion php con BD
* 1. conexion con el  servidor de datos
* 2. conexion con la base de datos
* 3. hacer la consulta SQL 
* 4. extraer informacion
* 5. cierre de la conexion
****************************************************************************
*/
class clsDatos {
	
	private $conexion;

	//generar conexion con el servidor y la BD
	
	/***********************************************************************
	*CUMPLE CON EL PASO 1 Y PASO 2
	***********************************************************************/
	public function __construct(){
		$servidor = "127.0.0.1";//"168.176.145.44";
		$puerto = "5432";
		$baseDatos = "bodegadatos";
		$usuario = "postgres";
		$clave = "ndcorpbod";

		$this->conexion = pg_connect("host='$servidor' port='$puerto' dbname='$baseDatos' user='$usuario' password='$clave'");

		if(!$this->conexion){
			echo"<p><center><h1>No hay conexion con la base de datos. <br> INTENTE MAS TARDE</h1></center></p>";
			exit;
		}
	}

	//el destruye la clase cuando no se usa en la ejecucion
	public function __destruct(){}

	//Hacer la consulta a la BD
	/***********************************************************************
	*CUMPLE CON EL PASO 3
	***********************************************************************/
	public function hacerConsulta($sql){
		$resultado = pg_query($this->conexion, $sql);
		return $resultado;
	}
	

	//para liberar el buffer de memoria y evitar que se vuelva lento el servidor
	public function cerrarConsulta($sql){
		pg_free_result($this->conexion, $sql);
	}

	//extraccion de los datos de la DB una sola fila
	/***********************************************************************
	*CUMPLE CON EL PASO 4
	***********************************************************************/
	public function generarArreglo($dato){
		$arreglo = pg_fetch_array($dato);//, 0, PGSQL_BOTH );
		return $arreglo;
	}

	//Hacer la consulta a la BD toda la tabla
	/***********************************************************************
	*CUMPLE CON EL PASO 3 y 4
	***********************************************************************/
	public function executeQuery($sql){
		return pg_fetch_all(pg_query($this->conexion, $sql));
	}


	//permite hacer consultas basicas de eliminar, agregar, modificar, que no nocesitan extraer datos.
	/***********************************************************************
	*CUMPLE CON EL PASO 3 -para update e insert-
	***********************************************************************/
	public function operacionesCrud($sql){
		pg_query($this->conexion, $sql);
	}

	//cierre de la conexion con el servidor y la base de datos
	/***********************************************************************
	*CUMPLE CON EL PASO 5
	***********************************************************************/
	public function cerrarConexion(){
		pg_close($this->conexion);
	}


}

?>