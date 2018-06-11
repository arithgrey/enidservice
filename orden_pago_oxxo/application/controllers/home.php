<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->library("principal");    
        $this->load->library("restclient");       
        $this->load->library('sessionclass');     
    }       
    function index(){

        $data = $this->val_session("Orden de compra");
        
        $data["meta_keywords"] = '';
        $data["desc_web"] = "";                
        $data["url_img_post"] = create_url_preview("");        
        $param =  $this->input->get();
        $data["info_pago"]= $param;
        $data["clasificaciones_departamentos"] = "";        
        $concepto =  valida_valor_variable($param , "concepto");    
        $id_usuario=  $this->input->get("q3"); 
        $data["usuario"]=  $this->get_usuario($id_usuario);
        $data["css"] = ["../css_tema/template/pago_oxxo.css"];
        $this->principal->show_data_page($data, 'ingresar_saldo_a_cuenta');        
    }    
    /**/
    function logout(){                      
        $this->sessionclass->logout();      
    }   
    /**/
    function val_session($titulo_dinamico_page ){

        $data["is_mobile"] = ($this->agent->is_mobile() == FALSE)?0:1;
        if( $this->sessionclass->is_logged_in() == 1){                                                                                                    
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
    function get_usuario($id_usuario){
        /**/
        $q["id_usuario"] =  $id_usuario;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/q/format/json/" , $q);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }

    
}