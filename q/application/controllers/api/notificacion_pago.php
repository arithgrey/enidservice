<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class notificacion_pago extends REST_Controller{  
  function __construct(){
      parent::__construct();                           
      $this->load->model("notificacion_pago_model");                                    
      $this->load->library(lib_def());               
  } 
  function resumen_GET(){

    $param    = $this->get();
    $response = $this->notificacion_pago_model->get_notificacion_pago($param);
    $this->response($response);
  }
  function es_notificado_GET(){
    $param    = $this->get();
    $response = $this->notificacion_pago_model->verifica_pago_notificado($param);
    $this->response($response); 
  }

  function pago_resumen_GET($param){
    $param    = $this->get();
    $response = $this->notificacion_pago_model->get_notificacion_pago_resumen($param);
    $this->response($response);  
  }
  function notifica_pago_usuario_POST(){
        $param =  $this->post();                
        $data["estado_registro"] =  $this->notificacion_pago_model->registra_pago_usuario($param);
        $this->response($data["estado_registro"]);
        /**/
  }  
  function notificacion_pago_PUT(){
        
        $param = $this->put();                
        $response = $this->notificacion_pago_model->actualiza_pago_notificado($param);       
        $this->response($response);    
    }
}
?>