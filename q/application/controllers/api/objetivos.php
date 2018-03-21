<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class objetivos extends REST_Controller{      
    function __construct(){
        parent::__construct();                                      
        $this->load->helper("enid");
       	$this->load->model("productividad_model");
        $this->load->library('sessionclass');
    }
	/**/
    function usuario_GET(){        
        $param = $this->get();
        $param["id_usuario"] =  $this->sessionclass->getidusuario();
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
        $db_response = $this->productividad_model->insert_metas($param);
        $this->response($db_response);        
    }
    /**/
    function ingresos_GET(){


        $param = $this->get();
        $param["id_usuario"] =  $this->sessionclass->getidusuario();
        $data["metas"] = $this->productividad_model->relacion_ingresos($param);
        $this->load->view("productividad/ingresos" , $data );
    }

    /**/
}?>
