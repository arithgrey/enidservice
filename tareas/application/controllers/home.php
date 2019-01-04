<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->library(lib_def()); 
        $this->principal->acceso();
    }       
    function index(){

            
        $data                       = $this->principal->val_session("");
        $data["meta_keywords"]      = "";
        $data["desc_web"]           = "";
        $data["url_img_post"]       = create_url_preview("4.png");
        $data["estado"]             = $this->get_estados();
        $data["tipos_negocios"]     = $this->get_tipos_negocios();
        $data["tipos_negocios_enid"]= $this->get_tipos_negocios();        

        $num_perfil                 = $this->principal->getperfiles();
        if($num_perfil == 20){
            header("location:../area_cliente");   
        }       
        
        $data["clasificaciones_departamentos"]  =   $this->principal->get_departamentos("nosotros");
        $param                                  =   $this->input->get();
        $activa                                 =   get_info_variable($param , "q");
        if($activa === "" ){
            $activa = 1;
        }
        $data["activa"]         = $activa;
        $data["css_external"]   = ["http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css"];
        $data["css"]            = ["tareas.css"];
        $this->principal->show_data_page($data, 'home');                          
    }
    private function get_estados($q=[]){

        $api = "locaciones/get/format/json/";
        return $this->principal->api( $api ,$q);
    }
    private function get_tipos_negocios($q=[]){

        $api = "tipos_negocios/all/format/json/";
        return $this->principal->api( $api ,$q);
    }
}