<?php defined('BASEPATH') OR exit('No direct script access allowed');
class clasificacion_model extends CI_Model{
  
  function __construct(){
      parent::__construct();        
      $this->load->database();
  }   
  /**/
  function count_clasificacion($param){

    $nombre =    $param["clasificacion"];
    $servicio =  $param["servicio"];
    $query_get = "SELECT COUNT(0)num FROM clasificacion 
                  WHERE 
                  flag_servicio =  '".$servicio."'
                  AND 
                  nombre_clasificacion =  '".$nombre."' LIMIT 1 ";
    $result =  $this->db->query($query_get);
    $response["existencia"] =  $result->result_array()[0]["num"];
    return $response;
  }
  /**/  
  function get_clasificacion_nivel($param){

      $es_servicio  =  $param["es_servicio"];
      $nivel        =  $param["nivel"];
      $padre        =  $param["padre"];

      $query_get  = "SELECT * FROM 
                    clasificacion 
                    WHERE 
                      flag_servicio = '".$es_servicio."' 
                    AND 
                      nivel =  '".$nivel."'
                    AND 
                      padre = '".$padre."'";

      $result =  $this->db->query($query_get);                  
      return $result->result_array();
  }
  /**/
  function add_clasificacion($param){

      $nivel          =  $param["nivel"];
      $clasificacion  =  $param["clasificacion"];
      $tipo           =  $param["tipo"];
      $padre          =  $param["padre"];
      $query_insert =  "INSERT INTO 
                          clasificacion(
                            nombre_clasificacion,
                            flag_servicio ,
                            padre ,
                            nivel
                        ) VALUES(
                            '".$clasificacion."',
                            '".$tipo ."',
                            '".$padre ."',
                            '".$nivel."'
                        )";      
      return $this->db->query($query_insert);
  }
  /**/
}