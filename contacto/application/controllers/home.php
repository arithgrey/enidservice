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
    function set_option($key , $val ){
        $this->option[$key] = $val;
    }
    /**/
    function get_option($key){
        return $this->option[$key];
    }  
    /**/     
    /**/
    function index(){
        
        $data = $this->val_session("Solicita una llamada aquí, 
            Whatsapp al (55)5296-7027, (55)3269-3811");

        $data["meta_keywords"] = 
        "Solicita una llamada aquí, Whatsapp al (55)5296-7027, (55)3269-3811";

        $data["desc_web"] = 
        "Solicita una llamada aquí,Whatsapp al (55)5296-7027, (55)3269-3811";                
        $data["url_img_post"] = create_url_preview("images_1.jpg");
        
        $data["departamentos"] = $this->principal->get_departamentos($data["in_session"]);

        $clasificaciones_departamentos =   $this->get_departamentos("nosotros");        
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;

        $this->principal->crea_historico(43);         
        $this->principal->show_data_page($data, 'home');                          
    }
    /**/
    function logout(){                      
        $this->sessionclass->logout();      
    }   
    /**/
    function val_session($titulo_dinamico_page ){

        if( $this->sessionclass->is_logged_in() == 1){                                                                                            
        
                $menu = $this->sessionclass->generadinamymenu();
                $nombre = $this->sessionclass->getnombre();                       
                $id_usuario = $this->sessionclass->getidusuario();                  
                $data["id_usuario"] = $id_usuario;
                $data['titulo']= $titulo_dinamico_page;              
                $data["menu"] = $menu;              
                $data["nombre"]= $nombre;                                               
                $data["email"]= $this->sessionclass->getemailuser();
                $data["telefono"] =  $this->principal->get_telefono_por_usuario($id_usuario);
                $data["perfilactual"] =  $this->sessionclass->getnameperfilactual();                
                $data["in_session"] = 1;
                $data["no_publics"] =1;
                $data["meta_keywords"] =  "";
                $data["url_img_post"]= "";
                             
                $data["id_empresa"] =  $this->sessionclass->getidempresa();                     
                $data["info_empresa"] =  $this->sessionclass->get_info_empresa();                     
                $data["desc_web"] =  "";
                return $data;
                
                

        }else{            
            $data['titulo']=$titulo_dinamico_page;              
            $data["in_session"] = 0;                                    
            $data["id_usuario"] = "";                                    
            $data["nombre"] = "";                                    
            $data["email"] = "";                                    
            $data["telefono"] = "";                                    
            return $data;
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