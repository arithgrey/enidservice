<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Ciclo_facturacion extends REST_Controller{      
    function __construct(){
        parent::__construct();                                  
        $this->load->model("facturacion_model");
        $this->load->library(lib_def());            
    } 
    /*
    function servicio_GET(){
        
        $param  =  $this->get();                
        $ciclos =  
        $this->facturacion_model->get_ciclos_facturacion_disponibles($param);
        $this->response($ciclos);
    }
    */
    /**/
    function not_ciclo_facturacion_GET(){
        $param  =  $this->get();                
        $ciclos =  $this->facturacion_model->not_ciclo_facturacion($param);
        $this->response($ciclos);
    }     
    /**/


   
}?>