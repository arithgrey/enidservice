<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class validacion extends REST_Controller{      
    function __construct(){
        parent::__construct();                                              
        $this->load->model("validacionmodel");
        $this->load->helper("persona");
        $this->load->library('sessionclass');
    }
    /**/
    function q_GET(){
        $param =  $this->get();
        $data =  $this->validacionmodel->get_clientesq($param);
        $this->load->view("validacion/resumen_usuario", $data);        
    }        
    /**/
    function envio_info_POST(){
        $param =  $this->post();
        $data =  $this->validacionmodel->envio_info_inicial_paginas_web($param);
        $this->response($data);            
    }
    /**/    
}?>
