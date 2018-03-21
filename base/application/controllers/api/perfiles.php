<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Perfiles extends REST_Controller{
  function __construct(){
        parent::__construct();                                             
        $this->load->model("presentacionmodel");
        $this->load->library('sessionclass');      
  }  
  /**/
  function afiliado_PUT(){
        
        $param =  $this->put();
        $param["id_perfil"] = 19;
        $id_usuario=  $this->sessionclass->getidusuario();
        $param["id_usuario"] =  $this->sessionclass->getidusuario();
        $db_response=  $this->presentacionmodel->update_perfil_usuario($param);
        $this->response($db_response);
        
  }
  /**/
  function tipo_servicio_disponible_GET(){

    $param =  $this->get();
    $db_response["prospectos_disponibles"] =  $this->presentacionmodel->get_tipos_negocios_disponibles($param);    
    $this->load->view("prospectos/base_disponible" , $db_response);
  }
  /**/
  function disponibles_GET(){

    $param =  $this->get();
    
    $db_response["perfiles"] =  $this->presentacionmodel->get_negocios_disponibles($param);
    $db_response["extra"] = $param;
    $db_response["perfiles_diponibles_prospectacion"] =  $this->presentacionmodel->get_tipos_negocios_disponibles_prospeccion($param);

    $this->load->view("perfiles/principal" , $db_response);
  }
  /**/

  function disponibles_PUT(){

    $param =  $this->put();
    $db_response  =  $this->presentacionmodel->update_negocios_disponibles($param);
    $this->response($db_response);
  }
  /**/
  function disponible_DELETE(){

    $param =  $this->delete();
    $db_response  =  $this->presentacionmodel->delete_negocios_disponibles($param);
    $this->response($db_response);
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