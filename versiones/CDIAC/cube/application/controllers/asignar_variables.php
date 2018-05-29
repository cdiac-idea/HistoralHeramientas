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

//este controlador es el que permite cargar un archivo excel, con los datos que 
//se leen desde las estaciones
//se debe acceder a la tabla variables, donde estan los filtros que se deben hacer, antes de insertar los datos en la BD
//En la tabla variables, esta el valor máximo y minimo permitido y la diferencia con el valor anterior
//estos filtros solo son informativos... entrega la fila en excel que esta malo, y que variable y por que filtro falló 
// 
header('Content-Type: text/html; charset=UTF-8');

class asignar_variables extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('migrar_model');
    }
    
    public function index(){
               
       
        $content = array(
                'title' => 'asignar variables',
                'main' => 'asignar_variables_view',
                'var_redes' => $this->migrar_model->lista_redes(),
            
                'page' => 'Esquema'
            );
            $this->load->view('include/main_template', $content);
         
        }
      
        
        public function estacion_select($id)
        {
            $id = urldecode($id);
            $datos['estacion']=
            $this->migrar_model->lista_estaciones($id);
            $this->load->view('opc_estacion',$datos);
        }
        
        public function variables_para_crear(){
            $red=  $this->input->post('red');
            $estacion=  $this->input->post('estacion');        
            $estacion_sk=$this->migrar_model->buscar_estacion($red,$estacion);

        }
        
        function do_upload()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
                //$config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';
        //$config['max_width']  = '1024';
        //$config['max_height']  = '768';
                $config['overwrite']=true;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('archivo'))
        {
            $error = array('error' => $this->upload->display_errors());
                         var_dump($error);
            //$this->load->view('migrar_view', $error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
                        $this->guardar_archivo();
        }
    }
        
        
        public function guardar_archivo(){
                        
            $nombre_archivo = $_FILES['archivo']['name']; 
            $tipo_archivo = $_FILES['archivo']['type']; 
            $tamano_archivo = $_FILES['archivo']['size']; 
            
            $ruta='./uploads/'.$nombre_archivo;
            
            
                    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta)){ 
                        $this->convertir($ruta);
                   }else{ 
                           echo "Ocurrió algún error al subir el fichero. No pudo guardarse."; 
                        }     
            
            //guardar el archivo que subieron 
//            echo 'Nombre del archivo    '.$nombre_archivo;
//            echo 'Tipo del archivo    '.$tipo_archivo;
//            echo 'tamaño del archivoooo   '.$tamano_archivo;            
        }
        
        public function convertir($archivo_leer){

            $row = 1; 
        $fp = fopen ($archivo_leer,'r');
        if (empty($fp)){
            echo"El archivo no contiene datos.";
            exit();
        }
        else{
            $encabezados = fgetcsv ($fp, 1000, ",");
            $encabezados1=  explode(";", $encabezados[0]);
            $columnas=count($encabezados1);
            
            //Procesamiento de la Red y la Estacion 
                //recibo de las listas red y estacion
                $red=  $this->input->post('red');
                $estacion=  $this->input->post('estacion');        
                $estacion_sk=$this->migrar_model->buscar_estacion($red,$estacion);
        $error='';
        
        
            $i = 0; //cuenta las filas
            while ($data = fgetcsv($fp, 1000, ",")) { //me entrega una fila
                $data3 = explode(";", $data[0]); //separo la fila en columnas 
                $data1[$i] = $data3;
                $i++; //filas
            }//while
            //
            //Procesamiento de las fechas, en el excel la fecha va en la columna 0
            for ($g = 0; $g < $i; $g++) {
                $fecha_sk = $this->migrar_model->buscar_fecha($data1[$g][0]);
                $data1[$g][0] = $fecha_sk;
            }
            

            //Procesamiento de las horas , la hora en el excel va en la columna 1 
            for ($h = 0; $h < $i; $h++) {
                $hora = $data1[$h][1] . ':00';
                $hora_sk = $this->migrar_model->buscar_hora($hora);
                $data1[$h][1] = $hora_sk;
            }
                    
        
        
        //Busco las columnas que lee cada estación, se busca los encabezados
        
        //$variables_todas = $this->migrar_model->buscar_variables($estacion_sk);
       
$errores=array();

$d=0;
       for ($f = 0; $f < $columnas; $f++) 
        { //saco cada uno de los encabezados
              $parametros = $this->migrar_model->buscar_parametros($estacion_sk,  utf8_encode($encabezados1[$f]));

              foreach ($parametros as $row1) //recorro el resultado de la consulta en la BD la tabla variables 
                {
                  //danny eres el mejor te quiero!!!
                  //mua
//                  $"columna"=>$row1->variable_excel,"minimo"=>$row1->minimo,"maximo"=>$row1->maximo
                  for ($x = 0; $x < $i; $x++) {
                  if ($data1[$x][$f] < $row1->minimo || $data1[$x][$f] > $row1->maximo) {
                      
                      $errores[$d]=array("estacion"=>$row1->estacion,"fila"=>$x,"columna"=>$row1->variable_excel,"dato"=>$data1[$x][$f],"minimo"=>$row1->minimo,"maximo"=>$row1->maximo);
                      $d++;
                        //$error = $error . '<br>- Valor no permitido en la variable: '.$row1->variable_excel .' en la fila ' . $x.': '.$data1[$x][$f];
                        }
                    }                       
                } 
                $parametros=null;               
          }
        $this->correccion_errores($errores,$data1);
          
        
      //$this->migrar_model->guardar_cald2($estacion_sk,$data1,$i,$columnas,$encabezados1);
        
        //echo $error;
//        $content = array(
//                'title' => 'Exito Migrar',
//                'main' => 'exito_migrar_view',
//                
//            
//                'page' => 'Esquema'
//            );
//              
//            $this->load->view('include/main_template', $content);
//                
            }//else del si existe el archivo!!!  
            
            fclose ($fp); 
        }
        
        private function correccion_errores($errores,$matrizexcel){
              $content = array(
                'title' => 'Corrección de errores',
                'main' => 'corregir_error_view',
                'errores'=>$errores,
                'matriz'=>$matrizexcel,            
                'page' => 'Esquema'
            );
              
            $this->load->view('include/main_template', $content);
        }
}

?>