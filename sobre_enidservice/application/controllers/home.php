<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->library(lib_def());        
    }       
    function index(){

        $data = $this->principal->val_session("");
        $data["meta_keywords"] = '';
        $data["desc_web"] = "";                
        $data["url_img_post"] = create_url_preview("paginas_web_ii.jpeg");

        $num_hist= get_info_servicio( $this->input->get("q"));
        $data["f_pago"]=1;               
        $num_usuario = get_info_usuario( $this->input->get("q2"));        
        $num_servicio = get_info_usuario( $this->input->get("q3"));        

        $clasificaciones_departamentos =   
        $this->principal->get_departamentos("nosotros");        
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;

        $this->principal->crea_historico(566 , $num_usuario , $num_servicio );
        $data["js"]          =  [base_url('application/js/principal.js') , '../js_tema/sobre_enidservice/principal.js',];

        $this->principal->show_data_page($data, 'home');                          
    }
    
    function logout(){                      
        $this->principal->logout();      
    }   

 

    
}