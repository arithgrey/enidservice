<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inicio extends CI_Controller {
	function __construct(){        
        parent::__construct();            				    
        $this->load->helper("planes");
        $this->load->library(lib_def());        
        $this->principal->acceso();
    }    
    /**/
    function index(){
        
		$data                           =  $this->principal->val_session("");
        $param                          =  $this->input->get();
        $data["action"]                 =  valida_action($param , "action");     
        $data["considera_segundo"]      =  0;
        $data["extra_servicio"]         =  0;

        if ( $data["action"] ==  2 ){                        
            $data["considera_segundo"]  = 1;                        
            if (ctype_digit($param["servicio"]) && $data["in_session"] ==  1 && $data["id_usuario"]>0 ){
                
                $param["id_usuario"] =  $data["id_usuario"];
                if ( $this->valida_servicio_usuario($param) != 1 ){
                    $this->principal->logout();
                }    
                $data["extra_servicio"] = $param["servicio"];
            }else{
                $this->principal->logout();
            }            
        }
        
        $id_usuario                             =   $data["id_usuario"];    
        $msj                                    =   $this->input->get("mensaje");         
        $data["error_registro"]                 =   valida_extension($msj , 5 , "");         

        $data["top_servicios"]                  =   $this->get_top_servicios_usuario($id_usuario);        
        $num_perfil                             =   $this->principal->getperfiles(2, "idperfil"); 
        $data["ciclo_facturacion"]              =   $this->create_ciclo_facturacion();
        $data["clasificaciones_departamentos"]  =   "";    
        $data["is_mobile"] = (  $this->agent->is_mobile() === FALSE ) ? 0 : 1;
        
        
        $data["js"] =['../js_tema/planes_servicios/principal.js', 
                      '../js_tema/planes_servicios/img.js',
                      '../js_tema/js/summernote.js'];

        $data["css"]=[
            "css_tienda.css", 
            "vender.css" ,
            "planes_servicios.css",
            "producto.css"
        ];

        $data["css_external"] = [
            "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css"];

        $data["list_orden"]  = $this->get_orden();        
        $this->principal->show_data_page( $data , 'home_enid');			
          	        	
    }    	
    /**/
    private function valida_servicio_usuario($q){        

        $api = "producto/es_servicio_usuario/format/json/";
        return  $this->principal->api("tag" , $api , $q );
    }
    /*Regresa el top de servicios*/
    private function get_top_servicios_usuario($id_usuario){    

        $q["id_usuario"] = $id_usuario;        
        $api             = "servicio/top_semanal_vendedor/format/json/";
        return   $this->principal->api("q", $api , $q );                        
    }
    private function get_orden(){
        $response =["Las novedades primero",
                    "Lo     más vendido",
                    "Los más votados",
                    "Los más populares ",
                    "Precio [de mayor a menor]",
                    "Precio [de menor a mayor]",
                    "Nombre del producto [A-Z]",
                    "Nombre del producto [Z-A]",
                    "Sólo servicios",
                    "Sólo productos"
                     ];
        return $response;
    }
    /*Crea request  dentro de Enid METHOD PUT*/    
    private function create_ciclo_facturacion(){

        $q          = array();
        $api        =  "ciclo_facturacion/not_ciclo_facturacion/format/json/";
        return  $this->principal->api("q", $api , $q);         
    }
}