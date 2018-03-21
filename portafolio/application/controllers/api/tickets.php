<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
require 'restclient.php';
class Tickets extends REST_Controller{          
    function __construct(){
        parent::__construct();                          
        $this->load->helper("proyectos");
        $this->load->model("ticketsmodel");                                          
        $this->load->model("tareasmodel");
        $this->load->library("sessionclass");
    }
    /**/
    function formulario_respuesta_GET(){

        $param = $this->get();
        $data["request"] = $param;
        $this->load->view("tickets/form_respuesta" , $data);            
    }
    /**/
    function respuesta_POST(){

        $param =  $this->post();
        $param["id_usuario"] = $this->sessionclass->getidusuario();
        $db_response =  $this->tareasmodel->registra_respuesta($param);
        $this->response($db_response);
    }
    function respuesta_GET(){

        $param =  $this->get();        
        $db_response =  $this->tareasmodel->get_respuestas($param);
        $db_response["info_respuestas"] = $db_response;
        $this->load->view("tickets/respuestas" , $db_response);        
    }
    /**/
    function num_respuestas_GET(){

        $param =  $this->get();        
        $num_respuestas =  $this->tareasmodel->get_num_respuestas($param);    
        $this->response("Comentarios (".$num_respuestas.")");
    }
    /**/
    function asunto_PUT(){        
        $param =  $this->put();
        $db_response =  $this->ticketsmodel->update_asunto($param);
        $this->response($db_response);
    }
    /**/
    function form_GET(){
        $param =  $this->get();                 
        $data["departamentos"] = $this->ticketsmodel->get_departamentos($param);
        $this->load->view("secciones/form_tickets" , $data );        
    }
    /**/
    function form_proyectos_GET(){
        
        $param =  $this->get();                         
        $clientes_disponibles =  $this->ticketsmodel->get_clientes_actuales();
        /**/
        $data["clientes_disponibles"] = $clientes_disponibles;
        /**/
        $id_persona =  $clientes_disponibles[0]["id_persona"];    
        /**/
        $data["servicios_cliente"] = 
        $this->ticketsmodel->get_servicios_cliente($id_persona);
        /**/        
        /**/
        $data["departamentos"] = $this->ticketsmodel->get_departamentos($param);
        $this->load->view("secciones/form_tickets_proyectos" , $data );        
    }
    /**/
    function form_proyectos_persona_GET(){
        

        $param =  $this->get();   
        $param["id_usuario"] =  $this->sessionclass->getidusuario();
        $clientes_disponibles =  $this->ticketsmodel->get_info_cliente($param);        
        $data["clientes_disponibles"] = $clientes_disponibles;
        $id_usuario =  $clientes_disponibles[0]["id_usuario"];    

        $data["servicios_cliente"] = 
        $this->ticketsmodel->get_servicios_cliente($id_usuario);
        $data["departamentos"] = $this->ticketsmodel->get_departamentos($param);
        $this->load->view("secciones/form_tickets_proyectos_persona" , $data );            
    }
    /**/
    function servicios_cliente_GET(){
        
        $param =  $this->get();
        $id_usuario = $this->sessionclass->getidusuario();
        $data["servicios_cliente"] = $this->ticketsmodel->get_servicios_cliente($id_usuario);
        $this->load->view("secciones/lista_servicios_cliente", $data);        
    }    
    /**/
    function ticket_POST(){        

        $param = $this->post();            
        $param["id_usuario"] = $this->sessionclass->getidusuario();
        $ticket_abierto =  $this->ticketsmodel->insert_ticket($param);                
        $es_cliente =  $this->ticketsmodel->es_cliente($param["id_usuario"]);
        $param["ticket"] = $ticket_abierto;
        $estatus_notificacion =  "";
        if ($es_cliente ==  1){                    
            $estatus_notificacion =  $this->notificacion_nuevo_ticket_soporte($param);
        }                

        $this->response($param["ticket"]);        
        
    }   
    function notificacion_nuevo_ticket_soporte($param){
                        
        $api = new RestClient(); 
        $id_usuario = $param["id_usuario"];  
        $info_usuario =  $this->ticketsmodel->get_nombre_usuario($id_usuario); 
        $ticket=  $param["ticket"];  
        $info_tickets = $this->ticketsmodel->get_ticket_id($ticket);
        $mensaje_notificacion =  create_notificacion_ticket($info_usuario , $param ,  $info_tickets);
        
        $mensaje_notificacion["lista_correo_dirigido_a"] =  ["soporte@eniservice.com"];
        if ($param["departamento"] == 4){
            $mensaje_notificacion["lista_correo_dirigido_a"][1] =  "aritgrey@gmail.com";
        }

        $extra = array('q' => $mensaje_notificacion);
        $url = "msj/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $api->set_option('base_url', $url_request);
        $api->set_option('format', "HTML");            
        /**/


        foreach ($mensaje_notificacion as $key => $value) {
            # code...
        }
        $result = $api->post("areacliente/notificacion_soporte/" , $extra);        
        /**/
        $response =  $result->response;
        return $response;
            
     } 
     /**/
    function test_ticket_GET(){
        
        $ticket=  $this->get("ticket");  
        $info_tickets["ticket"] = $this->ticketsmodel->get_ticket_id($ticket);
        $this->load->view("tickets/test" , $info_tickets);        
    }
    /**/

    /**/
    function ticket_PUT(){

        $param =  $this->put();
        $db_response =  $this->ticketsmodel->update_departamento($param);
        $this->response($db_response);

    }
    
    function tickets_por_servicio($param){                
        $data["info_tickets"] =  $this->ticketsmodel->get_tickets($param);
        $data["status_solicitado"] =  $param["status"];        
        return $data;       
    }
   
    /**/
    function ticket_desarrollo_GET(){

        $param = $this->get();
        $data =[];
        $modulo =  $param["modulo"]; 
        switch ($modulo) {
            case 1:
                /*Cargamos data tickets desde la versión del vendedor y por producto*/
                $data =  $this->tickets_por_servicio($param);
                break;
        
            case 2:
                /*Cargamos data tickets desde la versión direccion*/
                $data["info_tickets"] =  $this->ticketsmodel->get_tickets_desarrollo($param);
                $data["status_solicitado"] =  $param["status"];
                $data["info_get"] =  $param;
                break;
        
            default:
                /**/
                break;
        }
       
        
        $this->load->view("tickets/principal_desarollo" , $data );
    }
    function ticket_persona_GET(){

        $param = $this->get();
        $param["id_usuario"] =  $this->sessionclass->getidusuario();
        $data["info_tickets"] =  $this->ticketsmodel->get_tickets_persona($param);
        
        
        $data["status_solicitado"] =  $param["status"];
        $data["info_get"] =  $param;
        $this->load->view("tickets/principal_desarollo_persona" , $data );
        
        
    }
    /**/
    function detalle_GET(){

        $param = $this->get(); 
        
        $perfil =  $this->sessionclass->getperfiles();
        
        $data["info_ticket"] =  $this->ticketsmodel->get_info_ticket($param);            
        $data["info_tareas"] =  $this->tareasmodel->get_tareas_ticket($param);
        $data["info_num_tareas"] = $this->tareasmodel->get_tareas_ticket_num($param);
        
        $data["perfil"] =  $perfil;
        $this->load->view("tickets/detalle" , $data );     
        
        

    }
    /**/
    function status_PUT(){

        $param = $this->put();    
        $db_response =  $this->ticketsmodel->update_status($param);
        $this->response($db_response);
    }
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
}?>