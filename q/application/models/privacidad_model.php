<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Privacidad_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }  
    private function get($table='imagen' , $params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get($table)->result_array();
    }
    private function insert($tabla ='privacidad', $params , $return_id=0){        
        $insert   = $this->db->insert($tabla, $params);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    
    function get_conceptos_por_funcionalidad_usuario($id_funcionalidad , $id_usuario){

        $keys = get_keys(["p.id_privacidad", "p.privacidad" , "pu.id_usuario"]);
        $query_get = "SELECT ".$keys." 
                        FROM 
                            privacidad  p 
                        LEFT OUTER JOIN 
                        privacidad_usuario pu
                            ON
                            p.id_privacidad =  pu.id_privacidad
                            AND 
                            pu.id_usuario = $id_usuario
                        WHERE 
                        p.id_funcionalidad =  $id_funcionalidad
                        ORDER BY id_privacidad";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }  
    
    
}