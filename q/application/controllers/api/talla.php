<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Talla extends REST_Controller{
  function __construct(){
        parent::__construct();           
        $this->load->model("talla_model"); 
        $this->load->library(lib_def());       
  }  
  /**/
  function id_GET(){    
    $param        =   $this->get();
    //debug($param , 1);
    $params       =   $param["fields"];
    $id_talla     =   $param["id"];
    $response     =   $this->talla_model->q_get($params , $id_talla);  
    $this->response($response);
    
  }    
  function tipo_talla_id_GET(){

    $param        =   $this->get();
    $response     =   $this->talla_model->get_tipo_talla($param);
    $this->response($response);

  }
  function clasificacion_PUT(){

    $param        =   $this->put();
    $response     =   $this->talla_model->update_talla_clasificacion($param);
    $this->response($response);

  }
  /**/
  function clasificacion_GET(){

    $param        =   $this->put();
    $response     =   $this->talla_model->get_tallas_clasificacion($param);
    $this->response($response);
  }
  function tallas_countries_GET(){
    
    $param        =   $this->get();    
    $response     =   $this->talla_model->get_tallas_countries($param);
    $this->response($response);
  }

}
?>