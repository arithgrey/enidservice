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
    function pregunta_vendedor_GET(){

        $param =  $this->get();
        $prm =  $this->get_info_usuario($param["usuario"]);
        if(count($prm)>0){        
            /**/
            $email_vendedor =  $prm[0]["email"];                
            $prm_email["info_correo"] =  $this->crea_vista_notificacion_pregunta($prm);    
            $prm_email["asunto"] =  "Notificación, un nuevo cliente te ha enviado una pregunta, presúrate!";
            $this->envia_email($prm_email , $email_vendedor); 
            $this->response(1);
            
        }else{
            $this->response("No se envió el mensaje");
        }        
        
    }
    function crea_vista_notificacion_pregunta($param){
        
        $url = "msj/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = 
        $this->restclient->get("presentacion/notificacion_duda_vendedor/format/html/" , $param);
        return $result->response;
    }
    /**/
    private function get_info_usuario($id_usuario){

        $param["id_usuario"] =  $id_usuario;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/q/format/json/" , $param);        
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


}?>