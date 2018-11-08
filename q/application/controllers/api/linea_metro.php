<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Linea_metro extends REST_Controller{      
    function __construct(){
        parent::__construct();                     
        $this->load->model("linea_metro_model");        
        $this->load->helper("lineametro");        
        $this->load->library(lib_def());  
    }
    function index_GET(){

        $param      =  $this->get();
        $response   =  $this->linea_metro_model->get([], [] , 100 );
        if (if_ext($param , "v")) {
            
            if ($param["v"] ==  1) {
                $response =  create_listado_linea_metro($response);        
            }                
        }        
        $this->response($response);
    }
    
}?>