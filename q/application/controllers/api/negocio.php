<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Negocio extends REST_Controller{
    private $id_usuario;
    function __construct(){
        parent::__construct();      
        $this->load->model('negocio_model');                 
        $this->load->library(lib_def());              
        $this->id_usuario   =  $this->principal->get_session("idusuario");           
    }
    
    function index_GET(){

        $id_usuario                 =  $this->id_usuario;
        $data["entregas_en_casa"]   =  $this->get_tipo_entregas($id_usuario);
        $this->load->view("negocio/principal" ,  $data);
        
    }
    private function get_tipo_entregas($id_usuario){    
        $q["id_usuario"] =  $id_usuario;   
        $api             = "usuario/entregas_en_casa/format/json/";     
        return  $this->principal->api( $api , $q );
    }    
    /*
    function entregas_en_casa_PUT(){
        
        $param                  =   $this->put();
        $param["id_usuario"]    =   $this->id_usuario;
        $response               =   $this->negocio_model->update_entregas_en_casa($param);
        $this->response($response);
    } 
    */   
    
       
}