<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Clasificacion extends REST_Controller{      
    function __construct(){
        parent::__construct();             
        $this->load->model("clasificacion_model");
        $this->load->library("restclient");
        $this->load->library('sessionclass');                                           
    }
 /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    function existencia_GET(){
        $param =  $this->get();
        $response =  $this->clasificacion_model->count_clasificacion($param);
        $this->response($response);
    }
    /**/
    function nivel_POST(){

        $param      =  $this->post();
        $response   =  $this->clasificacion_model->add_clasificacion($param);
        $this->response($response);
    }
    /**/
    function nivel_GET(){

        $param      =  $this->get();
        $response   =  $this->clasificacion_model->get_clasificacion_nivel($param);
        
        if (array_key_exists('v', $param) && $param["v"] ==  1 ) {
            $this->response($response);
        }else{                
                
            $response  = 
                select_vertical($response , 
                    "id_clasificacion" , 
                    "nombre_clasificacion" , 
                    array(
                        'size'      => 20 , 
                        'class'     => 'sugerencia_clasificacion'
                    ) 
                );

            if ($param["nivel"] !== "primer_nivel") {
                $mas_nivel =  "mas_".$param["nivel"];
                $seleccion =  "seleccion_".$param["nivel"];            
                $response .=    "<div class='".$mas_nivel."'>

                                    <button class='button-op ".$seleccion."'>
                                        AGREGAR A LA LISTA
                                    </button>                                
                                </div>";    
            }    
            
            $this->response($response);    
        }    
    }
    /**/
}?>