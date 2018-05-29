<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('data_model');
    }

    //funcion principal.
    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $content = array(
                'user' => $session_data['username'],
                'title' => 'Dashboard',
                'main' => 'dashboard_view',
                'page' => 'Esquema'
            );
            $this->load->view('include/main_template', $content);
        } else {
            //If no session, redirect to login page
            redirect(base_url(), 'refresh');
        }
    }

}

