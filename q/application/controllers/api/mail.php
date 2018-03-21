<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Mail extends REST_Controller{      
    function __construct(){
        parent::__construct();                  
        $this->load->helper("enid");
        $this->load->helper("correoenid");        
        $this->load->model("email_model");
        $this->load->library('restclient');                    
        $this->load->library('sessionclass');                    
    }
    function reporte_mail_marketing_GET(){        
        
        $param = $this->get();
        $email = $this->email_model->get_correos_enviados_accesos($param);        
        $nuevo_email =  $this->agrega_ventas($email);
        
        $data["email"] = $nuevo_email;
        $this->load->view("enid/actividad_mail_marketing/principal" , $data);                
        
    }
    /**/
    function agrega_ventas($email){

        $nueva_data = [];
        $a =0;
        foreach($email as $row){
            
            $nueva_data[$a] =  $row;
            $fecha_registro = $row["fecha_registro"];
            $nueva_data[$a]["ventas"]=  $this->get_ventas_dia($fecha_registro);
            $nueva_data[$a]["solicitudes"]=  $this->get_solicitudes_ventas_dia($fecha_registro);

            $a ++;
        }
        return $nueva_data;
    }
    /**/
    function get_solicitudes_ventas_dia($fecha){

        $q["fecha"] =  $fecha;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("ganancias/solicitudes_fecha/format/json/" , $q);        
        $response =  $result->response;        
        return json_decode($response , true);
        
    }
    /**/
    function get_ventas_dia($fecha){

        $q["fecha"] =  $fecha;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("ganancias/ganancias_fecha/format/json/" , $q);        
        $response =  $result->response;        
        return json_decode($response , true);
        
    }
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    
    /**/ 
}?>