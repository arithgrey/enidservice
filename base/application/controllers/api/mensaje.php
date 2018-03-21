<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'restclient.php';    
class Mensaje extends REST_Controller{
  function __construct(){
        parent::__construct();                                     
        $this->load->model("mensajemodel");
        $this->load->library('sessionclass');      
  }  
  /**/
  function comentario_persona_usuario_POST(){
        
        $api = new RestClient();         

        $param =  $this->post();
        $param["id_usuario"] = $this->sessionclass->getidusuario();


        $tipificacion=  $param["tipificacion"];          
        $url = "persona/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $api->set_option('base_url', $url_request);
        $api->set_option('format', "json");
            
        switch($tipificacion){
          case 2:
            
            $param["tipo_llamada"] =1;
            $result = $api->post("persona/agendar" , $param);
            $response =  $result->response;
            $this->response($response);
            break;

          case 5:
            
            $param["tipo_llamada"] =1;
            $result = $api->post("persona/agendar" , $param);
            $response =  $result->response;
            $this->response($response);
            break;  
          
          case 9:
            
            $result = $api->post("persona/agendar_email" , $param);
            $response =  $result->response;
            $this->response($response);
            
            break;

          default:
            $db_response  =  $this->mensajemodel->insert_comentario($param);
            $this->response($db_response);
            break;
        }
        

  }
  /**/
  function q_GET(){

    $param =  $this->get();
    $db_response =  $this->mensajemodel->get_mensaje($param);
    $this->response($db_response);
    
  }
  /**/
  function red_social_PUT(){
    $param =  $this->put();    
    $db_response =   $this->mensajemodel->update_mensaje_red_social($param);
    $this->response($db_response);
  }
  /**/
  function red_social_DELETE(){
    
    $param =  $this->delete();    
    $db_response =   $this->mensajemodel->delete_mensaje_red_social($param);
    $this->response($db_response);
  }
  /**/
  function red_social_POST(){
    
    /**/
    $param =  $this->post();
    $param["id_usuario"] =  $this->sessionclass->getidusuario();
    if($param["id_mensaje"] > 0){
            
      $db_response =   $this->mensajemodel->update_mensaje($param);
      $this->response($db_response);   
      
    }else{
      $db_response =  $this->mensajemodel->insert_mensaje_red_social($param);
      $this->response($db_response);          
    }
    
  }
  
  function red_social_GET(){
      
      $param =  $this->get();    
      $data["servicio"] = $param["servicio"];
      $data["red_social"] = $param["red_social"];
      $param["id_usuario"] =  $this->sessionclass->getidusuario();    
      
      $info_mensaje =  $this->mensajemodel->get_mensaje_red_social($param);
      
      $data["id_usuario"] = $this->sessionclass->getidusuario();      
      $data["info_mensaje"] = $info_mensaje;
      

      
      //
      if (count($info_mensaje["mensaje"]) > 0){
        $this->load->view("mensaje/principal",  $data);
      }else{
        $this->response("<span style='font-size:.8em;'> Sín mensajes </span>");
      }
      

      
  }
  /**/
  function comandos_GET(){

    $param =  $this->get();
    $data["comandos_ayuda"] =  $this->mensajemodel->get_comandos_ayuda($param);
    $this->load->view("comando/principal" , $data);
  }
  /**/
  function comandos_POST(){

    $param =  $this->post();    
    return $this->mensajemodel->insert_comando($param);
    
  }
  function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
  }
  /**/
  function val_session(){

      if( $this->sessionclass->is_logged_in() == 1){

      }else{
        redirect(base_url());
      }   
  }    
   
}
?>