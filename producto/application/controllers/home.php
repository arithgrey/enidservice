<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    public $options;  

    function __construct($options=[]){        
        parent::__construct();                                    
        $this->load->library("principal");   
        $this->load->library("restclient");  
        $this->load->model("producto_model");      
        $this->load->library('sessionclass');     
    }       
    private function set_option($key, $value){
        $this->options[$key] = $value;
    }
    /**/
    function get_option($key){
        return  $this->options[$key];
    }
    /**/
    function crea_data_costo_envio(){        
        $param["flag_envio_gratis"]=   $this->get_option("servicio")[0]["flag_envio_gratis"];   
        return $param;
    }
    /**/
    function index(){


        $id_servicio =  get_info_producto($this->input->get("producto"));                    
        $this->set_option("id_servicio" , $id_servicio);
        $data = $this->val_session("");  
        $clasificaciones_departamentos =   $this->get_departamentos("nosotros");        
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;        
        /**/
        if ($id_servicio == 0 ){      
            /**/
            $data["meta_keywords"]="";
            $data["desc_web"] ="";
            $data["url_img_post"]="";
            

            $this->principal->show_data_page($data, $this->get_vista_no_encontrado());
        }else{            
            $param =  $this->input->get();                            
            $data["desde_valoracion"] =  get_valor_variable($this->input->get() , "valoracion");
            $this->crea_vista_producto($param , $data);
        }        
    }
    /**/
    function crea_vista_producto($param , $data){
                

            $id_servicio =  $this->get_option("id_servicio");  
            $num_hist = get_info_servicio( $this->input->get("q"));                    
            $num_usuario = get_info_usuario( $this->input->get("q2"));        
            $num_servicio = get_info_usuario( $this->input->get("q3"));        
            $id_mensaje = get_info_usuario($this->input->get("q4"));
            $data["q2"] =  $num_usuario;            
            $servicio =  $this->get_informacion_basica_servicio($id_servicio);               
            /**/
            
            $nombre_usuario =  $this->get_nombre_usuario($servicio[0]["id_usuario"]);
            $data["nombre_usuario"] = $nombre_usuario; 
            $data["id_publicador"] = $servicio[0]["id_usuario"];

            /**/            
            if(count($servicio) == 0){
                header("location:../producto");  
            }            
            /**/
            $this->set_option("servicio" , $servicio);                                            
            $data["costo_envio"] ="";
            /**/
            if($servicio[0]["flag_servicio"] ==  0){                
                $data["costo_envio"] = $this->calcula_costo_envio($this->crea_data_costo_envio());    
            }                        
            /**/
            $data["info_servicio"]["servicio"] = $servicio;    
            $this->set_option("flag_precio_definido" , 0);
            $data["precio_unidad"] = 0;
            /**/
            if($servicio[0]["flag_precio_definido"] == 1){
                $precio =  $this->get_precio_servicio($id_servicio);
                $precio_unidad =  $precio[0]["precio"];            
                $data["precio_unidad"] = $precio_unidad; 
                $this->set_option("precio_unidad" , $precio_unidad);
                $this->set_option("flag_precio_definido" , 1);
            }
            
            $data["imgs"]=  $this->get_imagenes_productos($id_servicio);            
            $this->costruye_meta_keyword();
            $data["meta_keywords"] = $this->get_option("meta_keywords");                
            
            $this->costruye_descripcion_producto();             

            $this->principal->crea_historico($num_hist , $num_usuario , $num_usuario , $id_mensaje);

            $data["url_actual"]=   $this->get_the_current_url();
            $data["meta_keywords"] = $this->get_option("meta_keywords");                    
            $data["url_img_post"] = $this->get_url_imagen_post();    
            $data["desc_web"] = $this->get_option("desc_web");
            $data["id_servicio"] =  $id_servicio;
            

            $prm["id_servicio"] = $id_servicio;
            $data["existencia"]=  $this->verifica_disponibilidad_servicio($prm);


            $this->principal->show_data_page($data, 'home');                                              
            
    }
    /**/
    function get_nombre_usuario($id_usuario){

        $param["id_usuario"] = $id_usuario;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/nombre_usuario/format/json/", $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }            
    /**/
    function verifica_disponibilidad_servicio($param){        

        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("producto/articulos_disponibles/format/json/", $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    function calcula_costo_envio($param){        
        /**/
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("cobranza/calcula_costo_envio/format/json/", $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    function get_descripcion_mensaje($id_mensaje){
        /**/
        $mensaje =  $this->principal->get_info_mensaje($id_mensaje);                 
        $descripcion_mensaje  =  $mensaje[0]["descripcion"];  
        $this->set_mensaje_descripcion(strip_tags($descripcion_mensaje));
    }
    /**/
    function get_precio_servicio($id_servicio){
        return $this->producto_model->get_precio_servicio($id_servicio);        
    }
    /**/
    /**/
    function get_informacion_basica_servicio($id_servicio){
        return  $this->producto_model->info_basica_producto($id_servicio); 
    }    
    /**/
    function get_imagenes_productos($id_servicio){
        return $this->principal->get_imgs_servicio($id_servicio);
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
    /**/
    /**/
    function get_url_imagen_post(){

        $id_servicio  =  $this->get_option("id_servicio"); 
        return "http://enidservice.com/inicio/imgs/index.php/enid/imagen_servicio/".$id_servicio."/";
    }
    /**/
    function set_mensaje_descripcion($mensaje_descripcion){        
        /**/
        $this->mensaje_descripcion= $mensaje_descripcion;
    }
    /**/
    function get_nombre_servicio(){
        return $this->nombre_servicio;
    }
    /**/
    function get_precio_venta($costo){

        $q["costo"] =  $costo;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("cobranza/calcula_precio_producto/format/json/", $q);        
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    function get_precio_venta_mayoreo($costo){

        $q["costo"] =  $costo;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = $this->restclient->get("cobranza/calcula_precio_producto_mayoreo" , $q);        
        $response =  $result->response;        
        return $response;
    }
    /**/

    function costruye_descripcion_producto(){
        
        $servicio =  $this->get_option("servicio")[0];        
        $nombre_servicio =  $servicio["nombre_servicio"];        
        $descripcion =  $servicio["descripcion"];        

        $precio_unidad ="";
        if($this->get_option("flag_precio_definido") == 1){

            $precio_unidad =  $this->get_option("precio_unidad");    
            $precio_unidad = $precio_unidad ." MXN ";
        }        
        $text=  $nombre_servicio." ".$precio_unidad." ".$descripcion;
        $this->set_option( "desc_web" , $text);        
    } 
    function costruye_meta_keyword(){
                
        $servicio =  $this->get_option("servicio")[0];
        $metakeyword =  $servicio["metakeyword"];
        $metakeyword_usuario =  $servicio["metakeyword_usuario"];
        $nombre_servicio =  $servicio["nombre_servicio"];
        $descripcion =  $servicio["descripcion"];                    
        $id_clasificacion =  $servicio["id_clasificacion"];
        
        $array =  explode(",", $metakeyword);
        
        
        array_push($array, $nombre_servicio ); 
        array_push($array, $descripcion ); 
        array_push($array, " precio " ); 

        if (strlen(trim($metakeyword_usuario)) > 0 ) {            
            array_push($array, $metakeyword_usuario );    
        }        
        
        $meta_keyword =  implode(",", $array);
        $meta_keywords =  $metakeyword;
        /**/        
        $this->set_option("meta_keywords", $meta_keyword );

    }    
    /**/
    function get_categorias_por_producto($id_clasificacion){
                
        $q["id_clasificacion"] =  $id_clasificacion;
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("clasificacion/clasificaciones_por_servicio/format/json/" , $q);        
        $response =  $result->response;        
        return json_decode($response , true);

    }
    /**/
    function get_the_current_url(){
    
        $protocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $base_url = $protocol . "://" . $_SERVER['HTTP_HOST'];
        $complete_url =   $base_url . $_SERVER["REQUEST_URI"];
        
        return $complete_url;
         
    }
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    function get_vista_no_encontrado(){
        return "../../../view_tema/producto_no_encontrado";
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
    
}