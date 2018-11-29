<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Areacliente extends REST_Controller{          
    function __construct(){
        parent::__construct();                                  
        //$this->load->model("areaclientemodel");        
        $this->load->library("mensajeria_lead");
        $this->load->library(lib_def());     
    }
    function pago_pendiente_web_GET(){

        
        $param                  = $this->get();        
        $cuerpo_correo          = $this->carga_pago_pendiente_por_recibo($param["id_recibo"]);        
        //debug($cuerpo_correo ,1);

        $param["info_correo"]   =   $cuerpo_correo;
        $param["asunto"]        =   "Notificacion de compra o renovación pendiente";
        $correo_dirigido_a      =   $param["email"];            
        $this->mensajeria_lead->notificacion_email($param , $correo_dirigido_a);
        $this->response($cuerpo_correo);
        
    }    
    function carga_pago_pendiente_por_recibo($id_recibo){

        $q["id_recibo"] =  $id_recibo;        
        $api            = "recibo/resumen_desglose_pago/format/html/"; 
        return $this->principal->api( $api , $q ,"html"  );
    }
    /*
    function notifica_accesos_nuevo_usuario_POST(){

        $param =  $this->post();        
        $password =  $this->areaclientemodel->set_info_password_usuario($param);        
        $param["password"] =  $password;        
        $param["info_usuario"] = $this->areaclientemodel->get_info_usuario($param);
        $envio_correo_maps = $this->mensajeria_lead->envia_correo_maps($param);
        $this->response($envio_correo_maps);        
    }
    
    
    
    function reporte_direccion_GET(){

        $param = $this->get();        
        $db_respose = $this->areaclientemodel->get_fechas_7();         
        $result =  $db_respose[0]; 
        $hoy =  $result["hoy"];
        $menos_7 =  $result["menos_7"];
        
        $q = [
            'fecha_inicio' =>  $menos_7 ,  
            'fecha_termino' => $hoy, "vista" =>  1
        ];

        $q["id_recibo"] =  $id_recibo;        
        $api  = "enid/metricas_cotizaciones/"; 
    
        $param["info_correo"] =  $this->principal->api( $api , $q ,"json" );
        $param["asunto"] =  "Resumen del día Enid Service";
        $lista_correos= ["arithgrey@gmail.com"];

        for($a=0; $a < count($lista_correos); $a++){                 
            $this->mensajeria_lead->notificacion_email($param , $lista_correos[$a]);
        }            
        $this->response($response);
            
    }
    */
    /**/
    
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

}?>