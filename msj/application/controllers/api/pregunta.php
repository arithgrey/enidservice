<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Pregunta extends REST_Controller{      
    function __construct(){
        parent::__construct();                                          
        $this->load->library("restclient");
        $this->load->library("mensajeria_lead");        
    }    
    /**/
    function envia_email($param , $email_a_quien_se_envia){

        $this->mensajeria_lead->notificacion_email($param , $email_a_quien_se_envia);
    }
    /**/
    function respuesta_vendedor_GET(){

        $param =  $this->get();
        $id_pregunta =  $param["pregunta"];
        
        $prm =  $this->get_info_cliente_por_id_pregunta($id_pregunta);
        
        if(count($prm)>0){        
          
            $email_cliente =  $prm[0]["email"];                
            $prm_email["info_correo"] =  $this->crea_vista_notificacion_respuesta($prm);    
            $prm_email["asunto"] ="Notificación, un nuevo cliente te ha enviado una pregunta, apresúrate!";
            $this->envia_email($prm_email , $email_cliente); 
            $this->response(1);
            
        }else{
            $this->response("No se envió el mensaje");
        }
        
    }
    /**/
    function pregunta_vendedor_GET(){

        $param =  $this->get();

        $prm =  $this->get_info_vendedor_por_servicio($param["servicio"]);
        if(count($prm)>0){        
            /**/
            $email_vendedor =  $prm[0]["email"];                
            $prm_email["info_correo"] =  $this->crea_vista_notificacion_pregunta($prm);    
            $prm_email["asunto"] ="Notificación, un nuevo cliente te ha enviado una pregunta, apresúrate!";
            $this->envia_email($prm_email , $email_vendedor); 
            $this->response(1);
            
        }else{
            $this->response("No se envió el mensaje");
        }        
        
    }
    /**/
    private function crea_vista_notificacion_pregunta($param){
        
        $url = "msj/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = 
        $this->restclient->get("presentacion/notificacion_duda_vendedor/format/html/" , $param);
        return $result->response;
    }
    private function crea_vista_notificacion_respuesta($param){
        
        $url = "msj/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = 
        $this->restclient->get("presentacion/notificacion_respuesta_a_cliente/format/html/" , $param);
        return $result->response;
    }
    /**/
    private function get_info_vendedor_por_servicio($id_servicio){

        $param["servicio"] =  $id_servicio;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/usuario_servicio/format/json/" , $param);        
        $data =  $result->response;
        return json_decode($data , true);  
    }
    /**/    
    private function get_url_request($extra){
        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    private function get_info_cliente_por_id_pregunta($id_pregunta){

        $param["id_pregunta"] =  $id_pregunta;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/usuario_por_pregunta/format/json/" , $param);        
        $data =  $result->response;
        return json_decode($data , true);  
    }


}?>