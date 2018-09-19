<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Usuario_perfil_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function insert($params , $return_id=0){        
      $insert   = $this->db->insert($tabla, $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    function get($params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get("usuario_perfil")->result_array();
    }   
    function agrega_permisos_usuario($param){

        $puesto =  $param["puesto"];
        $id_usuario =  $param["id_usuario"];
        $query_delete =  "DELETE FROM usuario_perfil WHERE idusuario = '".$id_usuario."' ";
        $this->db->query($query_delete);
        $params =["idusuario" => $id_usuario , "idperfil" => $puesto ];
        return $this->insert($params);
    }
    function  get_es_cliente($id_usuario){
        
        $query_get ="SELECT count(0)num_cliente FROM usuario_perfil WHERE idusuario = $id_usuario AND idperfil =20 LIMIT 1";                  
        $result =  $this->db->query($query_get);
        $es_cliente =  $result->result_array()[0]["num_cliente"];
        return $es_cliente;
    }
    function get_perfil_usuario($param){
        $id_usuario =  $param["id_usuario"];
        return $this->get(["idperfil"] ,  ["idusuario" => $id_usuario ] )[0]["idperfil"];
    }
    
}