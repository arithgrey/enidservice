<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    public $option;
    function __construct(){        
        parent::__construct();                            
        $this->load->library(lib_def());            
    }
    function index(){

        $data                       =   $this->principal->val_session("");
        $data["meta_keywords"]      =   "";
        $data["desc_web"]           =   "";
        $data["url_img_post"]       =   create_url_preview("");
        $data["clasificaciones_departamentos"] = $this->principal->get_departamentos("nosotros");
        $vista                      =   "secciones/terminos_condiciones";
        $titulo                     =   "TÉRMINOS Y CONDICIONES";
        $data["vista"] =  $vista;
        $data["titulo"] = $titulo;        
        $this->principal->show_data_page($data, 'home');                          
    }
}