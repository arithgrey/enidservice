<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require 'restclient.php';   
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->library("principal");        
        $this->load->library("restclient");   
        $this->load->library('sessionclass');     
    }   
         
    /**/
    function index(){

        if (is_array($this->input->get()) && array_key_exists("info", $this->input->get())) {
            $this->crea_info();    
        }else{
            $this->crea_orden();
        }
    }
    /**/
    private function crea_info(){
        
        $data = $this->val_session("");
        $data["meta_keywords"] = '';
        $data["desc_web"] = "Formas de pago Enid Service";                
        $data["url_img_post"] = create_url_preview("formas_pago_enid.png");        
        $data["clasificaciones_departamentos"] = "";        
        $this->principal->show_data_page($data, 'info_formas_pago');                    
        
    }
    /**/
    private function crea_orden(){
        $data = $this->val_session("");
        $data["meta_keywords"] = '';
        $data["desc_web"] = "";                
        $data["url_img_post"] = create_url_preview("formas_pago_enid.png");        
        $id_recibo =  $this->input->get("recibo");                
        $data["recibo"] = $id_recibo;        
        $data["info_recibo"] = $this->get_recibo_forma_pago($id_recibo);

        $num_hist= get_info_servicio( $this->input->get("q"));            
        $num_usuario = get_info_usuario( $this->input->get("q2"));        
        $num_servicio = get_info_usuario( $this->input->get("q3"));        
        $this->principal->crea_historico(5669877 , $num_usuario , $num_servicio );
        $data["clasificaciones_departamentos"] = "";        
        $this->principal->show_data_page($data, 'home');                          
    }
    /**/
    function get_recibo_forma_pago($id_recibo){
                
                
        $extra = array('id_recibo' =>  $id_recibo );
        $url = "pagos/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");
        $result = $this->restclient->get("cobranza/resumen_desglose_pago" , $extra);
        $response =  $result->response;        
        return $response;        
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
}