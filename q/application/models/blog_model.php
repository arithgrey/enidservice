<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class blog_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function insert( $params , $return_id=0){        
      $insert   = $this->db->insert($tabla, $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    private function get( $params=[], $params_where =[] , $limit =1, $order = '', $type_order='DESC'){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        if($order !=  ''){
          $this->db->order_by($order, $type_order);  
        }       
        return $this->db->get("faq")->result_array();
    }
    function get_url_blog_fecha($param){
      return $this->get(["id_faq", "titulo" ,"id_categoria"  , "fecha_registro"], [ "DATE(fecha_registro) " => $param["fecha"]] , 1000);
    }
}