<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class perfil_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function get( $params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get("perfil")->result_array();
    }
    /**/
    function insert( $params , $return_id=0){        
        $insert   = $this->db->insert($tabla, $params);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    /**/
    function get_id_departamento_by_id_perfil($param){
        $id_perfil =  $param["id_perfil"];
        $result = $this->get("perfil" , ["id_departamento"] , ["idperfil" => $id_perfil ]);
        return $result[0]["id_departamento"];
    }       
    function get_usuario($id_usuario){


        $query_get ="SELECT 
                    p.idperfil , 
                    p.nombreperfil , 
                    p.descripcion 
                    FROM 
                    perfil 
                    AS p , 
                    usuario_perfil AS up 
                    WHERE  
                    up.idperfil = p.idperfil 
                    AND up.idusuario = $id_usuario  
                    AND  up.status =  1 LIMIT 1";
                    
        return $this->db->query($query_get)->result_array();       
        
    }
    function get_puesto_cargo($param){
      $id_departamento =  $param["id_departamento"];
      return $this->get([] , ["id_departamento" =>  $id_departamento ] , 100);
    }      

}