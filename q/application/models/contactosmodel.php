<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class contactosmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();

    }
    /**/
    function insert($params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert("contact", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }        
    function get_contactos($param){

      $query_get =  "SELECT * FROM  
                    contact 
                    WHERE 
                    DATE(fecha_registro)
                    BETWEEN '".$param["fecha_inicio"]."' AND '".$param["fecha_termino"]."' "; 
      $result = $this->db->query($query_get);      
      return $result->result_array();
    }
    
    
    /*
    function get_resumen_cotizacione($param)
    {

      $fecha =  $param["fecha"];
      $query_get =  "SELECT * FROM cotizador WHERE DATE(fecha_registro) = '".$fecha."' "; 
      $result = $this->db->query($query_get);      
      return $result->result_array();
    }
    
    
    
    
  */
    
}