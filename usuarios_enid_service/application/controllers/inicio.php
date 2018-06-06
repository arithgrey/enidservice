<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inicio extends CI_Controller {
	function __construct(){        
        parent::__construct();            			
	    $this->load->library("principal");
        $this->load->library("restclient");   
	    $this->load->library('sessionclass');	     
    }    
    /**/
    function index(){

		$data = $this->val_session("Grupo ventas - Enid Service - ");        	    	  
        $num_perfil =  $this->sessionclass->getperfiles()[0]["idperfil"];   
        /*Si tienes perfil, soporte a ventas enciamos al usuario a su sitio  home*/       
        $num_perfil =  $this->sessionclass->getperfiles()[0]["idperfil"];
        if ($num_perfil == 20 ) {
            header("location:../area_cliente");   
        }        
        $data["departamentos"] =  $this->principal->get_departamentos();       
        $data["perfiles_enid_service"] =  $this->principal->get_perfiles_enid_service(); 
        $clasificaciones_departamentos =   $this->get_departamentos("nosotros");    
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;   

        $data["js"]      = [
            "../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js",
            "../js_tema/js/bootstrap-datepicker/js/bootstrap-datepicker.js",
            "../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
            "../js_tema/js/bootstrap-daterangepicker/moment.min.js",
            "../js_tema/js/bootstrap-daterangepicker/daterangepicker.js",
            "../js_tema/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
            "../js_tema/js/bootstrap-timepicker/js/bootstrap-timepicker.js",
            "../js_tema/js/pickers-init.js",
            base_url('application/js/principal.js'),
            base_url('application/js/notificaciones.js'),
            base_url('application/js/categorias.js')

        ];

        /**/
        $data["css"] = [
            "../js_tema/js/bootstrap-colorpicker/css/colorpicker.css" ,
            "../js_tema/js/bootstrap-datepicker/css/datepicker-custom.css" ,
            "../js_tema/js/bootstrap-datepicker/css/datepicker.css" ,
            "../js_tema/js/bootstrap-daterangepicker/daterangepicker.css" ,
            "../js_tema/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" ,
            "../js_tema/js/bootstrap-datetimepicker/css/datetimepicker.css",
            "../js_tema/js/bootstrap-timepicker/css/timepicker.css" ,
            "../js_tema/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css", 
            base_url("application/css/principal.css")

        ];
    
        $this->principal->show_data_page( $data , 'empresas_enid');			    	                	
    }    	
   /**/
    function val_session($titulo_dinamico_page ){        
        if ( $this->sessionclass->is_logged_in() == 1) {                                                            
                $menu = $this->sessionclass->generadinamymenu();
                $nombre = $this->sessionclass->getnombre();                                         
                $data['titulo']= $titulo_dinamico_page;              
                $data["menu"] = $menu;              
                $data["nombre"]= $nombre;                                               
                $data["email"]= $this->sessionclass->getemailuser();                                               
                $data["perfilactual"] =  $this->sessionclass->getnameperfilactual();                
                $data["in_session"] = 1;
                $data["no_publics"] =1;
                $data["meta_keywords"] =  "";
                $data["url_img_post"]= "";
                $data["id_usuario"] = $this->sessionclass->getidusuario();                     
                $data["id_empresa"] =  $this->sessionclass->getidempresa();                     
                $data["info_empresa"] =  $this->sessionclass->get_info_empresa();                     
                $data["desc_web"] =  "";
                return $data;
        }else{            
            redirect(url_log_out());
        }   
    }      
    /**/
    function get_departamentos($nombre_pagina){

        $q["q"] =  $nombre_pagina;
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = $this->restclient->get("clasificacion/primer_nivel/format/json/" , $q);        
        $response =  $result->response;        
        return $response;
    }
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }



}