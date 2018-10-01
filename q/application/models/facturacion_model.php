<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class facturacion_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }   
    function get( $params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        if($order !=  ''){
          $this->db->order_by($order, $type_order);  
        }       
        return $this->db->get('ciclo_facturacion')->result_array();
    }
    /**/
    function not_ciclo_facturacion($param){

        $query_get  =   
        "SELECT * FROM ciclo_facturacion WHERE id_ciclo_facturacion!=5";
        $result     =   $this->db->query($query_get);
        return $result->result_array();
    }   
  
}