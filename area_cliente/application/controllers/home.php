<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();  
        $this->load->helper("area");                          
        $this->load->library(lib_def());   
        $this->principal->acceso();               
    }
    function index(){

        $data   =   $this->principal->val_session("");
        if (get_param_def($this->input->get() , "transfer" ) > 0 ) {
            
        }else{

            $this->principal->acceso();
            $data["meta_keywords"]                  =   "";    
            $data["desc_web"]                       =   "";        
            $data["url_img_post"]                   =   "";                
            $data["action"]                         =   $this->input->get("action");
            $valoraciones                           =   $this->resumen_valoraciones($data["id_usuario"]);        
            $data["valoraciones"]                   =   $valoraciones["info_valoraciones"];     
            $class_departamentos                    =   $this->principal->get_departamentos("nosotros");    
            $data["clasificaciones_departamentos"]  =   $class_departamentos;        
            $alcance                                =   $this->get_alcance($data["id_usuario"]);
            $data["alcance"]                        =   crea_alcance($alcance);
            
            $data["js"] =  [
                'area_cliente/principal.js',
                'area_cliente/proyectos_persona.js',
                'area_cliente/cobranza.js',
                'js/direccion.js',
                'area_cliente/buzon.js',
                "alerts/jquery-confirm.js"

            ];


            $data["css"] = [
                "css_tienda_cliente.css",
                "valoracion.css",
                "area_cliente.css",
                "preguntas.css",
                "confirm-alert.css"
            ];
            
            $data["ticket"] =  get_info_variable( $this->input->get() , "ticket" );
            $this->principal->show_data_page($data, 'home');   
        }                   
                             
        
        
    }
    private function resumen_valoraciones($id_usuario){

        $q["id_usuario"] =  $id_usuario;
        $api             =  "valoracion/usuario/format/json/";
        return $this->principal->api( $api, $q);
    }
    private function get_alcance($id_usuario){

        $q["id_usuario"]    =  $id_usuario;
        $api                =  "servicio/alcance_usuario/format/json/";
        return              $this->principal->api( $api, $q );    

    }
}