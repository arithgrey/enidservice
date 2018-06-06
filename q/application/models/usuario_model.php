<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class usuario_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function has_phone($param){
        $id_usuario =  $param["id_usuario"];
        $query_get ="SELECT 
                        COUNT(0)num 
                    FROM usuario 
                    WHERE 
                        idusuario =$id_usuario
                    AND 
                        tel_contacto 
                    IS NOT NULl LIMIT 1";
                    $result =  $this->db->query($query_get);
                    return $result->result_array()[0]["num"];
    }
    /**/
    function get_contacto_usuario($param){
        $id_usuario =  $param["id_usuario"];
        $query_get =    "SELECT 
                        idusuario id_usuario, 
                        nombre , 
                        apellido_paterno , 
                        apellido_materno ,
                        email,
                        tel_contacto,  
                        tel_contacto_alterno,
                        tel_lada,
                        lada_negocio
                        FROM 
                        usuario 
                        WHERE idusuario = $id_usuario LIMIT 1"; 
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_usuario_por_id_pregunta($param){
        /**/  
      $id_pregunta =  $param["id_pregunta"];
      $query_get ="SELECT id_usuario FROM pregunta WHERE id_pregunta = $id_pregunta LIMIT 1";
      $result = $this->db->query($query_get);
      return $result->result_array();
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
    /**/
    function get_tipo_entregas($param){

        $id_usuario =  $param["id_usuario"];
        $query_get = "SELECT 
                        entregas_en_casa 
                        tipo_entregas 
                        FROM usuario 
                        WHERE 
                        idusuario =  $id_usuario LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["tipo_entregas"];
    }
    /**/
    function get_informes_por_telefono($param){

        $id_usuario =  $param["id_usuario"];
        $query_get = "SELECT 
                        informes_telefono                        
                        FROM usuario 
                        WHERE 
                        idusuario =  $id_usuario LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["informes_telefono"];
    
    }
    /**/
    function get_terminos_privacidad($param){

        $id_usuario =  $param["id_usuario"];
        $query_get = "SELECT 
                        *
                        FROM privacidad_usuario
                        WHERE 
                        id_usuario =  $id_usuario";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_terminos_privacidad_usuario($param){

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
    }
    /**/

}