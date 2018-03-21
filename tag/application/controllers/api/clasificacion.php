<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class clasificacion extends REST_Controller{      
    function __construct(){
        parent::__construct();                                      
        $this->load->model("clasificacion_model");
        $this->load->helper("enid");        
    }   
    /**/
    function clasificaciones_por_servicio_GET(){
        
        $param =  $this->get();
        $clasificacion =  $this->clasificacion_model->get_clasificaciones_por_id($param);
        $this->response($clasificacion);        
    }
    /**/
    function primer_nivel_GET(){

        $param =  $this->get();
        $primer_nivel =  $this->clasificacion_model->get_clasificaciones_primer_nivel($param);        
        $data["clasificaciones"] 
        = $this->clasificacion_model->get_clasificaciones_segundo($primer_nivel);        
        $this->load->view("clasificaciones/menu" , $data);
    }
    /**/
    function nombre_GET(){
        
        $param =  $this->get();
        $nombre_clasificacion =  
        $this->clasificacion_model->get_nombre_clasificacion_por_id_clasificacion($param);
        $this->response($nombre_clasificacion);
    }
    /**/
    function info_clasificacion_GET(){

        $param = $this->get();        
        $info_clasificacion =  
        $this->clasificacion_model->get_clasificaciones_por_id_clasificacion($param);
        $this->response($info_clasificacion);
    }
    /**/
    
    /**/
}?>
