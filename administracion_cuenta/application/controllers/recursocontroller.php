<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Recursocontroller extends CI_Controller {
	function __construct(){		
        parent::__construct();				
		$this->load->library(lib_def());    				
        $this->principal->acceso();
	}
	/**/
	function informacioncuenta(){				

		$data               =  $this->principal->val_session("");						
        $id_usuario         =  $this->principal->get_session("idusuario"); 
        $data["usuario"]    =  $this->principal->get_info_usuario($id_usuario);
        
        $clasificaciones_departamentos        =   
        $this->principal->get_departamentos("nosotros");    
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;        
        $data["js"] = [
            '../js_tema/administracion_cuenta/principal.js',
            '../js_tema/administracion_cuenta/privacidad_seguridad.js',            
            '../js_tema/administracion_cuenta/img.js',            
            "../js_tema/js/direccion.js",
            '../js_tema/administracion_cuenta/sha1.js'
        ];
        $data["css"] = 
        ["administracion_cuenta_principal.css" , "administracion_cuenta_info_usuario.css" ];
        $this->principal->show_data_page($data , 'home' );        
	}	
  
}