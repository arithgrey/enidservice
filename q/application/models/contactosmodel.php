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
    function get_contactos($param)
    {

      $fecha =  $param["fecha"];
      $query_get =  "SELECT * FROM  
                    contact 
                    WHERE DATE(fecha_registro) = '".$fecha."' and id_tipo_contacto =  2 "; 
      $result = $this->db->query($query_get);      
      return $result->result_array();
    }
    /**/
    function get_contactos_sitios_web($param)
    {

      $fecha =  $param["fecha"];
      $query_get =  "SELECT * FROM  
                    contact 
                    WHERE DATE(fecha_registro) = '".$fecha."' and id_tipo_contacto =  10 "; 
      $result = $this->db->query($query_get);      
      return $result->result_array();
    }
    /**/
    /**/
    function get_contactos_adwords($param)
    {

      $fecha =  $param["fecha"];
      $query_get =  "SELECT * FROM  
                    contact 
                    WHERE DATE(fecha_registro) = '".$fecha."' and id_tipo_contacto =  11 "; 
      $result = $this->db->query($query_get);      
      return $result->result_array();
    }
    /**/
    /**/
    function get_contactos_tienda_en_linea($param)
    {

      $fecha =  $param["fecha"];
      $query_get =  "SELECT * FROM  
                    contact 
                    WHERE DATE(fecha_registro) = '".$fecha."' and id_tipo_contacto =  12 "; 
      $result = $this->db->query($query_get);      
      return $result->result_array();
    }
    /**/    
    function get_contactos_crm($param)
    {

      $fecha =  $param["fecha"];
      $query_get =  "SELECT * FROM  
                    contact 
                    WHERE DATE(fecha_registro) = '".$fecha."' and id_tipo_contacto =  13 "; 
      $result = $this->db->query($query_get);      
      return $result->result_array();
    }


    
}