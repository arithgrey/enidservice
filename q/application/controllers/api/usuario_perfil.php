<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class usuario_perfil extends REST_Controller{      
    function __construct(){
        parent::__construct();                  
        $this->load->model("usuario_perfil_model");        
        $this->load->library(lib_def());                    
    }
    function usuario_GET(){        
      
      $param          =   $this->get();
      $id_usuario     =   $param["id_usuario"];      
      $params         =   ["idusuario" => $id_usuario , "status"   =>  1 ];
      $response       =   $this->usuario_perfil_model->get(["idperfil"] , $params);
      $this->response($response);
  	}    
    function permisos_usuario_POST(){
      
      $param          =   $this->post();      
      $id_usuario     =   $param["id_usuario"];
      $id_perfil      =   $param["puesto"];      
      $status         =   $this->usuario_perfil_model->delete(["idusuario" => $id_usuario], 15);

      $response       = [];
      if($status == true){  

        $params         =   ["idusuario" => $id_usuario , "idperfil" => $id_perfil ];        
        $response       =   $this->usuario_perfil_model->insert($params);        
        
      }
      $this->response($response);        
    }
    function es_cliente_GET($id_usuario){    
      $param          =   $this->get();
      $response       =   $this->usuario_perfil_model->get_es_cliente($param["id_usuario"]);
      $this->response($response);      
    }

}?>