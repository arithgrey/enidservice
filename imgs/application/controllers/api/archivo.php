<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Archivo extends REST_Controller{      
    function __construct(){
        parent::__construct();                       
        $this->load->model("img_model");
        $this->load->library('sessionclass');                    
    }
    function extension($str){
        $str=implode("",explode("\\",$str));
        $str=explode(".",$str);
        $str=strtolower(end($str));
         return $str;
    }
    /**/
    function imgs_POST(){
        $prm = $this->post(); 
        
        if($_FILES['imagen']['error'] === 4) {
            $this->response( 'Es necesario establecer una imagen' );        
        }else if($_FILES['imagen']['error'] === 0 ){

            
                    $imagenBinaria = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
                    $nombre_archivo = $_FILES['imagen']['name'];
                    
                    $extensiones = array('jpg', 'jpeg', 'gif', 'png', 'bmp' , "image/jpg", "image/jpeg", "image/gif", "image/png" );            
                                    
                    $extension=  $this->extension($nombre_archivo );

            if(!in_array($extension, $extensiones)) {
                $this->response( 'Sólo se permiten archivos con las siguientes extensiones: '.implode(', ', $extensiones) );
            }

            

            
            $prm["imagenBinaria"] = $imagenBinaria;
            $prm["nombre_archivo"] =  $nombre_archivo;
            $prm["extension"] =  $extension; 
            $img_response  = $this->gestiona_imagenes($prm);         
            $this->response($img_response);            
            
        }
        

    }
    /**/
    function gestiona_imagenes($param){ 

        $this->validate_user_sesssion();            
        $param["id_usuario"] = $this->sessionclass->getidusuario();    
        $param["id_empresa"] =  $this->sessionclass->getidempresa();            



        switch ($param["q"]) {
            
            
              case 'faq':
                
                $db_response = $this->img_model->insert_img_faq( $param);
                return $this->response_status_img($db_response);                    
                
            
                break;        

                
              case 'perfil_usuario':
                
                
                $db_response = 
                $this->img_model->insert_imgen_usuario($param);                
                return $this->response_status_img($db_response);                    
                
                break;        

              case 'servicio':
                                
                                
                $db_response = $this->img_model->insert_imgen_servicio($param);                
                return $db_response;

                
                break;          

        
              default:

                break;
        }

        //return $q;
    }
    /**/
    function response_status_img($status){

        $msj ="Error al cargar la image, reportar al admistrador ";
        if ($status ==  1  ) {
            $msj =  "Imagen guardada .!";
        }
        return $msj; 
    }
    /*Validar session para modificar datos*/
    function validate_user_sesssion(){
        if($this->sessionclass->is_logged_in() == 1){}else{        
            $this->sessionclass->logout();
        }   
    }   
}?>