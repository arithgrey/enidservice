<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class presentacionmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    /**/
    function update_perfil_usuario($param){

      /**/      
      $id_usuario =  $param["id_usuario"];
      $id_perfil = $param["id_perfil"];

      $query_update =  "UPDATE usuario_perfil 
                          SET 
                          idperfil =  '".$id_perfil."'
                          WHERE 
                          idusuario = '".$id_usuario."' LIMIT 1";

        return $this->db->query($query_update);
    }
    /**/
    function delete_negocios_disponibles($param){
        $query_update =  "UPDATE tipo_negocio SET prospeccion =  0 LIMIT 200";
        return $this->db->query($query_update);
        
    }
    /**/
    function get_tipos_negocios_disponibles_prospeccion($param){        

        $query_get ="SELECT * FROM tipo_negocio WHERE  prospeccion = 1";
        $result =  $this->db->query($query_get);
        return $result->result_array();

    }
    /**/
    function get_tipos_negocios_disponibles($param){        

        $query_get ="SELECT 
        SUM(CASE WHEN tipo_servicio = 1 THEN 1 ELSE 0 END )pw ,
        SUM(CASE WHEN tipo_servicio = 2 THEN 1 ELSE 0 END )adw ,
        SUM(CASE WHEN tipo_servicio = 3 THEN 1 ELSE 0 END )tl ,
        SUM(CASE WHEN tipo_servicio = 4 THEN 1 ELSE 0 END )crm ,
        SUM(CASE WHEN tipo_servicio = 5 THEN 1 ELSE 0 END )gestos_contenidos 
        FROM prospecto 
        WHERE  n_tocado =0";

        $result =  $this->db->query($query_get);
        return $result->result_array();

    }
    /**/
    function insert_mensaje_red_social($param){
            
        $demo_ejemplo =  $param["demo_ejemplo"];        
        $query_insert ="INSERT INTO sitio_presentacion(sitio) VALUES('".$demo_ejemplo."')";
        return   $this->db->query($query_insert);                         
    }
    /**/
    function get_negocios_disponibles($param){

        $q =  $param["q"];
        $query_get ="SELECT * FROM tipo_negocio 
        WHERE 
        
        nombre like '%".$q."%'
        ORDER BY nombre ASC";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function update_negocios_disponibles($param){

        $id_tipo_negocio =  $param["id_tipo_negocio"];  
        

        if (isset($param["flag"])){

                $flag = $param["flag"];

                if($flag ==  0 ){$flag = 1; }else{$flag = 0;}            

        }else{
            $flag = 0;
        }
        
        
        
        $query_get = "UPDATE tipo_negocio 
                      SET prospeccion = '".$flag."' 
                      WHERE  idtipo_negocio = '". $id_tipo_negocio ."' ";         
        return $this->db->query($query_get);

    }
    /**/
    
}