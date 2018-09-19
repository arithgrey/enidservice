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
	function agrega_pregunta_servicio($id_pregunta , $id_servicio){
	    $params = ["id_pregunta"  =>  $id_pregunta , "id_servicio"   => $id_servicio];
	    return $this->insert($params);    
	}    
}
