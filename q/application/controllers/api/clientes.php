<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class clientes extends REST_Controller{      
    function __construct(){
        parent::__construct();                                              

        $this->load->model("posiblesclientesmodel");
        $this->load->helper("persona");
        $this->load->library('sessionclass');

    }
    /**/
    function posibles_clientes_GET(){

        $param =  $this->get();
        $data =  $this->posiblesclientesmodel->get_posibles_clientes($param);
        $this->load->view("clientes/resumen", $data);        
    }
	/**/
    function persona_GET(){
        $param =  $this->get();
        $data["info"] =  $this->posiblesclientesmodel->get_info_persona($param);
        $data["info_comentarios"] =  $this->posiblesclientesmodel->get_comentarios_persona($param);
        $this->load->view("persona/info", $data);   
    }
    /**/
    function info_pago_GET(){
        /**/        
        
        $param["id_usuario"] = $this->sessionclass->getidusuario();
        $data_complete  =  $this->posiblesclientesmodel->get_info_usuario($param);
        $this->response($data_complete);
    }
    /**/    
}?>
