<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Persona_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function q_get($params=[], $id){
        return $this->get($params, ["id_person" => $id ] );
    }
    function get($params=[], $params_where =[] , $limit =1){
        
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);        
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get("persona")->result_array();
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
	