<?php

class aire_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function guardar_man1($estacion, $data, $filas, $columnas){      
       echo "<br> <br>";
        for($p=0;$p<$filas;$p++)
        for ($c=0; $c < $columnas; $c++) {
           // echo $data[$p][$c] . "<br />\n";
         
        }    
   //guardar en la BD
       for($p=0;$p<$filas;$p++)
       { //recorre las filas
       $c=0;
        
            $fecha_sk = $data[$p][$c];$c++;
            $tiempo_sk = $data[$p][$c];$c++;
            $temperatura= $data[$p][$c];$c++;
            $velocidad_viento = $data[$p][$c];$c++;
            $direccion_viento= $data[$p][$c];$c++;
            $presion_barometrica= $data[$p][$c];$c++;
            $humedad_relativa= $data[$p][$c];$c++;
            $precipitacion= $data[$p][$c];$c++;
            $radiacion_solar= $data[$p][$c];$c++;
            $evapotranspiracion= $data[$p][$c];
        
            $datos = array(
                'estacion_sk' => $estacion,
                'fecha_sk' => $fecha_sk,
                'tiempo_sk' => $tiempo_sk,
                'temperatura' => $temperatura,
                'velocidad_viento' => $velocidad_viento,
                'direccion_viento' => $direccion_viento,
                'presion_barometrica' => $presion_barometrica,
                'humedad_relativa' => $humedad_relativa,
                'precipitacion' => $precipitacion,
                'radiacion_solar' => $radiacion_solar,
                'evapotranspiracion' => $evapotranspiracion
             );
              $this->db->insert('fact_table', $datos); 
       }//fin recorre filas
       
    }
    
    public function guardar_man2($estacion, $data, $filas, $columnas){      
       echo "<br> <br>";
        for($p=0;$p<$filas;$p++)
        for ($c=0; $c < $columnas; $c++) {
           // echo $data[$p][$c] . "<br />\n";
         
        }    
   //guardar en la BD
       for($p=0;$p<$filas;$p++)
       { //recorre las filas
       $c=0;
        
            $fecha_sk = $data[$p][$c];$c++;
            $tiempo_sk = $data[$p][$c];$c++;
            $temperatura= $data[$p][$c];$c++;
            $precipitacion= $data[$p][$c];$c++;
            $nivel= $data[$p][$c];$c++;
            $caudal= $data[$p][$c];
        
            $datos = array(
                'estacion_sk' => $estacion ,
                'fecha_sk' => $fecha_sk,
                'tiempo_sk' => $tiempo_sk,
                'temperatura' => $temperatura,
                'precipitacion' => $precipitacion,
                'nivel' => $nivel,
                'caudal' => $caudal
             );
              $this->db->insert('fact_table', $datos); 
       }//fin recorre filas
       
    }
    
    
    public function guardar_cald1($estacion, $data, $filas, $columnas){      
       echo "<br> <br>";
        for($p=0;$p<$filas;$p++)
        for ($c=0; $c < $columnas; $c++) {
           // echo $data[$p][$c] . "<br />\n";
         
        }    
   //guardar en la BD
       for($p=0;$p<$filas;$p++)
       { //recorre las filas
            $fecha_sk = $data[$p][0];
            $tiempo_sk = $data[$p][1];
            $temperatura= $data[$p][2];
            $precipitacion= $data[$p][7];
            $nivel= $data[$p][10];
        
            $datos = array(
                'estacion_sk' => $estacion ,
                'fecha_sk' => $fecha_sk,
                'tiempo_sk' => $tiempo_sk,
                'temperatura' => $temperatura,
                'precipitacion' => $precipitacion,
                'nivel' => $nivel,
             );
              $this->db->insert('fact_table', $datos); 
       }//fin recorre filas
       
    }
    public function guardar_cald2($estacion, $data, $filas, $columnas, $encabezados1){      
        
        //Debo enviar la estación_sk, saco de la base de datos variables 
        //las variables que mide e inserto en fac table 
        
         for($p=0;$p<$filas;$p++)
                    {
             $fecha_sk = $data[$p][0];
                $tiempo_sk = $data[$p][1];
             $datos = array(
                            'estacion_sk' => $estacion ,
                            'fecha_sk' => $fecha_sk,
                            'tiempo_sk' => $tiempo_sk,
                    );
             for ($f = 0; $f < $columnas; $f++) { //saco cada uno de los encabezados
                
                $parametros = $this->aire_model->buscar_parametros($estacion, utf8_encode($encabezados1[$f]));
                
                 foreach ($parametros as $row1) //recorro el resultado de la consulta en la BD la tabla variables 
                {
                     $datos[$row1->variables] = $data[$p][$f];
                            
                      
                   }
                   }  
                    print_r($datos);
                    echo "</br>";
                  
                  if($this->db->insert('fact_table', $datos))
                  {
                      echo "Diga que si inserto!!!";
                  }
                  else 
                      echo"No inserto :(";
              
                
            }
    }
    public function lista_estaciones($rede){
        
         $this->db->select('estacion');
         $this->db->where('red',$rede); 
         $this->db->where('tipologia','Calidad del aire');
         $query=  $this->db->get('station_dim');              
         return $query->result();
     }
    public function lista_redes(){      
         $this->db->select('red');
         $this->db->where('tipologia','Calidad del aire');
         $this->db->distinct();
         $query=  $this->db->get('station_dim');              
         return $query->result();
     }
     
     public function lista_tipologia(){      
         $this->db->select('tipologia');
         $this->db->distinct();
         $query=  $this->db->get('station_dim');              
         return $query->result();
     }
     public function lista_municipio(){      
         $this->db->select('municipio');
         $this->db->distinct();
         $query=  $this->db->get('station_dim');              
         return $query->result();
     }
    
    public function buscar_estacion($red,$estacion){      
         //buscar en la tabla station_dim la estacion_sk donde red= $red y estacion=$estacion
         $this->db->select();
         $this->db->where('red',$red); 
         $this->db->where('estacion',$estacion);
         $query=  $this->db->get('station_dim');              
         foreach ($query->result() as $row)
            {
             $estacion_sk= $row->estacion_sk;
            }
       
        return $estacion_sk;
     }
     public function buscar_fecha($fecha){      
         //buscar en la tabla date_dim la fecha_sk donde fecha= $fecha
         $this->db->select();
         $this->db->where('fecha',$fecha); 
         $query=  $this->db->get('date_dim');              
         foreach ($query->result() as $row)
            {
             $fecha_sk= $row->fecha_sk;
            }
         
         return $fecha_sk;
     }
     public function buscar_hora($hora){      
         //buscar en la tabla time_dim la hora_sk donde tiempo= $hora
         $this->db->select();
         $this->db->where('tiempo',$hora); 
         $query=  $this->db->get('time_dim');              
         foreach ($query->result() as $row)
            {
             $hora_sk= $row->tiempo_sk;
            }
         return $hora_sk;
     }     
     
     public function buscar_variables($estacion_sk){      
         //buscar en la tabla variables, las variables que mide cada estación y los filtros!!!
         $this->db->select();
         $this->db->where('estacion_sk',$estacion_sk); 
         $query=  $this->db->get('variables');    
         return $query->result();
     }
     
     public function buscar_parametros($estacion_sk,$variable){      
         //buscar en la tabla variables, las variables que mide cada estación y los filtros!!!
         $this->db->select('*');
         $this->db->from("variables");
         $this->db->where('estacion_sk',$estacion_sk); 
         $this->db->where('variable_excel',$variable); 
         $query=  $this->db->get();    
         return $query->result();
     }
    
}
?>
