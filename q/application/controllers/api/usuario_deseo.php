<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class usuario_deseo extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct();                  
        $this->load->model("usuario_deseo_model");        
        $this->load->library(lib_def());   
        $this->id_usuario   =  $this->principal->get_session("idusuario");                   
    }
    function num_deseo_servicio_usuario_GET($param){

        $param      =  $this->get();
        $response   =  $this->usuario_deseo_model->get_num_deseo_servicio_usuario($param);
        $this->response($response);
    }
    function add_lista_deseos_PUT(){

        $param      =   $this->put();        
        $response   =  $this->procesa_deseo($param);
        $this->response($response);
    }    
    function procesa_deseo($param){
        
        $response   =   0;
        if ($this->usuario_deseo_model->get_num_deseo_servicio_usuario($param) == 0 ) {            

            $params = [
                "id_usuario"    => $param["id_usuario"],
                "id_servicio"   => $param["id_servicio"]
            ];
            $response =  $this->usuario_deseo_model->insert($params);

            
        }else{
            $response = $this->usuario_deseo_model->aumenta_deseo($param);
        }        
        return $response;
    }
    function agregan_lista_deseos_periodo_GET(){

        $param      =   $this->get();
        $response   =   $this->usuario_deseo_model->agregan_lista_deseos_periodo($param);
        $this->response($response);        
    }
    function lista_deseos_PUT(){
        
        $param               =  $this->put();
        $param["id_usuario"] =  $this->id_usuario;              
        $this->procesa_deseo($param);
        $this->agrega_interes_usuario($param);
        $this->gamificacion_deseo($param);
        $this->response(true);        
    }
    function usuario_GET(){    
        
        $param      =   $this->get();
        $response   =   $this->usuario_deseo_model->get_por_usuario($param);
        $this->response($response);
    }
    /*
    function add_lista_deseos($q){        
        $api    =  "usuario_deseo/add_lista_deseos/format/json/";
        return $this->principal->api( $api , $q , "json" , "PUT");
    }
    */
    function agrega_interes_usuario($q){

        $api    =  "usuario_clasificacion/interes";
        return $this->principal->api( $api , $q , "json" , "POST");
    }
    function gamificacion_deseo($q){
        $api  =  "servicio/gamificacion_deseo";
        return  $this->principal->api(  $api , $q, "json" , "PUT");  
    }

}?>