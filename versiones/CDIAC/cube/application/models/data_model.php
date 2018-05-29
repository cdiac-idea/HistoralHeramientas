<?php

class Data_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_facts(){
        $query = $this->db->get('fact_table');
        return $query->result();
    }
}
?>
