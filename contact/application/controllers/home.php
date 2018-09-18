<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    public $option;
    function __construct(){        
        parent::__construct();                            
        $this->load->library(lib_def());    
    }        
    function index(){    
        $data                   = 
        $this->principal->val_session("Solicita una llamada aquí");
        $data["meta_keywords"]  =   "Solicita una llamada aquí";
        $data["desc_web"]       =   "Solicita una llamada aquí";
        $data["url_img_post"]   =   create_url_preview("images_1.jpg");            
        $data["departamentos"]  =   $this->get_departamentos_enid();         
        $data["clasificaciones_departamentos"]  = $this->principal->get_departamentos();

        if ($data["id_usuario"]>0){        
            $usuario            =         $this->principal->get_info_usuario($data["id_usuario"]);
            $data["telefono"]   =         $usuario[0]["tel_contacto"];                
        }
        $this->principal->show_data_page($data, 'home');
    }    
    /**/
    function get_departamentos_enid(){ 
     
        $api       =  "departamento/index/format/json/";        
        return  $this->principal->api("q" , $api );

    }       
     
}