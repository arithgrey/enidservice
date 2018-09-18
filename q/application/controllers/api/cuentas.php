<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Cuentas extends REST_Controller{      
    public $option; 
    function __construct(){
        parent::__construct();                                  
        $this->load->model("cuentas_model");
        $this->load->library(lib_def());   
                
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
    
}?>