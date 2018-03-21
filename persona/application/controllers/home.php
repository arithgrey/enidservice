<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->library("principal");
        $this->load->library('sessionclass');        
    }        
    /**/
    function evaluacion(){
        $this->load->view("empresa/evaluacion_enid");
    }
    /**/
    function usos_privacidad_enid_service(){        
        $this->principal->crea_historico(28);
        $this->load->view("empresa/uso_privacidad");
    }     
    /**/                        
    function index(){        

        $data["titulo"] =  "OPTIMICE LA TOMA DE DECISIONES DE SU NEGOCIO.";
        $data["meta_keywords"] =  "Desarrollo de sitios web, negocios,  página web, business intelligence, consultoria"; 
        $data["url_img_post"] = create_url_preview(1);
        $this->principal->crea_historico(99);                    
        
        $this->load->view("header" , $data);
        $this->load->view("home" , $data);                     
        $this->load->view("footer" , $data);
    }
    /**/
    function info_sitios_web(){

        $data["titulo"] =  "Como hacer que mi negocio aparezca en google";
        $data["meta_keywords"] =  "Sitios web, Paǵinas web, Página en Internet"; 
        $data["url_img_post"] = create_url_preview(1);
        $this->principal->crea_historico(99);                    
        
        $this->load->view("header_pw" , $data);
        $this->load->view("servicio/info_paginas_web" , $data);                     
        $this->load->view("footer" , $data);
    }
    /**/
    function logout(){  
        $this->session->sess_destroy();
        redirect(base_url());
    }
    /**/   
    function val_session($titulo_dinamico_page){

        if ( $this->sessionclass->is_logged_in() == 1) {                                                            
                $menu = $this->sessionclass->generadinamymenu();
                $nombre = $this->sessionclass->getnombre();                                         
                $data['titulo']= $titulo_dinamico_page;              
                $data["menu"] = $menu;              
                $data["nombre"]= $nombre;                                               
                $data["perfilactual"] =  $this->sessionclass->getnameperfilactual();                
                $data["in_session"] = 1;
                $data["no_publics"] =1;
                $data["meta_keywords"] =  "";
                $data["url_img_post"]= "";
                return $data;
        }else{            
            $data['titulo']=$titulo_dinamico_page;              
            $data["in_session"] = 0;
            $data["no_publics"] =0;
            $data["meta_keywords"] =  "";
            $data["url_img_post"]= "";
            return $data;
        }   
    }    
 
}