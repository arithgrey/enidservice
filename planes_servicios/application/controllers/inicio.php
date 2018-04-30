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
        $param =  $this->input->get();
        $data["action"] =  valida_action($param , "action");     
        $data["considera_segundo"] =0;
        $data["extra_servicio"] =0;

        if ($data["action"] ==  2 ){            
            $data["considera_segundo"] =1;
            if (ctype_digit($param["servicio"])){
                $prm =  $param;            
                $prm["id_usuario"] =  $data["id_usuario"];            

                if ($this->valida_servicio_usuario($prm)!= 1){
                    redirect(url_log_out());
                }    
                $data["extra_servicio"] = $param["servicio"];
            }else{
                redirect(url_log_out());
            }            
        }

        $num_perfil =  $this->sessionclass->getperfiles()[0]["idperfil"];        
        $data["ciclo_facturacion"]= $this->principal->create_ciclo_facturacion();          
        $data["clasificaciones_departamentos"] = "";    
        $this->principal->show_data_page( $data , 'home_enid');			    	        	
    }    	
    /**/
    private function val_session($titulo_dinamico_page ){        
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
    /**/    
    private function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }  
    /**/
    private function valida_servicio_usuario($param){
        
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("producto/es_servicio_usuario/format/json/", $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }

}