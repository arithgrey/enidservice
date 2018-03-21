<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    public $option;
    function __construct(){        
        parent::__construct();                            
        $this->load->library("principal");        
        $this->load->library('restclient'); 
        $this->load->library('sessionclass');     
    }   
    /**/
    function get_option($key)
    {
        return $this->option[$key];
    }
    /**/
    function set_option($key , $val){
        $this->option[$key] =  $val;
    }
     function crea_data_costo_envio(){        
        $param["flag_envio_gratis"]=   $this->get_option("servicio")[0]["flag_envio_gratis"];   
        return $param;
    }
    /**/    
    function index(){

        $data = 
        $this->val_session("Registra tu cuenta en nuestro sistema y recibe asistencia al momento."); 
        $data["meta_keywords"] = '';
        $data["desc_web"] = 
        "Registra tu cuenta en nuestro sistema y recibe  asistencia 
        al momento.";
        $data["url_img_post"] = create_url_preview("recomendacion.jpg");
        $num_hist= get_info_usuario( $this->input->get("q"));   
        $num_usuario_referencia= get_info_usuario( $this->input->get("q2"));                    
        $data["q2"]= $num_usuario_referencia;
        $param =  $this->input->get();
        /**/
        $data_servicio =  $this->principal->resumen_servicio($param); 
        $this->set_option("servicio" , $data_servicio );
        /**/
        $data["costo_envio"] = $this->calcula_costo_envio($this->crea_data_costo_envio());
        
        
        $costo =  $data_servicio[0]["costo"];
        $info_solicitud["resumen_servicio"]= $data_servicio;
        $data["precio_publico"] = $this->get_precio_venta($costo);
        
        $info_solicitud["info_solicitud_extra"] =  $param; 
        $data["info_solicitud"] = $info_solicitud;
        $clasificaciones_departamentos =   $this->get_departamentos("nosotros");        
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;

        $this->principal->crea_historico( 2892 , 0, 0 );                 
        $this->principal->show_data_page($data, 'home');                          
        

    }
    /**/
    function get_precio_venta($costo){

        $q["costo"] =  $costo;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("cobranza/calcula_precio_producto/format/json/" , $q);
        $precio_publico =  $result->response;
        return json_decode($precio_publico , true);
            
    }
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
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
                $data["desc_web"] =  "";
                return $data;                
                

        }else{            
            $data['titulo']=$titulo_dinamico_page;              
            $data["in_session"] = 0;     
            $data["id_usuario"] = "";       
            $data["email"]= "";                       
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
    /**/
    function calcula_costo_envio($param){
        
        
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("cobranza/calcula_costo_envio/format/json/", $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    
   

    
}