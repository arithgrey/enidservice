<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Privacidad_usuario_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }  
    function insert( $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert("privacidad_usuario", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }        
    private function get($params=[], $params_where =[] , $limit =1, $order = '', $type_order='DESC'){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        if($order !=  ''){
          $this->db->order_by($order, $type_order);  
        }       
        return $this->db->get("privacidad_usuario")->result_array();
    }
    function delete( $params_where =[] , $limit =1){
        $this->db->limit($limit);        
        foreach ($params_where as $key => $value) {
          $this->db->where($key , $value);
        }        
        return  $this->db->delete("privacidad_usuario", $params_where);
    }   
    /* 
    function asociar_concepto_privacidad_usuario($param){

        if($param["termino_asociado"] == 0){

            $params = 
                    [ "id_privacidad" =>  $param["concepto"] ,
                        "id_usuario"    =>  $param["id_usuario"]
                    ];
            return $this->insert($params);            
        }else{            
            $params_where =  ["id_privacidad" => $id_privacidad ,  "id_usuario" => $id_usuario ];
            return  $this->delete($params_where);            
        }
    }
    */
    function get_terminos_privacidad_usuario($param){

        /*
        $id_usuario =  $param["id_usuario"];
        $query_get = "SELECT 
                        SUM( CASE WHEN id_privacidad =  5 THEN 1 ELSE 0 END )entregas_en_casa,
                        SUM( CASE WHEN id_privacidad =  2 THEN 1 ELSE 0 END )telefonos_visibles
                        FROM 
                        privacidad_usuario
                        WHERE 
                        id_usuario = $id_usuario LIMIT 10";
        $result =  $this->db->query($query_get);
        return $result->result_array();
        */
        $params =  [
            "SUM( CASE WHEN id_privacidad =  5 THEN 1 ELSE 0 END )entregas_en_casa",
            "SUM( CASE WHEN id_privacidad =  2 THEN 1 ELSE 0 END )telefonos_visibles"
        ];
        return $this->get($params , ["id_usuario" => $id_usuario] , 10);
    }    
    
    
}
