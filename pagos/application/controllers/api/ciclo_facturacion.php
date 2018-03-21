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
        $id_ciclo_facturacion =  $this->facturacion_model->get_ciclo_facturacion($param);        
        $ciclos_facturacion =  $this->facturacion_model->get_ciclos_facturacion_disponibles($param);
        /**/
        $data["ciclos_factura_servicio"] =  $id_ciclo_facturacion;
        $data["disponibles"] =  $ciclos_facturacion;

        $id_ciclo=  $id_ciclo_facturacion -1;
        $data["nombre_ciclo"] = $ciclos_facturacion[$id_ciclo]["ciclo"];
        /**/
        $this->response($data);
    }
     
    /**/
}?>