<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Ventas_tel extends REST_Controller{
  function __construct(){
        parent::__construct();                                     
        $this->load->model("ventastelmodel");
        $this->load->model("agendadosmodel");
        $this->load->helper("ventastel");
        $this->load->library('sessionclass');      
  }  
  /**/
  function num_pagos_notificados_GET(){
    
    $param = $this->get();
    $db_response =  $this->agendadosmodel->get_num_clientes_notificacion_pago($param);
    
    if ($db_response > 0 ) {
      
      $new_response =
      "<span class='alerta_llamadas_agendadas fa fa-plus-circle' >".  $db_response ."</span>";
    }
    $this->response($new_response);

  }
  /**/
  function llamar_despues_GET(){
      $param =  $this->get();
      $data["llamar_despues"] =  $this->agendadosmodel->get_llamar_despues($param);
      $this->load->view("agendados/llamar_despues" , $data);
  }
  /**/
  function marca_llamada_hecha_posterior_comentario_PUT(){

    $param =  $this->PUT();
    $db_response =  $this->agendadosmodel->limpia_registro_llamada_posterior_a_comentario($param);
    $this->response($db_response);
  }
  /**/
  function num_clientes_restantes_GET(){
    
    /**/
    $param = $this->get();
    $db_response =  $this->agendadosmodel->get_num_clientes_restantes($param);
    
    $notificacion = 3 - $db_response;

    $new_response ="";

    if ($notificacion > 0 ) {
      
      $new_response =
      "<span class='alerta_red_notificacion fa fa-minus-circle' >".  $notificacion ."</span>";        
    }elseif ($notificacion == 0) {
    
     $new_response ="";      
    }else{

      $new_response =
      "<span class='alerta_llamadas_agendadas fa fa-plus-circle' >".  abs($notificacion) ."</span>";
    }

    
    $this->response($new_response);
  }
  /**/
  function num_agendados_validacion_GET(){

    $param = $this->get();
    $db_response =  $this->agendadosmodel->get_num_agendados_validacion($param);

    $new_response ="";
    if ($db_response  > 0 ) {
      $new_response ="<span class='alerta_llamadas_agendadas fa fa-star' >".$db_response."</span>";  
    }
    
    $this->response($new_response);
  }
  /**/
  function num_agendados_GET(){

    $param = $this->get();    
    $db_response =  $this->agendadosmodel->get_num_agendados($param);

    $new_response ="";
    if ($db_response  > 0 ) {
        $new_response ="<span class='alerta_llamadas_agendadas fa fa-phone' >".$db_response."</span>";  
    }
    
    /**/
    $tareas_pendientes =  $this->agendadosmodel->get_num_tareas_pendientes_area($param);
    $new_tareas_pendientes ="";
    if ($tareas_pendientes  > 0 ) {
        $new_tareas_pendientes ="<span class='alerta_tareas_pendientes fa fa-check-circle' >".$tareas_pendientes."</span>";  
    }
    /****/
    $data["num_agendados_posibles_clientes"] = $new_response;            
    $data["num_tareas_pendientes"] = $new_tareas_pendientes;            
    $this->response($data);
    
  }
  /**/
  function num_agendados_email_GET(){

  
    $param = $this->get();
    $db_response =  $this->agendadosmodel->get_num_agendados_email($param);

    $new_response ="";
    if ($db_response  > 0 ) {
      $new_response ="<span class='alerta_llamadas_agendadas fa fa-envelope-o'>".$db_response."</span>";  
    }
    
    $this->response($new_response); 
  
  }
  /**/
  function prospecto_GET(){

    $param =  $this->get();
    $data["id_usuario"] =  $param["id_usuario"];    
    $data["data_tel"] =  $this->ventastelmodel->get_prospecto($param);
    $num_contactos  =  count($data["data_tel"]["tel"]);  

    if ($num_contactos > 0 ){
      $this->load->view("ventas_telefonicas/ficha", $data);      
    }else{
      $this->response(0);
    }
  }
  /**/
  function prospecto_PUT(){

    $param =  $this->put();
    $db_response =  $this->ventastelmodel->update_prospecto($param);
    $this->response($db_response);
  }  
  function agendados_GET(){
    
    $param =  $this->get();
    $data =  $this->agendadosmodel->get_agendados($param);
    $this->load->view("agendados/principal", $data);
  }  
  /**/
  function agendadosemail_GET(){

    $param =  $this->get();
    $data["info_agendados"] =  $this->agendadosmodel->get_correos_agendados($param);
    $this->load->view("agendados/principalemail", $data);
  }  

  /**/
  function agendados_llamada_hecha_PUT(){
    $param =  $this->put();
    $db_response =  $this->agendadosmodel->actualiza_llamada($param);  
    $this->response($db_response);  
  }
  /**/
  
  function agendados_correo_hecho_PUT(){

    $param =  $this->put();
    $db_response =  $this->agendadosmodel->actualiza_correo_envio($param);  
    $this->response($db_response);  
  }
  /**/

}
?>