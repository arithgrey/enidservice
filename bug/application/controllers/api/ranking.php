<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Ranking extends REST_Controller{
  function __construct(){
        parent::__construct();                              
        $this->load->model("rankingmodel");
        $this->load->library('sessionclass');      
  }  
  /**/
  function comentarios_calificacion_GET(){

    $param = $this->get();
    $param["id_empresa"] =  $this->sessionclass->getidempresa();
    $param["id_usuario"] =  $this->sessionclass->getidusuario();
    
    $data["info_comentarios"] =  $this->rankingmodel->get_comentarios_calificacion($param);
    $this->load->view("ranking/comentarios" ,  $data);
  }
  /**/
  function general_GET(){

    $this->validate_user_sesssion();
    
    $param =  $this->get();    
    $param["id_empresa"] =  $this->sessionclass->getidempresa();
    $param["id_usuario"] =  $this->sessionclass->getidusuario();
    
    $data["info_estrellas"]=   $this->rankingmodel->get_info_general($param);



    $this->load->view("ranking/info_general_calificaciones" , $data);
    
  }
  function validate_user_sesssion(){
      if( $this->sessionclass->is_logged_in() == 1) {                        

            }else{
              /*Terminamos la session*/
              $this->sessionclass->logout();
          }   
  }/*termina validar session */

  
}
?>