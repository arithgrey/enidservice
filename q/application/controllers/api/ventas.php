<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Ventas extends REST_Controller{      
    function __construct(){
        parent::__construct();                          
        $this->load->model("ventastelmodel");        
        $this->load->helper("ventastel");
        $this->load->helper("afiliados");
        $this->load->library('sessionclass');      
    }
    function servicios_disponibles_GET(){
        /**/
        $param =  $this->get();
        $lista =  $this->ventastelmodel->servicios_disponibles($param);        
        //$this->load->view("empresa/servicios_disponibles" , $data);
        $servicio_select=  create_select($lista , "servicio" , "form-control servicio" , "servicio" , "nombre_servicio" , 
            "id_servicio");  
        $this->response($servicio_select);
        
    }
    /**/
    function porcentaje_ganancias_GET(){

        $param =  $this->get();        
        $data["servicios"]=  $this->ventastelmodel->get_porcentajes_ganancias_plan($param);
        $this->load->view("afiliados/table_ganancias" , $data);
    }
    /**/
    function tipo_negocio_q_GET(){

       $param =  $this->get();
       $db_response =  $this->ventastelmodel->get_tipo_negocio_q($param);
       $this->response($db_response);     
    }
    /**/
    function negocio_q_GET(){        
       /**/
       $param =  $this->get();
       $db_response =  $this->ventastelmodel->get_tipos_negocios($param);
       $this->response($db_response);     
    }
    /**/
    function laborventa_GET(){
     
        $param =  $this->get();                
        $param["id_usuario"] =  $this->sessionclass->getidusuario();        
        $db_response["comparativa"]= $this->ventastelmodel->get_comparativa_labor_venta($param);
        $db_response["labor_venta"] =  $this->ventastelmodel->get_labor_venta($param);    
        $this->load->view("vtelefonicas/metricas_usuario" , $db_response);    
        /**/
    }
    /**/
    function pagos_notificados_GET(){
        /**/
        $param =  $this->get();    
        $data["pagos_notificados"]= $this->ventastelmodel->get_pagos_notificados($param);
        $this->load->view("clientes/pagos_en_notificacion" , $data);
    }
    
    /**/
}?>