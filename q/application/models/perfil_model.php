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
        $insert   = $this->db->insert("perfil", $params);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
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
    
}