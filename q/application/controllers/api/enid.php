<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Enid extends REST_Controller{      
    function __construct(){
        parent::__construct();              
        $this->load->helper("q");            
        $this->load->model("actividad_web_model");
        $this->load->library(lib_def());                    
    }
    function bugs_GET(){

        $param =  $this->get();
        $data["resumen_bugs"]=  $this->enidmodel->get_bugs($param);
        $this->load->view("enid/bugs_enid", $data);        
    }
    function bug_PUT(){
        $param =  $this->put();
        $response =  $this->enidmodel->update_inicidencia($param);
        $this->response($response);
        
    }
    function usabilidad_landing_pages_GET(){    

        if($this->input->is_ajax_request()){ 
            $param = $this->get();
            $data["info_sistema"] =  $this->actividad_web_model->get_comparativa_landing_page($param);
            $this->load->view("enid/uso_sistema" , $data );        
        }else{
            $this->response("Error");
        }    
    }        
    
    function metricas_cotizaciones_GET(){        

        $param      =   $this->get();
        $response   =   false;
        $inicio     =   microtime_float();
        $data       =   $this->actividad_web_model->crea_reporte_enid_service($param);
        $fin        =   microtime_float();

        $response["envio_usuario"]          =   $param;
        $response["tiempo_empleado"]        =   ($inicio - $fin);
        $response["actividad_enid_service"] =   $data["resumen"];

        if ($param["vista"] == 1){
            $this->load->view("cotizador/principal", $response);
        }else{
            $this->response($data);
        }
    }
    /*
    function dispositivos_dia_GET(){

        $data["dispositivos"] =   $this->enidmodel->get_dispositivos_dia();
        $this->load->view("enid/market/dispositivos_visitados" ,  $data);
    }
    */
    /*
    function sitios_dia_GET(){

        $data["sitios_visitados"] =   $this->enidmodel->get_sitios_dia();
        $this->load->view("enid/market/sitios_visitados" ,  $data);
    }
    */

}