<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Recursocontroller extends CI_Controller {
	function __construct(){		
		/**/
        parent::__construct();				
        $this->load->helper("form");
		$this->load->library('principal');  			
        $this->load->library("restclient");   
		$this->load->library('sessionclass');  			
	}
	/**/
	function informacioncuenta(){				

		$data = $this->val_session("");									
        $id_usuario =  $this->sessionclass->getidusuario(); 

        $data["usuario"] =  $this->principal->get_info_usuario($id_usuario);
        $clasificaciones_departamentos =   $this->get_departamentos("nosotros");    
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;        
        $data["js"] =  [
            base_url('application/js/principal.js'),
            base_url('application/js/privacidad_seguridad.js'),
            base_url('application/js/sobre_el_negocio.js'),
            base_url('application/js/img.js'),
            base_url('application/js/perfil_user.js'),
            "../js_tema/js/direccion.js",
            base_url('application/js/sha1.js')
        ];

        $data["css"] = [base_url("application/css/principal.css") ];
        $this->principal->show_data_page($data , 'home' );        
	}	
    /*Inicia perfil avanzado*/	
	 function val_session($titulo_dinamico_page ){        

        $data["is_mobile"] = ($this->agent->is_mobile() == FALSE)?0:1;
        
        if($this->sessionclass->is_logged_in() == 1) {                                                            
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
                /**/
                $data["id_empresa"] =  $this->sessionclass->getidempresa();                     
                $data["info_empresa"] =  $this->sessionclass->get_info_empresa();                     
                $data["desc_web"] =  "";
                $data["info_perfil_usuario"] = 
                $this->sessionclass->getperfiles()[0]["idperfil"];
                /**/
                return $data;
        }else{            
            redirect(url_log_out());
        }   
    }      
    /**/  
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
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
}