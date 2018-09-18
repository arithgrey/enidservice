<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class direccion extends REST_Controller{      
    function __construct(){
        parent::__construct();                 
        $this->load->model("direccion_model");    	
        $this->load->library(lib_def());     
    }
    function data_direccion_GET(){
        $param      = $this->get();
        $response   =  $this->direccion_model->get_data_direccion($param);
        $this->response($response);
    }
    function index_POST(){
        $param      = $this->post();
        $response   =  $this->direccion_model->crea_direccion($param);        
        $this->response($response);
    }       
    

}?>
