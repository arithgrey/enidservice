<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Pregunta_servicio extends REST_Controller{      
    function __construct(){
        parent::__construct();                                  
        $this->load->model("pregunta_servicio_model");
        $this->load->library(lib_def());            
    } 
    function index_POST(){

        $param     = $this->post();
        $param["id_servicio"] = $param["servicio"];
        $response  = $this->pregunta_servicio_model->create($param);
        $this->response($response);
    }
   
}?>