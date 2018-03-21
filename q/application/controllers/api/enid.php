<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Enid extends REST_Controller{      
    function __construct(){
        parent::__construct();                  
        $this->load->helper("enid");
        $this->load->helper("indicadores");
        $this->load->model("actividad_web_model");
        $this->load->library('sessionclass');                    
    }
    /**/
    function bugs_GET(){

        $param =  $this->get();
        $data["resumen_bugs"]=  $this->enidmodel->get_bugs($param);
        $this->load->view("enid/bugs_enid", $data);        
    }
    /**/
    function bug_PUT(){
        $param =  $this->put();
        $db_response =  $this->enidmodel->update_inicidencia($param);
        $this->response($db_response);
        
    }    
    /**/
    function dispositivos_dia_GET(){
        
        $data["dispositivos"] =   $this->enidmodel->get_dispositivos_dia();
        $this->load->view("enid/market/dispositivos_visitados" ,  $data);
    }
    /**/
    function sitios_dia_GET(){
        
        $data["sitios_visitados"] =   $this->enidmodel->get_sitios_dia();
        $this->load->view("enid/market/sitios_visitados" ,  $data);
    }
    /**/
    function usabilidad_landing_pages_GET(){    

        if($this->input->is_ajax_request()){ 
            $param = $this->get();
            $data["info_sistema"] =  $this->actividad_web_model->get_comparativa_landing_page($param);
            $this->load->view("enid/uso_sistema" , $data );        
        }else{
            $this->response("Error");
        }
    
    }        
    /**/
    function metricas_cotizaciones_GET(){        

        if($this->input->is_ajax_request()){ 

            $param = $this->get();        
            $inicio =  $this->microtime_float();         
            $data =  $this->actividad_web_model->crea_reporte_enid_service($param);
            $fin  =  $this->microtime_float();         
            $db_response["envio_usuario"] = $param;
            $db_response["tiempo_empleado"] =($inicio - $fin); 
            $db_response["actividad_enid_service"] =$data["resumen"];        

            if ($param["vista"] == 1){
                /*Reporte 1 */
                $this->load->view("cotizador/principal", $db_response);    
            }else{
                /*Regresamos data para reporte agradable*/
                $this->response($data);
            }
        }else{
            $this->response("Error");
        }
    }
    /**/
    function microtime_float(){
        list($useg, $seg) = explode(" ", microtime());
        return ((float)$useg + (float)$seg);
    }
    /**/
    
    /**/ 
}?>