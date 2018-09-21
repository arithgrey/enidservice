<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Metakeyword_usuario_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    private function update($data =[] , $params_where =[] , $limit =1 ){
    
      foreach ($params_where as $key => $value) {
        $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update("metakeyword_usuario", $data);    
    }
    function delete_tag_servicio($param){
        
        $tag            =   $param["tag"];
        $id_servicio    =   $param["id_servicio"];        
        $palabras_clave =   $this->get_palabras_clave_por_servicio($id_servicio);        
        $tag_arreglo    =   explode(",", $palabras_clave);
        $posicion       =   $this->busqueda_meta_key_word($tag_arreglo , $tag);  
        unset($tag_arreglo[$posicion]);
        $param["metakeyword_usuario"] =   implode(",", $tag_arreglo);
        return $param;
    }    
    function set_metakeyword_usuario($param){
        return $this->update($param["metakeyword_usuario"] ,  ["id_usuario" =>  $param["id_usuario"] ]);    
    }     
    /*
    function q_up($q , $q2 , $id_servicio){
        return $this->update([$q => $q2 ] , ["id_servicio" => $id_servicio ]);
    }
    */
    /*

    function agrega_metakeyword($param){
        
        $metakeyword_usuario    =   $param["metakeyword_usuario"];    
        $id_servicio            =   $param["id_servicio"];
        $meta                   =   $this->get_palabras_clave_por_servicio($id_servicio);
        $metakeyword_usuario    =   $meta .",".$metakeyword_usuario;
        $this->q_up("metakeyword_usuario" , $metakeyword_usuario , $id_servicio);
    }
    */
       
    
}