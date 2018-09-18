<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Direccion_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }    
    function crea_direccion($param){

      $calle            =   $param["calle"];
      $referencia       =   $param["referencia"];
      $numero_exterior  =   $param["numero_exterior"];
      $numero_interior  =   $param["numero_interior"];
      $id_codigo_postal =   $param["id_codigo_postal"];
      $receptor         =   get_param_def($param ,"nombre_receptor" , "");
      $tel_receptor     =   get_param_def($param ,"telefono_receptor" , 0);
      

      $params = [
        "calle"               =>  $calle,
        "entre_calles"        =>  $referencia,
        "numero_exterior"     =>  $numero_exterior,
        "numero_interior"     =>  $numero_interior,
        "id_codigo_postal"    =>  $id_codigo_postal,
        "nombre_receptor"     =>  $receptor,
        "telefono_receptor"   =>  $tel_receptor
      ];
      return $this->insert("direccion", $params , 1);
      
    }  
    function get_data_direccion($param){
        
        $id_direccion =  $param["id_direccion"];
        $query_get ="SELECT 
                    d.*,
                    cp.* 
                    FROM 
                    direccion 
                    d 
                    INNER JOIN 
                    codigo_postal 
                    cp 
                    ON d.id_codigo_postal =  cp.id_codigo_postal  
                    WHERE d.id_direccion =".$id_direccion;
        $result   =  $this->db->query($query_get);
        $info     =  $result->result_array();    
        return $info;

    } 
    function insert($tabla ='imagen', $params , $return_id=0 , $debug=0){        
          $insert   = $this->db->insert($tabla, $params , $debug);     
          return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }        
}