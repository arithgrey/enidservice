<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Tarea extends REST_Controller{      
    function __construct(){
        parent::__construct();                          
        $this->load->model("tareasmodel");
        $this->load->library('sessionclass');      

    }
    /**/    
    function estado_PUT(){
        $param =  $this->put();
        $db_response = $this->tareasmodel->update_estado_tarea($param);
        $this->response($db_response);
    }
    /**/
    function nueva_POST(){
        
        $param =  $this->post();
        $param["id_usuario"] =  $this->sessionclass->getidusuario();
        $db_response = $this->tareasmodel->insert_tarea($param);
        $this->response($db_response);        
    }
    function buzon_POST(){
        
        $param =  $this->post();       
        $db_response = $this->tareasmodel->insert_tarea($param);
        $this->response($db_response);        
    }

}?>