<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Cobranza extends REST_Controller{      
    /**/
    public $options;
    function __construct($options=[]){
        parent::__construct();              
        $this->load->library("restclient");                                    
        $this->load->library("mensajeria_lead");                                    
    }
    /**/
    function cancelacion_venta_GET(){

        $param = $this->get();        

        $cuerpo_correo = $this->get_mensaje_cancelacion_venta($param); 
        $this->response($cuerpo_correo);
    }
    /**/
    private function get_mensaje_cancelacion_venta($param){
        
        $info_usuario =  $param;
        $url = "msj/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = 
        $this->restclient->get("cron/cancelacion_venta/format/html/" , 
            $info_usuario);
        $response =  $result->response;        
        return $response;
    }
    /**/
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
                $info_correo_afiliado["asunto"] =  
                "Reporte de ganancias - afiliados - Enid Service";
                $correo_dirigido_a = $email;
                

                $this->mensajeria_lead->notificacion_email($info_correo_afiliado , 
                    $correo_dirigido_a);
                
                    
            $a ++;
        }
        
        $this->response($data_notificacion);
    }
    /**/
    private function get_mensaje_ganancias_afiliado($param){
        
        /**/
        $info_usuario =  $param;
        $url = "msj/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = 
        $this->restclient->get("cron/notificacion_ganancias_afiliado/format/html/" , 
            $info_usuario);
        $response =  $result->response;        
        return $response;
        
    }
    /**/
    private function get_reporte_ganancias($param){
        
        /**/
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("afiliados/usuarios_ganancias/format/json/" , $param);
        $response =  $result->response;        
        return json_decode($response , true);
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
        
        $recibos = $this->get_cuentas_por_cobrar();                                
        $num_email_enviados =0;  
        $r =0;  
        foreach($recibos as $row){

            $email =  $row["usuario"][0]["email"];
            $nombre =  $row["usuario"][0]["nombre"];
            $apellido_paterno =  $row["usuario"][0]["apellido_paterno"];
            $apellido_materno =  $row["usuario"][0]["apellido_materno"];
            
            $id_proyecto_persona_forma_pago 
                =  
            $row["cuenta_por_cobrar"]["id_proyecto_persona_forma_pago"];
                
                

                $param["info_correo"] =  $row["recibo"];
                $nombre_cliente = $nombre." " .$apellido_materno ." " .$apellido_paterno;
                
                $param["asunto"] =  "Hola ".$nombre_cliente." 
                                        recordatorio de compra 
                                        o renovación pendiente";
                $correo_dirigido_a = $email;
                
                $this->mensajeria_lead->notificacion_email($param , $correo_dirigido_a);         
                
                
                $this->actualiza_pago_notificado($id_proyecto_persona_forma_pago);
                $num_email_enviados ++;
            

        }
    
        $this->set_option("mensaje", " Email enviados con éxito " . $num_email_enviados);                
        $this->response($this->get_option("mensaje"));
        

    }
    /**/

    private function actualiza_pago_notificado($id_recibo){

        $url = "pagos/index.php/api/"; 
        $param["id_recibo"] = $id_recibo;
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->put("cobranza/notifica_recordatorio_cobranza" , $param);        
        $response =  $result->response;        
        return $response;
    }
    /**/
    private function get_cuentas_por_cobrar(){

        $url = "pagos/index.php/api/"; 
        $extra ="";
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");
        
        $result = $this->restclient->get("cobranza/cuentas_por_cobrar" , $extra);        
        $response =  $result->response;        
        return json_decode($response , true);
        
    }
    /**/
    private function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    
}?>
