<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class clasificacion extends REST_Controller{      
    function __construct(){
        parent::__construct();                                      
        $this->load->model("clasificacion_model");
        $this->load->helper("enid");        
        $this->load->library("sessionclass");
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
    function interes_usuario_GET($param){
        
        $param      =  $this->get();
        $response   =  $this->clasificacion_model->get_intereses_usuario($param);
        $this->response($response);
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
    function categorias_destacadas_GET(){
        
        $param = $this->get();
        $data_complete["clasificaciones"]=$this->clasificacion_model->get_clasificaciones_destacadas($param);
        $data_complete["nombres_primer_nivel"] =
        $this->clasificacion_model->get_clasificaciones_primer_nivel_nombres($param);
        
        $this->response($data_complete);
    }    
    /**/
    function interes_PUT(){

        $param=  $this->put();         
        $param["id_usuario"] =  $this->sessionclass->getidusuario();
        $response =  $this->clasificacion_model->interes_usuario($param);        
        $this->response($response);        
    }
}?>
