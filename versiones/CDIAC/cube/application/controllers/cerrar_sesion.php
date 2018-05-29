<?php
session_start(); // se inicia la sesión
session_unset(); // libera todas las variables de sesión actualmente registradas.
session_destroy(); // Destruye toda la información registrada de una sesión
header("Location: ../index.php"); // redirige a la página principal

if (! defined('BASEPATH')) exit ('no direct script allowed');
class cerrar_sesion extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	function index(){
		$this->load->view('cerrar_sesion_view'); // carga la vista del cierre de sesión
		
	}
}
?>