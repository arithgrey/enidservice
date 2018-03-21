<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Posiblesclientes extends REST_Controller{      
    function __construct(){        
        parent::__construct(); 
        $this->load->model("posiblesclientesmodel");                                 
        $this->load->helper("persona");
        $this->load->library('sessionclass');      
    }
    /**/
    function usuario_campo_GET(){

        $param =  $this->get();
        $data =  $this->posiblesclientesmodel->get_posibles_clientes_usuario_campo($param);
        $data["info_recibida"] = $param;
        

        $resultados =  count($data["info"]);
        if ($resultados>0) {
            $this->load->view("clientes/resumen", $data);   
        }else{
            $this->response("<center><span class='strong blue_enid_background white'> 0 Resultados encontrados</span></center>");
        }
    }
    /**/     
     function tipificacion_GET(){

        $param =  $this->get();
        
        $data = $this->posiblesclientesmodel->get_posibles_clientes_tipificacion($param);
        $data["info"] = $data["info"];

        
        if ($param["tipificacion"] ==  1) {

            $this->load->view("clientes/resumen", $data);         
        }else{
            $this->load->view("clientes/resumen_clientes", $data);         
        }
        
    }
}?>