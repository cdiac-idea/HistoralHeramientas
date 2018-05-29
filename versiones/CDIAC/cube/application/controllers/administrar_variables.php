<?php

class administrar_variables extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('migrar_model');
        $this->load->model('estacion_model');
    }
    
    public function index(){
                      
        $content = array(
                'title=' > 'Administras Varibles',
                'main' => 'administrar_variables_view',
                'var_redes' => $this->migrar_model->lista_redes(),
                
            
                'page' => 'Esquema'
            );
            $this->load->view('include/main_template', $content);

      
        }

        public function formulario_uno(){

              $contentDos = array(

                'title' => 'formulario_uno',
                'main' => 'formulario_uno',
                'var_redes' => $this->migrar_model->lista_redes(),
                'page' => 'Esquema' );
            $this->load->view('formulario_uno',$contentDos);

        }
         public function estacion_select($id)
            {
            $id = urldecode($id);
            $datos['estacion']=
            $this->migrar_model->lista_estaciones($id);
            $this->load->view('opc_estacion',$datos);
                }
        public function variable_select($id,$estacion)
            {
            $id = urldecode($id);
            $estacion = urldecode($estacion);
            $estacion_sk = $this->migrar_model->buscar_estacion($red,$estacion);
            $datos['estacion']=
            $this->migrar_model->lista_variables($estacion_sk);
            $this->load->view('opc_variables',$datos);
                }
    }
?>
