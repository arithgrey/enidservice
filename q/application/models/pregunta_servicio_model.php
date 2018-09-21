<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Pregunta_servicio_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }    
    function insert( $params , $return_id=0){                
        $insert  =	 $this->db->insert("pregunta_servicio", $params);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }    
	   
}
