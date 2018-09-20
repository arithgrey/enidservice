<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class recurso extends REST_Controller{      
    function __construct(){
        parent::__construct();          
        $this->load->model("recurso_model");        
        $this->load->library(lib_def());                    
    }
    function index_POST(){

        $param      =  $this->post();
        $response   =  $this->recurso_model->create($param);
        $this->response($response);
    }
    function navegacion_GET(){                
        $param    = $this->get();        
        $response = $this->recurso_model->recursos_perfiles($param);                
        $this->response($response);
    }
    
    function mapa_perfiles_permisos_GET(){        
        $param            = $this->get();        
        $data["recursos"] = $this->recurso_model->get_perfiles_permisos($param);              
        $this->load->view("equipo/tabla_recursos" , $data);
    }   

    
}?>