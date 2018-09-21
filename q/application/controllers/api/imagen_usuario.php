<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Imagen_usuario extends REST_Controller{          
    function __construct(){
        parent::__construct();                                  
        $this->load->model("imagen_usuario_model");            
        $this->load->library(lib_def());                    
    } 
    function usuario_GET(){
      $param      =  $this->get();
      $response   =  $this->imagen_usuario_model->get_img_usuario($param["id_usuario"]);
      $this->response($response);   
  	}
    

}?>
