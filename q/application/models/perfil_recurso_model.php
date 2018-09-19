<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Perfil_recurso_model extends CI_Model{
    function __construct(){      
        parent::__construct();        
        $this->load->database();
  }
  function delete($params_where =[] , $limit =1){              
    $this->db->limit($limit);        
    foreach ($params_where as $key => $value) {
      $this->db->where($key , $value);
    }        
    return  $this->db->delete("perfil_recurso", $params_where);
  }
  function insert( $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert($tabla, $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
  }        
  function q_up($q , $q2 , $id_servicio){
        return $this->update("perfil_recurso" , [$q => $q2 ] , ["id_servicio" => $id_servicio ]);
  }

  function q_get($params=[], $id){
      return $this->get("perfil_recurso", $params, ["id_servicio" => $id ] );
  }  
  function get_num($param){
     $query_get ="SELECT 
                    COUNT(0)num_permiso FROM perfil_recurso 
                    WHERE 
                  idrecurso = '".$param["id_recurso"]."' 
                    AND 
                  idperfil = '".$param["id_perfil"]."'";

    return  $this->db->query($query_get)->result_array()[0]["num_permiso"];                    
  }  
  function delete_perfil_recurso($param){
    
    $params_where =  [
      "idrecurso" => $param["id_recurso"] , 
      "idperfil"  => $param["id_perfil"]
    ];

    return  $this->delete($params_where);
  }
}
