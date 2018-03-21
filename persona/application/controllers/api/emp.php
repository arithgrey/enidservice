<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Emp extends REST_Controller{      
    function __construct(){
        parent::__construct();                  
        $this->load->model("empresamodel");                                  
        $this->load->library("mensajeria");
        $this->load->library("mensajeria_servicios_ofertados");
        
    }    
    /**/
    function lead_POST(){
        
        $param =  $this->post();
        $db_response = $this->empresamodel->insert_lead($param);        
        /**/
        
        $this->response($db_response);    
    }
    /**/
    function contacto_POST(){

        
        $param =  $this->post();
        $db_response = $this->empresamodel->insert_contacto($param);        
        $info =  "";
        
        if ($param["tipo"] ==  2 ){
          
            $info =  $this->mensajeria->notifica_nuevo_contacto( $param ,  "enidservice@gmail.com");
            $info =  $this->mensajeria->notifica_agradecimiento_contacto($param);

        }
        $this->response($info);    
    }
    /**/
    function cotiza_paginas_web_POST(){

        $param = $this->post();            
        $data["inf"] = $this->empresamodel->insert_paginas_web($param);
        $inf_msj_me =  $this->mensajeria_servicios_ofertados->notifica_paginas_web_me($param , "enidservice@gmail.com");        
        $inf_msj_prospecto =  $this->mensajeria_servicios_ofertados->notifica_agradecimiento_contacto($param);    
        $this->response($inf_msj_prospecto);        
    }
    /**/     
}?>