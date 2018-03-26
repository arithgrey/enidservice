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
        $data["url_img_post"] = create_url_preview("4.png");
    
        $data["estado"]= $this->principal->get_estados();
        $data["tipos_negocios"]= $this->principal->get_tipos_negocios();
        $data["tipos_negocios_enid"]= $this->principal->get_tipos_negocios_enid();        
        $data["servicios"] = $this->principal->get_servicios();
        $data["fuentes"] = $this->principal->get_fuentes();
        /**/
        $data["ciclo_facturacion"] =  $this->principal->get_ciclo_facturacion();
    
        $num_perfil =  $this->sessionclass->getperfiles()[0]["idperfil"];
        if($num_perfil == 20){
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

        $this->principal->show_data_page($data, 'home');                          
    }
    function logout(){                      
        $this->sessionclass->logout();      
    }   
    /**/
    function val_session($titulo_dinamico_page ){        

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

}