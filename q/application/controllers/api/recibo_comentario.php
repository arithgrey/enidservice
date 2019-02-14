<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Recibo_comentario extends REST_Controller{
    public $option;
    function __construct(){
        parent::__construct();
        $this->load->model("recibo_comentario_model");
        $this->load->library(lib_def());
    }
    function index_POST(){

        $param      =   $this->post();
        $response   =   false;
        if(if_ext($param , "id_recibo,comentarios")){

            $params     =  ["id_recibo" => $param["id_recibo"] , "comentario" => $param["comentarios"]];
            $response   =  $this->recibo_comentario_model->insert($params , 1);
        }
        $this->response($response);
    }
    function index_GET(){

        $param      =  $this->get();
        $response   =  false;
        if(if_ext($param , "id_recibo")){
            $response  = $this->recibo_comentario_model->get([], ["id_recibo" => $param["id_recibo"]] , 10 , "fecha_registro");
        }
        $this->response($response);
    }

}