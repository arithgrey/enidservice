<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->library("principal");        
        $this->load->library("restclient");   
        $this->load->library("sessionclass");
    }       
    function index(){        
        
        $data = $this->val_session("");                
        $data["meta_keywords"] = "";    
        $data["desc_web"] = "";        
        $data["url_img_post"] = "";
        $data["clasificaciones_departamentos"] = $this->get_departamentos("");
        

        if (is_array($this->input->get()) 
            && array_key_exists("q", $this->input->get())
            && $this->input->get("q") === "preferencias" ){
            
            $data["preferencias"]=  $this->get_preferencias($data["id_usuario"]);            
            $data["css"] = array( base_url("application/css/preferencias.css") );
            $data["js"] = array( base_url("application/js/preferencias.js") );
            $this->principal->show_data_page($data, 'home_preferencias');        

        }else{            
            /*Validamos que se envíe a lista de deseos o a preferencias*/            
            $data["productos_deseados"]=  $this->get_lista_deseos($data["id_usuario"]);
            $data["css"] =  array("../css_tema/template/lista_deseos.css");
            $this->principal->show_data_page($data, 'home');        
        } 
        
    }    
    /**/
    function val_session( $titulo_dinamico_page ){        

        if($this->sessionclass->is_logged_in() == 1) {                                                            
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
    private function get_departamentos($nombre_pagina){
                
        $q["q"] =  $nombre_pagina;
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = $this->restclient->get("clasificacion/primer_nivel/format/json/" , $q);        
        $response =  $result->response;        
        return $response;
    }
    private function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    private function get_lista_deseos($id_usuario){

        $q["id_usuario"]    =  $id_usuario;
        $url                = "tag/index.php/api/";         
        $url_request        =  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result             =$this->restclient->get("producto/lista_deseos/format/json/" , $q);
        return json_decode($result->response , true);
        
    }
    /**/    
    private function get_preferencias($id_usuario){

        $q["id_usuario"]    =  $id_usuario;
        $url                = "tag/index.php/api/";         
        $url_request        =  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result  = $this->restclient->get("clasificacion/interes_usuario/format/json/" , $q);
        return json_decode($result->response , true);
        
    }
    
}