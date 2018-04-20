<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Negocio extends REST_Controller{
    function __construct(){
        parent::__construct();      
        $this->load->model('negocio_model');                 
        $this->load->library('restclient');                 
        $this->load->library('sessionclass');
    }
    /**/
    function index_GET(){
        
        $this->get();
        $id_usuario =  $this->sessionclass->getidusuario();    
        $data["entregas_en_casa"]=  $this->get_tipo_entregas($id_usuario);        
        $this->load->view("negocio/principal" ,  $data);
        
    }
    /**/    
    private function get_tipo_entregas($id_usuario){
        
        $q["id_usuario"] =  $id_usuario;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/entregas_en_casa/format/json/" , $q);
        $info =  $result->response;        
        return json_decode($info, true);
    }
    /**/
    function entregas_en_casa_PUT(){
        /**/
        $param =  $this->put();
        $param["id_usuario"] = $this->sessionclass->getidusuario();
        $db_response =  $this->negocio_model->update_entregas_en_casa($param);
        $this->response($db_response);
    }    
    /**/
    private function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }  
       
}
?>