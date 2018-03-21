<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Base extends REST_Controller{
  function __construct(){
        parent::__construct();                                     
        $this->load->library('sessionclass');      
  }  
  /**/
  function prospecto_POST()
  {
  	
    $this->val_session();
    $param =  $this->post();
    $param["id_usuario"] =  $this->sessionclass->getidusuario();
  	$db_response = $this->enidmodel->registra_prospecto($param);
    $this->response($db_response);
  }
  /**/
  function prospecto_PUT()
  {
    
    $this->val_session();
    $param =  $this->put();    
    $db_response = $this->enidmodel->actualiza_contacto($param);
    $this->response($db_response);
  }
  /**/
  function prospecto_GET()
  {
    $this->val_session();
    $param = $this->get();
    $param["id_usuario"] =  $this->sessionclass->getidusuario();
    $data["info_mail"]=  $this->enidmodel->get_registros_email($param);
    $this->load->view("secciones/reporte_mail_registrados" , $data);
  }
  /**/
  function prospectos_GET(){
    
    $this->val_session();
    $param = $this->get();
    $data["info_registros"] =  $this->enidmodel->get_registros_disponibles($param);
    $this->load->view("prospectos/contactos_disponibles" , $data);
    
  }
  /**/
  function registros_GET()
  {
    $param = $this->get();
    $data["info_mail"]=  $this->enidmodel->get_registros($param);
    $this->load->view("secciones/lista" , $data);
  }
  /**/
  function enviados_GET()
  {
    $param = $this->get();
    $data["info_mail"]=  $this->enidmodel->get_enviados($param);
    $this->load->view("secciones/lista" , $data);
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