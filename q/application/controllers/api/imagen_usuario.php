<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Imagen_usuario extends REST_Controller{          
    function __construct(){
        parent::__construct();                                  
        $this->load->model("imagen_usuario_model");            
        $this->load->library(lib_def());                    
    } 
    function usuario_GET(){
      $param      =  $this->get();
      $response   =  $this->imagen_usuario_model->get_img_usuario($param["id_usuario"]);
      $this->response($response);   
  	}
    /**/    
    function index_POST(){

      $param      =   $this->post();           
      $response   =   false;      
      if ($this->delete_usuario($param) ==  1) {

          $params     = [
            "id_imagen" => $param["id_imagen"],
            "idusuario" => $param["id_usuario"]
          ];          
          $response   =   $this->imagen_usuario_model->insert($params);        
      }      
      $this->response($response);
    }
    private function delete_usuario($param){
      
      
      $in   =  ["idusuario" => $param["id_usuario"]];      
      $imagenes = $this->imagen_usuario_model->get(["id_imagen"] , $in , 10);
      foreach ($imagenes as $row){

        $this->imagen_usuario_model->delete($in , 10);
        $response = $this->delete_imagen($row["id_imagen"]);
        //debug($response);

      }
      return 1;
    }    
    private function delete_imagen($id_imagen){

      $q["id_imagen"] = $id_imagen;
      $api =  "img/index";
      return $this->principal->api($api , $q , "json" , "DELETE");
    }
    function img_perfil_GET(){

        $param      =   $this->get();
        $response   =   $this->imagen_usuario_model->img_perfil($param);
        $this->response($response);        
    }   

}?>