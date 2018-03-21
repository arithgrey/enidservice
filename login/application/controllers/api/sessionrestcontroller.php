<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Sessionrestcontroller extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->load->library('principal');
    }     
    /**/
    function start_post(){
        
        if($this->input->is_ajax_request()){   

            $param =  $this->post();
            $secret = $param["secret"];        
            $mail = $param["email"];            
            $db_response = $this->principal->isuserexistrecord(trim($mail), trim($secret));        
            $this->response($db_response);        
        }else{
            $this->response("Error");
        }
        
        /**/
    }
}