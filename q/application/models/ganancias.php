<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Ganancias extends REST_Controller{      
    function __construct(){
        parent::__construct();                          
        $this->load->helper("proyectos");            
        $this->load->model("cobranzamodel");     
        $this->load->library(lib_def());                                      
        
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
   
}?>