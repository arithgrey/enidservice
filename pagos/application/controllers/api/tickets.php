<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Tickets extends REST_Controller{      
    function __construct(){
        parent::__construct();                                                  
        $this->load->library("restclient");             
        $this->load->model("tickets_model");                       
        $this->load->library("sessionclass");            
    } 
    /**/
    function compras_GET(){

        $param =  $this->get();
        /**/
        $db_response =  $this->tickets_model->get_compras_tipo_periodo($param);
        $data["compras"]=  $db_response;
        $data["tipo"] =  $param["tipo"];
        $data["status_enid_service"] =  $this->tickets_model->get_status_enid_service($param);
        $this->load->view("ventas/compras" , $data);

    }
    /**/
    function costos_envios_por_recibo_GET(){
        
        $param =  $this->get();
        $id_servicio =  $this->tickets_model->get_id_servicio_por_id_recibo($param);        
        $flag_envio_gratis =  $this->tickets_model->get_flag_envio_gratis_por_id_recibo($param);
        $this->response($flag_envio_gratis);
    }
    /**/
    function servicio_recibo_GET(){
        /**/
        $param =  $this->get();
        $db_response =  $this->tickets_model->get_servicio_por_recibo($param);        
        $this->response($db_response );
    }
    /**/
    function en_proceso_GET(){
        /**********************/        
        $param =  $this->get();
        $db_response =  $this->tickets_model->carga_actividad_pendiente($param);        
        $this->response($db_response);
    } 
    /**/
    function verifica_anteriores_GET(){
        /**/
        $param =  $this->get();        
        $db_response = $this->tickets_model->num_compras_efectivas_usuario($param);        
        $this->response($db_response);        
    }
    /**/
    function compras_efectivas_GET(){
        /**/
        /**/
        $param =  $this->get();           
        $data_complete["total"] = 
        $this->tickets_model->total_compras_ventas_efectivas_usuario($param);        
        
        if($data_complete["total"] > 0 ){
            $data_complete["compras"] 
            = $this->tickets_model->compras_ventas_efectivas_usuario($param);
        }
        $this->response($data_complete);  
    }
    /**/
   
}?>