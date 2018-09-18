<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Respuesta extends REST_Controller{      
      private $id_usuario;
    function __construct(){
        parent::__construct();          
        $this->load->helper("respuesta");
        $this->load->model("respuesta_model");        
        $this->load->library(lib_def());                    
        $this->id_usuario = $this->principal->get_session("idusuario");
    }
    function respuesta_pregunta_POST(){        
        $param                  =   $this->post();
        $param["id_usuario"]    =   $this->id_usuario;
        $status                 =   $this->respuesta_model->registra_respuesta($param);
        $response               =   $this->respuesta_model->actualiza_estado_pregunta($param);
        if($param["modalidad"] ==  1){          
            $response =  $this->notifica_respuesta_email($param);
        }
        $this->response($response);
    }
    private function notifica_respuesta_email($q){
        
        $api =  "pregunta/respuesta_vendedor/format/json/"; 
        return $this->principal->api("msj" , $api , $q );        
    }
    function respuestas_GET(){

        $param      = $this->get();
        $response   = $this->respuesta_model->get_respuestas($param);
        $this->response($response);
        
    }
    function num_respuestas_GET(){

        $param =  $this->get();        
        $num_respuestas =  $this->respuesta_model->get_num_respuestas($param);    
        $this->response("Comentarios (".$num_respuestas.")");
    }
    function num_respuestas_sin_leer_GET(){

        $param    =  $this->get();
        $response =  $this->respuesta_model->get_num_respuestas_sin_leer($param);
        $this->response($response);
    }
    
    function respuesta_pregunta_GET(){
        
        $param                  =   $this->get();
        $response["data_send"]  =   $param;    
        $visto                  =   $this->set_visto_pregunta($param);
        $response["respuestas"] =   $this->respuesta_model->get_respuestas_pregunta($param);
        $response["info_usuario"] = 0;
        if ($param["modalidad"] ==  1) {            
            $response["info_usuario"] 
            = $this->principal->get_info_usuario($param["usuario_pregunta"]);
        }
        $this->load->view("valoraciones/form_respuesta" , $response);        
        
    }    
    function set_visto_pregunta($q){
        $api = "pregunta/visto_pregunta";
        return $this->principal->api("q" , $api , $q  , "json" , "PUT");
    }

}?>