<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class producto extends REST_Controller{
    public $options;      
    private $id_usuario;
    function __construct($options=[]){
        parent::__construct();                                      
        $this->load->helper("q"); 
        $this->load->helper("tag"); 
        //$this->load->model("qmodel");             
        $this->load->library("pagination");  
        //$this->load->model("clasificacion_model");	
        $this->load->library(lib_def());
        $this->id_usuario =  $this->principal->get_session("idusuario");
        
    }    
    
   
    /**/
    
    /*
     private function get_option($key){
        return $this->options[$key];
    }    
    
    private function set_option($key , $value){
        $this->options[$key] = $value;
    }
    function agregar_precios_en_servicio($servicios){

        $nueva_data =[];
        $a =0;
        foreach ($servicios as $row){

            $nueva_data[$a] =  $row;
            $a ++;
        }
        return $nueva_data;
    } 
    */   
    /********************************************************/
    /*
    function q_GET(){
        
        
        $param =  $this->get();        
        $id_usuario = 
        ($this->principal->is_logged_in())?
        $this->id_usuario:get_info_variable($param , "id_usuario" );

        $param["id_usuario"] =  $id_usuario;
        $this->registra_keyword($param);
                     
            $servicios_complete =  $this->qmodel->busqueda_producto($param);
            if( count($servicios_complete["servicio"])>0 ){

                $servicios =  
                $this->agrega_costo_envio($servicios_complete["servicio"]);         
                $data["servicios"] = $servicios;            
                $data["url_request"] =  get_url_request(""); 
                $data["num_servicios"] =  $servicios_complete["num_servicios"];                
                if($param["agrega_clasificaciones"] == 1){
                    $data["clasificaciones_niveles"] =  
                    $servicios_complete["clasificaciones_niveles"];    
                }                          
                $this->response($data);                         
                
                
            }else{
                $data["num_servicios"] =0;
                $this->response($data);         
            } 
            
                        
    }
    */

    /*
    function qmetakeyword_GET(){

        $param          =  $this->get();        
        $q              = (array_key_exists("q", $param))? $param["q"]:"";
        $param["q2"]    = 0;
        $param["q"]     = $q;
        $param["order"] =  1;
        $param["id_clasificacion"]  =1;
        $param["id_usuario"]        =0;
        $param["vendedor"]          =0;
        $param["resultados_por_pagina"]     = $param["limit"];
        $param["agrega_clasificaciones"]    =0;
        $servicios =  $this->qmodel->busqueda_producto($param);

        if (count($servicios)>0) {
            $response = $this->agrega_costo_envio($servicios["servicio"]);
            $this->response($response);    
        }else{
            $this->response(array());    
        }        
    }
    */
    function agrega_costo_envio($servicios){
        
        
        $nueva_data =[];
        $a =0;
        foreach($servicios as $row){
            
            $nueva_data[$a] = $row;                        
            $flag_servicio =  $row["flag_servicio"];
            
            if($flag_servicio == 0){
                $prm["flag_envio_gratis"] =  $row["flag_envio_gratis"];
                $nueva_data[$a]["costo_envio"] = 
                $this->principal->calcula_costo_envio($prm);    
            } 
            
            $a ++;
        }        
        return $nueva_data;
        
    }     
    /**/
    function get_servicios_empresa($q){

        $api  =  "producto/q/format/json/";
        return  $this->principal->api($api , $q);  
    }
    /***/
    function agrega_precio_servicio_publico(){
    

        $servicios =  $this->get_option("servicios");
        $nueva_data =[];
        $a =0;
        foreach($servicios["servicio"] as $row){
            
            $precio =  $row["precio"];
            $nueva_data[$a] = $row;
            $precio_publico =  $this->get_precio_venta($precio);  
            $nueva_data[$a]["precio_publico"] = $precio_publico;            
            /***/           

            $a ++;
        }
        $this->set_option("servicios" , $nueva_data);

    }

  
    function registra_keyword($param){        
        if(array_key_exists("q", $param) >0 && strlen(trim($param["q"]))>1 ){
            $api = "metakeyword/registro";
            $this->principal->api( $api , $param, "json", "POST");
        }            
        
    }    
    
    function get_precio_calculado_productos($info){

        $data =  $info;
        $nueva_data = [];

        $x =0;
        foreach($info as $row){
            
            $precio_publico =  $this->get_precio_venta($row["precio"]);
      
            $nueva_data[$x] = array(
                    "id_servicio" =>  $row["id_servicio"],
                    "nombre_servicio" =>  $row["nombre_servicio"],
                    "flag_servicio" =>  $row["flag_servicio"],
                    "flag_envio_gratis" =>  $row["flag_envio_gratis"],
                    "flag_precio_definido"  =>  $row["flag_precio_definido"],
                    "fecha_registro" =>  $row["fecha_registro"],
                    "precio" =>  $row["precio"],                    
                    "precio_publico" => $precio_publico 
                );

            $x ++;

        }         
        return $nueva_data;
    }
   
    
    /**/
    function paginacion_GET(){
        
        $param              =  $this->get();        
        $totales_elementos  =  $param["totales_elementos"];
        $per_page           =  $param["per_page"]; 
        
        $q                  = $param["q"];        
        $base_url           = "?q=$q";
        if(isset($param["q2"]) && $param["q2"] >0){
            $q2 = $param["q2"];    
            $base_url .= "&q2=$q2";
        }if(isset($param["q3"]) && $param["q3"] >0){
            $q3 = $param["q3"];    
            $base_url .= "&q3=$q3";
        }

        if (array_key_exists("order", $param)) {
            $base_url .= "&order=".$param["order"];
        }

        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';        
        $config['cur_tag_open'] = '<li class="active"><span>';
        $config['cur_tag_close'] = '<span></span></span></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';        
        $config['prev_link'] = '‹';
        $config['last_link'] = '»';
        $config['next_link'] = '<span class="white">›</span>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>'; 
        $config['per_page'] = $per_page;
        $config['base_url'] = $base_url;    
        $config['num_links'] = 10;     
        $config['first_link'] = '<span class="white">« Primera</span>';
        $config['last_link'] = '<span class="white">Última»</span>';
        $config['total_rows'] = $totales_elementos;                
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;     
        $config['enable_query_strings'] = TRUE;                
        $config['query_string_segment'] = 'page';

        $this->pagination->initialize($config);        
        $paginacion =   $this->pagination->create_links();  
        $this->response($paginacion);
    }
    /**/
    function get_servicios_periodo_simple($q){
        
        $api    =  "servicio/periodo/format/json/";
        return $this->principal->api( $api , $q );
    }
    /**/
    function periodo_GET(){        
        $param              = $this->get();        
        $data["servicios"]  = $this->get_servicios_periodo_simple($param);
        $this->load->view("producto/simple" , $data);        
    }    

    /*
    function es_servicio_usuario_GET(){
        $param =  $this->get();
        $this->response($this->qmodel->valida_servicio_usuario($param));
    }
    */
    /*
    function producto_por_id_GET(){

        $param =  $this->get();
        $this->response($this->qmodel->get_producto_por_id($param));       
    }
    */
    /**/
    

    /**/
    
    function get_num_deseo_servicio_usuario($q){
        $api =  "usuario/num_deseo_servicio_usuario/format/json/";
        return $this->principal->api( $api , $q);
    }    
    
    function lista_deseos_periodo_GET(){            
        $param = $this->get();     
        $data["productos_deseados"]=$this->get_productos_interes($param);   
        $data["extra"] =  $param;
        $this->load->view("producto/lista_deseos" , $data);
    }
    /**/
    /**/
    function get_productos_interes($q){

        $api    =  "usuario/productos_interes/format/json";
        return $this->principal->productos_deseados_periodo("q", $api ,  $q);
    }

}?>