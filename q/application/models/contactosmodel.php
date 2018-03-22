<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class contactosmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function get_resumen_cotizacione($param)
    {

      $fecha =  $param["fecha"];
      $query_get =  "SELECT * FROM cotizador WHERE DATE(fecha_registro) = '".$fecha."' "; 
      $result = $this->db->query($query_get);      
      return $result->result_array();
    }
    /**/
    function get_contactos($param){

      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];

      $query_get =  "SELECT 
                      * 
                    FROM  
                    contact 
                    WHERE 
                    DATE(fecha_registro)
                    BETWEEN '".$fecha_inicio."' AND '".$fecha_termino."' "; 
      $result = $this->db->query($query_get);      
      return $result->result_array();
    }
    /**/
    

    
}