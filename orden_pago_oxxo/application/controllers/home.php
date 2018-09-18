<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->library(lib_def());  
        
    }       
    function index(){

        $data                       = 
        $this->principal->val_session("Orden de compra");        
        $data["meta_keywords"]      =   '';
        $data["desc_web"]           =   "";                
        $data["url_img_post"]       =   create_url_preview("");        
        $param                      =   $this->input->get();
        $data["info_pago"]          =   $param;
        $data["clasificaciones_departamentos"] = "";        
        $concepto                   =   get_info_variable($param , "concepto");    
        $id_usuario                 =   get_info_variable($param,  "q3"); 
        
        $data["usuario"]            =   $this->principal->get_info_usuario($id_usuario);
        $data["css"]                =   ["pago_oxxo.css"];
        $this->principal->show_data_page($data, 'ingresar_saldo_a_cuenta');        
    }        
}