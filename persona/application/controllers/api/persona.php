<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Persona extends REST_Controller{          
    function __construct(){        
        parent::__construct();                                  
        $this->load->model("equipomodel");
        $this->load->model("personamodel");
        $this->load->model("agendamodel");        
        $this->load->library('sessionclass');      
    }
    /**/
    function vendedor_POST(){

        if($this->input->is_ajax_request()){ 
            
            $param = $this->post();        
            $db_reponse = $this->equipomodel->registra_vendedor($param);
            $this->response($db_reponse);

        }else{
            $this->response("Error");
        }    
    }
    /**/    
    function agendar_POST(){
    	   
        $param =  $this->post();
        $db_reponse = $this->agendamodel->agenda_llamada($param);
        $this->response($db_reponse);
    }
    /**/    
    function agendar_email_POST(){

        $param =  $this->post();
        $db_reponse = $this->agendamodel->agenda_correo($param);
        $this->response($db_reponse);   
    
    }
    /**/     
   
    /**/
    
}?>