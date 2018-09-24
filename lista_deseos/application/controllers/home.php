<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->library(lib_def());
        $this->principal->acceso();           
    }       
    function index(){        
        
        $data = $this->principal->val_session("");                
        $data["meta_keywords"] = "";    
        $data["desc_web"] = "";        
        $data["url_img_post"] = "";
        $data["clasificaciones_departamentos"] = $this->principal->get_departamentos("");
        
        if (is_array($this->input->get()) 
            && array_key_exists("q", $this->input->get())
            && $this->input->get("q") === "preferencias" ){
            
            $data["preferencias"]=  $this->get_preferencias($data["id_usuario"]);            
            $data["css"] = ["preferencias.css"];
            $data["js"] = ["../js_tema/lista_deseos/preferencias.js"];
            $this->principal->show_data_page($data, 'home_preferencias');        


        }else{            

            /*Validamos que se envíe a lista de deseos o a preferencias*/            
            $data["productos_deseados"]=  $this->get_lista_deseos($data["id_usuario"]);
            $data["css"] =  array("lista_deseos.css");
            $this->principal->show_data_page($data, 'home');        

        } 
        
    }    
    
    /**/
    private function get_lista_deseos($id_usuario){

        $q["id_usuario"]    =  $id_usuario;        
        $api                =  "usuario_deseo/usuario/format/json/";
        return $this->principal->api( $api ,  $q);        
    }
    /**/    
    private function get_preferencias($id_usuario){

        $q["id_usuario"]    =  $id_usuario;        
        $api = "clasificacion/interes_usuario/format/json/";
        return $this->principal->api( $api ,  $q);        
    }
    
}