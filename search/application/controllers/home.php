<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    public $options;    
    function __construct(){        
        parent::__construct();       
        $this->load->helper("search");      
        $this->load->library(lib_def());                              
    }       
    private function set_option($key, $value){
        $this->options[$key] = $value;
    }    
    private function get_option($key){
        return  $this->options[$key];
    }    
    function index(){           
                
        $param                      =  $this->input->get();
        $param["id_clasificacion"]  =  get_info_variable($param , "q2" );               
        $param["vendedor"]          =  get_info_variable($param , "q3" );        
        $q                          =  get_param_def($param     , "q", "");    
        $param["num_hist"]          =  get_info_servicio($q);                        
        $this->load_data($param);    
        
    }
    private function load_data($param){
        

        $data                           = 
        $this->principal->val_session("¿Necesitas que más clientes encuentren tu negocio?");
        $data["meta_keywords"]          =   "Comprar y vender tus artículos y servicios";
        $data["desc_web"]               =   "";
        $data["url_img_post"]           =   create_url_preview("promo.png");
    
        $q                              =  (array_key_exists("q", $param)) ?$param["q"] :""; 

        $data_send["q"]                 = $q; 
        $data_send["vendedor"]          = $param["vendedor"];
        $data_send["id_clasificacion"]  =  $param["id_clasificacion"];
        $data_send["extra"]             = $param;
        $data_send["order"]             = 
        (array_key_exists("order", $param))?$param["order"]:11;

        $per_page = 12;        
        $data_send["resultados_por_pagina"]     =   $per_page;        
        $data_send["agrega_clasificaciones"]    = 1;
        $data_send["in_session"] = 0;

        
        if($this->agent->is_mobile()){
            $data_send["agrega_clasificaciones"] =0;
            $data["clasificaciones_departamentos"] =  "";
            
        }else{
            $data["clasificaciones_departamentos"] = 
            $this->principal->get_departamentos("");
            
        }
        
        $servicios              =  $this->busqueda_producto_por_palabra_clave($data_send);        
        $categorias_destacadas  =  $this->carga_categorias_destacadas();            
        //debug($categorias_destacadas , 1);
        $data["servicios"]      =  $servicios;



        if ($servicios["num_servicios"] > 0) {
            
            $data["url_request"]        =  get_url_request("");
            $data["busqueda"]           =  $q;
            $totales_elementos          =  $data["servicios"]["num_servicios"];
            $data["num_servicios"]      =  $totales_elementos;
            $data["bloque_busqueda"]    =   "";
            $data["es_movil"]           =  1;

            
            if($this->agent->is_mobile() == FALSE) {
                
                $this->crea_menu_lateral($data["servicios"]["clasificaciones_niveles"]);
                $data["bloque_busqueda"] =  $this->get_option("bloque_busqueda");
                $data["es_movil"] =  0;
            }
            
            $this->principal->crea_historico($param["num_hist"]);

            $config_paginacion["totales_elementos"] =  $totales_elementos;
            $config_paginacion["per_page"]  =   $per_page;
            $config_paginacion["q"]         =   $q;
            $config_paginacion["q2"]        =   $param["id_clasificacion"];
            $config_paginacion["q3"]        =   $param["vendedor"];
            $config_paginacion["order"]     =   $data_send["order"];
            $config_paginacion["page"]      =   get_info_variable($param , "page" );            
            $data["paginacion"]             =   
            $this->create_pagination($config_paginacion);            

            $this->set_option("in_session" , 0);

            

            $data["lista_productos"]        =   $this->agrega_vista_servicios($servicios["servicios"]);
            $data["q"]                      =   $q;
            $data["categorias_destacadas"]  =   $categorias_destacadas;
            $data["css"]                    =   [ "search_main.css" , 
                                                    "css_tienda.css",
                                                    "producto.css"
                                                ];

            $data["js"]     = ["../js_tema/search/principal.js"];

            $data["filtros"] =  $this->get_orden();
            $data["order"]   = $config_paginacion["order"];
            $this->principal->show_data_page($data, 'home');
            
        }else{
            
            $data["css"]        = ["search_sin_encontrar.css"];
            $tienda             = get_param_def($param , "tienda");
            $this->principal->crea_historico($param["num_hist"]);
            if ($tienda == 0) {
                $this->principal->show_data_page($data , 'sin_resultados');    
            }else{
                $this->principal->show_data_page($data , 'sin_resultados_tienda');    
            }            
        }    
        
    }
    /**/
    private function get_vista_servicio($servicio){
        
        $q               =  $servicio;
        $q["in_session"] =  $this->get_option("in_session");                
        $api             =  "servicio/crea_vista_producto/format/html/";
        return $this->principal->api( $api, $q , 'html'); 
    }
    /**/   
    private function create_pagination($q){        
        $api =  "producto/paginacion/format/json/";
        return $this->principal->api( $api, $q); 
    }
    /**/
    private function crea_menu_lateral($clasificaciones_niveles){
        
        
        $primer_nivel   = $clasificaciones_niveles["primer_nivel"];
        $segundo_nivel  = $clasificaciones_niveles["segundo_nivel"];
        $tercer_nivel   = $clasificaciones_niveles["tercer_nivel"];
        $cuarto_nivel   = $clasificaciones_niveles["cuarto_nivel"];
        $quinto_nivel   = $clasificaciones_niveles["quinto_nivel"];
        
        $bloque["primer_nivel"] =  $this->get_info_bloque($primer_nivel);
        $bloque["segundo_nivel"]=  $this->get_info_bloque($segundo_nivel);
        $bloque["tercer_nivel"]=  $this->get_info_bloque($tercer_nivel);
        $bloque["cuarto_nivel"]=  $this->get_info_bloque($cuarto_nivel);
        $bloque["quinto_nivel"]=  $this->get_info_bloque($quinto_nivel);
        $this->set_option("bloque_busqueda" , $bloque);
        
        
    }
    private function get_info_bloque($info){
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
    private function busqueda_producto_por_palabra_clave($q){        
        $api =  "servicio/q/format/json/";        
        return $this->principal->api( $api, $q);
    }
    /**/
    private function logout(){                      
        $this->principal->logout();      
    }         
    private function get_info_clasificacion($id_clasificacion){

        $q["id_clasificacion"] =  $id_clasificacion;
        $api                   = "clasificacion/id/format/json/";
        return $this->principal->api( $api, $q);
    }
    /**/
    private function carga_categorias_destacadas($q=''){
        
        $q      =   [];
        $api    =   "clasificacion/categorias_destacadas/format/json/";
        return $this->principal->api( $api, $q);
    }
    /**/
    private function get_orden(){
        $response =["ORDENAR POR",
                    "Las novedades primero",
                    "Lo     más vendido",
                    "Los más votados",
                    "Los más populares ",
                    "Precio [de mayor a menor]",
                    "Precio [de menor a mayor]",
                    "Nombre del producto [A-Z]",
                    "Nombre del producto [Z-A]",
                    "Sólo servicios",
                    "Sólo productos"];
        return $response;
    }
      function agrega_vista_servicios($data_servicio){
    $data_complete = [];
    $a = 0;
    foreach ($data_servicio as $row){        
      $data_complete[$a] =  $this->get_vista_servicio($row);
      $a ++;            
    }
    return $data_complete;
  }  
}