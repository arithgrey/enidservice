<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    public $options;    
    private $id_usuario;
    function __construct(){        
        parent::__construct();       
        $this->load->helper("search");      
        $this->load->library(lib_def());                              
        $this->id_usuario = $this->principal->get_session("idusuario");
    }       

    function index(){           
                
        $param                      =  $this->input->get();
        $param["id_clasificacion"]  =  get_info_variable($param , "q2" , 1 );               
        $param["vendedor"]          =  get_info_variable($param , "q3"  , 1);        
        $q                          =  get_param_def($param     , "q", "" , 1);            
        evita_basura($q);
        $param["num_hist"]          =  get_info_servicio($q);                        

        $this->load_data($param);                
    }
    private function load_data($param){
        

        $data                           =   $this->principal->val_session("");
        $data["meta_keywords"]          =   "Comprar y vender tus artículos y servicios";
        $data["desc_web"]               =   "";
        $data["url_img_post"]           =   create_url_preview("promo.png");        
        $q                              =   (array_key_exists("q", $param)) ?$param["q"] :"";
        $data_send["q"]                 =   $q; 
        $data_send["vendedor"]          =   $param["vendedor"];
        $data_send["id_clasificacion"]  =   $param["id_clasificacion"];
        $data_send["extra"]             =   $param;
        $data_send["order"]             =   get_param_def($param , "order" ,  11 , 1);
        $per_page                       =   8;
        $data_send["resultados_por_pagina"]     =   $per_page;        
        $data_send["agrega_clasificaciones"]    =   1;
        $data_send["in_session"] = 0;

        
        if($this->agent->is_mobile()){

            $data_send["agrega_clasificaciones"]    =  0;
            $data["clasificaciones_departamentos"]  =  "";
            
        }else{

            $data["clasificaciones_departamentos"] = $this->principal->get_departamentos("");

        }
        $servicios              =  $this->busqueda_producto_por_palabra_clave($data_send);
        $data["servicios"]      =  $servicios;

        if ($servicios["num_servicios"] > 0) {

            $this->muetra_servicios($data , $param, $q, $data_send , $servicios, $per_page);

        }else{
            $this->muestra_sin_resultados($param, $data);
        }    
        
    }
    private function muestra_sin_resultados($param, $data){

        $data["css"]        = ["search_sin_encontrar.css"];
        $tienda             = get_param_def($param , "tienda" , 1);
        if ($tienda == 0) {
            $this->principal->show_data_page($data , 'sin_resultados');
        }else{
            $this->principal->show_data_page($data , 'sin_resultados_tienda');
        }
    }
    private function muetra_servicios($data , $param, $q , $data_send , $servicios, $per_page){

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



        $data["paginacion"]  =  $this->create_pagination($totales_elementos,
            $per_page,
            $q ,
            $param["id_clasificacion"],
            $param["vendedor"] ,
            $data_send["order"] ,
            get_info_variable($param , "page" )
        );

        $this->set_option("in_session" , 0);


        $categorias_destacadas          =   $this->carga_categorias_destacadas();
        $data["lista_productos"]        =   $this->agrega_vista_servicios($servicios["servicios"]);
        $data["q"]                      =   $q;
        $data["categorias_destacadas"]  =   $categorias_destacadas;
        $data["css"]                    =   [ "search_main.css" ,
            "css_tienda.css",
            "producto.css"
        ];


        $data["js"]         =   ["search/principal.js"];
        $data["filtros"]    =   $this->get_orden();
        $data["order"]      =   $data_send["order"];
        $this->create_keyword($param);
        $this->principal->show_data_page($data, 'home');
    }
    private function set_option($key, $value){
        $this->options[$key] = $value;
    }
    private function get_option($key){
        return  $this->options[$key];
    }
    private function get_vista_servicio($servicio){
        
        $q               =  $servicio;
        $q["in_session"] =  $this->get_option("in_session");                
        $api             =  "servicio/crea_vista_producto/format/html/";
        return $this->principal->api( $api, $q , 'html'); 
    }
    private function create_pagination($totales_elementos ,  $per_page , $q , $id_clasificacion, $vendedor ,  $order , $page){
        $config["totales_elementos"] =   $totales_elementos;
        $config["per_page"]          =   $per_page;
        $config["q"]                 =   $q;
        $config["q2"]                =   $id_clasificacion;
        $config["q3"]                =   $vendedor;
        $config["order"]             =   $order;
        $config["page"]              =   $page;        
        return $this->principal->create_pagination($config);
    }
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


        return $info_bloque;
    }
    private function busqueda_producto_por_palabra_clave($q){        
        $api =  "servicio/q/format/json/";        
        return $this->principal->api( $api, $q);
    }
    private function logout(){                      
        $this->principal->logout();      
    }         
    private function get_info_clasificacion($id_clasificacion){

        $q["id_clasificacion"] =  $id_clasificacion;
        $api                   = "clasificacion/id/format/json/";
        return $this->principal->api( $api, $q);
    }
    private function carga_categorias_destacadas($q=''){
        
        $q      =   [];
        $api    =   "clasificacion/categorias_destacadas/format/json/";
        return $this->principal->api( $api, $q);
    }
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
    private function agrega_vista_servicios($data_servicio){
        $data_complete = [];
        $a = 0;
        foreach ($data_servicio as $row){
            $data_complete[$a] =  $this->get_vista_servicio($row);
            $a ++;
        }
        return $data_complete;
  }  
  private function create_keyword($q){

    if(array_key_exists("q", $q)){

        if ($this->id_usuario > 0) {
            $q["id_usuario"] =  $this->id_usuario;
        }
        $api          =  "keyword/index";
        return $this->principal->api($api , $q, "json" , "POST");
    }

  }

}