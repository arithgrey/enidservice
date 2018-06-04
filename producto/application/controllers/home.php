<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ('../librerias/google-translate/vendor/autoload.php');
use \Statickidz\GoogleTranslate;
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
        if (ctype_digit(trim($this->input->get("producto")))) {
            $this->load_servicio($this->input->get());
        }else{
            redirect("../../?q=");
        }    
    }
    /**/
    private function load_servicio($param){

        $id_servicio =  get_info_producto($param["producto"] );                    
        $this->set_option("id_servicio" , $id_servicio);        
        $data = $this->val_session("");  
        $data["clasificaciones_departamentos"] = "";        

        if($this->agent->is_mobile() == FALSE){
            /**/
            
            $data["clasificaciones_departamentos"] = $this->get_departamentos("nosotros");        
        }
        if ($id_servicio == 0 ){      
            /**/
            $data["meta_keywords"]="";
            $data["desc_web"] ="";
            $data["url_img_post"]="";            
            $this->principal->show_data_page($data, $this->get_vista_no_encontrado());
            
        }else{            
            /**/
            $data["desde_valoracion"] =  get_valor_variable($param , "valoracion");
            $this->crea_vista_producto($param , $data);            
        }        
    }                
    /**/
    private function crea_vista_producto($param , $data){
            

            $id_servicio =  $this->get_option("id_servicio");                              
            $data["q2"] =   valida_valor_variable($param , "q2");            
            $servicio =     $this->get_informacion_basica_servicio($id_servicio);

            $usuario =0;
            if (count($servicio)>0 ){
                $usuario         =  $this->get_contacto_usuario($servicio[0]["id_usuario"]);
            }
            if ($usuario == 0) {
                redirect("../../?q=");
            }

                    $data["usuario"] = $usuario; 
                    $data["id_publicador"]  = $servicio[0]["id_usuario"];
                           
                    if(count($servicio) == 0){                        
                        redirect("../../?q=");
                    }                        
                    $this->set_option("servicio" , $servicio);                                            
                    $data["costo_envio"] ="";
                    $data["tiempo_entrega"] ="";
                    if($servicio[0]["flag_servicio"] ==  0){                
                        $data["costo_envio"] = 
                        $this->calcula_costo_envio($this->crea_data_costo_envio());    

                        $tiempo_promedio_entrega =  $servicio[0]["tiempo_promedio_entrega"];
                        $data["tiempo_entrega"] = 
                        $this->valida_tiempo_entrega($tiempo_promedio_entrega);
                    }                        
                    



                    $data["info_servicio"]["servicio"] = $servicio;    
                    $this->set_option("flag_precio_definido" , 0);
                   
                    
                    $data["imgs"]=  $this->get_imagenes_productos($id_servicio);            
                    $this->costruye_meta_keyword();
                    $data["meta_keywords"] = $this->get_option("meta_keywords");                
                    

                    $this->costruye_descripcion_producto();             

                    $this->principal->crea_historico_vista_servicio($id_servicio , 
                        $data["in_session"] ,$data["id_publicador"]);

                    $data["url_actual"]=   $this->get_the_current_url();
                    $data["meta_keywords"] = $this->get_option("meta_keywords");                    
                    $data["url_img_post"] = $this->get_url_imagen_post();    
                    $data["desc_web"] = $this->get_option("desc_web");
                    
                    $data["id_servicio"] =  $id_servicio;            
                    $prm["id_servicio"] = $id_servicio;
                    $data["existencia"]=  $this->verifica_disponibilidad_servicio($prm);

                    $data["css"] = [base_url('application/css/main.css'),
                                    "../css_tema/template/css_tienda.css",
                                    base_url('application/css/zoom_imagen.css')
                                    ];

                    $data["js"] = [
                                base_url('application/js/principal.js'),
                                "../librerias/jquery-zoom/jquery.zoom.js"
                            ];
                    $this->principal->show_data_page($data, 'home');
    }
    /**/
    private function get_contacto_usuario($id_usuario){

        $param["id_usuario"] = $id_usuario;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/contacto/format/json/", $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }            
    /**/
    private function verifica_disponibilidad_servicio($param){        

        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = 
        $this->restclient->get("producto/articulos_disponibles/format/json/", $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    private function calcula_costo_envio($param){        
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
    private function get_descripcion_mensaje($id_mensaje){
        /**/
        $mensaje =  $this->principal->get_info_mensaje($id_mensaje);                 
        $descripcion_mensaje  =  $mensaje[0]["descripcion"];  
        $this->set_mensaje_descripcion(strip_tags($descripcion_mensaje));
    }
    /**/
    private function get_informacion_basica_servicio($id_servicio){
        return  $this->producto_model->info_basica_producto($id_servicio); 
    }    
    /**/
    private function get_imagenes_productos($id_servicio){
        return $this->principal->get_imgs_servicio($id_servicio);
    }
    /**/
    function logout(){                      
        $this->sessionclass->logout();      
    }   
    /**/
    private function val_session($titulo_dinamico_page ){

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
    private function get_precio_venta_mayoreo($costo){

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
    private function costruye_descripcion_producto(){
        
        $servicio =  $this->get_option("servicio")[0];        
        $nombre_servicio =  $servicio["nombre_servicio"];        
        $descripcion =  $servicio["descripcion"];        

        $precio_unidad ="";
        if($this->get_option("flag_precio_definido") == 1){

            $precio_unidad =  $this->get_option("precio_unidad");    
            $precio_unidad = $precio_unidad ." MXN ";
        }        
        $text=  strip_tags($nombre_servicio)." ".strip_tags($precio_unidad)." ".strip_tags($descripcion);
        $this->set_option( "desc_web" , $text);        
    } 
    private function costruye_meta_keyword(){
                
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
        $this->set_option("meta_keywords", strip_tags($meta_keyword) );

    }    
    /**/
    private function get_categorias_por_producto($id_clasificacion){
                
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
    private function get_the_current_url(){
    
        $protocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $base_url = $protocol . "://" . $_SERVER['HTTP_HOST'];
        $complete_url =   $base_url . $_SERVER["REQUEST_URI"];
        
        return $complete_url;
         
    }
    private function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    private function get_vista_no_encontrado(){
        return "../../../view_tema/producto_no_encontrado";
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
    /***/
    private  function valida_tiempo_entrega($tiempo)
    {

        
        $source = 'en';
        $target = 'es';

        $fecha =  date("Y-m-d e");    
        $fecha = new DateTime($fecha);
        $fecha->add(new DateInterval('P'.$tiempo.'D'));        
        $fecha_entrega_promedio =  $fecha->format('l, d M Y');
        $trans = new GoogleTranslate();
        $fecha_entrega_promedio = $trans->translate($source, $target, strtoupper($fecha_entrega_promedio));

        $tiempo_entrega =  "REALIZA HOY TU PEDIDO PARA 
        TENERLO EN TU HOGAR
        EL <span class='tiempo_promedio'>".$fecha_entrega_promedio."</span>";

        return $tiempo_entrega;
      
    }

}