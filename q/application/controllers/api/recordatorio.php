<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class recordatorio extends REST_Controller{
    private $id_usuario;
    function __construct(){
        parent::__construct();
        $this->load->model("recordatorio_model");
        $this->load->library(lib_def());
    }
    function index_GET()
    {
        $response   = false;
        $param      =  $this->get();
        if(if_ext($param ,  "id_recibo")){
            $response   =  $this->recordatorio_model->get_complete($param["id_recibo"]);
        }
        $this->response($response);
    }
    function index_POST()
    {
        $response   =   false;
        $param      =   $this->post();
        if(if_ext($param ,  "fecha_cordatorio,horario_entrega,recibo,tipo,descripcion")){

            $fecha                  =   $param["fecha_cordatorio"]." ".$param["horario_entrega"].":00";
            $id_recibo              =   $param["recibo"];
            $tipo                   =   $param["tipo"];
            $descripcion            =   $param["descripcion"];

            $params =  [

                "fecha_cordatorio"  =>  $fecha,
                "id_recibo"         =>  $id_recibo,
                "id_tipo"           =>  $tipo,
                "descripcion"       =>  $descripcion

            ];
            $response=  $this->recordatorio_model->insert($params);
        }
        $this->response($response);
    }
    function status_PUT()
    {
        $response   =  false;
        $param      =  $this->put();
        if(if_ext($param ,  "id_recordatorio,status")){

            $id                 =   $param["id_recordatorio"];
            $status             =   $param["status"];
            $response           =   $this->recordatorio_model-> q_up("status", $status, $id);
        }
        $this->response($response);
    }
}