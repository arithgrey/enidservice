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
        $clasificaciones_departamentos =   $this->get_departamentos("nosotros");    
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;
        $this->principal->show_data_page( $data , 'empresas_enid');			
    	$this->principal->crea_historico(29 , 0 , $this->sessionclass->getidusuario());
                		
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