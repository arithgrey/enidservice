<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Mailrest extends REST_Controller{
	function __construct(){
	    parent::__construct();	  
	    //$this->load->model("enidmodel");  
	    $this->load->library('mensajerialogin');   
	    $this->load->library(lib_def());       
	}    
	/**/
	function recupera_password_POST(){

		if($this->input->is_ajax_request()){ 
			$param 					=  $this->post();		
			$response 				=  $this->set_pass($param);
			$response["info_set"] 	=  $response;
			if ($response["status_send"] ==  1){					
				$response["info_mail"] =  $this->mensajerialogin->mail_recuperacion_pw($response);			
			}
			$this->response(1);
		}else{
			$this->response("Error");
		}
	}
	/**/
	function set_pass($q){

		$api 	=  "usuario/pass/format/json";
		return  $this->principal->api("q" , $api , $q , 'json', 'PUT');
	}
	/**/
}/*Termina rest*/