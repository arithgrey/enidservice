<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Servicios extends REST_Controller{
  function __construct(){
        parent::__construct();        
        $this->load->model("img_model");              
        $this->load->library(lib_def());          
  }  
  /**/
  function imgs_servicio_GET(){

    $param =  $this->get();       
    $imgs =  $this->img_model->get_imagenes_por_servicio($param);
    $this->response($imgs);
    
  }
   /**/  
}