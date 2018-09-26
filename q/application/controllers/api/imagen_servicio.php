<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Imagen_servicio extends REST_Controller{
  function __construct(){
      parent::__construct();        
      $this->load->model("imagen_servicio_model");              
      $this->load->library(lib_def());              
  }     
  function servicio_GET(){

      $param      =  $this->get();
      $response   =  $this->imagen_servicio_model->get_img_servicio($param["id_servicio"]);
      $this->response($response);   
  }
  function index_POST(){              
    
    $param    =  $this->post();          
    $response = 2;
    if (if_ext($param , "id_imagen,id_servicio" )) {
      $params = [ 
          "id_imagen"   =>  $param["id_imagen"] ,
          "id_servicio" =>  $param["id_servicio"]
      ];
      $response         =  $this->imagen_servicio_model->insert($params);          
    }
    $this->response($response);

  }
  function index_DELETE(){
    
    $param    =   $this->delete();    
    $response =   [];
    if ( if_ext($param , 'id_imagen') ){

        $q      = [ "id_imagen" => $param["id_imagen"] ];
        $status = $this->imagen_servicio_model->delete($q, 20);  

        if ($status) {

            $response["status_imagen_servicio"] = 1;
            $response["status_img"]   =  $this->delete_imagen($param);        
            $response["evento"]       =  $this->valida_existencia_servicio($param);
        }        
    }    

    $this->response($response);   
  }
  /**/
  private function delete_imagen($q){
    $api =  "img/index";
    return $this->principal->api($api , $q , "json" , "DELETE");
  }
  private function valida_existencia_servicio($q){

    /*Ahora valido que el servicio no se quede sin imagenes, de ser así pasar a 0 el status del servicio*/    
    $response  = [];
    if(if_ext($q , "id_servicio")){

      $response["num_imagenes"]=  $this->imagen_servicio_model->get_num_servicio($q["id_servicio"]); 
      if ($response["num_imagenes"] == 0  ) {
          /*Notifico en servicio que no cuenta con la imagen*/
          $response["notificacion_existencia"] =  $this->notifica_existencia_servicio($q);   
      }      
    }
    return $response;
  }
  private function notifica_existencia_servicio($q){

    $api      =  "servicio/status_imagen";
    $q["existencia"]  = 0;
    return    $this->principal->api($api , $q , "json" , "PUT");
  }  
  /**/
}