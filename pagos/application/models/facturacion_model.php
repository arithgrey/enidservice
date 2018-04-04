<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class facturacion_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }   
    /**/
    /**/
    function get_ciclos_facturacion_disponibles($param){
        /**/
        $query_get ="SELECT * FROM ciclo_facturacion";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/  
}