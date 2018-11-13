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
    /*get_nombre_estado_enid_service*/ 
    function nombre_GET($param){
        
        $param      =   $this->get();
        $response   =   false;
        if ($param["id_estatus"] > 0) {
            $respnse    =   $this->status_enid_service->q_get(["nombre"] ,  $param["id_estatus"])[0]["nombre"];
        }
        $this->response($response);
    }
    function index_GET(){
        $param      =   $this->get();
        $response   =   [];                
        $this->response($this->status_enid_service_model->get([] ,[] ,100));
    }
}?>