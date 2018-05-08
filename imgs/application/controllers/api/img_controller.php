<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Img_controller extends REST_Controller{
  function __construct(){
        parent::__construct();        
        $this->load->model("img_model");              
        $this->load->library('sessionclass');            
  }  
  /**/
  function get_imgs_servicio($param){

    $param =  $this->get();   
    $imgs =  $this->img_model->get_imagenes_por_servicio($param);
    $this->response($imgs);
  }
  /**/
  function form_faq_GET(){            
    
    $data["id_faq"] =  $this->get("id_faq");
    $this->load->view("imgs/faq" ,  $data);    
  } 
  /**/
  function form_img_user_GET(){

    $param =  $this->get();
    $param["id_usuario"] = $this->sessionclass->getidusuario();   
    $this->load->view("imgs/usuario" ,  $param);       
    
  }  
  /**/
  function form_img_servicio_producto_GET(){
    /**/
    $param =  $this->get();
    
    $param["q"] =  "servicio";
    $param["q2"] = "servicio";
    $param["q3"] = $param["servicio"];

    $this->load->view("imgs/servicio_producto_servicio" ,  $param);       
    
  }  
  /**/
  function imagen_servicio_DELETE(){

    $param =  $this->delete();    
    $db_response =  $this->img_model->delete_imagen_servicio($param);
    $this->response($db_response);
    
  }
  
  /**/  
}