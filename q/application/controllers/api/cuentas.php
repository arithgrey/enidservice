<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Cuentas extends REST_Controller{      
    public $option; 
    function __construct(){
        parent::__construct();                                  
        $this->load->model("cuenta_pago_model");
        $this->load->library(lib_def());   
                
    }     
    /*
    function bancos_disponibles_GET(){                
        $param =  $this->get();
        $bancos =  $this->cuenta_pago_model->get_bancos($param);
        $this->response($bancos);
    }
    */
    /**/
    function usuario_POST(){    

        $param      = $this->post();
        $response   = false;
        if (if_ext($param , "metodos_disponibles")){
            if($param["metodos_disponibles"] ==  1){

                $response   =  $this->cuenta_pago_model->get_cuentas_usuario($param);
            }
        }
        $this->response($response);

    }
    function bancaria_POST(){

        $param       =   $this->post();
        $response    =   false;

        if ($param["tipo"] ==0 ){
            if (if_ext($param , "id_usuario,clabe,banco")){
                $response   =  $this->cuenta_pago_model->regitra_cuenta_bancaria($param);
            }
        }else{

            //$response   =  $this->cuenta_pago_model->regitra_tarjeta($param);
        }
        $this->response($response);

    }    
    
}