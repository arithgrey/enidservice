<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class sugerencia_model extends CI_Model {
    public $options;
    function __construct($options=[]){      
        parent::__construct();  
        
        $this->load->database();
    }
    /**/
    function q($param){

        $id_servicio =  $param["servicio"];
        
        return  $id_servicio;

    }
    
}