<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Perfiles extends REST_Controller{
  function __construct(){
      parent::__construct();                                             
      $this->load->model("perfil_model");        
      $this->load->library(lib_def());  
  } 
  
  function get_GET(){
    
    $param    =   $this->get();
    $response =  $this->perfil_model->get( [], [] , 50);
    $this->response($response);
  }  
  /**/
  function  id_departamento_by_id_perfil_GET(){

    $param           = $this->get();
    $id_departamento = $this->get(["id_departamento"] , ["idperfil" => $param["id_perfil"] ])[0]["id_departamento"];
    $this->response($id_departamento);
  }
  function data_usuario_GET(){

    $param          =  $this->get();
    $id_usuario     =  $param["id_usuario"];
    $response       =  $this->perfil_model->get_usuario($id_usuario);
    $this->response($response);
  }
  function puesto_cargo_GET(){

    $param      =   $this->get();    
    $puestos    = $this->perfil_model->get( [] ,["id_departamento" =>  $param["id_departamento"] ] , 100);
    $select     =   create_select(
      $puestos , 
      "puesto" , 
      "form-control input-sm puesto" , 
      "puesto" , "nombreperfil" , "idperfil");
      $this->response($select);

  }

  /*
  function afiliado_PUT(){        

    $param              =  $this->put();
    $param["id_perfil"] = 19;    
    $param["id_usuario"]=  $this->principal->get_session("idusuario");
    $response        =  $this->presentacionmodel->update_perfil_usuario($param);
    $this->response($response);        
  }
  function tipo_servicio_disponible_GET(){

    $param                                  =  $this->get();
    $response["prospectos_disponibles"]     =  $this->presentacionmodel->get_tipos_negocios_disponibles($param);    
    $this->load->view("prospectos/base_disponible" , $response);
  }
  
  
  function disponibles_GET(){

    $param                        =  $this->get();
    $response["perfiles"]      =  $this->presentacionmodel->get_negocios_disponibles($param);
    $response["extra"]         = $param;
    $response["perfiles_diponibles_prospectacion"] =  $this->presentacionmodel->get_tipos_negocios_disponibles_prospeccion($param);

    $this->load->view("perfiles/principal" , $response);
  }
  
  

  function disponibles_PUT(){

    $param              =  $this->put();
    $response        =  $this->presentacionmodel->update_negocios_disponibles($param);
    $this->response($response);
  }
  
  
  function disponible_DELETE(){

    $param =  $this->delete();
    $response  =  $this->presentacionmodel->delete_negocios_disponibles($param);
    $this->response($response);
  }
  */
  /**/
  
   
}
?>