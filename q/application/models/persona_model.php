<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Persona_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
   	function ventas_enid_service(){   
        
        $query_get ="SELECT
                        count(0)num_ventas 
                    FROM 
                    persona 
                    WHERE
                    tipo =2 
                        AND 
                    fecha_cambio_tipo =  current_date()";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_ventas"];
 
    }
      
   
        
}
	