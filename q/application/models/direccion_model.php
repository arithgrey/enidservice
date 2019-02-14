<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Direccion_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }    
      
    function get_data_direccion($param){
        
        $id_direccion =  $param["id_direccion"];
        $query_get ="SELECT 
                    d.*,
                    cp.* 
                    FROM 
                    direccion 
                    d 
                    INNER JOIN 
                    codigo_postal 
                    cp 
                    ON d.id_codigo_postal =  cp.id_codigo_postal  
                    WHERE d.id_direccion =".$id_direccion;
        return  $this->db->query($query_get)->result_array();
        
    } 
    function insert( $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert("direccion", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }        
}