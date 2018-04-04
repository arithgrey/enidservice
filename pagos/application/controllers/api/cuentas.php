<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Cuentas extends REST_Controller{      
    public $option; 
    function __construct(){
        parent::__construct();                                  
        $this->load->library("restclient");                                    
        $this->load->model("cuentas_model");
        $this->load->library("sessionclass");            
    } 
    /**/
    function bancos_disponibles_GET(){        
        
        $param =  $this->get();
        $bancos =  $this->cuentas_model->get_bancos($param);
        $this->response($bancos);
    }
    /**/
    function usuario_POST(){    
        /**/        
        $param = $this->post();
        if($param["metodos_disponibles"] ==  1){
            /*Agregamos pequeño filtro de validacion*/
            $cuentas =  $this->cuentas_model->get_cuentas_usuario($param);
            $this->response($cuentas);    
        }
    } 
    /**/
    function bancaria_POST(){

        $param =  $this->post();
        $registro ="";
        if ($param["tipo"] ==0 ){
            $registro =  $this->cuentas_model->regitra_cuenta_bancaria($param);    
        }else{
            $registro =  $this->cuentas_model->regitra_tarjeta($param);    
        }
        $this->response($registro);
    }
    /**/
    private function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    private function set_option($key, $value){
        $this->option[$key] = $value;
    }
    /**/
    private function get_option($key){
        return $this->option[$key];
    }
    /**/
}?>