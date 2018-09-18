<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class incidencia extends REST_Controller{      
    function __construct(){
        parent::__construct();         
        $this->load->model("incidencia_model");
        $this->load->library(lib_def());                      
    }
    function reporte_sistema_POST(){
      $param    = $this->post();
      $response =  $this->incidencia_model->reporta_error($param);
      $this->response($response);
    }
  
}?>
