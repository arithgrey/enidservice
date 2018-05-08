<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Areacliente extends REST_Controller{      
    /**/
    function __construct(){
        parent::__construct();                                  
        $this->load->model("areaclientemodel");
        $this->load->library("restclient");
        $this->load->library("mensajeria_lead");
        
    }
    /**/
    function notifica_accesos_nuevo_usuario_POST(){

        $param =  $this->post();        
        $password =  $this->areaclientemodel->set_info_password_usuario($param);        
        $param["password"] =  $password;
        /**/
        $param["info_usuario"] = $this->areaclientemodel->get_info_usuario($param);                        
        $envio_correo_maps = $this->mensajeria_lead->envia_correo_maps($param);
        
        $this->response($envio_correo_maps);
        /**/            
    }
    function carga_pago_pendiente_por_recibo($id_recibo){

        $param["id_recibo"] =  $id_recibo;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = 
        $this->restclient->get("cobranza/resumen_desglose_pago/format/html/" , $param);
        return $result->response;
    }
    /**/
    function pago_pendiente_web_GET(){

        $param = $this->get();        
        $cuerpo_correo = $this->carga_pago_pendiente_por_recibo($param["id_recibo"]);        
        $param["info_correo"] =  $cuerpo_correo;
        $param["asunto"] =  "Notificacion de compra o renovación pendiente";
        $correo_dirigido_a = $param["email"];            
        $this->mensajeria_lead->notificacion_email($param , $correo_dirigido_a);         
        $this->response($cuerpo_correo);
        
    }
    function reporte_direccion_GET(){

        
        $param = $this->get();
        
            $db_respose = $this->areaclientemodel->get_fechas_7();         
            $result =  $db_respose[0]; 
            $hoy =  $result["hoy"];
            $menos_7 =  $result["menos_7"];

            $extra = array('fecha_inicio' =>  $menos_7 ,  'fecha_termino' => $hoy, "vista" =>  1);
            $url = "q/index.php/api/";    
            $url_request=  $this->get_url_request($url);
            $this->restclient->set_option('base_url', $url_request);
            $this->restclient->set_option('format', "json");
            $result = $this->restclient->get("enid/metricas_cotizaciones/" , $extra);
            $response =  $result->response;
    
            /**/
            $param["info_correo"] =  $response;
            $param["asunto"] =  "Resumen del día Enid Service";
            $lista_correos= ["arithgrey@gmail.com"];

            for($a=0; $a < count($lista_correos); $a++){                 
                $this->mensajeria_lead->notificacion_email($param , $lista_correos[$a]);
            }            
        $this->response($response);
            
    }
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    function notificacion_soporte_POST(){
        
        $param =  $this->post("q");

        $lista_correo_dirigido_a =  $param["lista_correo_dirigido_a"];

        for ($i=0; $i <count($lista_correo_dirigido_a) ; $i++){                         
            $this->mensajeria_lead->notificacion_email($param , $lista_correo_dirigido_a[$i]);                 
        }
        $this->response($param["asunto"]);

    }

}?>