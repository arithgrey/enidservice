<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inicio extends CI_Controller {
	function __construct(){        
        parent::__construct();            			
	    $this->load->library(lib_def());      
        $this->principal->acceso();
    }    
    /**/
    function index(){

		$data                       =   $this->principal->val_session("");
	    $num_perfil                 =   $this->principal->getperfiles(2,  "idperfil");        
        $data["num_departamento"]   =   $this->get_id_departamento_by_id_perfil($num_perfil);
        $data["departamentos"]      =   $this->get_departamentos_enid();            
        $data["clasificaciones_departamentos"]  
                                    =   $this->principal->get_departamentos("" , 1);        
        $x                          =   ($num_perfil == 20 ) ? header("location:../area_cliente") : "";
        $activa                     =   get_info_variable($this->input->get() , "q");
        $data["activa"]             =   ($activa === "" )? 1 : $activa;         
        

        $data["css_external"] = [            
            "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css"
        ];        
        $data["css"]                =   ["desarrollo_principal.css"];
        
        $data["js"] = [
                "../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js",
                "../js_tema/js/bootstrap-datepicker/js/bootstrap-datepicker.js",                
                "../js_tema/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                "../js_tema/js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                "../js_tema/js/pickers-init.js",
                '../js_tema/desarrollo/principal.js',
                '../js_tema/desarrollo/summernote.js',
                "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"
            

        ];
        $this->principal->show_data_page( $data , 'empresas_enid');                                 
    }    	
    /**/
    function get_id_departamento_by_id_perfil($id_perfil){        
        $q["id_perfil"]  = $id_perfil;
        $api             = "perfiles/id_departamento_by_id_perfil/format/json/";
        return  $this->principal->api( $api , $q);
    }
    /**/
    function get_departamentos_enid(){
        $q["info"]  = 1;
        $api        = "departamento/index/format/json/";        
        return  $this->principal->api( $api , $q );   
    }
    
}