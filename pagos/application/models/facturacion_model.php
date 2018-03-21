<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class facturacion_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }   
    /**/
    function get_ciclo_facturacion($param){

        $id_servicio =  $param["id_servicio"];
        /**/
        $query_get = "SELECT 
                          id_ciclo_facturacion 
                      FROM precio 
                        WHERE 
                      id_servicio = $id_servicio LIMIT 1";
                      $result =  $this->db->query($query_get);
                      return  $result->result_array()[0]["id_ciclo_facturacion"];
    }
    /**/
    function get_ciclos_facturacion_disponibles($param){
        /**/
        $query_get ="SELECT * FROM ciclo_facturacion";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/  
}