<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Presentacion extends REST_Controller{
  function __construct(){
        parent::__construct();                                     

        $this->load->model("presentacionmodel");
  }  
  /**/
  function demo_POST(){

    $param =  $this->post();

    $db_response = $this->presentacionmodel->insert_mensaje_red_social($param);

    $this->response($db_response );

  }
  
}
?>