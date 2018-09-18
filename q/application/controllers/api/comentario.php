<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Comentario extends REST_Controller{      
    function __construct(){
        parent::__construct();          
        $this->load->model("comentario_model");        
        $this->load->library(lib_def());                    
    }
    
}?>