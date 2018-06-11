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

		$data = $this->val_session("Métricas Enid Service");
	    $num_perfil =  $this->sessionclass->getperfiles()[0]["idperfil"];
        		
        if($num_perfil == 5  ){
            header("location:../cargar_base");
        }       
        if($num_perfil == 6  ){
            header("location:../tareas");
        }
        if($num_perfil == 7 || $num_perfil == 8 || $num_perfil == 11 ){
            header("location:../desarrollo");
        }        
         /**/
        if($num_perfil == 17){
            header("location:../programa_afiliados");
        }       
        /**/
        if($num_perfil == 19){
            header("location:../programa_afiliados");
        }
        /**/
        if ($num_perfil == 20 ) {
            header("location:../area_cliente");   
        }
        /**/            
        $data["usuarios_disponibles"]=  $this->principal->get_usuario_enid();        
        $data["clasificaciones_departamentos"] = "";
        $data["categorias_destacadas"] =  $this->carga_categorias_destacadas("");

        $data["js"] = array(
            "../js_tema/js/bootstrap-datepicker/js/bootstrap-datepicker.js",
            "../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
            "../js_tema/js/bootstrap-daterangepicker/moment.min.js",
            "../js_tema/js/bootstrap-daterangepicker/daterangepicker.js",
            "../js_tema/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
            "../js_tema/js/bootstrap-timepicker/js/bootstrap-timepicker.js",
            "../js_tema/js/pickers-init.js",
            base_url('application/js/principal.js')
        );


        $data["css"] = array(
            "../js_tema/js/bootstrap-datepicker/css/datepicker-custom.css",
            "../js_tema/js/bootstrap-timepicker/css/timepicker.css",
            "../css_tema/template/metricas.css",
            "../css_tema/template/lista_deseos.css");
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
    /**/
    private function carga_categorias_destacadas($param){
                
        $url = "tag/index.php/api/";
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");
        $result = $this->restclient->get("clasificacion/categorias_destacadas/format/json/" 
            , $param);
        $response =  $result->response;
        return json_decode($response , true );
    }
 
}