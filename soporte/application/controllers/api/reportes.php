<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Reportes extends REST_Controller{
  function __construct(){
        parent::__construct();                      
        
        $this->load->helper("repo");
        $this->load->model("repomodel");    
        $this->load->library('sessionclass');      
  }  
  /**/
  function reporte_sistema_POST(){

        $param = $this->post();
        $db_response =  $this->repomodel->reporta_error($param);
        $this->response($db_response);
  }
  /**/
  function reporteincidencia_post(){  
      
      $id_user  =  0; 
      if ( $this->sessionclass->is_logged_in() == true) {
        $id_user = $this->sessionclass->getidusuario();  
      }


      $param =  $this->post();    
      $param["id_user"] =  $id_user; 
      $db_response =  $this->repomodel->insert_incidencia($param);
      $this->response($db_response);
    
    
  }
  /**/
  function global_empresa_GET(){
    /**/    
    $this->validate_user_sesssion();    
    $id_empresa =  $this->sessionclass->getidempresa();   
    $param =  $this->get();
    $db_response =  $this->repomodel->global_empresa($id_empresa ,  $param);
    $repo =  resumen_e($db_response);
    $this->response($repo);      

  }
  /**/
  function validate_user_sesssion(){
      if( $this->sessionclass->is_logged_in() == 1) {                        

            }else{
              /*Terminamos la session*/
              $this->sessionclass->logout();
          }   
  }/*termina validar session */
  /**/
  function erroresform_GET(){
    $param =  $this->get();   
    $data["param"] =  $param; 
    $data["calificaciones"] =  $this->repomodel->get_calificaciones($param["tipo"]);
    $data["tipos_incidencias"] = $this->repomodel->get_tipos_incidencias($param["tipo"]);
    echo $this->load->view("reporte/f_errores" , $data );
  }
  
}
?>