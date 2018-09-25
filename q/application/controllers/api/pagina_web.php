<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Pagina_web extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct();                      
        $this->load->model("pagina_web_model");         
        $this->load->library(lib_def());                    
        $this->id_usuario = $this->principal->get_session("idusuario");
    } 
     

}?>