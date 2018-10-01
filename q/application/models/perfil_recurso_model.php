<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Perfil_recurso_model extends CI_Model{
    function __construct(){      
        parent::__construct();        
        $this->load->database();
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
        return $this->db->get("perfil_recurso")->result_array();
  }
  function delete($params_where =[] , $limit =1){              
    $this->db->limit($limit);        
    foreach ($params_where as $key => $value) {
      $this->db->where($key , $value);
    }        
    return  $this->db->delete("perfil_recurso", $params_where);
  }
  function insert( $params , $return_id=0 , $debug=0){        
    $insert   = $this->db->insert("perfil_recurso", $params , $debug);     
    return ($return_id ==  1) ? $this->db->insert_id() : $insert;
  }        
  function q_up($q , $q2 , $id_servicio){
        return $this->update("perfil_recurso" , [$q => $q2 ] , ["id_servicio" => $id_servicio ]);
  }
  /*
  function q_get($params=[], $id){
      return $this->get($params, ["id_servicio" => $id ] );
  } 
  */ 
  function get_num($param){
    
    $params_where = [
      "idrecurso" => $param["id_recurso"],
      "idperfil"  => $param["id_perfil"]
    ];
    $this->get(["COUNT(0)num"] , $params_where )[0]["num"];
  }  
  
}
