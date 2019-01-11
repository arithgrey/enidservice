<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Emp extends REST_Controller{      
    function __construct(){
        parent::__construct();                  
        $this->load->model("empresamodel");                                  
        $this->load->library("mensajeria");
        $this->load->library("mensajeria_servicios_ofertados"); 
        $this->load->library("mensajeria_lead");            
        $this->load->library(lib_def());              
    }
    function gamifica_usuarios_sin_contestar_cliente_GET(){
        /*solicito los servicio que no han dado respuesta al cliente*/
        $param      =  $this->get();
        $api        =  "valoracion/servicios_pregunta_sin_contestar/format/json/";
        $servicios  =  $this->principal->api( $api , $param);

        if (count($servicios)>0) {

            $data_complete  = [];
            $a =0;
            foreach ($servicios as $row) {

                $id_servicio                =  $row["id_servicio"];
                $id_pregunta                =  $row["id_pregunta"];
                $prm["servicio"]            =  $id_servicio;
                $api                        =  "usuario/id_usuario_por_id_servicio/format/json/";
                $usuario                    =  $this->principal->api( $api  , $prm  );

                $id_usuario                 =   $usuario[0]["id_usuario"];
                $data_complete[$a]["id"]    =   $id_usuario;

                $data_send["id"]            =   $id_usuario;
                $data_send["type"]          =   4;
                $data_complete[$a]["gamificacion"] =  $this->aplica_gamification_servicio($data_send);
                /*ahora actualizo la gamificacion en preguntas*/

                $prm["id_pregunta"]         =  $id_pregunta;
                $api                        =  "valoracion/gamificacion_pregunta/format/json/";
                $data_complete[$a]["nueva_gamificacion"]    =
                    $this->principal->api( $api , $prm , "json" , "PUT");

                $a ++;
            }
            $this->response($data_complete);

        }
        $this->response("No hay usuarios a quienes gamificar");
    }
    function contacto_POST(){

        $param                  =   $this->post();
        $response               =   $this->insert_contacto($param);
        $param["url_registro"]  =   $_SERVER['HTTP_REFERER'];
        $ticket                 =   $this->abre_ticket($param);
        $this->response($ticket);
        $param["id_ticket"]     =   $ticket;
        $response               =   $this->agrega_tarea_ticket($param);

        if ($param["tipo"] ==  2 ){
            $email  =  "enidservice@gmail.com";
            $info   =  $this->mensajeria->notifica_nuevo_contacto( $param ,  $email);
            $info   =  $this->mensajeria->notifica_agradecimiento_contacto($param);
        }
        $this->response($response);
    }
    function notifica_pago_POST(){

        $param      =  $this->post();
        $response   =  $this->get_notificacion_pago($param);
        $msj_result =  $this->mensajeria_lead->notifica_registro_de_pago_efectuado($response);
        $msj_result2 =
            $this->mensajeria_lead->notifica_registro_de_pago_efectuado_cliente($response);
        $this->response($msj_result2);
    }
    function solicitud_usuario_POST(){

        $param      =  $this->post();
        $usuario    =  $this->empresamodel->get_usuario($param);
        $msj        =  $this->mensajeria_lead->notifica_usuario_en_proceso_compra($usuario);
        $this->response($msj);
    }
    function solicitud_pagina_web_POST(){

        $param =  $this->post();
        $response =  $this->empresamodel->get_usuario($param);
        $msj_result =  $this->mensajeria_lead->notifica_usuario_pagina_web($response);
        $this->mensajeria_lead->notifica_usuario_pagina_web_notificacion($response);
        $this->response($msj_result);
    }
    function salir_GET(){

        $param      = $this->get();
        $response   = false;
        switch ($param["type"]) {
            /*Correos de promoción*/
            case 1:

                $response =   $this->salir_list_email($param);
                break;

            case 2:
                return $this->cancela_recordatorio($param);
                break;

            case 3:
                /*Se cancelan los recordatorios de publicacion servicio*/
                return $this->cancelar_recordatorio_servicio($param);
                break;
            
            default:
                
                break;
        }
        $this->response($response);
    }
    private function aplica_gamification_servicio($param){

        $url    =  "servicio/add_gamification_servicio/format/json/"; 
        return  $this->put_service_enid($param, "base" , $url );
    } 
    private function get_notificacion_pago($q){

        $api    =  "notificacion_pago/resumen/format/json/"; 
        return $this->principal->api( $api , $q);
    }
    private function carga_mensaje_bienvenida_afiliado($param){
        $api =  "emp/mensaje_inicial_afiliado/format/html/"; 
        return $this->principal->api($api ,$param, "html");
    }
    function mensaje_inicial_afiliado_GET(){

        $param["info_persona"] =  $this->get();        
        $this->load->view("registro/mensaje_inicial_afiliado" , $param);
    }
    private function agrega_tarea_ticket($param){


        $nombre     = $param["nombre"];
        $email      = $param["email"];
        $tel        = $param["tel"];
        $mensaje    = $param["mensaje"];
        
        $nuevo_mensaje =
        "Hola soy Nombre:".
        $nombre ."Correo electrónico: ". 
        $email  ." Teléfono: " 
        . $tel .
        "----- Solicitud hecha desde la página de contacto -------".$mensaje;

        $data_send["tarea"]         = $nuevo_mensaje;
        $data_send["id_ticket"]     = $this->abre_ticket($param);
        $data_send["id_usuario"]    = 180;
        
        return $param["id_ticket"];
        $this->principal->api("tarea/buzon", $data_send , "json" ,"POST");

    }   
    /*Se califica al cliente con base en su respuesta al cliente*/
    private function cancelar_recordatorio_servicio($param){

        $param["url_request"] = get_url_request("");
        $param["in_session"]  = 0;
        $uri_request          = "equipo/cancelar_envio_recordatorio";
        $param["v"]           = rand();
        $this->aplica_gamification_servicio($param);
        $this->principal->api( $uri_request , $param, "json", "PUT");
        $this->load->view("mensaje/evaluacion" , $param );
    }
    private function cancela_recordatorio($param){

        $param["url_request"] = get_url_request("");
        $param["in_session"]  = 0;
        $uri_request          = "cobranza/cancelar_envio_recordatorio";
        $param["v"]           = rand();
        $this->principal->api( $uri_request, $param, "json", "PUT");
        $this->aplica_gamification_servicio($param);
        $this->load->view(  "mensaje/evaluacion" , $param );
    }
    private function salir_list_email($q){
        $api = "prospecto/salir_list_email";
        return $this->principal->api( $api , $q , "json" , "PUT");
    }
    /*
    function solicitud_sitio_web_POST(){

        $param =  $this->post();
        $response =  $this->empresamodel->get_usuario($param);
        $msj_result =  $this->mensajeria_lead->notifica_usuario_sitio_web($response);
        $this->response($msj_result);
    }
    */

    /*
    function abre_ticket($param){

        $data_send["prioridad"]         =   1;
        $data_send["departamento"]      =   $param["departamento"];
        $data_send["asunto"]            =   "Solicitud  buzón de contacto";
        $data_send["id_proyecto"]       =   38;
        $data_send["id_usuario"]        =   180;
        $api = "tickets/ticket/format/json/";
        return $this->principal->api(  $api , $data_send ,"json" ,"POST");

    }*/
    /*
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
    */
    /*
  function lead_POST(){

      $param                      =   $this->post();
      $password_legible           =   get_random();
      $param["password"]          =   sha1($password_legible);
      $param["password_legible"]  =   $password_legible;
      $mensaje_bienvenida         =   $this->carga_mensaje_bienvenida($param);
      $param["info_correo"]       =   $mensaje_bienvenida;
      $nombre                     =   $param["nombre"];
      $param["asunto"]            =   "Notificación Enid Service, buen día ".$nombre;
      $email                      =   trim($param["email"]);
      $this->mensajeria_lead->notificacion_email($param , $email );
      $registro_usuario           =   $this->registra_usuario_enid_service($param);
      $this->response($mensaje_bienvenida);

  } */
    /*
    private function registra_usuario_enid_service($param){

        $extra = array('email' =>  $param["email"] ,  'password'=> $param["password"] ,  'nombre' =>
            $param["nombre"] ,  'telefono'=> $param["telefono"] );

        $url = "persona/index.php/api/";
        $url_request=  get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");
        $result =
        $this->restclient->post("equipo/prospecto_subscrito/format/json/" , $extra);
        $response =  $result->response;
        return $response;

    }
    */
    /*
    function carga_mensaje_bienvenida($param){

        $api = new RestClient();
        $extra = array('q' =>  $param);
        $url = "msj/index.php/api/";
        $url_request=  get_url_request($url);
        $api->set_option('base_url', $url_request);
        $api->set_option('format', "json");
        $result = $api->post("presentacion/bienvenida_enid_service_usuario_subscrito" , $extra);
        $response =  $result->response;
        return $response;
    }
    */
}