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
  function img_perfil($param){
        
        $fecha_inicio   = $param["fecha_inicio"];  
        $fecha_termino  = $param["fecha_termino"];
        $query_get      = 
                        "SELECT 
                            COUNT(0)num 
                        FROM 
                            imagen_usuario
                        WHERE 
                            DATE(fecha_registro) 
                        BETWEEN 
                          '".$fecha_inicio."' 
                        AND  
                          '".$fecha_termino."'";

        $result = $this->db->query($query_get);                
        return $result->result_array()[0]["num"];
    }
}