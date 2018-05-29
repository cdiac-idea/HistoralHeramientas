<?php

class Estacion_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function guardar($estacion, $boxmedidas){      
           
        
        $this->db->insert('station_dim', $estacion); 
       
       
    }
    
    
//    public function lista_redes(){      
//         $this->db->select('red');
//         $this->db->distinct();
//         $query=  $this->db->get('station_dim');              
//         return $query->result();
//     }
//     
//     public function lista_tipologia(){      
//         $this->db->select('tipologia');
//         $this->db->distinct();
//         $query=  $this->db->get('station_dim');              
//         return $query->result();
//     }
//     public function lista_municipio(){      
//         $this->db->select('municipio');
//         $this->db->distinct();
//         $query=  $this->db->get('station_dim');              
//         return $query->result();
//     }
//    
     
     
    
}
?>