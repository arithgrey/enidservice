<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Accesos extends REST_Controller{      
    public $options; 
    function __construct($options=[]){
        
        parent::__construct();                      

        $this->load->model("accesos_model");            
        $this->load->library('restclient');                 
        $this->load->library('sessionclass');                    
    }
    /**/
    function set_option($key , $value){
        $this->options[$key] = $value;        
    }
    /**/
    function get_option($key){
        return $this->options[$key];
    }
    /**/
    function afiliados_periodo_GET(){
        $param =  $this->get();
        $db_response = $this->accesos_model->get_accesos_periodo_afiliado($param);
        $this->response($db_response);
    }   
    /**/
   
}?>