<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enid extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("img_model");
        $this->load->model("enidmodel");
        $this->load->library('principal');    
        
    }

    function img_faq($id_faq){

        $this->construye_img_format(
            $this->img_model->get_img_faq($id_faq));                
    }
    /**/
    function imagen($id_imagen){

        $img_src="";
        foreach ($this->img_model->get_img($id_imagen) as $row ){ 
            $img_src =  $row["img"];
            echo  $img_src;
        }        
    }       
    function img($id_imagen){

        $img_src="";
        foreach ($this->img_model->get_img($id_imagen) as $row ){ 
            $img_src =  $row["img"];
            echo  $img_src;
        }         
    }
    /**/
     /**/   
    function imagen_usuario($id_usuario){
        
        $this->construye_img_format(
            $this->img_model->get_img_usuario($id_usuario));        
    }        
    /**/
    function imagen_servicio($id_servicio){

        $this->construye_img_format(
            $this->img_model->get_img_servicio($id_servicio));        
    }
    private function construye_img_format($response){
        
        if ( count($response) > 0 ) {            
            $id_imagen =  $response[0]["id_imagen"];            
            $img= $this->costruye_imagen($id_imagen);
            
            header('Content-Type: image/png');
            echo $img;
            /*
            $im = imagecreatefromstring($img);
            if ($im !== false) {
                header('Content-Type: image/png');
                imagepng($im);
                imagedestroy($im);
            }
            else {
                echo 'Ocurrió un error.';
            }
            */

            
        }         
    }
    /**/
    private function costruye_imagen($id_imagen){
        $img_src="";
        foreach ($this->img_model->get_img($id_imagen) as $row ){ 
            $img_src =  $row["img"];
        }     
        return  $img_src;
    }

    /*Determina que vistas mostrar para los eventos*/    
}/*Termina el controlador */