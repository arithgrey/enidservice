<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Mailrest extends REST_Controller{
	function __construct(){
	    parent::__construct();
	    $this->load->library('mensajerialogin');   
	    $this->load->library(lib_def());       
	}
	function recupera_password_POST(){

	    $response   =  false;
		if($this->input->is_ajax_request()){ 

			$param 					=  	$this->post();		
			$param["type"]			= 	1;
			$response 				=  	$this->set_pass($param);					
			if ($response["status_send"] ==  1){					
				$response["info_mail"] =  $this->mensajerialogin->mail_recuperacion_pw($response);			
			}
            $response =  1;
		}
        $this->response($response);
	}
	private function set_pass($q){
		$api 	=  "usuario/pass/";
		return  $this->principal->api( $api , $q , 'json', 'PUT');
	}
}