<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class usuario_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }

    /********/
    function get_usuario_por_servicio($param){
      /**/  
      $id_servicio =  $param["servicio"];
      $query_get ="SELECT id_usuario FROM servicio WHERE id_servicio = $id_servicio LIMIT 1";
      $result = $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function nombre_usuario($param){
            
        $id_usuario =  $param["id_usuario"];
        $query_get ="SELECT nombre FROM usuario WHERE idusuario =$id_usuario LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function existencia_q($param){

        $key = $param["key"];
        $value =  $param["value"];

        $query_get = "SELECT 
                        COUNT(0)num 
                        FROM usuario 
                            WHERE 
                            $key = '".$value."' LIMIT 1";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num"];            
    }
    /**/
    function get_usuario_cliente($param){
        /**/

        $id_usuario =  $param["id_usuario"];
        
        $query_get =    "SELECT 
                        idusuario id_usuario, 
                        nombre , 
                        apellido_paterno , 
                        apellido_materno ,
                        email
                        FROM 
                        usuario 
                        WHERE idusuario = $id_usuario LIMIT 1"; 
        $result =  $this->db->query($query_get);
        return $result->result_array();
    } 
    /**/
    function get_usuario_cobranza($param){
        /**/
        $id_usuario =  $param["id_usuario"];                
        $query_get =    "SELECT 
                            idusuario id_usuario, 
                            nombre, 
                            apellido_paterno, 
                            apellido_materno ,
                            email
                        FROM usuario 
                        WHERE 
                        idusuario = $id_usuario LIMIT 1"; 
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
      

}