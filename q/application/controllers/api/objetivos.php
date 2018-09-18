<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class objetivos extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct();                                      
        $this->load->helper("q");                                     
       	$this->load->model("objetivos_model");
        $this->load->library(lib_def());     
        $this->id_usuario= $this->principal->get_session("idusuario");
    }
	/**/
    function usuario_GET(){        
        $param = $this->get();
        $param["id_usuario"] =  $this->id_usuario;
        $data["metas"] = $this->productividad_model->metas_usuario($param);
        $this->load->view("productividad/metas" , $data );
    }
    /**/
    function presentaciones_GET(){

        $param =  $this->get(); 
        $data["info_presentaciones"] =  $this->productividad_model->get_presentaciones($param);
        $this->load->view("presentaciones/principal" , $data );                
    }
    /**/
    function meta_POST(){

        $param =  $this->post(); 
        $response = $this->productividad_model->insert_metas($param);
        $this->response($response);        
    }
    /**/
    function ingresos_GET(){

        $param = $this->get();
        $param["id_usuario"] =  $this->id_usuario;
        $data["metas"] = $this->productividad_model->relacion_ingresos($param);
        $this->load->view("productividad/ingresos" , $data );
    }
    function perfil_GET(){
        $param      = $this->get();        
        $response   = 
        $this->objetivos_model->get(
            "objetivo", 
            [] , 
            ["id_perfil" => $param["id_perfil"]
            ] , 
            100);
        $this->response($response);
    }

    /**/
}?>
