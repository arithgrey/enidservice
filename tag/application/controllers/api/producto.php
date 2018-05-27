<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class producto extends REST_Controller{
    public $options;      
    function __construct($options=[]){
        parent::__construct();                                      
        $this->load->helper("q"); 
        $this->load->model("qmodel");             
        $this->load->library("pagination");  
        $this->load->model("clasificacion_model");	
        $this->load->library('restclient');
        $this->load->library('sessionclass');
    }    
    /*Cargamos el número de productos en venta de una persona*/
    function productos_en_venta_GET(){
        
        $param =  $this->get(); 
        $db_response = $this->qmodel->carga_productos_en_venta_usuario($param);
        $this->response($db_response);
    }
    /*Regresa información basica del servicio, en caso de estar disponible*/
    function info_disponibilidad_servicio_GET(){
        $param=  $this->get(); 
        $result =  $this->qmodel->get_informacion_basica_servicio_disponible($param);
        $this->response($result);
    }  
    /**/
    function articulos_disponibles_GET(){        
        $param =  $this->get();
        $db_response =  
        $this->qmodel->consulta_numero_articulos_disponibles_por_id_servicio($param["id_servicio"]);
        $this->response($db_response);
    }     
    /**/
    private function get_option($key){
        return $this->options[$key];
    }    
    /**/
    private function set_option($key , $value){
        $this->options[$key] = $value;
    }
    /**/
    function producto_por_clasificacion_GET(){

        $param =  $this->get();
        $servicios =  $this->qmodel->get_producto_por_clasificacion($param);
        $response =  $this->agrega_costo_envio($servicios);        
        $this->response($response);
        
    }    
    /**/
    function agregar_precios_en_servicio($servicios){

        $nueva_data =[];
        $a =0;
        foreach ($servicios as $row){

            $nueva_data[$a] =  $row;
            $a ++;
        }
        return $nueva_data;
    }    
    /********************************************************/
    function q_GET(){
        
        $param =  $this->get();        
                
        $id_usuario=($this->sessionclass->is_logged_in())?
        $this->sessionclass->getidusuario():
        get_info_variable($param , "id_usuario" );
        




        $param["id_usuario"] =  $id_usuario;
        $this->registra_keyword($param);                                           
            /**/            
            $servicios_complete =  $this->qmodel->busqueda_producto($param);            
            
            if( count($servicios_complete["servicio"])>0 ){

                $servicios =  $this->agrega_costo_envio($servicios_complete["servicio"]);         
                $data["servicios"] = $servicios;            

                $data["url_request"] =  $this->get_url_request(""); 
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
    /**/
    function agrega_costo_envio($servicios){
        
        
        $nueva_data =[];
        $a =0;
        foreach($servicios as $row){
            
            $nueva_data[$a] = $row;                        
            $flag_servicio =  $row["flag_servicio"];
            
            if($flag_servicio == 0){
                $prm["flag_envio_gratis"] =  $row["flag_envio_gratis"];
                $nueva_data[$a]["costo_envio"] = $this->calcula_costo_envio($prm);    
            } 
            
            $a ++;
        }        
        return $nueva_data;
        
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
    /**/
    function servicios_empresa_GET(){
        

        if($this->input->is_ajax_request() OR $_SERVER['HTTP_HOST'] ==  "localhost"){ 
            
            $param =  $this->get();                                     
            $param["q"]= $this->get("q");
            $param["id_usuario"] =  $this->sessionclass->getidusuario();  
            $param["id_clasificacion"] = get_info_variable($param , "q2" );   
            $param["extra"]= $param;            
            $param["resultados_por_pagina"] =12;
            $param["agrega_clasificaciones"] = 0;
            $param["vendedor"]=0;
            $servicios =  $this->get_servicios_empresa($param);        

            if (count($servicios) > 0){    
                if($servicios["num_servicios"] > 0){                                    
                        
                        $config_paginacion["totales_elementos"] =  
                        $servicios["num_servicios"];
                        
                        $config_paginacion["per_page"] = 12;
                        $config_paginacion["q"] = $param["q"];                                
                        $config_paginacion["q2"] = 0;   
                        $config_paginacion["page"] = 
                        get_info_variable($this->input->get() , "page" );

                        $data["busqueda"] =  $param["q"];                                             
                        $data["num_servicios"] =  $servicios["num_servicios"];

                        $this->set_option("in_session" , 1);
                        $this->set_option("id_usuario" , $this->sessionclass->getidusuario());

                        $data["lista_productos"]= 
                        $this->agrega_vista_servicios($servicios["servicios"]);
                        $data["paginacion"]= $this->create_pagination($config_paginacion);
                        $this->load->view("producto/basico_empresa" , $data);                    
                }
                
            }else{     

                /**/
                $data_complete["num_servicios"] = 0;            
                $data_complete["info_servicios"] = "
                                <i class='fa fa-search'>
                                </i>
                                Tu búsqueda de 
                                <strong> ".$param["q"]." </strong>(0 Productos) ";
                
                $this->response($data_complete);
            }    
            
        }else{
            $this->response("error");
        }

    }  
    function create_pagination($q){
        
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("producto/paginacion/format/json/" , $q);                
        $response =  $result->response;
        return json_decode($response, true);            
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
        $servicio["id_usuario"] =  $this->get_option("id_usuario");

        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = $this->restclient->get("producto/crea_vista_producto/format/html/" , $servicio);
        return   $result->response;        
    }
    /**/
    function get_servicios_empresa($param){

        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("producto/q/format/json/" , $param);        
        $response =  $result->response;        
        return json_decode($response , true);
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

    /*
    function add_precio_publico($servicios){
    
        $nueva_data =[];
        $a =0;
        foreach($servicios as $row){
            
            $precio =  $row["precio"];
            $nueva_data[$a] = $row;
            $precio_publico =  $this->get_precio_venta($precio);  
            $nueva_data[$a]["precio_publico"] = $precio_publico;            
      
            $a ++;
        }
        return $nueva_data;

    }
    */
    /*
    function agrega_precio_publico($servicios){
      
        $nueva_data =[];
        $a =0;
        foreach($servicios as $row){
            
            $flag_servicio =  $row["flag_servicio"];
            $precio_publico = 0;

      
            if($flag_servicio ==  0){
                $precio =  $row["precio"];
                $precio_publico =  $this->get_precio_venta($precio);      
            }else{

                $id_ciclo_facturacion =  $row["id_ciclo_facturacion"];                
                if($id_ciclo_facturacion  != 9){
                    $precio =  $row["precio"];
                    $precio_publico =  $this->get_precio_venta($precio);        
                }
            }            
            $nueva_data[$a] = $row;
            $nueva_data[$a]["precio_publico"] = $precio_publico;            
            $a ++;
        }
        $this->set_option("servicios" , $nueva_data);
    }
    */
    function registra_keyword($param){        
        if(array_key_exists("q", $param) >0 && strlen(trim($param["q"]))>1 ){
            $this->qmodel->registra_keyword($param);   
        }            
        
    }
    /**/
    function basic_servicio_GET(){
    /**/        
        $param = $this->get();
        $response = $this->qmodel->get_basic_servicio($param);
        $this->response($response);
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
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /*
    function get_precio_venta($precio){


        $q["precio"] =  $precio;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("cobranza/calcula_precio_producto/format/json/" , $q);        
        $response =  $result->response;        
        return json_decode($response , true);
    }
    */
    /**/
    function crea_vista_producto_GET(){        
        
        $data["servicio"] = $this->get();        
        $data["url_request"]=  $this->get_url_request("");                
        $this->load->view("producto/basico" , $data);
    }
    /**/
    function paginacion_GET(){
        
        $param = $this->get();        
        $totales_elementos =  $param["totales_elementos"];
        $per_page =  $param["per_page"]; 
        
        $q = $param["q"];        
        $base_url = "?q=$q";
        if(isset($param["q2"]) && $param["q2"] >0){
            $q2 = $param["q2"];    
            $base_url .= "&q2=$q2";
        }if(isset($param["q3"]) && $param["q3"] >0){
            $q3 = $param["q3"];    
            $base_url .= "&q3=$q3";
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
    function periodo_GET(){
        /**/
        $param = $this->get();
        $servicios =  $this->qmodel->get_servicios_periodo_simple($param);
        $data["servicios"]= $servicios;
        $this->load->view("producto/simple" , $data);        
    }    
    /**/
    function es_servicio_usuario_GET(){
        $param =  $this->get();
        $this->response($this->qmodel->valida_servicio_usuario($param));
    }
    /**/
    function producto_por_id_GET(){

        $param =  $this->get();
        $this->response($this->qmodel->get_producto_por_id($param));       
    }
    /**/
    function lista_deseos_PUT(){
        
        $param               =            $this->put();
        $param["id_usuario"] =  $this->sessionclass->getidusuario();          
        $response            =  $this->qmodel->add_lista_deseos($param);
        $this->response($response);
    }
    /**
     * 
     */
    function lista_deseos_GET(){    
        $param = $this->get();
        $response =  $this->qmodel->get_productos_deseados_usuario($param);
        $this->response($response);
    }
    /**/
    function lista_deseos_periodo_GET(){            
        $param = $this->get();     
        $data["productos_deseados"]=$this->qmodel->get_productos_deseados_periodo($param);   
        $data["extra"] =  $param;
        $this->load->view("producto/lista_deseos" , $data);
    }

}?>
