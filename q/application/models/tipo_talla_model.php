<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Tipo_talla_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function q_up($q , $q2 , $id){
        return $this->update([$q => $q2 ] , ["id" => $id ]);
    }
    function update($data =[] , $params_where =[] , $limit =1 ){
      foreach ($params_where as $key => $value) {
              $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update("tipo_talla", $data);    
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
        return $this->db->get("tipo_talla")->result_array();
    }    
  	function get_like_clasificacion($param){ 

        $extra  = (array_key_exists("clasificacion", $param) && strlen($param["clasificacion"])>0 )?
        " WHERE tipo LIKE '%".$param["clasificacion"]."%' LIMIT 10":" LIMIT 30"; 
        
        $query_get      = "SELECT * FROM tipo_talla".$extra;  
        $result         = $this->db->query($query_get);
        return            $result->result_array();

    }
    /*
    function get_tipo_talla($param){
        $id             = $param["id"];
        return $this->get([] , ["id" => $id] );
    }
    function update_talla_clasificacion($param){
        return $this->q_up("clasificacion" ,  $param["clasificaciones"] ,  $param["id"]);
    }
    **/


}