<?php defined('BASEPATH') OR exit('No direct script access allowed');
class emailmodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 
  /**/
  function update_tipo_negocio($param){

    $query_update = "UPDATE tipo_negocio SET 
                    prospeccion_mail = '".$param["activo"]."' 
                    WHERE 
                    idtipo_negocio = '".$param["tipo_negocio"]."'  LIMIT 1"; 

    return  $this->db->query($query_update);

  }
  /*Termina modelo */
}