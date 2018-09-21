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
  function elimina_pre_img_usuario($param){

    $id_usuario =  $param["id_usuario"];  
    $imagen = $this->get_img_usuario($id_usuario);  
    foreach ($imagen as $row){
      $id_imagen=  $row["id_imagen"];      
      $query_delete ="DELETE FROM imagen_usuario WHERE  idusuario  = '". $id_usuario ."' LIMIT 1";
      $this->db->query($query_delete); 
      $this->elimina_img($id_imagen);
    }
    
  }
  function insert_imgen_usuario($param){

    $this->elimina_pre_img_usuario($param);    
    $id_usuario =  $param["id_usuario"];
    $id_empresa = $param["id_empresa"];
    $id_imagen = $this->insert_img($param , 1);  
    $params   = ["id_imagen" => $id_imagen,"idusuario" => $id_usuario];    
    return $this->insert("imagen_usuario" , $params);
  }
}