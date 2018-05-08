<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    public $option;
    function __construct(){        
        parent::__construct();                            
        $this->load->library("principal");        
        $this->load->library("restclient"); 
        $this->load->library('sessionclass');     
    }       
    /**/
    private function get_option($key){
        return $this->option[$key];
    }
    /**/
    private function set_option($key , $value){
        $this->option[$key]= $value;
    }
    /**/
    function index(){

        $data = $this->val_session("");        
        $data["meta_keywords"] = '';
        $data["desc_web"] = "";                
        $data["url_img_post"] = create_url_preview("");        
        $data["clasificaciones_departamentos"] = $this->get_departamentos("nosotros");        
        
        $param =  $this->input->get();
        $vista =  "secciones/terminos_condiciones";
        $titulo ="TÉRMINOS Y CONDICIONES";
        if ( is_array($param) && array_key_exists("action", $param)) {
            
        }

        $data["vista"] =  $vista;
        $data["titulo"] = $titulo;
        $this->principal->show_data_page($data, 'home');                          
    }
    /**/
    function carga_servicio_por_recibo($param){

        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("tickets/servicio_recibo/format/json/" , $param);        
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/    
    function logout(){                      
        $this->sessionclass->logout();      
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
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }    
    /**/
    function val_session($titulo_dinamico_page ){

        if( $this->sessionclass->is_logged_in() == 1){                                                                                            

                /*
                $email_user  = $this->sessionclass->getemailuser();            
                $data['titulo']= $titulo_dinamico_page;                              
                $data["in_session"] = 1; 
                $data["menu"] ="";                                        
                return $data;
                */
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
                //$data["info_empresa"] =  $this->sessionclass->get_info_empresa();                     
                $data["desc_web"] =  "";
                return $data;                
                

        }else{            
            $data['titulo']=$titulo_dinamico_page;              
            $data["in_session"] = 0;     
            $data["id_usuario"] = "";                              
            return $data;
        }   
    }    


    
}