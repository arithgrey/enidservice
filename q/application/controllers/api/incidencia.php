<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class incidencia extends REST_Controller{      
    function __construct(){
        parent::__construct();         
        $this->load->model("incidencia_model");
        $this->load->library(lib_def());                      
    }
    function reporte_sistema_POST(){

        $param        =   $this->post();
        $descripcion  =  (array_key_exists("descripcion", $param )) ? $param["descripcion"]:"Error desde js";
        $params = [
            "descripcion_incidencia"  => $descripcion,
            "idtipo_incidencia"       =>  4 ,
            "idcalificacion"          =>  1,
            "id_user"                 =>  1,
        ];
        $response  =  $this->incidencia_model->insert($params, 1);
        $this->response($response);
    }
  
}