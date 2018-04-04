<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Saldos extends REST_Controller{      
    public $option; 
    function __construct(){
        parent::__construct();                                  
        $this->load->library("restclient");                                    
        $this->load->model("saldos_model");
        $this->load->library("sessionclass");            
    } 
    /**/
    function usuario_POST(){
        
        $param =  $this->post();
        $saldos=  $this->saldos_model->get_saldo_usuario($param);
        
        $nueva_data =0;
        if(count($saldos)>0){            
            
            $porcentaje_comision = $this->get_porcentaje_comision($param);
            $nueva_data=  crea_saldo_disponible($saldos , $porcentaje_comision);

        }
        $this->response($nueva_data);
    }
    /**/
    private function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    private function set_option($key, $value){
        $this->option[$key] = $value;
    }
    /**/
    private function get_option($key){
        return $this->option[$key];
    }
    /**/
    private function get_porcentaje_comision($param){
      
      $url = "pagos/index.php/api/";         
      $url_request=  $this->get_url_request($url);
      $this->restclient->set_option('base_url', $url_request);
      $this->restclient->set_option('format', "json");        
      $result = $this->restclient->get("cobranza/comision/format/json/", $param);
      $response =  $result->response;        
      return json_decode($response , true); 
    }
  
   
}?>