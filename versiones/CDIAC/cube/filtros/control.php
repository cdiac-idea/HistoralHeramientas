<?php
	
	session_start(); // se inicia la sesión
	require_once("../conexion/conexiondwh.php"); // se establece la conexión

 // se incluye el archivo de conexión con la bodega de datos
//$pg_servidor = @pg_connect ("user = postgres password=administrador port=5432 dbname= datawarehouse_idea host=localhost");

pg_set_client_encoding($pg_servidor, "UNICODE"); //  Establecimiento de la codificación de cliente

$user = $_POST["username"]; // se recibe el valor del usuario ingresado en el formulario de inicio de sesión
$contra = $_POST["password"]; // se recibe el valor del password ingresado en el formulario de inicio de sesión
$_SESSION['username'] = $user; // se almacena el usuario como una variable de session
$_SESSION['contra'] = $contra; // se almacena el password como una variable de session


 
$consulto = "SELECT * from usuario where nombre_usuario = '$user' and contrasenia = '$contra' and id_rol_usu = '1'";// verifica si existe un usuario con el user y el password ingresado y que sea de tipo 1
$e_consulto = pg_query($consulto);
$r_consulto = pg_num_rows($e_consulto);

if($r_consulto > 0){ // si resulta que existe un usuario con el user y password ingresado se permite el ingreso y se desplega la página de asignar variables como página principal
	header("Location: ../index.php/asignar_variables");
}
else{ // si no encuentra usuarios con el user y password ingresados se emite un mensaje de error en el formulario de inicio de session pasando un valor por el metodo get que indica error cuando tiene valor de 1
	header("Location: ../index.php?spe=1");
}

if (! defined('BASEPATH')) exit ('no direct script allowed');
class control extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	function index(){
		$this->load->view('control_view');
		
	}
}
?>