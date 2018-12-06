<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();      
        $this->load->helper("validador");                      
        $this->load->library(lib_def());      
        
    }            
    function index(){

        $data = $this->principal->val_session("");
        $data["meta_keywords"] = '';
        $data["desc_web"] = "";                
        $data["url_img_post"] = create_url_preview("formas_pago_enid.png");
        $servicio =  $this->input->get("tag");
        if($servicio > 0 && ctype_digit($servicio)){
            
            $num_hist       = get_info_servicio( $this->input->get("q"));            
            $num_usuario    = get_info_usuario( $this->input->get("q2"));        
            $num_servicio   = get_info_usuario( $this->input->get("q3"));        
            $this->principal->crea_historico(56698727 , $num_usuario , $num_servicio );            
            $data["clasificaciones_departamentos"] = $this->principal->get_departamentos("nosotros");    

            

            $servicio_send["in_session"] = $this->principal->is_logged_in();
            $servicio_send["id_servicio"] =  $servicio;
            $servicio_send["id_usuario"] =0;
            if ($servicio_send["in_session"] == 1) {
                $servicio_send["id_usuario"]=  
                $this->principal->get_session("idusuario");
            }


            $data["formulario_valoracion"]= $this->carga_formulario_valoracion($servicio_send);            
            
            $data["in_session"] =  $this->principal->is_logged_in();
            $data["id_servicio"] = $servicio; 
            $data["js"]     =  ["../js_tema/pregunta/principal.js"];
            $data["css"]    =  ["producto.css" , "sugerencias.css" , "valoracion.css"];

            $this->principal->show_data_page($data, 'home');
            
        
        }else{
            header("location:../?q2=0&q=");
        }    
    }
    /**/
    private function carga_formulario_valoracion($q){
        
        $api =  "valoracion/pregunta_consumudor_form/format/json/";
        return $this->principal->api( $api , $q , "html" , "GET");
    }
    
}?>