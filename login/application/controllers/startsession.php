<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Startsession extends CI_Controller{
    public $option;
	function __construct(){        
        parent::__construct();                               
        $this->load->library(lib_def());  
    }      
    function index(){                
    

        $data                   =   $this->principal->val_session("");
        $q                      =   $this->input->get("q");
        $data["desc_web"]       =   "COMPRA Y VENDE EN ENID SERVICE";
        $data["meta_keywords"]  =   "COMPRA Y VENDE ARTÍCULOS Y SERVICIOS  EN ENID SERVICE "; 
        $data["url_img_post"]   =   create_url_preview("promo.png");   
        
        $data["css"]   =   ["login.css"];
        $data["js"]             =   ["../js_tema/login/sha1.js" ,"../js_tema/login/ini.js"];
        
        $data["action"] = get_info_variable($this->input->get() , "action");          
        $this->principal->validate_user_sesssion();    
        $data["clasificaciones_departamentos"] = "";                
        $this->principal->show_data_page($data, "signin");            
        
    } 
    
	function logout(){						
		$this->principal->logout();
	}	
}