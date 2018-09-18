<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Status_enid_service extends REST_Controller{      
    function __construct(){
        parent::__construct();                  
        $this->load->model("status_enid_service_model");        
        $this->load->library(lib_def());                    
    }
    /**/
    function servicio_GET(){        

        $param    = $this->get();    
        $response =  $this->status_enid_service_model->get_estatus_servicio_enid_service($param);
        $this->response($response);
    }
    /**/ 
}?>