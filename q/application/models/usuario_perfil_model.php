<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Usuario_perfil_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function delete($params_where =[] , $limit =1){              
        $this->db->limit($limit);        
        foreach ($params_where as $key => $value) {
          $this->db->where($key , $value);
        }        
        return  $this->db->delete("usuario_perfil", $params_where);
    }
    function insert($params , $return_id=0){        
      $insert   = $this->db->insert("usuario_perfil", $params);     
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
        return $this->db->get("usuario_perfil")->result_array();
    } 
    function  get_es_cliente($id_usuario){
        $params_where = ["idusuario" => $id_usuario , "idperfil" => 20];
        return $this->get(["count(0)num_cliente"] , $params_where )[0]["num_cliente"];
    }
    function get_perfil_usuario($param){
        $id_usuario =  $param["id_usuario"];
        return $this->get(["idperfil"] ,  ["idusuario" => $id_usuario ] )[0]["idperfil"];
    }
    
}