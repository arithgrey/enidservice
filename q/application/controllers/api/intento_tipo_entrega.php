<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class intento_tipo_entrega extends REST_Controller{      
    function __construct(){
        parent::__construct();         
        $this->load->model("intento_tipo_entrega_model");
        $this->load->library(lib_def());                      
    }
    function index_POST(){

      $param    =  $this->post();
      $response =  false;
      if (if_ext($param ,  "id_servicio,tipo")){

        $params =  [
                      "id_servicio"     => $param["id_servicio"] ,
                      "id_tipo_entrega" => $param["tipo"] 

                    ];
        $response =  $this->intento_tipo_entrega_model->insert($params , 1);
      } 
      $this->response($response);
    }
    function periodo_GET(){

      $param    =  $this->get();
      $response =  false;
      if (if_ext($param ,  "fecha_inicio,fecha_termino")) {
          $response =  $this->intento_tipo_entrega_model->get_pediodo($param);
      } 
      $this->response($response);
    }
    
}