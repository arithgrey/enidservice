<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Ganancias extends REST_Controller{      
    function __construct(){
        parent::__construct();                          
        $this->load->helper("proyectos");            
        $this->load->model("cobranzamodel");     
        $this->load->library("restclient");                                    
        $this->load->library("sessionclass");            
    } 
    /**/
    function ganancias_fecha_GET(){
        
        $param =  $this->get();
        $num_ventas =  $this->cobranzamodel->get_ventas_dia($param);
        $this->response($num_ventas);
    }
    function solicitudes_fecha_GET(){
        
        $param =  $this->get();
        $num_ventas =  $this->cobranzamodel->get_solicitudes_venta_dia($param);
        $this->response($num_ventas);
    }
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    
   
}?>