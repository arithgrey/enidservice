<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ('../librerias/google-translate/vendor/autoload.php');
use \Statickidz\GoogleTranslate;
class Home extends CI_Controller{
    public $options;  
    function __construct($options=[]){        
        parent::__construct();              
        $this->load->helper("producto");                                    
        $this->load->library(lib_def());                           
    }       
    private function set_option($key, $value){
        $this->options[$key] = $value;
    }
    function get_option($key){  
        return  $this->options[$key];
    }
    function crea_data_costo_envio(){
        $flag                       =   $this->get_option("servicio")[0]["flag_envio_gratis"];
        $param["flag_envio_gratis"] =   $flag;
        return $param;
    }
    function load_pre(){

        $data        = $this->principal->val_session("");  
        $data["clasificaciones_departamentos"] = "";        
        if($this->agent->is_mobile() == FALSE){                    
            $data["clasificaciones_departamentos"] = $this->principal->get_departamentos("nosotros");
        }
        $data["meta_keywords"]      =   "";
        $data["desc_web"]           =   "";
        $data["url_img_post"]       =   "";            
        $data["css"]                =   ["pre.css"];
        $data["js"]                 =   ["servicio/pre.js"];
        $data["id_servicio"]        =   $this->input->get("producto");
        $data["proceso_compra"]     =   1;

        $param                      =   $this->input->post();
        $data["plan"]               =   $param["plan"];
        $data["extension_dominio"]  =   $param["extension_dominio"];
        $data["ciclo_facturacion"]  =   $param["ciclo_facturacion"];
        $data["is_servicio"]        =   $param["is_servicio"];
        $data["q2"]                 =   $param["q2"];
        $data["num_ciclos"]         =   $param["num_ciclos"];
        $data["orden_pedido"]       =   1;
        $this->principal->show_data_page($data, 'pre'); 

    }    
    function index(){                
        $param              = $this->input->get();
        evita_basura($this->input->get("producto"));
        $request_method     =  $_SERVER['REQUEST_METHOD'];
        if (ctype_digit(trim($this->input->get("producto")))) {

            if (array_key_exists("pre", $param)) {
                if ($request_method ==  "POST") {
                    
                    $this->load_pre($param);            

                }else{

                    $id_servicio  = $this->input->get("producto");
                    redirect("../../producto/?producto=".$id_servicio);
                }
                
            }else{
                $this->load_servicio($param);
            }
            
        }else{
            if ($request_method ==  "POST" 
                && 
                ctype_digit(trim($this->input->get("recibo")))){
                $this->view_recibo_registrado();

            }else{
                redirect("https://www.google.com/" , "refresh" ,302);        
            }
        }     
    }
    function view_recibo_registrado(){


        $data        = $this->principal->val_session("");  
        $data["clasificaciones_departamentos"] = "";        
        if($this->agent->is_mobile() == FALSE){                    
            $data["clasificaciones_departamentos"] = $this->principal->get_departamentos("nosotros");
        }

        $param                      =   $this->input->get();
        $data["meta_keywords"]      =   "";
        $data["desc_web"]           =   "";
        $data["url_img_post"]       =   "";            
        $data["css"]                =   ["pre.css"];
        $data["js"]                 =   ["servicio/pre.js"];
        $data["id_servicio"]        =   $param["servicio"];
        $data["recibo"]             =   $param["recibo"];
        $data["proceso_compra"]     =   1;       
        $data["orden_pedido"]       =   0;

        $this->principal->show_data_page($data, 'pre'); 

    }
    private function load_servicio($param){

        $id_servicio    =  get_info_producto($param["producto"]);
    
        $this->set_option("id_servicio" , $id_servicio);                
        $data        = $this->principal->val_session("");  
        $data["proceso_compra"] = get_info_variable( $param , "proceso" );
        if ($data["in_session"] ==  1) {
            $data["proceso_compra"]  = 1;
        }
                
        $data["clasificaciones_departamentos"] = "";        
        if($this->agent->is_mobile() == FALSE){                    
            $data["clasificaciones_departamentos"] = $this->principal->get_departamentos("nosotros");
        }
        
        if ($id_servicio == 0 ){                  
            
            $data["meta_keywords"]  ="";
            $data["desc_web"]       ="";
            $data["url_img_post"]   ="";            
            $this->principal->show_data_page($data, $this->get_vista_no_encontrado());
            
        }else{  
            
            $data["desde_valoracion"] = get_info_usuario_valor_variable($param , "valoracion");
            $this->vista($param , $data);            
        }
    }
    private function get_tallas($id_servicio){
        $api            =   "servicio/talla/format/json/";        
        $q              =   [
            "id"            =>  $id_servicio ,
            "v"             =>  "1",
            "id_servicio"   =>  $id_servicio

        ];
        return    $this->principal->api( $api , $q ); 
    }
    private function vista($param , $data){
        
        $id_servicio    =   $this->get_option("id_servicio");                              
        $data["q2"]     =   get_info_variable($param , "q2");            
        $servicio       =   $this->principal->get_base_servicio($id_servicio);
        $data["tallas"] =   $this->get_tallas($id_servicio);                
        $id_usuario     =   0;
        $usuario        =   0;
        
        if ( count( $servicio ) > 0 ){
            $usuario         =  $this->principal->get_info_usuario($servicio[0]["id_usuario"]);

        }else{
            redirect("../../?q="); 
        }
        if( count($usuario) == 0) {            
            redirect("../../?q=");
        }
        
        
        $data["usuario"]                    = $usuario; 
        $data["id_publicador"]              = $id_usuario;
        $this->set_option("servicio" , $servicio);    
        $data["info_servicio"]["servicio"]  =   $servicio;
        $data["costo_envio"]                =   "";
        $data["tiempo_entrega"]             =   "";

        if($servicio[0]["flag_servicio"] ==  0){
            $data["costo_envio"]            =   $this->calcula_costo_envio($this->crea_data_costo_envio());
            $tiempo_promedio_entrega        =   $servicio[0]["tiempo_promedio_entrega"];
            $data["tiempo_entrega"]         =   $this->valida_tiempo_entrega($tiempo_promedio_entrega);

        }                        

        $this->set_option("flag_precio_definido" , 0);       
        $data["imgs"]           =  $this->get_imagenes_productos($id_servicio);
        $this->set_option("meta_keywords", costruye_meta_keyword($this->get_option("servicio")[0]) );

        $data["meta_keywords"]  = $this->get_option("meta_keywords");
        $this->costruye_descripcion_producto();             
        $this->crea_historico_vista_servicio($id_servicio);
        $data["url_actual"]     =   get_url_request("");
        $data["meta_keywords"]  =   $this->get_option("meta_keywords");                    
        $data["url_img_post"]   =   get_url_imagen_post($this->get_option("id_servicio"));
        $data["desc_web"]       =   $this->get_option("desc_web");                    
        $data["id_servicio"]    =   $id_servicio;                    
        $data["existencia"]     =   $this->get_existencia($id_servicio);        
        
        $data["css"]            = [ "css_tienda.css",
                                    "producto_principal.css",
                                    "sugerencias.css",
                                    "producto.css"
        ];

        $data["js"] = ['producto/principal.js'];
        $this->principal->show_data_page($data, 'home');         

    }
    private function get_existencia($id_servicio){                
        $q["id_servicio"]   =  $id_servicio;
        $api  = "servicio/existencia/format/json/";
        return $this->principal->api( $api, $q);    
    }
    private function calcula_costo_envio($q){                
        $api  = "cobranza/calcula_costo_envio/format/json/";
        return $this->principal->api( $api, $q);    
    }
    private function get_descripcion_mensaje($id_mensaje){        
        $mensaje =  $this->principal->get_info_mensaje($id_mensaje);                 
        $descripcion_mensaje  =  $mensaje[0]["descripcion"];  
        $this->set_mensaje_descripcion(strip_tags($descripcion_mensaje));
    }
    private function get_imagenes_productos($id_servicio){
        
        $q["id_servicio"] = $id_servicio;
        $api =  "imagen_servicio/servicio/format/json/";
        return $this->principal->api( $api , $q);
    }
    function set_mensaje_descripcion($mensaje_descripcion){
        $this->mensaje_descripcion= $mensaje_descripcion;
    }
    function get_nombre_servicio(){
        return $this->nombre_servicio;
    }
    private function get_precio_venta_mayoreo($costo){
        $q["costo"] =  $costo;
        $api =  "cobranza/calcula_precio_producto_mayoreo";
        return $this->principal->api( $api , $q , "html" );
    }
    private function costruye_descripcion_producto(){
        
        $servicio           =  $this->get_option("servicio")[0];        
        $nombre_servicio    =  $servicio["nombre_servicio"];        
        $descripcion        =  $servicio["descripcion"];        

        $precio_unidad ="";
        if($this->get_option("flag_precio_definido") == 1){

            $precio_unidad =  $this->get_option("precio_unidad");    
            $precio_unidad = $precio_unidad ." MXN ";
        }        
        $text=  strip_tags($nombre_servicio)." ".strip_tags($precio_unidad)." ".strip_tags($descripcion);
        $this->set_option( "desc_web" , $text);        
    }
    private function get_vista_no_encontrado(){
        return "../../../view_tema/producto_no_encontrado";
    }
    private  function valida_tiempo_entrega($tiempo)
    {
        $trans      =   new GoogleTranslate();
        $source     =   'en';
        $target     =   'es';
        $fecha      =   date("Y-m-d e");
        $fechaT     =   date("Y-m-d e");
        $fecha      =   new DateTime($fecha);
        $fechaTest  =   new DateTime($fechaT);
        $fechaTest->add(new DateInterval('P'.$tiempo.'D'));

        if ($fechaTest->format("D") == "Sat" ) {
            $fecha->add(new DateInterval('P2D'));
        }else if($fechaTest->format("D") == "Sun" ){
            $fecha->add(new DateInterval('P1D'));
        }else{
            $fecha->add(new DateInterval('P'.$tiempo.'D'));    
        }

        $fecha_entrega_promedio =   $fecha->format('l, d M Y');
        $fecha_entrega_promedio =   $trans->translate($source, $target, strtoupper($fecha_entrega_promedio));
        $tiempo_entrega =  "REALIZA HOY TU PEDIDO Y TENLO EN TU HOGAR EL". span($fecha_entrega_promedio, ["class"=>'tiempo_promedio']);
        return $tiempo_entrega;     
    }
    private function crea_historico_vista_servicio($id_servicio){

        $q["id_servicio"]   =  $id_servicio;
        $api                = "servicio/visitas";
        $this->principal->api( $api, $q, 'json', 'PUT');    
    }
}