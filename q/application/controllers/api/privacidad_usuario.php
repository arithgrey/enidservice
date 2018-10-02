<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Privacidad_usuario extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct();         
        $this->load->model("privacidad_usuario_model");
        $this->load->library(lib_def());                      
        $this->id_usuario   =  $this->principal->get_session("idusuario");                   
    }
    function index_PUT(){    
        
        $param       =  $this->put();    
        $id_usuario  =  $this->id_usuario;        
        $response    = false;

        if (if_ext($param , 'concepto,termino_asociado') ==  1 && $id_usuario > 0 ){

            $q = [ "id_privacidad" =>  $param["concepto"] , "id_usuario"    =>  $id_usuario ];
            
            if($param["termino_asociado"] == 0){            
                $response =     $this->privacidad_usuario_model->insert($q);            
            }else{                        
                $response =     $this->privacidad_usuario_model->delete($q);            
            }
        }        
        $this->response($response);
    }
    function servicio_GET(){
        $param = $this->get();
        $response=  $this->privacidad_usuario_model->get_terminos_privacidad_usuario($param);
        $this->response($response);                 
    }
    
}?>
