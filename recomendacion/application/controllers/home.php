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
    function index(){

        $param =  $this->input->get();
        $val  =  get_info_valor_variable( $param , "q" ); 
        
        if(ctype_digit($val)){
            $id_usuario =  $this->input->get("q");
            $data = $this->val_session("");
            $data["meta_keywords"] = '';
            $data["desc_web"] = "";                
            $data["url_img_post"] = create_url_preview("");
            
            
            $num_hist= get_info_servicio( $this->input->get("q"));            
            $num_usuario = get_info_usuario( $this->input->get("q2"));        
            $num_servicio = get_info_usuario( $this->input->get("q3"));        

            $this->principal->crea_historico(5669877 , $num_usuario , $num_servicio );         
            $clasificaciones_departamentos =   $this->get_departamentos("nosotros");    
            $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;   

            /**/
            $prm["id_usuario"] =  $id_usuario;
            /*Creamos la vista de recomendaciones*/
            $data_recomendacion =  $this->busqueda_recomendacion($prm);
            $data["usuario"] =  $this->busqueda_datos_basicos_vendedor($prm);            
            
            if(count($data["usuario"]) > 0){
                /**/

                if($data["in_session"] == 1 ){
                    $id_usuario_actual =  $this->sessionclass->getidusuario();
                    /**/
                   
                    $this->notifica_lectura($id_usuario , $id_usuario_actual);    
                }
                
                /**/
                $data["resumen_recomendacion"] =  
                $data_recomendacion["info_valoraciones"];    

                /*Se crea la data*/             
                $prm["page"] = get_info_valor_variable($this->input->get() , "page");
                $prm["resultados_por_pagina"] =  5;
                $data["resumen_valoraciones_vendedor"] =  $this->resumen_valoraciones_vendedor($prm);
                $prm["totales_elementos"] = $data_recomendacion["data"][0]["num_valoraciones"];

                $data["paginacion"] = "";
                if($prm["totales_elementos"] > $prm["resultados_por_pagina"]){
                    /*Mandamos a crear paginación cuando es más grande el resultado que lo que se 
                    solicita*/
                    $prm["per_page"] =  5; 
                    $prm["q"] = $id_usuario;
                    $data["paginacion"] =  $this->get_paginacion($prm);                
                }
                
                $data["css"] = array(base_url("application/css/principal.css"));
                $this->principal->show_data_page($data, 'home');                          
            
            }else{
                /*Se envia a otro al home*/            
                $this->go_home();
            }
        }else{
            /*Se envia a otro al home*/            
            $this->go_home();    
        }            
    }
    /**/
    function go_home(){
        redirect("../../", 'POST');
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
    private function busqueda_recomendacion($param){

        $url = "portafolio/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = $this->restclient->get("valoracion/usuario/format/json/" , $param);        
        $response =  $result->response;        
        return json_decode($response, true);        
    }
    private function busqueda_datos_basicos_vendedor($param){

        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/q/format/json/" , $param);        
        $response =  $result->response;        
        return json_decode($response , true);        
    }
    /**/
    private function resumen_valoraciones_vendedor($param){

        $url = "portafolio/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("valoracion/resumen_valoraciones_vendedor/format/json/" , 
            $param);        
        $response =  $result->response;        
        return json_decode($response , true);        
    }    
    /**/
    private function get_option($key ){
        return $this->option[$key];
    }
    /**/
    private function  set_option($key  , $value){ 
        $this->option[$key] =  $value;
    }    
    private function get_paginacion($param){

        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = 
        $this->restclient->get("producto/paginacion/format/json/" , $param);        
        $response =  $result->response;        
        return json_decode($response , true);        
    }
    /**/
    private function notifica_lectura($id_usuario , $id_usuario_valoracion){
            

        if($id_usuario ==  $id_usuario_valoracion) {
            $this->principal->actualiza_lectura_valoracion($id_usuario);    
        }
        

        /**/
    }

    /***/
}