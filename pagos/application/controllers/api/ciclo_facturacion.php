<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Ciclo_facturacion extends REST_Controller{      
    function __construct(){
        parent::__construct();                                  
        $this->load->model("facturacion_model");
        $this->load->library("sessionclass");            
    } 
    /**/
    function servicio_GET(){
        
        $param =  $this->get();                
        $ciclos =  $this->facturacion_model->get_ciclos_facturacion_disponibles($param);
        $this->response($ciclos);
    }
     
    /**/
}?>