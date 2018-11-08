<?php defined('BASEPATH') OR exit('No direct script access allowed');
class proyecto_persona_forma_pago_punto_encuentro_model extends CI_Model{
  
  function __construct(){
      parent::__construct();        
      $this->load->database();
  }
  function insert( $params , $return_id=0){        
      $insert   = $this->db->insert("proyecto_persona_forma_pago_punto_encuentro", $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
  }
     
}