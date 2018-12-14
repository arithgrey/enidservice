<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Faqs extends REST_Controller{
  function __construct(){
        parent::__construct();    
        $this->load->helper("base");
        $this->load->model("faqsmodel");                                 
        $this->load->library(lib_def());    
  }  
  function qsearch_GET(){


    $param    = $this->get();
    $response =  [];
    if (if_ext($param , "id_categoria,extra")) {
        
        $response =  $this->faqsmodel->qsearch($param);
    }
    $this->response($response);

  }
  /*
  function q_GET(){
    $param      = $this->get();
    $response   =  $this->faqsmodel->q($param);
    $this->response($response);    
  }
  */
  /**/
  function search_GET(){    
    $param    =     $this->get();
    $response =     false;
    if (if_ext($param, "q")){
        $response =  $this->faqsmodel->search($param);
    }
    $this->response($response);
  }
  /**/  
  function respuesta_POST(){

    $param      =   $this->post();
    $response   =   false;
    if (if_ext($param, "editar_respuesta,id_faq,respuesta,categoria,titulo,status,id_usuario")){
        $param["id_usuario"]    =  $this->principal->get_session("idusuario");
        $editar_respuesta       =   $param["editar_respuesta"];
        $id_faq                 =   $param["id_faq"];
        $respuesta              =   $param["respuesta"];
        $categoria              =   $param["categoria"];
        $titulo                 =   $param["titulo"];
        $status                 =   $param["status"];
        $id_usuario             =   $param["id_usuario"];


        if ($editar_respuesta ==  0) {
            $params = [
                "titulo"           =>   $titulo,
                "respuesta"        =>   $respuesta,
                "id_categoria"     =>   $categoria,
                "status"           =>   $status,
                "id_usuario"       =>   $id_usuario
            ];
            $response =  $this->faqsmodel->insert("faq", $params, 1);
        }else{
            $params = [
                "titulo"          => $titulo ,
                "respuesta"       => $respuesta,
                "id_categoria"    => $categoria,
                "status"          => $status
            ];
            $response = $this->faqsmodel->update('faq' , $params ,["id_faq" => $id_faq]  );
        }
    }
    $this->response($response);
    
  }
  /**/
  function respuesta_GET(){

      $param    = $this->get();
      $response = false;
      if(if_ext($param , "id_faq")){
          $response =  $this->faqsmodel->get_respuesta($param);
      }
      $this->response($response);      
  }
  /*
  function categorias_extras_GET(){

    $in_session =  $this->principal->is_logged_in();
    if ($in_session ==  false ){
      
      $this->response("");

    }else{

      $perfiles     =  $this->principal->getperfiles();
      $id_perfil    =  $perfiles[0]["idperfil"];
        
      switch ($id_perfil) {
          case 20:
            $data_complete["categorias_cliente"]=  $this->get_categorias_por_tipo(3);
            $this->load->view("faq/categorias" , $data_complete);
            break;
          
          default:          

            $data_complete["categorias_cliente"]=  $this->get_categorias_por_tipo(3);
            $data_complete["labor_venta"]       =  $this->get_categorias_por_tipo(4);
            $this->load->view("faq/categorias_usuario_enid_service" , $data_complete);

            break;
        }  
      
      
    }
  }
  */
   
}