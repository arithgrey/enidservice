<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Privacidad extends REST_Controller{
  private $id_usuario;
  function __construct(){
        parent::__construct();                                             
        $this->load->model("privacidad_model");
        $this->load->library(lib_def());  
        $this->id_usuario   =  $this->principal->get_session("idusuario");                   
  }  
  /**/
  function conceptos_por_funcionalidad_usuario_GET()
  {
    
    $param    =  $this->get();
    $response =  
    $this->privacidad_model->get_conceptos_por_funcionalidad_usuario($param["id_funcionalidad"] , 
      $param["id_usuario"]);
    
    $this->response($response);
  }
  /*
  function conceptos_GET(){
    $param                =  $this->get();
    $param["id_usuario"]  =  $this->id_usuario;  
    $data["conceptos"]    = $this->get_conceptos_usuario($param);
    $this->load->view("privacidad/conceptos" , $data);
  }  
  function get_conceptos_usuario($param){

         
        return $this->add_conceptos($funcionalidades , $id_usuario);
    }
  */

}
?>