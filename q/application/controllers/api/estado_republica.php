<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class estado_republica extends REST_Controller{      
    function __construct(){
        parent::__construct();                                             
        $this->load->model("estado_republica_model");    	
        $this->load->library(lib_def());     
    }
	function id_GET($param){

        $param      =  $this->get();
        $response   =  $this->estado_republica_model->q_get([], $param["id_estado"]);
        $this->response($response);

    }
}