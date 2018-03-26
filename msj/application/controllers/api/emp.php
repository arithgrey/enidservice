<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Emp extends REST_Controller{      
    function __construct(){
        parent::__construct();                  
        $this->load->model("empresamodel");                                  
        $this->load->library("mensajeria");
        $this->load->library("mensajeria_servicios_ofertados"); 
        $this->load->library("mensajeria_lead");            
        $this->load->library("restclient");            
    }
    /**/
    function notifica_pago_POST(){
        
        $param =  $this->post();
        $db_response =  $this->empresamodel->get_notificacion_pago($param);
        /**/                          
        $msj_result =  
        $this->mensajeria_lead->notifica_registro_de_pago_efectuado($db_response);        
        $msj_result2 = 
        $this->mensajeria_lead->notifica_registro_de_pago_efectuado_cliente($db_response);     
        $this->response($msj_result2);        
    }
    /**/
    function solicitud_pagina_web_POST(){
        
        $param =  $this->post();
        $db_response =  $this->empresamodel->get_usuario($param);                         
        $msj_result =  $this->mensajeria_lead->notifica_usuario_pagina_web($db_response);
        $this->mensajeria_lead->notifica_usuario_pagina_web_notificacion($db_response);
        $this->response($msj_result);                            
    }
    /**/
    function solicitud_afiliado_POST(){

        $param =  $this->post();  
        $data_send_mensajeria["email"]  =  $param["email"];        
        $data_send_mensajeria["nombre"]  =  $param["nombre"];
        $data_send["info_correo"] =  $this->carga_mensaje_bienvenida_afiliado($data_send_mensajeria);
                
        $data_send["asunto"] = "Registro efectivo, ya formas 
        parte del 
        equipo de afiliados 
        Enid Service";

        $email_afiliado = $param["email"];            
        $this->mensajeria_lead->notificacion_email($data_send , $email_afiliado);  
        $this->response(1);                                    
    }
    /***/
    private function carga_mensaje_bienvenida_afiliado($param){
        $url = "msj/index.php/api/";         
        $url_request=  $this->get_url_request($url);        
        $this->restclient->set_option('base_url', $url_request);        
        $this->restclient->set_option('format', "html");        
        $result = $this->restclient->get("emp/mensaje_inicial_afiliado/format/html/" , $param);
        return $result->response;
    }
    /**/
    function mensaje_inicial_afiliado_GET(){

        $param["info_persona"] =  $this->get();        
        $this->load->view("registro/mensaje_inicial_afiliado" , $param);
    }
    /**/
    function solicitud_sitio_web_POST(){

        $param =  $this->post();
        $db_response =  $this->empresamodel->get_usuario($param);                         
        $msj_result =  $this->mensajeria_lead->notifica_usuario_sitio_web($db_response);
        $this->response($msj_result);                    
    }    
    /**/
    function solicitud_usuario_POST(){

        /**/
        $param =  $this->post();                            
        $usuario =  $this->empresamodel->get_usuario($param); 
        $msj =  $this->mensajeria_lead->notifica_usuario_en_proceso_compra($usuario);        
        $this->response($msj);
    }    
    /**/
    function lead_POST(){
            
        /**/    
        $param =  $this->post();   
        $password_legible =  get_random();                                       
        $param["password"] = sha1($password_legible);
        $param["password_legible"] = $password_legible;
        /**/        
        $mensaje_bienvenida =  $this->carga_mensaje_bienvenida($param);   
        $param["info_correo"] =  $mensaje_bienvenida;
        $nombre = $param["nombre"];     
        $param["asunto"] =  "Notificación Enid Service, buen día ".$nombre;
        $email = trim($param["email"]);  
        $this->mensajeria_lead->notificacion_email($param , $email );             
        $registro_usuario =  $this->registra_usuario_enid_service($param);
        $this->response($mensaje_bienvenida);
        /**/
    }      
    /**/
    private function registra_usuario_enid_service($param){

        /**/        
        $extra = array('email' =>  $param["email"] ,  'password'=> $param["password"] ,  'nombre' => 
            $param["nombre"] ,  'telefono'=> $param["telefono"] );

        $url = "persona/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = 
        $this->restclient->post("equipo/prospecto_subscrito/format/json/" , $extra);
        $response =  $result->response;        
        return $response;
        
    }    
    /**/
    function carga_mensaje_bienvenida($param){
        
        $api = new RestClient();                
        $extra = array('q' =>  $param);
        $url = "msj/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $api->set_option('base_url', $url_request);
        $api->set_option('format', "json");
        $result = $api->post("presentacion/bienvenida_enid_service_usuario_subscrito" , $extra);
        $response =  $result->response;
        return $response;
    }    
    /**/
    function contacto_POST(){
        
        $param =  $this->post();
        $db_response = $this->empresamodel->insert_contacto($param);        
        $param["url_registro"] =  $_SERVER['HTTP_REFERER'];  
        
        $param["id_ticket"] =  $this->abre_ticket($param);
        $db_response=  $this->agrega_tarea_ticket($param);

        if ($param["tipo"] ==  2 ){
          
            $info =  $this->mensajeria->notifica_nuevo_contacto( $param ,  "enidservice@gmail.com");
            $info =  $this->mensajeria->notifica_agradecimiento_contacto($param);
            
        }        
        $this->response($db_response);

    }
    /**/
    function abre_ticket($param){
        
        $data_send["prioridad"] = 1;
        $data_send["departamento"] = $param["departamento"];
        $data_send["asunto"] = "Solicitud  buzón de contacto";
        $data_send["id_proyecto"] = 38;
        $data_send["id_usuario"] =180;          
    
        $api = new RestClient();                        
        $url = "portafolio/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $api->set_option('base_url', $url_request);
        $api->set_option('format', "json");
        $result = $api->post("tickets/ticket" , $data_send);
        $response =  $result->response;
        return $response;
    }
    function test_GET(){
        $this->response("ok");
    }
    /**/
    function agrega_tarea_ticket($param){

        $nombre = $param["nombre"];
        $email = $param["email"];
        $tel = $param["tel"];
        $mensaje = $param["mensaje"];
        
        $nuevo_mensaje =
        "Hola soy 
        <br>
        Nombre:".
        $nombre ."<br> 
        Correo electrónico: ". 
        $email ."<br>  
        Teléfono: " 
        . $tel .
        "<br>
        ----- Solicitud hecha desde la página de contacto ------- <br>".
        $mensaje;

        $data_send["tarea"] = $nuevo_mensaje;
        $data_send["id_ticket"] = $param["id_ticket"];
        $data_send["id_usuario"] =  180;

  
        /**/
        
        $api = new RestClient();                        
        $url = "portafolio/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $api->set_option('base_url', $url_request);
        $api->set_option('format', "json");
        $result = $api->post("tarea/buzon" , $data_send);
        $response =  $result->response;
        return $response;

    }
    /**/
    function cotiza_paginas_web_POST(){

        $param = $this->post();            
        $data["inf"] = $this->empresamodel->insert_paginas_web($param);
        $inf_msj_me =  $this->mensajeria_servicios_ofertados->notifica_paginas_web_me($param , "enidservice@gmail.com");        
        $inf_msj_prospecto =  $this->mensajeria_servicios_ofertados->notifica_agradecimiento_contacto($param);    
        $this->response($inf_msj_prospecto);        
    }
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/     
}?>