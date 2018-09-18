<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class contactosmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();

    }
    /**/
    function insert($tabla ='imagen', $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert($tabla, $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }        
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
    
    function insert_contacto($param){

      $params = [
        "nombre"              =>  $param["nombre"],
        "email"               =>  $param["email"],
        "mensaje"             =>  $param["mensaje"],
        "id_empresa"          =>  $param["empresa"],
        "id_tipo_contacto"    =>  $param["tipo"],
        "telefono"            =>  $param["tel"]
      ];
      return $this->insert("contact" , $params);    
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