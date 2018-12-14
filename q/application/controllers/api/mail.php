<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Mail extends REST_Controller{      
    function __construct(){        
        parent::__construct();   
        $this->load->helper("q");                                                      
        $this->load->model("email_model");        
        $this->load->library(lib_def());                  
    }
    function reporte_mail_marketing_GET(){        
        

        $param     = $this->get();
        $response  = false;
        if (if_ext($param , 'fecha_inicio,fecha_termino') ) {

            $email          = $this->email_model->get_correos_enviados_accesos($param);                
            $nuevo_email    =  $this->agrega_ventas($email);        
            $data["email"]  = $nuevo_email;
            $this->load->view("enid/actividad_mail_marketing/principal" , $data);                    
        }else{
            $this->response($response);    
        }        
        
    }
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
    function get_solicitudes_ventas_dia($fecha){
        
        $q["fecha"] =  $fecha;
        $api =  "ganancias/solicitudes_fecha/format/json/"; 
        return $this->principal->api( $api , $q );        
    }
    function get_ventas_dia($fecha){
        $q["fecha"] =  $fecha;
        $api =  "ganancias/ganancias_fecha/format/json/"; 
        return $this->principal->api( $api , $q );                
    }    

}