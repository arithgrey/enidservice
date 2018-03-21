<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Mensaje extends REST_Controller{
  function __construct(){
        parent::__construct();                                     
        $this->load->model("mensajemodel");
        $this->load->library('sessionclass');      
  }  
  /**/
  function red_social_POST(){
    
    $param =  $this->post();
    $param["id_usuario"] =  $this->sessionclass->getidusuario();
    $db_response =  $this->mensajemodel->insert_mensaje_red_social($param);
    $this->response($db_response);  
  }
  
  function red_social_GET(){
    
    $param =  $this->get();
    $data["servicio"] = $param["servicio"];
    $data["red_social"] = $param["red_social"];

    $param["id_usuario"] =  $this->sessionclass->getidusuario();
    $data["id_usuario"] =  $this->sessionclass->getidusuario();
    $data["info_mensaje"] =  $this->mensajemodel->get_mensaje_red_social($param);

    $this->load->view("mensaje/principal",  $data);
  }
  /**/
  function val_session(){

      if( $this->sessionclass->is_logged_in() == 1){

      }else{
        redirect(base_url());
      }   
    }    
   
}
?>