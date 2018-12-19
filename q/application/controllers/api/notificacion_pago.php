<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class notificacion_pago extends REST_Controller{  
  function __construct(){
      parent::__construct();                           
      $this->load->model("notificacion_pago_model");                                    
      $this->load->library(lib_def());               
  }
  /*
  function resumen_GET(){

    $param    = $this->get();
    $response = false;
    if(if_ext($param , "id_notificacion_pago")){
        $response = $this->notificacion_pago_model->get_notificacion_pago($param);
    }
    $this->response($response);
  }
  function es_notificado_GET(){

    $param      = $this->get();
    $response   = false;
    if(if_ext($param , "recibo")) {
        $response = $this->notificacion_pago_model->verifica_pago_notificado($param);
    }
    $this->response($response);

  }
  function pago_resumen_GET(){

    $param    = $this->get();
    $response = false;
    if(if_ext($param , "id_notificacion_pago")) {
        $response = $this->notificacion_pago_model->get_notificacion_pago_resumen($param);
    }
    $this->response($response);

  }
  */
  function notifica_pago_usuario_POST(){
      $param    =  $this->post();
      $response =  false;
      if (if_ext($param,"nombre,correo,dominio,servicio,fecha,cantidad,forma_pago,referencia,comentarios,num_recibo")){
          $params =  [
              "nombre_persona"      => $param["nombre"],
              "correo"              => $param["correo"],
              "dominio"             => $param["dominio"],
              "id_servicio"         => $param["servicio"],
              "fecha_pago"          => $param["fecha"],
              "cantidad"            => $param["cantidad"],
              "id_forma_pago"       => $param["forma_pago"],
              "referencia"          => $param["referencia"],
              "comentario"          => $param["comentarios"],
              "num_recibo"          => $param["num_recibo"]
          ];
          $response =  $this->notificacion_pago_model->insert($params , 1);
      }
      $this->response($response);
  }  
  function notificacion_pago_PUT(){
        
        $param      =   $this->put();
        $response   =   false;
        if (if_ext($param,"estado,id_notificacion_pago")){
            $response   = $this->notificacion_pago_model->q_up("status", $param["estado"], $param["id_notificacion_pago"]);
        }
        $this->response($response);    
    }
}