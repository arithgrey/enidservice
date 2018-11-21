<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class tipificacion_recibo_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function insert( $params , $return_id=0){        
      $insert   = $this->db->insert("tipificacion_recibo", $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    function get($params=[], $params_where =[] , $limit =1, $order = '', $type_order='DESC'){
      $params = implode(",", $params);
      $this->db->limit($limit);
      $this->db->select($params);
      foreach ($params_where as $key => $value) {
          $this->db->where($key , $value);
      }
      if($order !=  ''){
        $this->db->order_by($order, $type_order);  
      }       
      return $this->db->get("tipificacion_recibo")->result_array();
    }
    function update($data =[] , $params_where =[] , $limit =1 ){
    
      foreach ($params_where as $key => $value) {
        $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update("tipificacion_recibo", $data);    
    }   
}