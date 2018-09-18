<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');	
	class principal extends CI_Controller {	 	
		function __construct(){        
			parent::__construct();     
			$this->load->library('../../librerias/sessionclass');     
	    }
	    function api($modul, $api, $q=[], $format='json', $type='GET', $debug = 0  ){
	        $url 				=  $modul."/index.php/api/";         
	        $url_request		=  get_url_request($url);

	        $this->restclient->set_option('base_url', $url_request);
	        $this->restclient->set_option('format', $format);        
	        $result 			= "";
	        switch ($type) {
	        	case 'GET':
	        		$result 			= $this->restclient->get($api, $q);        
	        		break;	        
	        	case 'PUT':	        		
	        		$result 			= $this->restclient->put($api, $q);        
	        		break;	       
	        	case 'POST':	        		
	        		$result 			= $this->restclient->post($api, $q);        
	        		break;	        
	        	case 'DELETE':	        		

	        		$result 			= $this->restclient->delete($api, $q);        
	        		
	        		break;	        
	        	default:	        		
	        		break;
	        }	        
	        
	             
	        if ($debug == 1) {
	        	if ($format ==  "json") {
	        		print_r(json_decode($result->response , true));	
	        	}else{
	        		print_r($result);
	        	}
	        	
	        }
	        if ($format ==  "json"){	        	
	        	$response 					= $result->response;   
	        	return json_decode($response , true); 	
	        }       	

	        return $result->response;   
	    }    
	    function get_session($key){
	    	return $this->sessionclass->get_session($key);
	    }
	    function logout(){
	    	$this->sessionclass->logout();		   						
	    }	    
		function get_departamentos($param = '' , $format_html =1){				
			
			if ($format_html == 1) {
				$api =  "clasificacion/primer_nivel/format/json/"; 			
				return $this->api("q", $api , [] , "html");			
			}else{
				$api =  "clasificacion/primer_nivel/format/json/"; 			
				return $this->api("q", $api , [] , "json");	
			}
			
	    }	   	    
	    function calcula_costo_envio($q){      
		    $api  = "cobranza/calcula_costo_envio/format/json/";
		    return $this->api("q", $api, $q );  
		}
		function get_info_usuario($id_usuario){
			
			$q["id_usuario"] =  $id_usuario;
	        $api =  "usuario/q/format/json/"; 
	        return $this->api("q" , $api , $q );
    	}
    	function get_base_servicio($id_servicio){    
    		$q["id_servicio"] =  $id_servicio;
	        $api  =  "servicio/base/format/json/";
	        return $this->api("q" ,  $api , $q );
    	}
    	function create_pagination($q){
    		$api  =  "producto/paginacion/format/json/";
	        return $this->api("tag" ,  $api , $q );        	              
	    }
		/**/		
		function get_valor_numerico_bool($bool){

			$valor =0;
			if ($bool ==  true ){
		        $valor =  1;
		    }
		    return $valor;
		}	
		function crea_historico($tipo,$id_evento = 0 , $id_usuario = 0,$id_empresa = 0){
      	}   
      	/**/
      	function validate_user_sesssion(){      	

    	    if( $this->sessionclass->is_logged_in() == 1) {
    	    	redirect(url_home());
    	    }
      	}
      	/**/
      	function acceso(){
      		if( $this->sessionclass->is_logged_in() != 1) {
    	    	$this->logout();
    	    }
      	}
      	/**/
      	function is_logged_in(){
      		return $this->sessionclass->is_logged_in();
      	}
      	function set_userdata($session_data){
      		$this->sessionclass->set_userdata($session_data);
      	}
		/**/
		function show_data_page($data, $center_page , $tema = 0 ){           
	        $this->load->view("../../../view_tema/header_template", $data);
	        $this->load->view($center_page , $data);            
	        $this->load->view("../../../view_tema/footer_template", $data);
	    }
	    /**/
	    function getperfiles($v = 2 , $key =''){
	    	return $this->sessionclass->getperfiles($v, $key);
	    }
	    /**/
	    function val_session($titulo){
	    	
	        $data["is_mobile"] = ($this->agent->is_mobile() == FALSE)?0:1;
	        if( $this->sessionclass->is_logged_in() == 1){                 
	                
	            $menu 					= 	$this->sessionclass->generadinamymenu();
	            $nombre 				= 	$this->get_session("nombre");
	            $data['titulo']			= 	$titulo;              
	            $data["menu"] 			= 	$menu;              
	            $data["nombre"]			= 	$nombre;                                               
	            $data["email"]			= 	$this->get_session("email");
	            $data["perfilactual"] 	=  	$this->sessionclass->getnameperfilactual();                
	            $data["in_session"] 	= 	1;
	            $data["no_publics"] 	=	1;
	            $data["meta_keywords"] 	=  	"";
	            $data["url_img_post"]	= 	"";
	            $data["id_usuario"] 	= 	$this->get_session("idusuario");                  
	            $data["id_empresa"] 	=  	$this->get_session("idempresa"); 
	            $data["info_empresa"] 	=  	$this->get_session("info_empresa");      
	            $data["desc_web"] 		= 	"";	            
	            return $data;
	                
	        }else{            
	            $data['titulo']		= 	$titulo;              
	            $data["in_session"] = 	0; 
	            $data["id_usuario"] =	"";                                   	            
	            $data["nombre"] 	= 	"";                                    
	            $data["email"] 		= 	"";                                    
	            $data["telefono"]	= 	"";  
	            return $data;
	        }   
	       
	    } 
	    /***/ 
	}
?>