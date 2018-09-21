<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class forma_pago extends REST_Controller{      
    function __construct(){
        parent::__construct();                 
        $this->load->model("forma_pago_model");    	
        $this->load->library(lib_def());     
    }
    function forma_pago_GET(){
        
        $param    = $this->get();
        $response =  $this->forma_pago_model->$this->get([], [], 100);
        $this->response($response);
    }
    
}?>
