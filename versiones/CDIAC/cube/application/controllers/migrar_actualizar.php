<?php

class Migrar_actualizar extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('migrar_model');
    }
    
    public function index(){
               
       
        $content = array(
                'title' => 'Actualizar Datos',
                'main' => 'actualizar_view',
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
        
        
        function actualizar()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'csv';
                //$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
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
                        $this->actualizar_archivo();
		}
	}
        
        
        public function actualizar_archivo(){
                        
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
            
//revisar los encabezados para verificar que filtros se deben aplicar.            
            for($f=0;$f<$columnas;$f++)
            {
                if($encabezados1[$f]=="Fecha"){    $col_fecha=$f;         }
                if($encabezados1[$f]=="Hora") {    $col_hora=$f;            }
                if(strncmp($encabezados1[$f],"T. del Aire (°C)",11)==0){$col_temperatura=$f; }
                if($encabezados1[$f]=="V. viento (m/s)"){ $col_velocidad_viento=$f; }
                if(strncmp($encabezados1[$f],"Dir. Viento (°)",11)==0){ $col_direccion_viento=$f;}
                if($encabezados1[$f]=="P. B. (mmHg)"){$col_presion_barometrica=$f;}
                if($encabezados1[$f]=="H. R. (%)"){$col_humedad_relativa=$f;}
                if($encabezados1[$f]=="P (mm)"){$col_precipitacion=$f;}
                if($encabezados1[$f]=="R. S. (W/m2)"){$col_radiacion_solar=$f;}
                if($encabezados1[$f]=="ET. (mm)"){$col_evotranspiracion=$f; }
            }
            
            
              $i=0; //cuenta las filas
            while ($data = fgetcsv ($fp, 1000, ",")){ //me entrega una fila
                
                $data3=  explode(";", $data[0]); //separo la fila en columnas 
                $data1[$i] = $data3;
                $i++; //filas
                }//while

            //Procesamiento de la Red y la Estacion 
                //recibo de las listas red y estacion
                $red=  $this->input->post('red');
                $estacion=  $this->input->post('estacion');        
                $estacion_sk=$this->migrar_model->buscar_estacion($red,$estacion);
         
         
                
                //Procesamiento de las fechas
            for($g=0;$g<$i;$g++)
            {
                $fecha_sk=$this->migrar_model->buscar_fecha($data1[$g][$col_fecha]);
                $data1[$g][$col_fecha]=$fecha_sk;  
            }

            //Procesamiento de las horas  
            for($h=0;$h<$i;$h++)
            {
                $hora=$data1[$h][$col_hora].':00';             // 
                $hora_sk=$this->migrar_model->buscar_hora($hora);
                $data1[$h][$col_hora]=$hora_sk;
            }
            
            /////FILTROS!!!!!!!!!!!!!///////////
            $error='';
            //$i es la cantidad de filas del archivo!!!
            for($x=0;$x<$i;$x++)
            {
            //filtro radiación no negativo entre 0-1600
                if (($data1[$x][$col_radiacion_solar]<0) || ($data1[$x][$col_radiacion_solar]>1600))
                {
                    $error=$error.'<br>- Rango no permitido en la radiación solar, fila '.$x+1;
                   
                }
                
            //filtro precipitación no negativo no mayor a 15
                if ($data1[$x][$col_precipitacion]<0 || $data1[$x][$col_precipitacion]>15)
               {
                   $error=$error.'<br>- Rango no permitido en la precipitación, fila '.$x+1;
                   
               }
            

            //Filtro Velocidad  No  negativa Entre 0 y 15
            if ($data1[$x][$col_velocidad_viento]<0 || $data1[$x][$col_velocidad_viento]>15)
               {
                   $error=$error.'<br>- Rango no permitido en la velocidad, fila '.$x+1;
                   
               }
            
//            //Filtro Direccion No negativa  Entre 0 - 360

                if ($data1[$x][$col_direccion_viento]<0 || $data1[$x][$col_direccion_viento]>360)
                {
                    $error=$error.'<br>- Rango no permitido en la Dirección, fila '.$x+1;

                }

//            //Filtro Presion No negativa Entre595 - 610
                if ($data1[$x][$col_presion_barometrica]<595 || $data1[$x][$col_presion_barometrica]>610)
                {
                    $error=$error.'<br>- Rango no permitido en la Presión, fila '.$x+1;

                }

//            
//            //Filtro Evapotranspiracion No negativa  No mayor a 1
                if ($data1[$x][$col_evotranspiracion]<0 || $data1[$x][$col_evotranspiracion]>1)
                {
                    $error=$error.'<br>- Rango no permitido en la Evopotranspiracion, fila '.$x+1;

                }
                
                            //Filtro Temperatura no mayor a 40 .. Temperatura Diferencia no mayor a 5 con el anterior
               if ($data1[$x][$col_temperatura]<40 || ($data1[$x][$col_temperatura]-$data1[$x-1][$col_temperatura])<5)
               {
                   $error=$error.'<br>- Rango no permitido en la Temperatura, fila '.$x;
                   
               }


//            //Filtro Temperatura no mayor a 40 .. Temperatura Diferencia no mayor a 5 con el anterior
//               if ($data1[$x][$col_temperatura]<40 || ($data1[$x][$col_temperatura]-$data1[$x-1][$col_temperatura])<5)
//               {
//                   $error=$error.'<br>- Rango no permitido en la Temperatura, fila '.$x;
//                   
//               }
//            
//                    
//                    
//            
//            //Filtro Humedad No negativa   Entre 0-100  Diferencia no mayor a 10 con el anterior
//            $data1[$x][$col_humedad_relativa]
               
            }
 echo $error;
            


            
            
             //$this->migrar_model->guardar($estacion_sk,$data1,$i,$columnas);
              $content = array(
                'title' => 'Exito Migrar',
                'main' => 'exito_migrar_view',
                
            
                'page' => 'Esquema'
            );
            $this->load->view('include/main_template', $content);
            
             
             
                
            }//else 
            
            fclose ($fp); 
        }
}


?>
