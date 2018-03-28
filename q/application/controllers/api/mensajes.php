<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Mensajes extends REST_Controller{      
    function __construct(){
        parent::__construct();                  
        $this->load->helper("enid");
        $this->load->model("mensajesmodel");
        $this->load->library('sessionclass');                    
    }
    /**/
    function ranking_usuarios_mensajes_GET(){        
        
        $param = $this->get();
        $db_response  =  $this->mensajesmodel->get_mensajes_destacados($param);
        $data["info_mensajes"] =  $db_response;
        /**/
        $this->load->view("ranking/mensajes" , $data);
    }
    /**/
    function ranking_usuarios_blog_GET(){

        $param = $this->get();

        $url="http://".$_SERVER['HTTP_HOST'];
        $param["dominio"] =  $url;
        $db_response  =  $this->mensajesmodel->get_blogs_destacados($param);
        $data["info_mensajes"] =  $db_response;        
        $this->load->view("ranking/blog" , $data);
    }
    /**/
    function ranking_posts_GET(){

        $param = $this->get();

        $param["id_usuario"] = $this->sessionclass->getidusuario();
        $db_response =  $this->mensajesmodel->get_posts_usuario($param);
        $data["info_mensajes"] =  $db_response;
        /**/
        $this->load->view("ranking/mensajes" , $data);
    }
    /**/ 
    function info_servicio_GET(){        
        /**/
        $param =  $this->get();
        $info_servicio["info_servicio"] = $this->mensajesmodel->info_servicio($param);
        $info_servicio["modalidad"] =  $param["modalidad"];
        $this->load->view("servicio/principal" , $info_servicio);
    }
    /**/
    
    /**/

}?>