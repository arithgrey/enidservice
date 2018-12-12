<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Presentacion extends REST_Controller{      
    function __construct(){
        parent::__construct();    
        $this->load->library(lib_def());                                                        
    }
    function notificacion_duda_vendedor_GET(){

        $param              =   $this->get();
        $data["vendedor"]   =   $param;        
        $this->load->view("ventas/notificacion_pregunta" , $data);
    }
    function notificacion_respuesta_a_cliente_GET(){
    	
    	$param               = $this->get();
        $data["cliente"]     = $param;        
        $this->load->view("ventas/notificacion_respuesta" , $data);	
    }
    /*Manda mensaje a la persona que se registra desde el buzón de novedades y descuentos en el footer*/
    function bienvenida_enid_service_usuario_subscrito_GET(){

        $param["info"] =  $this->get();
        $this->load->view("registro/subscrito" , $param);
    }
}