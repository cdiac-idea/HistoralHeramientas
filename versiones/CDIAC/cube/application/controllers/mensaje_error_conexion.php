<?php
if (! defined('BASEPATH')) exit ('no direct script allowed');
class mensaje_error_conexion extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	function index(){
		$this->load->view('error_conexion_view');
		
	}
}
?>