<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Mailrest extends REST_Controller{
	function __construct(){
	    parent::__construct();	  
	    $this->load->model("enidmodel");  
	    $this->load->library('mensajerialogin');        
	}    
	/**/
	function recupera_password_POST(){

		if($this->input->is_ajax_request()){ 
			$param =  $this->post();		
			$db_response =  $this->enidmodel->set_pass($param);
			$response["info_set"] =  $db_response;
			if ($db_response["status_send"] ==  1){					
				$response["info_mail"] =  $this->mensajerialogin->mail_recuperacion_pw($db_response);			
			}
			$this->response(1);
		}else{
			$this->response("Error");
		}
	}
	/**/
}/*Termina rest*/