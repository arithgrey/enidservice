<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Imagen_servicio extends REST_Controller{
  function __construct(){
      parent::__construct();        
      $this->load->model("imagen_servicio_model");              
      $this->load->library(lib_def());              
  }     
  function servicio_GET(){

      $param      =  $this->get();
      $response   =  $this->imagen_servicio_model->get_img_servicio($param["id_servicio"]);
      $this->response($response);   
  }
  function index_POST(){              
    $param    =  $this->post();        
    debug($param , 1);
    $response =  $this->imagen_servicio_model->create($param);
    $this->response($response);
  }

}