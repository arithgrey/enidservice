<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    public $options;    
    function __construct(){        
        parent::__construct();                            
        $this->load->library("principal");           
        $this->load->library("restclient");        
        $this->load->library('sessionclass');     
    }       
    function set_option($key, $value){
        $this->options[$key] = $value;
    }
    /**/
    function get_option($key){
        return  $this->options[$key];
    }
    /**/   
    function index(){
        
        $data = $this->val_session("¿Necesitas que más clientes encuentren tu negocio?");                    
        $data["meta_keywords"] = "Comprar, vender, ciudad de México, página web, tienda en linea";
        $data["desc_web"] = "";
        $data["url_img_post"] = create_url_preview("promo.png");        
        $data["clasificaciones_departamentos"] = 
        $this->carga_data_clasificaciones_busqueda();
        /**/
        $num_hist= get_info_servicio( $this->input->get("q"));                
        $q=  $this->input->get("q");
        /**/        
        $prm =  $this->input->get();
        $id_clasificacion =  get_info_variable($prm , "q2" );   
        /*usuario que promociona*/
        $vendedor =  get_info_variable($prm , "q3" );           
        /**/

        $data_send["q"]= $q;
        $data_send["vendedor"] = $vendedor;
        $data_send["id_clasificacion"] =  $id_clasificacion;        
        $data_send["extra"]= $this->input->get();    
        $per_page = 12;        
        
        $data_send["resultados_por_pagina"] =$per_page;
        
        $data_send["agrega_clasificaciones"] = 1;
        $data_send["in_session"] = 0;        
        $servicios=  $this->busqueda_producto_por_palabra_clave($data_send);

        
        $data["servicios"] =  $servicios;

        
                
        if ($servicios["num_servicios"] > 0) {
            
          
            $data["url_request"]=  $this->get_url_request("");
            $data["busqueda"] =  $q;     
            
            $totales_elementos=  $data["servicios"]["num_servicios"];    
            $data["num_servicios"] =  $totales_elementos;
            $this->crea_menu_lateral($data["servicios"]["clasificaciones_niveles"]);
            $data["bloque_busqueda"] =  $this->get_option("bloque_busqueda");
            $this->principal->crea_historico($num_hist);
            
            $config_paginacion["totales_elementos"] =  $totales_elementos;
            $config_paginacion["per_page"] = $per_page;
            $config_paginacion["q"] = $q;            
            $config_paginacion["q2"] = $id_clasificacion;   
            $config_paginacion["q3"] = $vendedor;
            $config_paginacion["page"] = get_info_variable($this->input->get() , "page" );

            $data["paginacion"]= $this->create_pagination($config_paginacion);

            $this->set_option("in_session" ,  0);
            $data["lista_productos"]= $this->agrega_vista_servicios($servicios["servicios"]);
            $data["q"] =$q;  
            $this->principal->show_data_page($data , 'home');                              

        }else{
            $this->principal->crea_historico($num_hist);
            $this->principal->show_data_page($data , 'sin_resultados');                              
        } 
        

    }
    /**/
    function agrega_vista_servicios($data_servicio){

        $data_complete = [];
        $a = 0;
        foreach ($data_servicio as $row){        
            $data_complete[$a] =  $this->get_vista_servicio($row);

            $a ++;            
        }
        return $data_complete;
    }
    /**/
    function get_vista_servicio($servicio){

        $servicio =  $servicio;
        $servicio["in_session"] =  $this->get_option("in_session");        
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = $this->restclient->get("producto/crea_vista_producto/format/html/" , $servicio);
        return   $result->response;        
    }
    /**/   
    function create_pagination($q){
        /**/
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("producto/paginacion/format/json/" , $q);                
        $response =  $result->response;
        return json_decode($response, true);            
    }
    /**/
    function crea_menu_lateral($clasificaciones_niveles){
        
        $primer_nivel = $clasificaciones_niveles["primer_nivel"];
        $segundo_nivel = $clasificaciones_niveles["segundo_nivel"];
        $tercer_nivel = $clasificaciones_niveles["tercer_nivel"];
        $cuarto_nivel = $clasificaciones_niveles["cuarto_nivel"];
        $quinto_nivel = $clasificaciones_niveles["quinto_nivel"];
        /**/
        
        $bloque["primer_nivel"] =  $this->get_info_bloque($primer_nivel);
        $bloque["segundo_nivel"]=  $this->get_info_bloque($segundo_nivel);
        $bloque["tercer_nivel"]=  $this->get_info_bloque($tercer_nivel);
        $bloque["cuarto_nivel"]=  $this->get_info_bloque($cuarto_nivel);
        $bloque["quinto_nivel"]=  $this->get_info_bloque($quinto_nivel);
        $this->set_option("bloque_busqueda" , $bloque);
        
        
    }
    function get_info_bloque($info){
        $info_bloque =[];
        
        for($a=0; $a <count($info); $a++){             

            $id_clasificacion =  $info[$a]["id_clasificacion"];            
            if($id_clasificacion > 0){

                $info_clasificacion =  $this->get_info_clasificacion($id_clasificacion);    
                array_push($info_bloque, $info_clasificacion);
            }
        }
        /**/
        return $info_bloque;
    }
    /**/
    function busqueda_producto_por_palabra_clave($q){

        /****************************/
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("producto/q/format/json/" , $q);        
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    function carga_data_clasificaciones_busqueda(){
        $clasificaciones_departamentos =   $this->get_departamentos("nosotros");        
        return $clasificaciones_departamentos;        
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
            $data["id_usuario"] ="";                                   
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
    function get_info_clasificacion($id_clasificacion){

        $q["id_clasificacion"] =  $id_clasificacion;
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("clasificacion/info_clasificacion/format/json/" , $q);        
        $response =  $result->response;        
        return json_decode($response , true );
    }
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
}