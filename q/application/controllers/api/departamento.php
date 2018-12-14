<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Departamento extends REST_Controller{
  function __construct(){
        parent::__construct();            
        $this->load->model("departamento_model");                                 
        $this->load->library(lib_def());    
  }  
  function index_GET(){

      $param    = $this->get();
      $response = $this->departamento_model->get([] , [] , 100);
      $this->response($response);
  }
}