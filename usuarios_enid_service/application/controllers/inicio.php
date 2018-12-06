<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inicio extends CI_Controller {
	function __construct(){        
        parent::__construct();            			
	    $this->load->library(lib_def());    
        $this->principal->acceso();
    }    
    /**/
    function index(){

		$data = $this->principal->val_session("Grupo ventas - Enid Service - ");
        $num_perfil =  $this->principal->getperfiles();
        if ($num_perfil == 20 ) {
            header("location:../area_cliente");   
        }        

        $data["departamentos"]                  =   $this->get_departamentos_enid();
        $data["perfiles_enid_service"]          =   $this->get_perfiles_enid_service();         
        $data["clasificaciones_departamentos"]  =   $this->principal->get_departamentos();

        $data["js"]      = [
            "../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js",
            "../js_tema/js/bootstrap-datepicker/js/bootstrap-datepicker.js",
            "../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
            "../js_tema/js/bootstrap-daterangepicker/moment.min.js",
            "../js_tema/js/bootstrap-daterangepicker/daterangepicker.js",
            "../js_tema/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
            "../js_tema/js/bootstrap-timepicker/js/bootstrap-timepicker.js",
            "../js_tema/js/pickers-init.js",    
            '../js_tema/usuarios_enid/principal.js',
            '../js_tema/usuarios_enid/notificaciones.js',
            '../js_tema/usuarios_enid/categorias.js',
            "../js_tema/js/clasificaciones.js"
        ];

        $data["css"] = [           
            "usuarios_enid_service_principal.css",
            "template_card.css",

        ];

        $data["css_external"] =  [
            "../js_tema/js/bootstrap-colorpicker/css/colorpicker.css" ,
            "../js_tema/js/bootstrap-datepicker/css/datepicker-custom.css" ,
            "../js_tema/js/bootstrap-datepicker/css/datepicker.css" ,
            "../js_tema/js/bootstrap-daterangepicker/daterangepicker.css" ,
            "../js_tema/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" ,
            "../js_tema/js/bootstrap-datetimepicker/css/datetimepicker.css",
            "../js_tema/js/bootstrap-timepicker/css/timepicker.css" ,
            "../js_tema/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css", 
        ];
    
        $this->principal->show_data_page( $data , 'empresas_enid');			    	                	
    }    	
    private function get_perfiles_enid_service(){
        
        $api = "perfiles/get/format/json/";                
        return $this->principal->api( $api , []);
    }
    /**/
    private function get_departamentos_enid(){

        $q["estado"]    =  1;
        $api            = "departamento/index/format/json/";                
        return $this->principal->api( $api , $q);
    }
}?>