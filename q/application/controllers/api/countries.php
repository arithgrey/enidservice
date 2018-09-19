<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class countries extends REST_Controller{      
    function __construct(){
        parent::__construct();                                  
        $this->load->model("countries_model");
        $this->load->library(lib_def());            
    } 
    function pais_GET(){

        $param      =  $this->get();                
        $response   =  $this->countries_model->get([] , ["idCountry" => $id_pais]);
        $this->response($response);
    }     
   
}?>