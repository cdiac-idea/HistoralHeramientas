<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
$pg_servidor = @pg_connect ("user = postgres password=%froac$ port=5432 dbname=idea_dwh_db_pruebascube host=froac.manizales.unal.edu.co");

pg_set_client_encoding($pg_servidor, "UNICODE");
$u = $_SESSION['username'];
$c = $_SESSION['contra'];

$queryExist = "SELECT * from usuario where nombre_usuario = '$u' and contrasenia = '$c'";
$e_queryExist = pg_query($queryExist);
$r_queryExist = pg_num_rows($e_queryExist);

if (!isset($u)){ 
header("Location: ../index.php");
}
elseif(!$r_queryExist > 0){
header("Location: ../index.php");
}

class Nueva_estacion extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('migrar_model');
        $this->load->model('estacion_model');
    }
    
    public function index(){
               
       
        $content = array(
                'title' => 'Crear nueva Estación',
                'main' => 'nueva_estacion_view',
                'var_redes' => $this->migrar_model->lista_redes(),
                'var_tipologia' => $this->migrar_model->lista_tipologia(),
                'var_municipio' => $this->migrar_model->lista_municipio(),
            
                'page' => 'Esquema'
            );
            $this->load->view('include/main_template', $content);
        
        }

        public function guardar()
        {
            $boxmedidas=$this->input->post('boxmedidas');
                        
            $estacion = array(
                'red' => $this->input->post('red'),
                'ubicacion' => $this->input->post('ubicacion'), 
                'estacion' => $this->input->post('nombre_estacion'),
                'latitud'=>$this->input->post('latitud'),
                'tipologia' => $this->input->post('tipologia'),
                'longitud' => $this->input->post('longitud'),
                'municipio'=>$this->input->post('municipio'), 
                'altitud' => $this->input->post('altitud'), 
                'propietario' => $this->input->post('propietario'), 
                'inicio_funcionamiento' => $this->input->post('inicio_funcionamiento'), 
                'observacion' => $this->input->post('observaciones')
            );

            if($this->estacion_model->guardar($estacion,$boxmedidas))
            {
                $this->exito();
            }
            
        }
        
        public function exito()
        {
            $content = array(
                'title' => 'Exito Migrar',
                'main' => 'exito_migrar_view',
                
            
                'page' => 'Esquema'
            );
            $this->load->view('include/main_template', $content);
        }
        

}


?>
