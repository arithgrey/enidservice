<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
require 'restclient.php';  
class Cron extends REST_Controller{      
    function __construct(){
        parent::__construct();                  
        $this->load->library("mensajeria_lead");
        $this->load->library("principal");
        $this->load->model("pagosmodel");                                              
    }
    /**/
    function pagos_GET(){

        $param = $this->get();
        $lista_email =  $this->pagosmodel->get_email_por_enviar($param);        
        $contenido_correo["mensaje"] = "contenido del correo";
        $contenido_correo["asunto"] = "Algún asunto";        
        $lista_email_enviados = $this->pagosmodel->registra_email_enviados($lista_email , $contenido_correo);
        $this->response($lista_email_enviados);
    }
    /**/
    /**/
    function encuesta_evaluacion_servicios_GET(){

        $api = new RestClient();                
        $param = $this->get();
            
            $extra = array('q' =>  1 );
            $url = "msj/index.php/api/";    
            $url_request=  $this->get_url_request($url);
            $api->set_option('base_url', $url_request);
            $api->set_option('format', "json");
            $result = $api->get("cron/evaluacion_servicios" , $extra);
            $response =  $result->response;
        
            $lista_email = $this->pagosmodel->get_lista_clientes_activos();                
            $b = 0;
            foreach($lista_email as $row){          
                    try{

                        $param["info_correo"] = $response;
                        $nombre_cliente =$row["nombre"] ." " .$row["apellido_paterno"] ." ".$row["apellido_materno"];

                        $param["asunto"] =  "Buen día ".trim($nombre_cliente);
                        $param["mensaje"] = $response;                                    
                        $correo_dirigido_a = $row["email"]; 
                        $this->mensajeria_lead->notificacion_email($param , $correo_dirigido_a);   
                        
                    }catch(Exception $e){              
                    
                    }                     
            }

        $this->response($response);        
    }
    /**/
    function base_promocion_GET(){
        $this->load->view("mensaje/mensaje_promocion");
    }
    function evaluacion_servicios_GET(){
        $this->load->view("mensaje/mensaje_evaluacion_servicios");
    }
    /**/
    function notificacion_ganancias_afiliado_GET(){
    
        $param =  $this->get();
        $data["info_usuario"] =  $param;
        $this->load->view("mensaje/ganancias_afiliado" , $data);
    }
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
 
}?>