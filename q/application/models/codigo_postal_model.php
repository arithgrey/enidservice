<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Codigo_postal_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();

    }
    
    function get_id_codigo_postal_por_patron($param){
      
      $cp        =  $param["cp"];
      $query_get ="SELECT 
                    id_codigo_postal 
                  FROM 
                    codigo_postal
                  WHERE 
                    cp = $cp                  
                  LIMIT 1";      
      return $this->db->query($query_get)->result_array()[0]["id_codigo_postal"];

    }
    function get_colonia_delegacion($param){    
    
      /*hay que realizar correccion a la base de datos*/
      $cp =  $param["cp"];    
      $query_get =  "SELECT * FROM codigo_postal WHERE cp like '".$cp."%' LIMIT 20";
      $cps = $this->db->query($query_get)->result_array();
      if (count($cps) ==  0) {
        $cp =  substr($cp, 1 , strlen($cp));
        $query_get =  "SELECT * FROM codigo_postal WHERE cp like '".$cp."%' LIMIT 20";
        $cps = $this->db->query($query_get)->result_array();
      }
      return $cps;

    }  
      
    
}