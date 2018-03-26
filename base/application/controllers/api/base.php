<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Base extends REST_Controller{
  function __construct(){
        parent::__construct();                                     
        $this->load->library('sessionclass');      
  }  
  /**/
  function lectura_email_GET(){

    $param = $this->get();
    $db_response=  $this->enidmodel->registra_lectura_email($param);
    $this->response($db_response);
  }
  /**/
  function prospecto_POST(){
    
    $this->val_session();
    $param =  $this->post();
    
    $email =  filtar_correos($param);
    $data["palabras"]=  $email;
    $param["lista_correos"] = $data["palabras"];      
    $db_response = $this->enidmodel->registra_prospecto($param);
    $this->response($db_response);    
    /**/        
  }
  /**/
  function prospectos_PUT(){
    
    /***/
    $this->val_session();    
    $param =  $this->put();
    $param["id_usuario"] = $this->sessionclass->getidusuario();
    $email =  filtar_correos($param);
    $data["palabras"]=  $email;
    $param["lista_correos"] = $data["palabras"];         
    /**/ 
    $db_response = $this->enidmodel->actualiza_contactos($param);
    $this->response($db_response);
  }
  /**/  
  function prospecto_PUT(){      
      $this->val_session();

      $param =  $this->put();    
      $param["id_usuario"] = $this->sessionclass->getidusuario();
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
    $param["id_usuario"] =  $this->sessionclass->getidusuario();
    /**/
    $num_correos_dia=  $this->enidmodel->get_num_correos_por_usuario_dia($param);
    
    if($num_correos_dia < 2500 ){

      $data["info_registros"] =  $this->enidmodel->get_registros_disponibles($param);
      $this->load->view("prospectos/contactos_disponibles" , $data);  
    }else{
      $this->response("<strong> Listo cumpliste tu meta del día!</strong>");
    }
    
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