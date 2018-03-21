<?php defined('BASEPATH') OR exit('No direct script access allowed');
class areaclientemodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 
  /**/
  function get_fechas_7(){
    
    $query_get ="SELECT ADDDATE(CURRENT_DATE(), INTERVAL 1  DAY)hoy , ADDDATE(CURRENT_DATE(), INTERVAL - 7 DAY)menos_7";
    $result =  $this->db->query($query_get);
    return $result->result_array();

  }
  /**/
  function set_info_password_usuario($param){

    $password = RandomString();
    $id_usuario =  $param["id_usuario"];  
    $query_update ="UPDATE 
                      usuario 
                    SET password = '".sha1($password) ."' 
                    WHERE 
                    idusuario = '".$id_usuario ."' LIMIT 1";
    
    $this->db->query($query_update);    
    return  $password; 
   
  }
  /**/
  function get_info_usuario($param){

    $id_usuario =  $param["id_usuario"];    
     
    $query_get ="SELECT 
                  * 
                 FROM 
                  usuario 
                 WHERE 
                  idusuario = '".$id_usuario."' LIMIT 1";

    $result = $this->db->query($query_get);    
    return  $result->result_array();    
  }

  /*Termina modelo */
}