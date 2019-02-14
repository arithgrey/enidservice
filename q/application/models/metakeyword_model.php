<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class metakeyword_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function update($data =[] , $params_where =[] , $limit =1 ){
    
      foreach ($params_where as $key => $value) {
        $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update("metakeyword", $data);    
    }
    function q_up($q , $q2 , $id_metakeyword){
        return $this->update([$q => $q2 ] , ["id_metakeyword" => $id_metakeyword ]);
    }
    function get( $params=[], $params_where =[] , $limit =1 , $order = '', $type_order='DESC'){
        
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);        
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        if($order !=  ''){
          $this->db->order_by($order, $type_order);  
        }       
        return $this->db->get("metakeyword")->result_array();
    }
    function insert( $params , $return_id=0){
        debug(9999);
      $insert   = $this->db->insert("metakeyword", $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    function get_metakeyword_catalogo_usuario($param){
        return $this->get(["metakeyword"], ["id_usuario" =>  $param["id_usuario"] ]);        
    } 
}