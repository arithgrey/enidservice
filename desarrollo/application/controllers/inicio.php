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
        
        $data["num_departamento"]= 
        $this->principal->get_id_departamento_by_id_perfil($num_perfil);
  
        $data["servicios"] = $this->principal->get_servicios();
        $data["departamentos"] =  $this->principal->get_departamentos();

        $num_perfil =  $this->sessionclass->getperfiles()[0]["idperfil"];
        if ($num_perfil == 20 ) {
            header("location:../area_cliente");   
        } 
        $clasificaciones_departamentos =   $this->get_departamentos("nosotros");    
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;
        /**/        
        $activa =  valida_valor_variable($this->input->get() , "q");
        if($activa === "" ){
            $activa = 1;
        }
        $data["activa"] = $activa;

        $data["css"] = [
            "http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css",
            "../css_tema/template/desarrollo.css",
            "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css",
            base_url("application/css/principal.css"),
            "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css"
            ];
        
        $data["js"] = [
                "../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js",
                "../js_tema/js/bootstrap-datepicker/js/bootstrap-datepicker.js",                
                "../js_tema/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                "../js_tema/js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                "../js_tema/js/pickers-init.js",
                base_url('application/js/principal.js'),                                
                base_url('application/js/summernote.js',
                "http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js",
                "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"
            )

        ];


        $this->principal->show_data_page( $data , 'empresas_enid');                 
        
    }    	
   /**/
    function val_session($titulo_dinamico_page ){       
        $data["is_mobile"] = ($this->agent->is_mobile() == FALSE)?0:1; 
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