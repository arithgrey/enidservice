<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Imagen_servicio_model extends CI_Model {  
  	function __construct(){
        parent::__construct();        
        $this->load->database();
  	}
  	private function insert( $params , $return_id=0){        
	    $insert   = $this->db->insert("imagen_servicio", $params);     
	    return ($return_id ==  1) ? $this->db->insert_id() : $insert;
	}
  	private function get( $params=[], $params_where =[] , $limit =1){
	    $params = implode(",", $params);
	    $this->db->limit($limit);
	    $this->db->select($params);
	    foreach ($params_where as $key => $value) {
	        $this->db->where($key , $value);
	    }
	    return $this->db->get("imagen_servicio")->result_array();
  	}
 	function get_img_servicio($id_servicio){
    	return $this->get(["id_imagen"] , ["id_servicio" => $id_servicio ] );
  	}
  	function get_imagenes_por_servicio($param){
	  $id_servicio   =  $param["id_servicio"];
	  return $this->get(["id_imagen"] , ["id_servicio" => $id_servicio ] , 10);
	}
}