<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class categoria extends REST_Controller{      
    function __construct(){
        parent::__construct();         
        $this->load->model("categoria_model");
        $this->load->library(lib_def());                      
    }
    /**/
    function categorias_por_tipo_GET(){

      $param    =   $this->get();
      $response =  $this->get_categorias_por_tipo($param["tipo"]); 
      $this->response($response);
      
  	}

}?>
