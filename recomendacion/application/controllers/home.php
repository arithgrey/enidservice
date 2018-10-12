<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    
    function __construct(){        
        parent::__construct();                            
        $this->load->library(lib_def());     
    }           
    /**/
    function index(){

        $param  =  $this->input->get();
        $val    =  get_info_variable( $param , "q" );         
        if(ctype_digit($val)){

            
            $id_usuario =  $this->input->get("q");
            $data       = $this->principal->val_session("");
            $data["meta_keywords"]  = '';
            $data["desc_web"]       = "";                
            $data["url_img_post"]   = create_url_preview("");
            
            $num_hist               = get_info_servicio( $this->input->get("q"));            
            $num_usuario            = get_info_usuario( $this->input->get("q2"));        
            $num_servicio           = get_info_usuario( $this->input->get("q3"));        

            $this->principal->crea_historico(5669877 , $num_usuario , $num_servicio );         
            $clasificaciones_departamentos =   $this->principal->get_departamentos("nosotros");    
            $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;   

            /**/
            $prm["id_usuario"]  =  $id_usuario;
            /*Creamos la vista de recomendaciones*/
            $data_recomendacion =  $this->busqueda_recomendacion($prm);
            $data["usuario"]    =  $this->principal->get_info_usuario($id_usuario);            
            
            if(count($data["usuario"]) > 0){

                if($data["in_session"] == 1 ){
                    $id_usuario_actual =  $data["id_usuario"];                    
                    $this->notifica_lectura($id_usuario , $id_usuario_actual);    
                }                
                $data["resumen_recomendacion"] =  $data_recomendacion["info_valoraciones"];    

                /*Se crea la data*/             
                $prm["page"]                    = get_info_variable($this->input->get() , "page");
                $prm["resultados_por_pagina"]   =  5;
                $data["resumen_valoraciones_vendedor"] =  $this->resumen_valoraciones_vendedor($prm);
                $prm["totales_elementos"]       = $data_recomendacion["data"][0]["num_valoraciones"];

                $data["paginacion"] = "";
                if($prm["totales_elementos"] > $prm["resultados_por_pagina"]){
                    /*Mandamos a crear paginación cuando es más grande el resultado que lo que se 
                    solicita*/
                    $prm["per_page"] =  5; 
                    $prm["q"] = $id_usuario;
                    $data["paginacion"] =  $this->get_paginacion($prm);                
                }
                
                $data["css"] = ["recomendacion_principal.css"];
                $data["js"]  = ["../js_tema/recomendaciones/principal.js"];
                $this->principal->show_data_page($data, 'home');                          
            
            }else{
                /*Se envia a otro al home*/            
                $this->go_home();
            }
        }else{
            /*Se envia a otro al home*/            
            $this->go_home();    
        }            
    }
    /**/
    function go_home(){
        redirect("../../", 'POST');
    }
    /**/
    private function busqueda_recomendacion($q){        
        $api =  "valoracion/usuario/format/json/";        
        return $this->principal->api( $api, $q); 
    }    
    /**/
    private function resumen_valoraciones_vendedor($q){     
        $api    =  "valoracion/resumen_valoraciones_vendedor/format/json/"; 
        return  $this->principal->api( $api , $q);                  
    }    
    private function get_paginacion($q){
        $api    =  "producto/paginacion/format/json/"; 
        return $this->principal->api( $api , $q);  
    }
    /**/
    private function notifica_lectura($id_usuario , $id_usuario_valoracion){
            
        if($id_usuario ==  $id_usuario_valoracion) {
            $q["id_usuario"] = $id_usuario;
            $api ="valoracion/lectura/format/json/";
            $this->principal->api( $api, $q, 'json', 'PUT');
        }                
    }
    /***/
}