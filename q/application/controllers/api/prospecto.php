<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Prospecto extends REST_Controller{      
    function __construct(){
        parent::__construct();             
        $this->load->model("prospecto_model");        
        $this->load->library(lib_def());     
    }   
    function salir_list_email_PUT(){

        $param      =   $this->put();
        $response   =   false;
        if (if_ext($param, "email")){
            $response   =    $this->prospecto_model->salir_list_email($param);
        }
        $this->response($response);    
    } 
    function dia_GET(){

        $response   = $this->prospecto_model->email_enviados_enid_service();
        $this->response($response);
    }
    
}