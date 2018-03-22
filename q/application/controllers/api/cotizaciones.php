<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class cotizaciones extends REST_Controller{      
    function __construct(){
        parent::__construct();                          
        $this->load->model("contactosmodel");
        $this->load->library('sessionclass');                    
    }
    /**/
    function contactos_GET(){        
        
        $param = $this->get();        
        $data["contactos"] = $this->contactosmodel->get_contactos($param);
        $this->load->view("cotizador/contactos_dia" , $data);
        
    }    
    /**/ 
}?>
