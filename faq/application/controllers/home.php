<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->library("principal");    
        $this->load->library("restclient");        
        $this->load->library('sessionclass');     
    }       
    function index(){

        $data = $this->val_session("");            
        $data["respuesta"] =  "";
        $data["faqs_categoria"] ="";
        $data["r_sim"] ="";
        $session =  $data["in_session"]; 
        /**/
        $faq =  $this->input->get("faq");
        $faqs =  $this->input->get("faqs");
        $categoria = $this->input->get("categoria");
        /**/
        $data["categorias_publicas_venta"] = 
        $this->principal->get_categorias_faq($session , 1 );
        $data["categorias_temas_de_ayuda"] = 
        $this->principal->get_categorias_faq($session , 5 );
        $data["categorias_programa_de_afiliados"] = $this->principal->get_categorias_faq($session , 6 );
    

        $flag_busqueda_q =  get_info_serviciosq($faq);           
        $data["flag_busqueda_q"] =  $flag_busqueda_q;
        /**/
        $data["lista_categorias"] =  $this->principal->get_lista_categorias($session);        

        /**/
        $data["meta_keywords"] =  " Preguntas frecuentes, Enid Service";
        $data["desc_web"] =  " Preguntas frecuentes, Enid Service";
        $data["url_img_post"] = create_url_preview("faq.png");    
        /**/
        /*CUANDO SE SOLICITA LA RESPUESTA ALGÚN FAQ POR ID*/        
        if($flag_busqueda_q ==  1){
            
            $respuesta =  $this->principal->get_faq($faq , $session );
            $data["respuesta"] =  $respuesta;            
            $info_respuesta = $respuesta[0];


            $id_faq =  $info_respuesta["id_faq"];
            $id_categoria =  $info_respuesta["id_categoria"];    
            
            $titulo =  $info_respuesta["titulo"];
            
            $data["meta_keywords"] =  $titulo;
            $data["desc_web"] =  $titulo;
            $data["url_img_post"] = "http://enidservice.com/inicio/imgs/index.php/enid/img_faq/".$id_faq."/";
            $resp_sim_faq = $this->principal->get_respuestas_similares($id_faq , $id_categoria);
            $data["r_sim"] =  $resp_sim_faq;                          
            /**/            
        }

        



        $flag_categoria = get_info_categoria($categoria);                           
        $data["flag_categoria"]  =  $flag_categoria;    
        /*Cuando la personas ve las respuestas por categorías*/        
        if ($flag_categoria == 1){            
            
            $id_categoria =  $categoria;
            $resumen_respuestas = $this->principal->get_faqs_categoria($id_categoria , $data);            
            $data["faqs_categoria"] = $resumen_respuestas;     

            /**/
            $info_categoria =  $this->principal->get_info_categoria($id_categoria);
            
            $data["meta_keywords"] =  " Preguntas frecuentes, ".$info_categoria["nombre_categoria"].", ";
            $data["desc_web"] =  " Preguntas frecuentes, ".$info_categoria["nombre_categoria"];
            $data["url_img_post"] = create_url_preview("faq.png");            
            /**/
        }
        /**/




        $flag_busqueda_personalidaza =  get_info_serviciosq($faqs);     
        $data["flag_busqueda_personalidaza"] =  $flag_busqueda_personalidaza;        

        /*CUANDO LA PERSONA REALIZA BÚSQUEDA DE FORMA PERSONALIZADA*/        
        if ($flag_busqueda_personalidaza ==  1){
                    
            $resumen_respuestas = $this->principal->get_faqs_q_personalizada($faqs , $data );
            $data["flag_categoria"] =1;   
            $data["faqs_categoria"] =  $resumen_respuestas;        
                        
        }    
        $clasificaciones_departamentos =   $this->get_departamentos("nosotros");        
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;            
        $this->principal->show_data_page($data, 'home');                          
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
                $data["perfilactual"] =  
                $this->sessionclass->getnameperfilactual();                
                $data["in_session"] = 1;
                $data["no_publics"] =1;
                $data["meta_keywords"] =  "";
                $data["url_img_post"]= "";
                $data["id_usuario"] = $this->sessionclass->getidusuario();                     
                $data["id_empresa"] =  $this->sessionclass->getidempresa();                     
                $data["info_empresa"] =  $this->sessionclass->get_info_empresa();                     
                $data["perfil"] = $this->sessionclass->getperfiles();
                $data["desc_web"] =  "";
                return $data;
                                
        }else{  

            $data['titulo']=$titulo_dinamico_page;              
            $data["in_session"] = 0;                                    
            $data["id_usuario"] ="";
            $data["perfilactual"] =0;
            $data["meta_keywords"] =  "";
            $data["url_img_post"] =  "";
            $data["desc_web"] =  "";
            $data["perfil"]= "";
            
            return $data;
        } 
        /**/  
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