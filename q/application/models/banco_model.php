<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Banco_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
   	/**/
    function get_bancos($param){          
      
      return $this->get("banco" , [] , ["status" => 1] , 100);
    }
    
}
	