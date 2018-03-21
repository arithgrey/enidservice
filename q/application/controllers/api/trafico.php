<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Trafico extends REST_Controller{      
    function __construct(){
        parent::__construct();          
        $this->load->model("traficomodel");                                
        $this->load->library('sessionclass');
    }   
    /**/
    function usuario_GET(){

        $param=  $this->get();
        
        $db_response["trafico"] =  $this->traficomodel->trafico_web_usuario($param);
        $this->load->view("trafico/principal" , $db_response);
    }
    /**/
    

    /**/
}?>
