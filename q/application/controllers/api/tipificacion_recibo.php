<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class tipificacion_recibo extends REST_Controller{          
    function __construct(){
        parent::__construct();                                          
        $this->load->model("tipificacion_recibo_model");
        $this->load->library(lib_def());     
    }
    function index_POST(){
        
        $param      =  $this->post();
        $response   =  false;
        if (if_ext($param ,  "recibo,tipificacion")) {
            
            /*paso a 0 las tipificaciones previas*/    
            $id_recibo  =  $param["recibo"];
            if ($this->set_null($id_recibo) == true) {
                
                $params = [
                    "id_recibo"         => $id_recibo , 
                    "id_tipificacion"   => $param["tipificacion"]
                ];
                $response   = $this->tipificacion_recibo_model->insert($params);
            }
        }
        $this->response($response);

    }
    private function set_null($id_recibo){

        return $this->tipificacion_recibo_model->update(
            ["status"       => 0] ,
            ["id_recibo"    => $id_recibo ] ,
            1000 );
    }    
    function recibo_GET(){

        $param      =   $this->get();
        $response   =   false;
        if(if_ext($param , "recibo")){
            
            $response = $this->tipificacion_recibo_model->get_recibo($param);
        }
        $this->response($response);
    }
}