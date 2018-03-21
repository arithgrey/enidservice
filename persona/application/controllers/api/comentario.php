<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Comentario extends REST_Controller{      
    function __construct(){        
        parent::__construct();                          
        $this->load->model("comentariosmodel");   
        $this->load->library('sessionclass');      
    }
    /**/
    function comentario_persona_usuario_POST(){
    	   
        $param =  $this->post();
        $db_response  =  $this->comentariosmodel->insert_comentario($param);
        $this->response($db_response);

    }
    /**/     
}?>