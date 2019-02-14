<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class cotizaciones extends REST_Controller{      
    function __construct(){
        parent::__construct(); 
        $this->load->helper("q");
        $this->load->model("contactosmodel");
        $this->load->library(lib_def());                      
    }
    function contactos_GET(){        
        
        $param = $this->get();
        if (if_ext($param, "fecha_inicio,fecha_termino")){
            $data["contactos"] = $this->contactosmodel->get_contactos($param);
            $this->load->view("cotizador/contactos_dia" , $data);
        }else{
            $this->response(false);
        }
    }
}