<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Punto_encuentro extends REST_Controller{      
    public $option; 
    function __construct(){
        parent::__construct();                                  
        $this->load->model("punto_encuentro_model");
        $this->load->helper("puntoencuentro");
        $this->load->library(lib_def());                   
    }     
    function tipo_GET(){

        $param      =  $this->get();
        $response   = [];
        
        if (if_ext($param , "id")) {
        
            $params_where = ["id_tipo_punto_encuentro" =>  $param["id"]];
            $response = $this->punto_encuentro_model->get([], $params_where , 100);         
        }
        $this->response($response);
    }
    function linea_metro_GET(){

        $param      =  $this->get();
        $response   = [];

        if (if_ext($param , "id,v")) {
        
            $params_where = ["id_linea_metro" =>  $param["id"]];
            $response = $this->punto_encuentro_model->get([], $params_where , 100);
            if ($param["v"] ==  1) {
                $response = create_estaciones($response);    
            }            
        }
        $this->response($response);     

    }
    function costo_entrega_GET(){

        $param      =  $this->get();
        $response   =  [];

        if (if_ext($param , "punto_encuentro")) {

            $id       =  $param["punto_encuentro"];
            $response = $this->punto_encuentro_model->q_get(["costo_envio"], $id);
        }
        $this->response($response);
    }
 
}?>