<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Faqs extends REST_Controller{
  function __construct(){
        parent::__construct();    
        $this->load->model("faqsmodel");                                 
        $this->load->library('sessionclass');      
  }  
  /**/  
  function respuesta_POST(){

    $param =  $this->post();
    
    $param["id_usuario"]=  $this->sessionclass->getidusuario();
    $db_response  =  $this->faqsmodel->registra_respuesta($param);    
    $this->response($db_response);
  }
  /**/
  function respuesta_GET(){

      $param = $this->get();
      $db_response =  $this->faqsmodel->get_respuesta($param);
      $this->response($db_response);      
  }
  /**/
  function categorias_extras_GET(){

    $in_session =  $this->sessionclass->is_logged_in();
    if ($in_session ==  false ){
      
      $this->response("");

    }else{

      /**/
      $perfiles =  $this->sessionclass->getperfiles();
      $id_perfil =  $perfiles[0]["idperfil"];  
        
      switch ($id_perfil) {
          case 20:
            /*Cuando es cliente solo se cargan algúnas categorias*/
            $data_complete["categorias_cliente"]=  $this->faqsmodel->get_categorias_por_tipo(3);
            $this->load->view("faq/categorias" , $data_complete);

            break;
          
          default:          

            $data_complete["categorias_cliente"]=  $this->faqsmodel->get_categorias_por_tipo(3);
            $data_complete["labor_venta"]=  $this->faqsmodel->get_categorias_por_tipo(4);
            $this->load->view("faq/categorias_usuario_enid_service" , $data_complete);

            break;
        }  
      
      
    }

    
  }
   
}
?>