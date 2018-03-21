<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Prospectos extends REST_Controller{
  function __construct(){
        parent::__construct();     
        $this->load->model("ventasmodel");                                
  }  
  /**/
  function comando_busqueda_GET(){

    $param = $this->get();
    
    $data["comando"] =  $this->ventasmodel->get_comando_busqueda($param);
    $this->load->view("comando/form" , $data);

  }
  
}
?>