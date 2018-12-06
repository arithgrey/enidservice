<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class contacto extends REST_Controller{      
    function __construct(){
        parent::__construct();         
        $this->load->model("contactosmodel");
        $this->load->library(lib_def());                      
    }
    function index_POST(){        
        $param      =  $this->post();
        
        $params = [
            "nombre"              =>  $param["nombre"],
            "email"               =>  $param["email"],
            "mensaje"             =>  $param["mensaje"],
            "id_empresa"          =>  $param["empresa"],
            "id_tipo_contacto"    =>  $param["tipo"],
            "telefono"            =>  $param["tel"]
        ];
        $response   =  $this->contactosmodel->insert($params);  
        /*ahora creo ticket*/
        $this->abre_ticket($param);
        $this->response($response);
    }
    /**/
    function abre_ticket($param){

        $q["prioridad"]         =   1;
        $q["departamento"]      =   $param["departamento"];
        $q["asunto"]            =   "Solicitud  buzón de contacto";
        $q["id_proyecto"]       =   38;
        $q["id_usuario"]        =   180;                  
        $api                    =   "tickets/index";     
        
        return $this->principal->api(  $api , $q ,"json" ,"POST");
    }


}?>