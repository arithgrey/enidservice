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
	    return $this->insert("incidencia", $params);
	    
	}
}
	