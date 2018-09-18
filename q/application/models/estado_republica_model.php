<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Estado_republica_model extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 

  function get_estado($param){    
    $id_estado =  $param["id_estado"];  
    return $this->get("estado_republica", [] , ["id_estado_republica" =>  $id_estado ]);
  }

}
