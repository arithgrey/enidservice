<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Ventas extends REST_Controller{
  function __construct(){
        parent::__construct();                                     
        $this->load->model("ventasmodel");
        $this->load->library('sessionclass');      
  }  
  /**/
  function prospecto_POST(){
    
    /********/
    $param =  $this->post();        
    $param["id_usuario"] =  $this->sessionclass->getidusuario();
    $num_usuario = $this->ventasmodel->verifica_existencia_usuario($param);    
    
    $data_complete["num_usuario"] =  $num_usuario;
    if($num_usuario == 0 ){
      $data_complete["id_persona"] = $this->ventasmodel->insert_prospecto($param);  
    }
    $this->response($data_complete);    
    
  }

  /**/
  function prospecto_get(){

    $param =  $this->get();    
    $param["id_usuario"] =  $this->sessionclass->getidusuario();

    $db_response["id_usuario"] =  $this->sessionclass->getidusuario();
    $db_response["data_prospectos"] =  $this->ventasmodel->get_prospecto($param);    
    $db_response["data_tipo_propuesta"] =  $this->ventasmodel->get_tipo_propuesta();    
    $db_response["data_servicios"] =  $this->ventasmodel->get_servicios();    

    $this->load->view("ventas/prospectos_disponibles" , $db_response );

  }
  /**/
  function propuesta_POST(){

    $param = $this->post();        
    $param["id_usuario"] = $this->sessionclass->getidusuario();    
    $db_response=  $this->ventasmodel->insert_propuesta($param);
    $this->response($db_response);
  
  }
  /**/
  function labor_venta_get(){

    $param =  $this->get();    
    $param["id_usuario"] =  $this->sessionclass->getidusuario();
    $db_response["labor_venta"] =  $this->ventasmodel->get_labor_venta($param);    
    $this->load->view("ventas/principal" , $db_response);    

  }
  /**/
}
?>