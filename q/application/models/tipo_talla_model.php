<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Tipo_talla_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();

    }
	function get_all($param=''){
    
	    $query_get  =  "SELECT  id , tipo , clasificacion  FROM tipo_talla LIMIT 10";
	    return   	$this->db->query($query_get)->result_array();
  	}    
  	function get_like_clasificacion($param){ 

        $extra  = (array_key_exists("clasificacion", $param) && strlen($param["clasificacion"])>0 )?
        " WHERE tipo LIKE '%".$param["clasificacion"]."%' LIMIT 10":" LIMIT 30"; 
        
        $query_get      = "SELECT * FROM tipo_talla".$extra;  
        $result         = $this->db->query($query_get);
        return            $result->result_array();

    }
}

