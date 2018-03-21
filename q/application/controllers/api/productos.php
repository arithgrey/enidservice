<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class productos extends REST_Controller{      
    function __construct(){
        parent::__construct();                                      
        $this->load->helper("enid");   
        $this->load->model("productos_model");
        $this->load->library('sessionclass');
    }   
    /**/
    function metricas_productos_solicitados_GET(){

        $param =  $this->get();
        $data["info_productos"] =  $this->productos_model->get_productos_solicitados($param);
        $this->load->view("producto/principal" , $data);
    }    
    /**/
}?>
