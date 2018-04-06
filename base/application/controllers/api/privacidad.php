<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Privacidad extends REST_Controller{
  function __construct(){
        parent::__construct();                                             
        $this->load->model("privacidad_model");
        $this->load->library('sessionclass');      
  }  
  /**/
  function concepto_PUT(){
    /**/
    $param =  $this->put();    
    $param["id_usuario"] =  $this->sessionclass->getidusuario();
    $registro = $this->privacidad_model->asociar_concepto_privacidad_usuario($param);
    $this->response($registro);

  }
  function conceptos_GET(){
    /**/
    $param =  $this->get();
    $param["id_usuario"] =  $this->sessionclass->getidusuario();
    
    $data["conceptos"] = $this->privacidad_model->get_conceptos_usuario($param);
    $this->load->view("privacidad/conceptos" , $data);
  }
  /**/

}
?>