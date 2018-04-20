<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Email extends REST_Controller{      
    function __construct(){
        parent::__construct();                  
        $this->load->model("emailmodel");                                              
    }
    /**/
    function tipo_negocio_PUT(){

    	$param =  $this->put();
       	$db_response =  $this->emailmodel->update_tipo_negocio($param);
       	$this->response($db_response);
    }
    /**/     
}?>