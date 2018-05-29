<?php

class Medidas_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function promedio($estacion, $medida){      
      $this->db->select_avg($medida);
      $this->db->where('estacion_sk',$estacion); 
         $query=  $this->db->get('fact_table');              
         return $query->result_array(); 
    }
    
    public function minimo($estacion, $medida){      
      $this->db->select_min($medida);
      $this->db->where('estacion_sk',$estacion); 
         $query=  $this->db->get('fact_table');              
         return $query->result_array(); 
    }
    
     public function maximo($estacion, $medida){      
      $this->db->select_max($medida);
      $this->db->where('estacion_sk',$estacion); 
         $query=  $this->db->get('fact_table');              
         return $query->result_array(); 
    }
    
     public function suma($estacion, $medida){      
      $this->db->select_sum($medida);
      $this->db->where('estacion_sk',$estacion); 
         $query=  $this->db->get('fact_table');              
         return $query->result_array(); 
    }
    
    public function lista_estaciones($rede){
        
         $this->db->select('estacion');
         $this->db->where('red',$rede); 
         $query=  $this->db->get('station_dim');              
         return $query->result();
     }
    public function lista_redes(){      
         $this->db->select('red');
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
     
     
      public function buscar_estaciones($red){      
         //buscar en la tabla station_dim todas las estacion_sk que pertenecen a una red red= $red
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
     
    
}
?>
