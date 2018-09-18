<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Tarea extends REST_Controller{      
    function __construct(){
        parent::__construct();                          
        $this->load->model("tareasmodel");
        $this->load->library(lib_def());     
    }
    /**/    
    function estado_PUT(){
        $param =  $this->put();
        $response = $this->tareasmodel->update_estado_tarea($param);
        $this->response($response);
    }
    /**/
    function nueva_POST(){
        
        $param =  $this->post();
        $param["id_usuario"] =  $this->principal->get_session("idusuario");
        $response = $this->tareasmodel->insert_tarea($param);
        $this->response($response);        
    }
    function buzon_POST(){
        
        $param =  $this->post();       
        $response = $this->tareasmodel->insert_tarea($param);
        $this->response($response);        
    }
    function tareas_ticket_GET(){

        $param      =   $this->get();       
        $response   =   $this->tareasmodel->get_tareas_ticket($param);
        $this->response($response);           
    }
    function tareas_ticket_num_GET(){

        $param      =   $this->get();       
        $response   =   $this->tareasmodel->get_tareas_ticket_num($param);
        $this->response($response);           
    }
    
}?>