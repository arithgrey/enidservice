<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class usuario_clasificacion extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct();          
        $this->load->model("usuario_clasificacion_model");        
        $this->load->library(lib_def());                    
        $this->id_usuario = $this->principal->get_session("idusuario");
    }
    function agregan_clasificaciones_periodo_GET(){

        $param      =   $this->get();
        $response   =   $this->usuario_clasificacion_model->agregan_clasificaciones_periodo($param);
        $this->response($response);        
    }
    function interes_PUT(){

        $param                  =   $this->put();         
        $id_usuario             =   $this->id_usuario;        
        $param["id_usuario"]    =   $id_usuario;
        $num                    =   $this->usuario_clasificacion_model->get_interes_usuario($param);        
        
        $response         = false;
        if ($id_usuario > 0 ) {

            $response["tipo"] =0;
            $params = [ 
                    "tipo"                =>    2,
                    "id_usuario"          =>    $id_usuario,
                    "id_clasificacion"    =>    $param["id_clasificacion"] ];      

            if ($num >0 ) {                  
                $this->usuario_clasificacion_model->delete($params);            
            }else{                    
                $this->usuario_clasificacion_model->insert($params);
                $response["tipo"] =1;
            }
        }
        $this->response($response);        
    }
    
    function interes_POST(){
        
        $param              =   $this->post();                
        $id_clasificacion   =   $this->get_clasificaciones_servicio($param)[0]["primer_nivel"];        
        $params             = [
            "id_usuario"        => $this->id_usuario,
            "id_clasificacion"  => $param["id_servicio"]
        ];    
        $num =  $this->usuario_clasificacion_model->get_num_usuario_clasificacion($this->id_usuario  , 
            $param["id_servicio"]);
        
        if ($num == 1 ){
            $this->response($this->usuario_clasificacion_model->insert("usuario_clasificacion" , $params));    
        }
        $this->response(true);
        
        
    } 
    /**/
    function get_clasificaciones_servicio($q){     
        
        $api =  "servicio/tallas/format/json/";
        return $this->principal->api( $api , $q);
    }   
    /**/ 

}?>