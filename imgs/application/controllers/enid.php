<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Enid extends CI_Controller {
    function __construct(){
        parent::__construct();        
        $this->load->model("img_model");
        $this->load->library(lib_def());          
    }
    private function img_faq($id_faq){
        $this->construye_img_format($this->get_img_faq($id_faq));                
    }
    function imagen($id_imagen){

        $img_src="";
        foreach ($this->get_img($id_imagen) as $row ){ 
            $img_src =  $row["img"];
            echo  $img_src;
        }        
    }       
    function img($id_imagen){

        $img_src="";
        foreach ($this->get_img($id_imagen) as $row ){ 
            $img_src =  $row["img"];
            echo  $img_src;
        }         
    }
    /**/     
    function imagen_usuario($id_usuario){        
        $img_usuario =  $this->get_img_usuario($id_usuario);
        $this->construye_img_format($img_usuario );        
    }        
    /**/
    function imagen_servicio($id_servicio){

        $this->construye_img_format($this->get_img_servicio($id_servicio));        
    }
    /**/
    private function construye_img_format($response){
            
        if ( count($response) > 0 ) {            
            $id_imagen =  $response[0]["id_imagen"];              
            $img       = $this->costruye_imagen($id_imagen);
            
            header('Content-Type: image/png');
            echo $img;            
        }         
    }
    /**/
    private function costruye_imagen($id_imagen){
        $img_src="";
        foreach ($this->get_img($id_imagen) as $row ){ 
            $img_src =  $row["img"];
        }     
        return  $img_src;
    }
    private function get_img_faq($id_faq){

        $q["id_faq"]    =  $id_faq;        
        $api            =  "img/img_faq/format/json/";
        return $this->principal->api( $api , $q);
    }
    private function get_img($id_imagen){

        return $this->img_model->get_img($id_imagen);        
    }
    private function get_img_usuario($id_usuario){

        $q["id_usuario"]   =  $id_usuario;        
        $api               =  "imagen_usuario/usuario/format/json/";
        return $this->principal->api( $api , $q);   
    }
    private function get_img_servicio($id_servicio){

        $q["id_servicio"]  =  $id_servicio;        
        $api               =  "imagen_servicio/servicio/format/json/";
        return $this->principal->api( $api , $q);            
    }
}/*Termina el controlador */