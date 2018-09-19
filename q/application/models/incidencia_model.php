<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Incidencia_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function reporta_error($param){
		$descripcion =  (array_key_exists("descripcion", $param )) ? $param["descripcion"]:"Error desde js";		      
	    $params = [ 
	      "descripcion_incidencia"  => $descripcion
	      "idtipo_incidencia"       =>  4 
	      "idcalificacion"          =>  1
	      "id_user"                 =>  1
	    ];
	    return $this->insert($params);
	    
	}
	function get($params=[], $params_where =[] , $limit =1){
        
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);        
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get("incidencia")->result_array();
    }
    function insert( $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert("incidencia", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }        
}
	