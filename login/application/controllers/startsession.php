<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Startsession extends CI_Controller{
    public $option;
	function __construct(){        
        parent::__construct();                               
        $this->load->library('principal');   
        $this->load->library("restclient");             
        $this->load->library('sessionclass');        
    }      
    function index(){                
        
        /**/        
        $data = $this->val_session("");
        $q =  $this->input->get("q");
        $data["desc_web"]  = "COMPRA Y VENDE EN ENID SERVICE";              
        $data["meta_keywords"] =  "COMPRA Y VENDE ARTÍCULOS Y SERVICIOS  EN ENID SERVICE "; 
        $data["url_img_post"] = create_url_preview("promo.png");        
        /***************************************************************/
        $data["action"] = valor_varible($this->input->get() , "action");                
        if ($this->sessionclass->is_logged_in() == true){        
            redirect(url_home());
        }else{  
            
            $clasificaciones_departamentos =   $this->get_departamentos("nosotros");        
            $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;            
            $this->principal->show_data_page($data, "signin");            
            $this->principal->crea_historico(4);
            $this->session->sess_destroy();     
        } 
    }    
    /**/    
	function logout(){						
		$this->sessionclass->logout();		
	}	
	function val_session($titulo_dinamico_page ){

        if ( $this->sessionclass->is_logged_in() == 1) {                                                                            
                $email_user  = $this->sessionclass->getemailuser();                
                $data['titulo']= $titulo_dinamico_page;                              
                $data["in_session"] = 1;                
                return $data;
        }else{            
            $data['titulo']=$titulo_dinamico_page;              
            $data["in_session"] = 0;     
            $data["id_usuario"] = "";                                           
            return $data;
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
    function set_option($key , $option){
        $this->option[$key] =  $option;
    }
    /**/
    function get_option($key){
        return $this->option[$key];
    }


}