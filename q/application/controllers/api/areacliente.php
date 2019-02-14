<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Areacliente extends REST_Controller{          
    function __construct(){
        parent::__construct();                                  

        $this->load->library("mensajeria_lead");
        $this->load->library(lib_def());     
    }
    function pago_pendiente_web_GET(){

        
        $param                  =   $this->get();
        $response               =   false;
        if (if_ext($param , "id_recibo, email")){

            $cuerpo                 =   $this->carga_pago_pendiente_por_recibo($param["id_recibo"]);
            $respose                =   true;
            if(strlen($cuerpo)>30){
                $asunto                 =   "Notificacion de compra o renovación pendiente";
                $email                  =   $param["email"];
                $q                      =   get_request_email($email, $asunto , $cuerpo);
                $this->principal->send_email_enid($q ,1);
            }

        }
        $this->response($response);
        
    }    
    function carga_pago_pendiente_por_recibo($id_recibo){

        $q["id_recibo"] =  $id_recibo;        
        $api            = "recibo/resumen_desglose_pago/format/json/";
        return $this->principal->api( $api , $q );
    }
    function enviar_POST(){

        $param      =  $this->post();  
        $response   = 2;
        if (if_ext($param , "mensaje,asunto,lista_correo_dirigido_a")) {

            $mensaje    =   $param["mensaje"]; 
            $asunto     =   $param["asunto"];
            $lista      =   $param["lista_correo_dirigido_a"];         
            $a          =   0;

            for ($i=0; $i < count($lista) ; $i++){                         
                $this->mensajeria_lead->enviar($mensaje, $asunto ,$lista[$i]);
                $a ++;
            }            
            $response["envios"] =  $a;
            $this->response($response);         
        }
        $this->response($response);        
    }

}