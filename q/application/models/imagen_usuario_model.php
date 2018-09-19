<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Imagen_usuario_model extends CI_Model{  
  function __construct(){
    parent::__construct();        
    $this->load->database();
  } 
  private function get($params=[], $params_where =[] , $limit =1){
    $params = implode(",", $params);
    $this->db->limit($limit);
    $this->db->select($params);
    foreach ($params_where as $key => $value) {
        $this->db->where($key , $value);
    }
    return $this->db->get("imagen_usuario")->result_array();
  }
  function get_img_usuario($id_usuario){
    return  $this->get(["id_imagen"] , ["idusuario" => $id_usuario ] ); 
  }  

}