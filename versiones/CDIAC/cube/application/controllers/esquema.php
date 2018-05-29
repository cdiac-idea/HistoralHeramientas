<?php

class Esquema extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function lista_esquema() {
        
    }

    public function esquema($id_esquema) {
        
    }

    public function nuevo_esquema() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $content = array(
                'user' => $session_data['username'],
                'title' => 'Creación de esquemas',
                'main' => 'nuevo_esquema_view',
                'page' => 'Constructor'
            );
            $this->load->view('include/main_template', $content);
        } else {
            //If no session, redirect to login page
            redirect(base_url(), 'refresh');
        }
    
    }

    public function editar_esquema($id_esquema) {
        
    }

    public function eliminar_esquema($id_esquema) {
        
    }
    
    public function guardar_esquema(){
        print_r($_POST);
    }

}

?>
