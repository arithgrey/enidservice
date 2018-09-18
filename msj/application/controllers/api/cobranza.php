<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Cobranza extends REST_Controller{          
    public $options;
    function __construct($options=[]){
        parent::__construct();              
        
        $this->load->library("mensajeria_lead");         
        $this->load->library(lib_def());                         
    }

    function cancelacion_venta_GET(){
                
        $param                      = $this->get();            
        $cliente                    = $param["usuario_notificado"][0];
        $nombre                     = $cliente["nombre"];    
        $email                      = $cliente["email"];    
        $info_correo["info_correo"] = $cuerpo_correo;        
        $cuerpo_correo              = $this->get_mensaje_cancelacion_venta($param); 
        $info_correo["asunto"]      = "HOLA ".$nombre." TENEMOS NOTICIAS SOBRE TU COMPRA";
        $this->mensajeria_lead->notificacion_email($info_correo , $email);
        $this->response($cuerpo_correo);        
    }
    /**/
    private function get_mensaje_cancelacion_venta($q){        
        $api  = "cron/cancelacion_venta/format/html/"; 
        return  $this->principal->api("msj", $api , $q, "html");
    }
    /*
    function ganancias_afiliados_GET(){

        $param =  $this->get();
        $data_notificacion =  $this->get_reporte_ganancias($param);                

        $a =0;
        foreach($data_notificacion as $row){
    

                if ($row["ganancias"] ==  null ) { 
                    $row["ganancias"] =  0;
                }
                $mensaje =  $this->get_mensaje_ganancias_afiliado($row);
                $data_notificacion[$a]["info_mensaje"] = $mensaje;

                
                $email =  $row["email"];
                $nombre =  $row["nombre"];            
                $info_correo_afiliado["info_correo"] =  $mensaje;
                $info_correo_afiliado["asunto"] = "Reporte de ganancias - afiliados - Enid Service";
                $correo_dirigido_a = $email;
                

                $this->mensajeria_lead->notificacion_email($info_correo_afiliado , 
                    $correo_dirigido_a);
                
                    
            $a ++;
        }
        
        $this->response($data_notificacion);
    }
    */
    /**/
    private function get_mensaje_ganancias_afiliado($q){
        $api  = "cron/notificacion_ganancias_afiliado/format/html/"; 
        return  $this->principal->api("msj", $api , $q, "html");        
    }
    /**/
    private function get_reporte_ganancias($param){
        
        $api  = "afiliados/usuarios_ganancias/format/json/"; 
        return  $this->principal->api("pagos", $api , $q);        
    }
    /**/
    private function set_option($key, $value){
        $this->options[$key] = $value;
    }
    /**/
    private function get_option($key){
        return $this->options[$key];
    }
    /**/
    function deuda_pendiente_GET(){
        
        $recibos            =   $this->get_cuentas_por_cobrar();                  
        $num_email_enviados =   0;  
        $r =0;  
        foreach($recibos as $row){

            $email              =  $row["usuario"][0]["email"];
            $nombre             =  $row["usuario"][0]["nombre"];
            $apellido_paterno   =  $row["usuario"][0]["apellido_paterno"];
            $apellido_materno   =  $row["usuario"][0]["apellido_materno"];
            
            $id_proyecto_persona_forma_pago 
                =  
            $row["cuenta_por_cobrar"]["id_proyecto_persona_forma_pago"];
                
                

            $param["info_correo"]   =   $row["recibo"];
            $nombre_cliente         =   $nombre." " .$apellido_materno ." " .$apellido_paterno;
            $asunto                 = 
            "Hola ".$nombre_cliente." recordatorio de compra o renovación pendiente"; 
            $param["asunto"]        =   $asunto;
            $correo_dirigido_a      =   $email;
            $this->mensajeria_lead->notificacion_email($param , $correo_dirigido_a);
            $this->actualiza_pago_notificado($id_proyecto_persona_forma_pago);
            $num_email_enviados ++;
            

        }
    
        $this->set_option("mensaje", " Email enviados con éxito " . $num_email_enviados);                
        $this->response($this->get_option("mensaje"));

    }
    /**/
    private function actualiza_pago_notificado($id_recibo){

        $param["id_recibo"] = $id_recibo;
        $api    = "cobranza/notifica_recordatorio_cobranza"; 
        return  $this->principal->api("pagos", $api , $q);        
    }
    /**/
    private function get_cuentas_por_cobrar(){

        $api    = "cobranza/cuentas_por_cobrar/format/json"; 
        return  $this->principal->api("pagos", $api , []);                
    }
    
}?>