<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    public $option;
    function __construct(){        
        parent::__construct();                            
        $this->load->helper("procesar");
        $this->load->library(lib_def());        
    }   
    private function crea_data_costo_envio($servicio){
        $param["flag_envio_gratis"]=  $servicio[0]["flag_envio_gratis"];   
        return $param;
    }
    function index(){
        
    
        $param  =  $this->input->post();
        if( array_key_exists("num_ciclos", $param)
            && ctype_digit($param["num_ciclos"])
            && $param["num_ciclos"] >0 && array_key_exists("ciclo_facturacion", $param)
            && $param["num_ciclos"] >0 && $param["num_ciclos"] < 10
            && ctype_digit($param["plan"])&& $param["plan"] >0  ){
                $this->crea_orden_compra($param);            
        }else{
            if (get_param_def($param , "recibo" , 0 , 1 ) > 0 ) {
                    
                $this->add_domicilio_entrega($param);    
            }else{
                redirect("../../");    
            }
            
        }    
    }
    private function crea_orden_compra($param){
        
        $data                   = $this->principal->val_session("");         
        $data["meta_keywords"]  = '';
        $data["desc_web"]       = "Registra tu cuenta  y recibe  asistencia al momento.";
        $data["url_img_post"]   = create_url_preview("recomendacion.jpg");
        $num_hist               = get_info_usuario( $this->input->get("q"));
        $num_usuario_referencia = get_info_usuario( $this->input->get("q2"));
        $data["q2"]             = $num_usuario_referencia;
        $data["servicio"]       = $this->resumen_servicio($param["plan"]);                 
        $data["costo_envio"]    = "";

        if($data["servicio"][0]["flag_servicio"] ==  0) {
            $data["costo_envio"] = 
            $this->calcula_costo_envio($this->crea_data_costo_envio($data["servicio"]));
            
        }   
        
        $data["info_solicitud_extra"]           =   $param;
        $data["clasificaciones_departamentos"]  =   "";
        $data["vendedor"]                       =   "";
        if($data["servicio"][0]["telefono_visible"]== 1 ){
            $data["vendedor"] =
            $this->principal->get_info_usuario($data["servicio"][0]["id_usuario"]);            
        }
        $data["js"]     =  ["js/direccion.js" ,  
                            'procesar/principal.js',
                            'procesar/sha1.js'];

        $data["css"]    = array("procesar_pago.css"); 
        $this->principal->show_data_page($data, 'home');                          
        
    }
    private function add_domicilio_entrega($param){

        $data                   = $this->principal->val_session("");
        $data["meta_keywords"]  = '';
        $data["desc_web"]       = "Registra tu cuenta  y recibe  asistencia al momento.";
        $data["clasificaciones_departamentos"]  = "";


        $data["js"]     =  [
            "domicilio/direccion_pedido_registrado.js" ,
            "js/direccion.js"
        ];

        $data["css"]                            =   ["procesar_pago.css"];
        $param["id_recibo"]                     =   $param["recibo"];
        $param["id_usuario"]                    =   $this->principal->get_session("idusuario");
        $data["carga_ficha_direccion_envio"]    =   $this->carga_ficha_direccion_envio($param);
        $this->principal->show_data_page($data, 'secciones_2/domicilio_entrega');
    }
    private function calcula_costo_envio($q){
        $api    = "cobranza/calcula_costo_envio/format/json/";
        return $this->principal->api(  $api , $q);
    }
    private function resumen_servicio($id_servicio){

        $q["id_servicio"] = $id_servicio;
        $api                 = "servicio/resumen/format/json/";
        return $this->principal->api(  $api , $q );           
    }
    private function carga_ficha_direccion_envio($q){

        $q["text_direccion"]    =   "Dirección de Envio";
        $q["externo"]           =   1;        
        $api                    =   "usuario_direccion/direccion_envio_pedido"; 
        return $this->principal->api( $api , $q , "html");  
    }
}