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
        $param["id_usuario"] = $this->sessionclass->getidusuario();        
        $this->response($param["id_usuario"]);

    }
    /**/
    function comentario_pedido_POST(){            
        $param =  $this->post();
        $db_response =  $this->comentariosmodel->agrega_comentario_pedido($param);
        $this->response($db_response);
    }

    /**/     
}?>