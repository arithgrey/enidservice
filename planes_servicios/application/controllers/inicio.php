<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inicio extends CI_Controller {
	function __construct(){        
        parent::__construct();            			
	    $this->load->library("principal");
        $this->load->library("restclient");   
	    $this->load->library('sessionclass');	     
    }    
    /**/
    function index(){
        
		$data = $this->val_session("Grupo ventas - Enid Service - ");        	            
        $num_perfil =  $this->sessionclass->getperfiles()[0]["idperfil"];        
        $data["ciclo_facturacion"]= $this->principal->create_ciclo_facturacion();          
        $data["clasificaciones_departamentos"] = "";
          
        $action =  valida_q($this->input->get("action"));           
        if($action === "nuevo" || $action ===  "vender"){
            $action = 1;  
        }else{
            $action = 0;
        }         
        $data["action"] =  $action;        
        /*************************************************************/        
        $this->principal->show_data_page( $data , 'home_enid');			
    	        	
    }    	
   /**/
    function val_session($titulo_dinamico_page ){        
        if ( $this->sessionclass->is_logged_in() == 1) {                                                            
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
            redirect(url_log_out());
        }   
    }           
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }


}